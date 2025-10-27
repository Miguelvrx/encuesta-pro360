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

    public function updating($property): void
    {
        if (in_array($property, ['busqueda', 'filtroSector', 'filtroEstado'])) {
            $this->resetPage();
        }
    }


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

        // 2. Generamos el PDF pasando todas las variables necesarias
        $pdf = Pdf::loadView('livewire.encuesta.empresas-pdf', [
            'empresas' => $empresas,
            'busqueda' => $this->busqueda,
            'filtroSector' => $this->filtroSector,
            'filtroEstado' => $this->filtroEstado
        ]);

        // 3. Descargamos el PDF en el navegador del usuario.
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'listado-empresas-' . now()->format('Y-m-d') . '.pdf');
    }

    public function exportarZip()
    {
        try {
            // 1. OBTENER DATOS
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

            if ($empresas->isEmpty()) {
                session()->flash('warning', 'No hay empresas para exportar con los filtros aplicados.');
                return;
            }

            // 2. CREAR ZIP
            $fecha = now()->format('Y-m-d_H-i-s');
            $zipFileName = 'reporte-empresas-' . $fecha . '.zip';
            $zipPath = storage_path('app/' . $zipFileName);

            $zip = new ZipArchive;

            if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {

                // 3. AGREGAR EXCEL AL ZIP (USANDO RAW)
                $export = new EmpresasExport($this->busqueda, $this->filtroSector, $this->filtroEstado);

                // Generar Excel en memoria
                $excelContent = Excel::raw($export, \Maatwebsite\Excel\Excel::XLSX);

                // Agregar Excel al ZIP
                if ($excelContent) {
                    $zip->addFromString('Reporte_Empresas.xlsx', $excelContent);
                } else {
                    throw new \Exception('No se pudo generar el archivo Excel');
                }

                // 4. AGREGAR PDF AL ZIP
                $pdf = Pdf::loadView('livewire.encuesta.empresas-pdf', [
                    'empresas' => $empresas,
                    'busqueda' => $this->busqueda,
                    'filtroSector' => $this->filtroSector,
                    'filtroEstado' => $this->filtroEstado
                ]);

                $pdfContent = $pdf->output();
                if ($pdfContent) {
                    $zip->addFromString('Listado_Empresas.pdf', $pdfContent);
                }

                $zip->close();

                // 5. VERIFICAR QUE EL ZIP SE CREÓ CORRECTAMENTE
                if (!File::exists($zipPath) || File::size($zipPath) === 0) {
                    throw new \Exception('El archivo ZIP se creó vacío o no se creó');
                }

                // 6. DESCARGAR
                return response()->download($zipPath, $zipFileName)->deleteFileAfterSend(true);
            } else {
                throw new \Exception('No se pudo crear el archivo ZIP');
            }
        } catch (\Exception $e) {
            // Limpiar en caso de error
            if (isset($zipPath) && File::exists($zipPath)) {
                File::delete($zipPath);
            }

            session()->flash('error', 'Error al generar el archivo ZIP: ' . $e->getMessage());
            logger()->error('Error en exportarZip: ' . $e->getMessage());
            return;
        }
    }


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
