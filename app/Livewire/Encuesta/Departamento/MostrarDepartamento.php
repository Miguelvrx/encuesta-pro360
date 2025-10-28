<?php

namespace App\Livewire\Encuesta\Departamento;

use App\Models\Departamento;
use App\Models\Empresa;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

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
