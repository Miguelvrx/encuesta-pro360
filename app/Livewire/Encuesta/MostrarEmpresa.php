<?php

namespace App\Livewire\Encuesta;

use App\Exports\EmpresasExport;
use App\Models\Empresa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use ZipArchive;

class MostrarEmpresa extends Component
{
    // 2. Usar los traits necesarios

    // use WithPagination;
    use WithPagination;

    // 3. Propiedades para los filtros y la búsqueda
    public string $busqueda = '';
    public string $filtroSector = '';
    public string $filtroEstado = '';
    // public string $ordenarPor = 'created_at';
    public string $direccionOrden = 'desc';
    public string $ordenarPor = 'id_empresa'; // Cambiado a id_empresa por defecto

    // 4. Atributo para mantener la URL limpia y amigable
    //    Esto hace que los filtros y la búsqueda se reflejen en la URL
    #[\Livewire\Attributes\Url]
    protected $queryString = [
        'busqueda' => ['except' => ''],
        'filtroSector' => ['except' => ''],
        'filtroEstado' => ['except' => ''],
    ];

    /**
     * Este método se ejecuta cada vez que una propiedad con #[Url] cambia.
     * Resetea la paginación para que el usuario siempre vaya a la primera página
     * de los nuevos resultados filtrados.
     */
    // public function updating($property): void
    // {
    //     if (in_array($property, ['busqueda', 'filtroSector', 'filtroEstado'])) {
    //         $this->resetPage();
    //     }
    // }
    public function updating($property): void
    {
        if (in_array($property, ['busqueda', 'filtroSector', 'filtroEstado'])) {
            $this->resetPage();
        }
    }

    /**
     * Método para cambiar la columna de ordenación y la dirección.
     */
    // public function ordenar($columna): void
    // {
    //     if ($this->ordenarPor === $columna) {
    //         $this->direccionOrden = $this->direccionOrden === 'asc' ? 'desc' : 'asc';
    //     } else {
    //         $this->ordenarPor = $columna;
    //         $this->direccionOrden = 'asc';
    //     }
    // }

    public function ordenar($columna): void
    {
        if ($this->ordenarPor === $columna) {
            $this->direccionOrden = $this->direccionOrden === 'asc' ? 'desc' : 'asc';
        } else {
            $this->ordenarPor = $columna;
            $this->direccionOrden = 'asc';
        }
    }



    #[On('confirm-delete')]
    public function showDeleteConfirmation(int $id): void
    {
        $this->dispatch('show-swal-delete', [
            'id' => $id,
            'title' => '¿Estás seguro?',
            'text' => 'Vas a eliminar esta empresa y todos sus datos asociados (departamentos, etc.). ¡Esta acción no se puede deshacer!',
            'icon' => 'warning',
        ]);
    }

    /**
     * 4. Escucha el evento final 'delete-confirmed' desde SweetAlert y elimina la empresa.
     */
    // #[On('delete-confirmed')]
    // public function deleteEmpresa(int $id): void
    // {
    //     try {
    //         $empresa = Empresa::findOrFail($id);

    //         // Si la empresa tiene un logo, lo borramos del almacenamiento.
    //         if ($empresa->logo) { // <-- Corregido de 'image' a 'logo' para coincidir con la BD
    //             Storage::disk('public')->delete($empresa->logo);
    //         }

    //         $empresa->delete();

    //         // Usamos session()->flash() para el mensaje de éxito.
    //         session()->flash('message', 'Empresa eliminada exitosamente.');

    //         $this->resetPage();
    //     } catch (\Exception $e) {
    //         session()->flash('error', 'Error al eliminar la empresa: ' . $e->getMessage());
    //     }
    // }
    // #[On('delete-confirmed')]
    // public function deleteEmpresa(int $id): void
    // {
    //     try {
    //         $empresa = Empresa::findOrFail($id);

    //         if ($empresa->logo) {
    //             Storage::disk('public')->delete($empresa->logo);
    //         }

    //         $empresa->delete();

    //         // Cambia session()->flash() por dispatch para Toastr
    //         $this->dispatch('toastr-success', message: 'Empresa eliminada exitosamente.');

    //         $this->resetPage();
    //     } catch (\Exception $e) {
    //         $this->dispatch('toastr-error', message: 'Error al eliminar la empresa: ' . $e->getMessage());
    //     }
    // }

    #[On('delete-confirmed')]
    public function deleteEmpresa(int $id): void
    {
        try {
            $empresa = Empresa::findOrFail($id);

            // En lugar de eliminar permanentemente, usamos soft delete
            $empresa->delete();

            $this->dispatch('toastr-success', message: 'Empresa movida a la papelera exitosamente.');

            $this->resetPage();
        } catch (\Exception $e) {
            $this->dispatch('toastr-error', message: 'Error al eliminar la empresa: ' . $e->getMessage());
        }
    }

    public function exportarExcel()
    {
        // El nombre del archivo que se descargará.
        $fileName = 'empresas-' . now()->format('Y-m-d') . '.xlsx';

        // Pasamos los filtros actuales al constructor de la clase de exportación.
        // Esto asegura que el Excel contenga exactamente los mismos datos que se ven en la tabla.
        $export = new EmpresasExport($this->busqueda, $this->filtroSector, $this->filtroEstado);

        // Usamos la fachada de Maatwebsite/Excel para descargar el archivo.
        return Excel::download($export, $fileName);
    }

    public function exportarPdf()
    {
        // 1. Obtenemos los datos con los mismos filtros que la tabla.
        //    Reutilizamos la lógica de la consulta del método render().
        $empresasQuery = Empresa::query();

        if ($this->busqueda) {
            $empresasQuery->where(function ($query) {
                $query->where('nombre_comercial', 'like', '%' . $this->busqueda . '%')
                    ->orWhere('razon_social', 'like', '%' . $this->busqueda . '%')
                    ->orWhere('rfc', 'like', '%' . $this->busqueda . '%');
            });
        }
        if ($this->filtroSector) {
            $empresasQuery->where('sector', $this->filtroSector);
        }
        if ($this->filtroEstado) {
            $empresasQuery->where('estado_inicial', $this->filtroEstado);
        }

        // Aplicamos la ordenación actual de la tabla
        $empresas = $empresasQuery->orderBy($this->ordenarPor, $this->direccionOrden)->get();

        // 2. Generamos el PDF
        $pdf = Pdf::loadView('livewire.encuesta.empresas-pdf', [
            'empresas' => $empresas
        ]);

        // 3. Descargamos el PDF en el navegador del usuario.
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'listado-empresas-' . now()->format('Y-m-d') . '.pdf');
    }

    public function exportarZip()
    {
        // 1. OBTENER LOS DATOS FILTRADOS (sin cambios)
        $empresasQuery = Empresa::query();
        if ($this->busqueda) {
            $empresasQuery->where(function ($query) {
                $query->where('nombre_comercial', 'like', '%' . $this->busqueda . '%')
                    ->orWhere('razon_social', 'like', '%' . $this->busqueda . '%')
                    ->orWhere('rfc', 'like', '%' . $this->busqueda . '%');
            });
        }
        if ($this->filtroSector) {
            $empresasQuery->where('sector', $this->filtroSector);
        }
        if ($this->filtroEstado) {
            $empresasQuery->where('estado_inicial', $this->filtroEstado);
        }
        $empresas = $empresasQuery->orderBy($this->ordenarPor, $this->direccionOrden)->get();

        // 2. PREPARAR CARPETAS Y NOMBRES DE ARCHIVO (sin cambios)
        $fecha = now()->format('Y-m-d');
        $nombreBase = 'reporte-empresas-' . $fecha;
        $directorioTemporal = storage_path('app/temp/' . $nombreBase);

        File::makeDirectory($directorioTemporal . '/empresa', 0755, true, true);

        $rutaExcel = $directorioTemporal . '/empresa/empresas-' . $fecha . '.xlsx';
        $rutaPdf = $directorioTemporal . '/empresa/listado-empresas-' . $fecha . '.pdf';

        // --- INICIO DE LA CORRECCIÓN ---

        // 3. GENERAR Y GUARDAR LOS ARCHIVOS (Lógica de Excel modificada)
        try {
            // Guardar Excel de forma explícita
            $export = new EmpresasExport($this->busqueda, $this->filtroSector, $this->filtroEstado);
            $contenidoExcel = Excel::raw($export, \Maatwebsite\Excel\Excel::XLSX);
            File::put($rutaExcel, $contenidoExcel);

            // Guardar PDF (sin cambios)
            $pdf = Pdf::loadView('livewire.encuesta.empresas-pdf', ['empresas' => $empresas]);
            File::put($rutaPdf, $pdf->output());
        } catch (\Exception $e) {
            // Si algo falla al generar los archivos, podemos manejar el error aquí.
            // Por ejemplo, mostrando un mensaje de error al usuario.
            session()->flash('error', 'No se pudieron generar los archivos de reporte: ' . $e->getMessage());
            return; // Detenemos la ejecución
        }

        // --- FIN DE LA CORRECCIÓN ---

        // 4. CREAR EL ARCHIVO ZIP (sin cambios)
        $zip = new ZipArchive;
        $nombreZip = storage_path('app/' . $nombreBase . '.zip');

        if ($zip->open($nombreZip, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            $archivos = File::allFiles($directorioTemporal);
            foreach ($archivos as $archivo) {
                $rutaRelativa = 'reportes/' . substr($archivo->getPathname(), strlen($directorioTemporal) + 1);
                $zip->addFile($archivo->getPathname(), $rutaRelativa);
            }
            $zip->close();
        }

        // 5. LIMPIAR LA CARPETA TEMPORAL (sin cambios)
        File::deleteDirectory($directorioTemporal);

        // 6. DESCARGAR EL ZIP Y LUEGO BORRARLO DEL SERVIDOR (sin cambios)
        return response()->download($nombreZip)->deleteFileAfterSend(true);
    }




    // public function render()
    // {
    //     // 1. Construir la consulta a la base de datos con los filtros
    //     $empresasQuery = Empresa::query();

    //     // Aplicar filtro de búsqueda
    //     if ($this->busqueda) {
    //         $empresasQuery->where(function ($query) {
    //             $query->where('nombre_comercial', 'like', '%' . $this->busqueda . '%')
    //                 ->orWhere('razon_social', 'like', '%' . $this->busqueda . '%')
    //                 ->orWhere('rfc', 'like', '%' . $this->busqueda . '%');
    //         });
    //     }

    //     // Aplicar filtro por sector
    //     if ($this->filtroSector) {
    //         $empresasQuery->where('sector', $this->filtroSector);
    //     }

    //     // Aplicar filtro por estado inicial
    //     if ($this->filtroEstado) {
    //         $empresasQuery->where('estado_inicial', $this->filtroEstado);
    //     }

    //     // --- INICIO DE LA CORRECCIÓN ---

    //     // 2. OBTENER DATOS PARA LOS FILTROS (ANTES DE ORDENAR)
    //     //    Clonamos la consulta con los `where` pero sin el `orderBy`.
    //     $sectores = (clone $empresasQuery)->distinct()->pluck('sector')->sort();
    //     $estados = (clone $empresasQuery)->distinct()->pluck('estado_inicial')->sort();

    //     // 3. AHORA SÍ, APLICAR LA ORDENACIÓN a la consulta principal
    //     $empresasQuery->orderBy($this->ordenarPor, $this->direccionOrden);

    //     // 4. Obtener los datos paginados
    //     $empresas = $empresasQuery->paginate(10);

    //     // --- FIN DE LA CORRECCIÓN ---

    //     // 5. Pasar todos los datos a la vista
    //     return view('livewire.encuesta.mostrar-empresa', [
    //         'empresas' => $empresas,
    //         'sectores' => $sectores,
    //         'estados' => $estados,
    //     ])->layout('layouts.app');
    // }

    public function render()
    {
        $empresasQuery = Empresa::query();

        if ($this->busqueda) {
            $empresasQuery->where(function ($query) {
                $query->where('nombre_comercial', 'like', '%' . $this->busqueda . '%')
                    ->orWhere('razon_social', 'like', '%' . $this->busqueda . '%')
                    ->orWhere('rfc', 'like', '%' . $this->busqueda . '%')
                    ->orWhere('id_empresa', 'like', '%' . $this->busqueda . '%'); // Agregar búsqueda por ID
            });
        }

        if ($this->filtroSector) {
            $empresasQuery->where('sector', $this->filtroSector);
        }

        if ($this->filtroEstado) {
            $empresasQuery->where('estado_inicial', $this->filtroEstado);
        }

        $sectores = (clone $empresasQuery)->distinct()->pluck('sector')->sort();
        $estados = (clone $empresasQuery)->distinct()->pluck('estado_inicial')->sort();

        $empresasQuery->orderBy($this->ordenarPor, $this->direccionOrden);
        $empresas = $empresasQuery->paginate(10);

        return view('livewire.encuesta.mostrar-empresa', [
            'empresas' => $empresas,
            'sectores' => $sectores,
            'estados' => $estados,
        ])->layout('layouts.app');
    }


    // public function render()
    // {
    //     return view('livewire.encuesta.mostrar-empresa');
    // }
}
