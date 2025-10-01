<?php

namespace App\Livewire\Encuesta;

use App\Models\Empresa;
use Illuminate\Support\Facades\Storage;
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

    //  public function deleteEmpresa(int $id): void
    // {
    //     try {
    //         // 1. Buscamos la empresa por su ID.
    //         $empresa = Empresa::findOrFail($id);

    //         // 2. (Opcional pero recomendado) Si tienes un logo, bórralo del almacenamiento
    //         //    para no dejar archivos huérfanos.
    //         if ($empresa->logo) {
    //             \Illuminate\Support\Facades\Storage::disk('public')->delete($empresa->logo);
    //         }

    //         // 3. Eliminamos el registro de la base de datos.
    //         $empresa->delete();

    //         // 4. (Opcional) Puedes mostrar un mensaje de éxito si lo deseas.
    //         //    Para esto, necesitarías añadir el bloque de mensajes en tu vista `mostrar-empresa`.
    //         session()->flash('message', 'Empresa eliminada exitosamente.');

    //         // 5. Forzamos la re-renderización del componente para que la empresa desaparezca de la tabla.
    //         //    Aunque Livewire suele hacerlo automáticamente, a veces es bueno ser explícito.
    //         $this->resetPage(); // Vuelve a la primera página si la página actual queda vacía.

    //     } catch (\Exception $e) {
    //         // En caso de error, mostramos un mensaje.
    //         session()->flash('error', 'Error al eliminar la empresa: ' . $e->getMessage());
    //     }
    // }

    public function deleteEmpresa(int $id): void
    {
        try {
            $empresa = Empresa::findOrFail($id);
            if ($empresa->image) {
                Storage::disk('public')->delete($empresa->image);
            }
            $empresa->delete();

            // Volvemos a usar session()->flash()
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
