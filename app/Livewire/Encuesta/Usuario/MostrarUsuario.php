<?php

namespace App\Livewire\Encuesta\Usuario;

use App\Exports\UsuariosExport;
use App\Models\Empresa;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use ZipArchive;

class MostrarUsuario extends Component
{
    use WithPagination;

    #[Url(except: '')]
    public string $busqueda = '';

    #[Url(except: '')]
    public string $filtroEmpresa = '';

    #[Url(except: '')]
    public string $filtroRol = '';

    public string $ordenarPor = 'created_at';
    public string $direccionOrden = 'desc';

    public function updating($property): void
    {
        if (in_array($property, ['busqueda', 'filtroEmpresa', 'filtroRol'])) {
            $this->resetPage();
        }
    }

    public function ordenar(string $columna): void
    {
        if ($this->ordenarPor === $columna) {
            $this->direccionOrden = $this->direccionOrden === 'asc' ? 'desc' : 'asc';
        } else {
            $this->ordenarPor = $columna;
            $this->direccionOrden = 'asc';
        }
    }

    /**
     * 3. Escucha el evento 'confirm-delete' despachado por el botón en la vista.
     *    Su única función es despachar otro evento que el script global de SweetAlert pueda capturar.
     */
    #[On('confirm-delete')]
    public function showDeleteConfirmation(int $id): void
    {
        $this->dispatch('show-swal-delete', [
            'id' => $id,
            'title' => '¿Estás seguro?',
            'text' => 'Vas a eliminar este usuario. ¡Esta acción no se puede deshacer!',
            'icon' => 'warning',
        ]);
    }

    /**
     * 4. Escucha el evento de confirmación final desde JavaScript ('delete-confirmed')
     *    y elimina el usuario.
     */
    #[On('delete-confirmed')]
    public function deleteUsuario(int $id): void
    {
        try {
            $user = User::findOrFail($id);

            // Opcional pero recomendado: Si el usuario tiene una foto de perfil, bórrala.
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            $user->delete();

            // Despachamos un toast de éxito usando nuestro sistema de eventos global.
            $this->dispatch('swal-toast', [
                'icon' => 'success',
                'title' => 'Usuario eliminado exitosamente'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('swal-toast', [
                'icon' => 'error',
                'title' => 'Error al eliminar el usuario',
                'text' => $e->getMessage()
            ]);
        }
    }


    /**
     * Prepara la consulta base con los filtros aplicados.
     * Es una función de ayuda para no repetir código.
     */
    private function getUsuariosQuery()
    {
        $query = User::with(['departamento.empresa']);

        if ($this->busqueda) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->busqueda . '%')
                    ->orWhere('email', 'like', '%' . $this->busqueda . '%')
                    ->orWhere('username', 'like', '%' . $this->busqueda . '%') // ← AGREGAR ESTA LÍNEA
                    ->orWhere('primer_apellido', 'like', '%' . $this->busqueda . '%');
            });
        }
        if ($this->filtroEmpresa) {
            $query->whereHas('departamento.empresa', function ($q) {
                $q->where('id_empresa', $this->filtroEmpresa);
            });
        }
        if ($this->filtroRol) {
            $query->where('rol', $this->filtroRol);
        }
        return $query;
    }

    /**
     * Exporta la vista actual a un archivo Excel.
     */
    public function exportarExcel()
    {
        $usuarios = $this->getUsuariosQuery()->orderBy($this->ordenarPor, $this->direccionOrden)->get();
        return Excel::download(new UsuariosExport($usuarios), 'usuarios-' . now()->format('Y-m-d') . '.xlsx');
    }

    /**
     * Exporta la vista actual a un archivo PDF.
     */
    public function exportarPdf()
    {
        $usuarios = $this->getUsuariosQuery()->orderBy($this->ordenarPor, $this->direccionOrden)->get();
        $pdf = Pdf::loadView('livewire.encuesta.usuario.usuarios-pdf', [
            'usuarios' => $usuarios,
            'tituloReporte' => 'Reporte General de Usuarios'
        ]);
        return response()->streamDownload(fn() => print($pdf->stream()), 'listado-usuarios-' . now()->format('Y-m-d') . '.pdf');
    }

    /**
     * Genera un ZIP con reportes generales y reportes por empresa.
     */
    public function exportarZip()
    {
        // 1. OBTENER Y AGRUPAR DATOS
        $usuarios = $this->getUsuariosQuery()->get();
        $usuariosAgrupados = $usuarios->groupBy('departamento.empresa.nombre_comercial');

        // 2. PREPARAR CARPETAS Y NOMBRES
        $fecha = now()->format('Y-m-d');
        $nombreBase = 'reporte-usuarios-' . $fecha;
        $directorioTemporal = storage_path('app/temp/' . $nombreBase);
        File::makeDirectory($directorioTemporal, 0755, true, true);

        // 3. GENERAR REPORTE GENERAL
        File::put(
            $directorioTemporal . '/usuarios-' . $fecha . '.xlsx',
            Excel::raw(new UsuariosExport($usuarios), \Maatwebsite\Excel\Excel::XLSX)
        );
        $pdfGeneral = Pdf::loadView('livewire.encuesta.usuario.usuarios-pdf', ['usuarios' => $usuarios, 'tituloReporte' => 'Reporte General']);
        File::put($directorioTemporal . '/listado-usuarios-' . $fecha . '.pdf', $pdfGeneral->output());

        // 4. GENERAR REPORTES POR EMPRESA
        foreach ($usuariosAgrupados as $nombreEmpresa => $usuariosDeLaEmpresa) {
            if (empty($nombreEmpresa)) {
                $nombreEmpresa = 'Sin Empresa Asignada';
            }

            // --- INICIO DE LA CORRECCIÓN ---

            // 1. Quitamos espacios al principio y al final del nombre de la empresa.
            $nombreLimpio = trim($nombreEmpresa);

            // 2. Saneamos el nombre para que no contenga caracteres inválidos para una carpeta.
            $nombreCarpeta = preg_replace('/[\\\\\/:\*\?"<>|]/', '', $nombreLimpio);

            // --- FIN DE LA CORRECCIÓN ---

            $directorioEmpresa = $directorioTemporal . '/' . $nombreCarpeta;
            File::makeDirectory($directorioEmpresa, 0755, true, true);

            // Guardar Excel de la empresa
            File::put(
                $directorioEmpresa . '/usuarios-' . $fecha . '.xlsx',
                Excel::raw(new UsuariosExport($usuariosDeLaEmpresa), \Maatwebsite\Excel\Excel::XLSX)
            );
            // Guardar PDF de la empresa
            $pdfEmpresa = Pdf::loadView('livewire.encuesta.usuario.usuarios-pdf', ['usuarios' => $usuariosDeLaEmpresa, 'tituloReporte' => 'Usuarios de ' . $nombreEmpresa]);
            File::put($directorioEmpresa . '/listado-usuarios-' . $fecha . '.pdf', $pdfEmpresa->output());
        }

        // 5. CREAR EL ARCHIVO ZIP
        $zip = new ZipArchive;
        $nombreZip = storage_path('app/' . $nombreBase . '.zip');
        if ($zip->open($nombreZip, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            $archivos = File::allFiles($directorioTemporal);
            foreach ($archivos as $archivo) {
                $rutaRelativa = 'reportes/usuario/' . $archivo->getRelativePathname();
                $zip->addFile($archivo->getPathname(), $rutaRelativa);
            }
            $zip->close();
        }

        // 6. LIMPIAR Y DESCARGAR
        File::deleteDirectory($directorioTemporal);
        return response()->download($nombreZip)->deleteFileAfterSend(true);
    }

    public function render()
    {
        // 1. Iniciar la consulta con la relación anidada.
        $usuariosQuery = User::with(['departamento.empresa']);

        // 2. Aplicar filtros
        if ($this->busqueda) {
            $usuariosQuery->where(function ($query) {
                $query->where('name', 'like', '%' . $this->busqueda . '%')
                    ->orWhere('email', 'like', '%' . $this->busqueda . '%')
                    ->orWhere('username', 'like', '%' . $this->busqueda . '%') // ← AGREGAR ESTA LÍNEA
                    ->orWhere('primer_apellido', 'like', '%' . $this->busqueda . '%');
            });
        }

        if ($this->filtroEmpresa) {
            $usuariosQuery->whereHas('departamento.empresa', function ($query) {
                $query->where('id_empresa', $this->filtroEmpresa);
            });
        }

        if ($this->filtroRol) {
            $usuariosQuery->where('rol', $this->filtroRol);
        }

        // 3. Obtener datos para los filtros
        $empresasFiltro = Empresa::orderBy('nombre_comercial')->get(['id_empresa', 'nombre_comercial']);
        // Asumiendo que tienes un mapeo de roles, ej. 1 => 'Admin', 2 => 'Usuario'
        $rolesFiltro = [1 => 'Usuario', 2 => 'Administrador']; // Ajusta esto a tus roles reales

        // 4. Aplicar ordenación
        $usuariosQuery->orderBy($this->ordenarPor, $this->direccionOrden);

        // 5. Paginar resultados
        $usuarios = $usuariosQuery->paginate(10);

        return view('livewire.encuesta.usuario.mostrar-usuario', [
            'usuarios' => $usuarios,
            'empresasFiltro' => $empresasFiltro,
            'rolesFiltro' => $rolesFiltro,
        ])->layout('layouts.app');
    }


    // public function render()
    // {
    //     return view('livewire.encuesta.usuario.mostrar-usuario')->layout('layouts.app');
    // }
}
