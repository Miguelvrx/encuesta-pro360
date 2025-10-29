<?php

namespace App\Livewire\Encuesta\Departamento;

use App\Exports\DepartamentosExport;
use App\Models\Departamento;
use App\Models\Empresa;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use ZipArchive;

class MostrarDepartamento extends Component
{
    use WithPagination;


    // Propiedades para filtros y búsqueda
    #[Url(except: '')]
    public string $busqueda = '';

    #[Url(except: '')]
    public string $filtroEmpresa = '';

    #[Url(except: '')]
    public string $filtroEstado = '';

    // Propiedades para la ordenación
    public string $ordenarPor = 'created_at';
    public string $direccionOrden = 'desc';

    /**
     * Resetea la paginación cuando se aplica un filtro.
     */
    public function updating($property): void
    {
        if (in_array($property, ['busqueda', 'filtroEmpresa', 'filtroEstado'])) {
            $this->resetPage();
        }
    }

    /**
     * Cambia la columna y dirección de la ordenación.
     */
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
     * Escucha el evento 'confirm-delete' despachado por el botón en la vista.
     * Su única función es despachar otro evento que el script global de SweetAlert pueda capturar.
     */
    #[On('confirm-delete')]
    public function showDeleteConfirmation(int $id): void
    {
        $this->dispatch('show-swal-delete', [
            'id' => $id,
            'title' => '¿Estás seguro?',
            'text' => 'Vas a eliminar este departamento. ¡Esta acción no se puede deshacer!',
            'icon' => 'warning',
        ]);
    }
    // --- FIN DE LA SOLUCIÓN ---

    /**
     * Escucha el evento de confirmación final desde JavaScript ('delete-confirmed')
     * y elimina el departamento.
     */
    #[On('delete-confirmed')]
    public function deleteDepartamento(int $id): void // <-- Asegúrate que este también reciba solo el $id
    {
        try {
            Departamento::findOrFail($id)->delete();
            session()->flash('message', 'Departamento eliminado exitosamente.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error al eliminar el departamento: ' . $e->getMessage());
        }
        // No es necesario resetPage() aquí, Livewire re-renderizará la vista.
    }

    public function exportarPdf()
    {
        // 1. Obtenemos los datos con los mismos filtros que la tabla.
        $departamentosQuery = Departamento::with('empresa');

        if ($this->busqueda) {
            $departamentosQuery->where(function ($query) {
                $query->where('nombre_departamento', 'like', '%' . $this->busqueda . '%')
                    ->orWhere('puesto', 'like', '%' . $this->busqueda . '%')
                    ->orWhere('descripcion', 'like', '%' . $this->busqueda . '%');
            });
        }

        if ($this->filtroEmpresa) {
            $departamentosQuery->where('empresa_id_empresa', $this->filtroEmpresa);
        }

        if ($this->filtroEstado) {
            $departamentosQuery->where('estado', $this->filtroEstado);
        }

        // Aplicamos la ordenación actual de la tabla
        $departamentos = $departamentosQuery->orderBy($this->ordenarPor, $this->direccionOrden)->get();

        // Obtener nombre de la empresa si hay filtro
        $empresaFiltroNombre = null;
        if ($this->filtroEmpresa) {
            $empresa = Empresa::find($this->filtroEmpresa);
            $empresaFiltroNombre = $empresa ? $empresa->nombre_comercial : null;
        }

        // 2. Generamos el PDF pasando todas las variables necesarias
        $pdf = Pdf::loadView('livewire.encuesta.departamento.departamento-pdf', [
            'departamentos' => $departamentos,
            'busqueda' => $this->busqueda,
            'filtroEmpresa' => $empresaFiltroNombre,
            'filtroEstado' => $this->filtroEstado
        ]);

        // 3. Descargamos el PDF en el navegador del usuario.
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'listado-departamentos-' . now()->format('Y-m-d') . '.pdf');
    }


    /**
     * Exporta el listado de departamentos a un archivo Excel.
     */
    public function exportarExcel()
    {
        // 1. Creamos una instancia de la clase de exportación, pasando los filtros y la ordenación
        // para que la consulta en la clase de exportación sea la misma que la de la tabla.
        $export = new DepartamentosExport(
            $this->busqueda,
            $this->filtroEmpresa,
            $this->filtroEstado,
            $this->ordenarPor,
            $this->direccionOrden
        );

        // 2. Definimos el nombre del archivo
        $fileName = 'listado-departamentos-' . now()->format('Y-m-d') . '.xlsx';

        // 3. Descargamos el archivo Excel
        return Excel::download($export, $fileName);
    }


    /**
     * Genera un ZIP con reportes generales y reportes por empresa en MostrarDepartamento.
     */
    public function exportarZip()
    {
        // 1. OBTENER Y AGRUPAR DATOS
        $departamentosQuery = Departamento::with('empresa');

        // Aplicar los mismos filtros que en la tabla
        if ($this->busqueda) {
            $departamentosQuery->where(function ($query) {
                $query->where('nombre_departamento', 'like', '%' . $this->busqueda . '%')
                    ->orWhere('puesto', 'like', '%' . $this->busqueda . '%')
                    ->orWhere('descripcion', 'like', '%' . $this->busqueda . '%');
            });
        }

        if ($this->filtroEmpresa) {
            $departamentosQuery->where('empresa_id_empresa', $this->filtroEmpresa);
        }

        if ($this->filtroEstado) {
            $departamentosQuery->where('estado', $this->filtroEstado);
        }

        // Aplicar ordenación
        $departamentos = $departamentosQuery->orderBy($this->ordenarPor, $this->direccionOrden)->get();

        // Agrupar departamentos por empresa
        $departamentosAgrupados = $departamentos->groupBy('empresa.nombre_comercial');

        // 2. PREPARAR CARPETAS Y NOMBRES
        $fecha = now()->format('Y-m-d');
        $nombreBase = 'reporte-departamentos-' . $fecha;
        $directorioTemporal = storage_path('app/temp/' . $nombreBase);
        \Illuminate\Support\Facades\File::makeDirectory($directorioTemporal, 0755, true, true);

        // 3. GENERAR REPORTE GENERAL
        \Illuminate\Support\Facades\File::put(
            $directorioTemporal . '/departamentos-' . $fecha . '.xlsx',
            Excel::raw(new DepartamentosExport(
                $this->busqueda,
                $this->filtroEmpresa,
                $this->filtroEstado,
                $this->ordenarPor,
                $this->direccionOrden
            ), \Maatwebsite\Excel\Excel::XLSX)
        );

        $pdfGeneral = Pdf::loadView('livewire.encuesta.departamento.departamento-pdf', [
            'departamentos' => $departamentos,
            'busqueda' => $this->busqueda,
            'filtroEmpresa' => null,
            'filtroEstado' => $this->filtroEstado
        ]);
        \Illuminate\Support\Facades\File::put($directorioTemporal . '/listado-departamentos-' . $fecha . '.pdf', $pdfGeneral->output());

        // 4. GENERAR REPORTES POR EMPRESA
        foreach ($departamentosAgrupados as $nombreEmpresa => $departamentosDeLaEmpresa) {
            if (empty($nombreEmpresa)) {
                $nombreEmpresa = 'Sin Empresa Asignada';
            }

            // Limpiar y sanear el nombre de la empresa para usarlo como carpeta
            $nombreLimpio = trim($nombreEmpresa);
            $nombreCarpeta = preg_replace('/[\\\\\/:\*\?"<>|]/', '', $nombreLimpio);

            $directorioEmpresa = $directorioTemporal . '/' . $nombreCarpeta;
            \Illuminate\Support\Facades\File::makeDirectory($directorioEmpresa, 0755, true, true);

            // Guardar Excel de la empresa
            // Crear una exportación específica para esta empresa
            $exportEmpresa = new DepartamentosExport(
                '',
                $departamentosDeLaEmpresa->first()->empresa_id_empresa ?? '',
                $this->filtroEstado,
                $this->ordenarPor,
                $this->direccionOrden
            );

            \Illuminate\Support\Facades\File::put(
                $directorioEmpresa . '/departamentos-' . $fecha . '.xlsx',
                Excel::raw($exportEmpresa, \Maatwebsite\Excel\Excel::XLSX)
            );

            // Guardar PDF de la empresa
            $pdfEmpresa = Pdf::loadView('livewire.encuesta.departamento.departamento-pdf', [
                'departamentos' => $departamentosDeLaEmpresa,
                'busqueda' => '',
                'filtroEmpresa' => $nombreEmpresa,
                'filtroEstado' => $this->filtroEstado
            ]);
            \Illuminate\Support\Facades\File::put($directorioEmpresa . '/listado-departamentos-' . $fecha . '.pdf', $pdfEmpresa->output());
        }

        // 5. CREAR EL ARCHIVO ZIP
        $zip = new \ZipArchive;
        $nombreZip = storage_path('app/' . $nombreBase . '.zip');
        if ($zip->open($nombreZip, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
            $archivos = \Illuminate\Support\Facades\File::allFiles($directorioTemporal);
            foreach ($archivos as $archivo) {
                $rutaRelativa = 'reportes/departamento/' . $archivo->getRelativePathname();
                $zip->addFile($archivo->getPathname(), $rutaRelativa);
            }
            $zip->close();
        }

        // 6. LIMPIAR Y DESCARGAR
        \Illuminate\Support\Facades\File::deleteDirectory($directorioTemporal);
        return response()->download($nombreZip)->deleteFileAfterSend(true);
    }


    /**
     * Renderiza la vista con los datos filtrados y paginados.
     */
    public function render()
    {
        // 1. Iniciar la consulta con la relación 'empresa' para evitar N+1 queries.
        $departamentosQuery = Departamento::with('empresa');

        // 2. Aplicar filtros
        if ($this->busqueda) {
            $departamentosQuery->where(function ($query) {
                $query->where('nombre_departamento', 'like', '%' . $this->busqueda . '%')
                    ->orWhere('puesto', 'like', '%' . $this->busqueda . '%');
            });
        }

        if ($this->filtroEmpresa) {
            $departamentosQuery->where('empresa_id_empresa', $this->filtroEmpresa);
        }

        if ($this->filtroEstado) {
            $departamentosQuery->where('estado', $this->filtroEstado);
        }

        // 3. Obtener datos para los selectores de filtro
        $empresasFiltro = Empresa::orderBy('nombre_comercial')->get(['id_empresa', 'nombre_comercial']);
        $estadosFiltro = ['activo', 'inactivo'];

        // 4. Aplicar ordenación
        $departamentosQuery->orderBy($this->ordenarPor, $this->direccionOrden);

        // 5. Paginar los resultados
        $departamentos = $departamentosQuery->paginate(10);

        // 6. Pasar los datos a la vista
        return view('livewire.encuesta.departamento.mostrar-departamento', [
            'departamentos' => $departamentos,
            'empresasFiltro' => $empresasFiltro,
            'estadosFiltro' => $estadosFiltro,
        ])->layout('layouts.app');
    }
    // public function render()
    // {
    //     return view('livewire.encuesta.departamento.mostrar-departamento')->layout('layouts.app');
    // }
}
