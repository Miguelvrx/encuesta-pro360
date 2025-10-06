<?php

namespace App\Livewire\Encuesta;

use App\Models\Empresa;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class MostrarEmpresa extends Component
{
    // 2. Usar los traits necesarios

    // use WithPagination;
    use WithPagination;

    // 3. Propiedades para los filtros y la búsqueda
    public string $busqueda = '';
    public string $filtroSector = '';
    public string $filtroEstado = '';
    public string $ordenarPor = 'created_at';
    public string $direccionOrden = 'desc';

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
    public function updating($property): void
    {
        if (in_array($property, ['busqueda', 'filtroSector', 'filtroEstado'])) {
            $this->resetPage();
        }
    }

    /**
     * Método para cambiar la columna de ordenación y la dirección.
     */
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
    #[On('delete-confirmed')]
    public function deleteEmpresa(int $id): void
    {
        try {
            $empresa = Empresa::findOrFail($id);

            // Si la empresa tiene un logo, lo borramos del almacenamiento.
            if ($empresa->logo) { // <-- Corregido de 'image' a 'logo' para coincidir con la BD
                Storage::disk('public')->delete($empresa->logo);
            }

            $empresa->delete();

            // Usamos session()->flash() para el mensaje de éxito.
            session()->flash('message', 'Empresa eliminada exitosamente.');

            $this->resetPage();
        } catch (\Exception $e) {
            session()->flash('error', 'Error al eliminar la empresa: ' . $e->getMessage());
        }
    }



    public function render()
    {
        // 1. Construir la consulta a la base de datos con los filtros
        $empresasQuery = Empresa::query();

        // Aplicar filtro de búsqueda
        if ($this->busqueda) {
            $empresasQuery->where(function ($query) {
                $query->where('nombre_comercial', 'like', '%' . $this->busqueda . '%')
                    ->orWhere('razon_social', 'like', '%' . $this->busqueda . '%')
                    ->orWhere('rfc', 'like', '%' . $this->busqueda . '%');
            });
        }

        // Aplicar filtro por sector
        if ($this->filtroSector) {
            $empresasQuery->where('sector', $this->filtroSector);
        }

        // Aplicar filtro por estado inicial
        if ($this->filtroEstado) {
            $empresasQuery->where('estado_inicial', $this->filtroEstado);
        }

        // --- INICIO DE LA CORRECCIÓN ---

        // 2. OBTENER DATOS PARA LOS FILTROS (ANTES DE ORDENAR)
        //    Clonamos la consulta con los `where` pero sin el `orderBy`.
        $sectores = (clone $empresasQuery)->distinct()->pluck('sector')->sort();
        $estados = (clone $empresasQuery)->distinct()->pluck('estado_inicial')->sort();

        // 3. AHORA SÍ, APLICAR LA ORDENACIÓN a la consulta principal
        $empresasQuery->orderBy($this->ordenarPor, $this->direccionOrden);

        // 4. Obtener los datos paginados
        $empresas = $empresasQuery->paginate(10);

        // --- FIN DE LA CORRECCIÓN ---

        // 5. Pasar todos los datos a la vista
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
