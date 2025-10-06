<?php

namespace App\Livewire\Encuesta\Competencia;

use App\Models\Categoria;
use App\Models\CategoriaCompetencia;
use App\Models\Competencia;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class RevisarComptencia extends Component
{

      use WithPagination;

    // Propiedades para los filtros, con el atributo #[Url] para que se reflejen en la URL
    #[Url(as: 'q', keep: true)]
    public string $busqueda = '';

    #[Url(keep: true)]
    public ?int $categoriaFiltro = null;

    // Propiedad para cargar la lista de categorías en el filtro
    public $categorias;

    public function mount(): void
    {
        // Cargar las categorías una sola vez al iniciar el componente
        $this->categorias = Categoria::orderBy('categoria')->get();
    }

    // Este método se ejecuta automáticamente cuando cambia la propiedad 'busqueda' o 'categoriaFiltro'
    public function updating($property, $value): void
    {
        // Si se modifica un filtro, reseteamos la paginación a la página 1
        if ($property === 'busqueda' || $property === 'categoriaFiltro') {
            $this->resetPage();
        }
    }

    public function render()
    {
        // Empezamos la consulta de competencias con sus relaciones para optimizar
        $query = Competencia::with(['categoria', 'niveles' => function ($query) {
            $query->orderBy('id_nivel'); // Opcional: ordenar niveles
        }]);

        // Aplicar filtro de búsqueda si no está vacío
        if (!empty($this->busqueda)) {
            $query->where('nombre_competencia', 'like', '%' . $this->busqueda . '%');
        }

        // Aplicar filtro de categoría si se ha seleccionado una
        if (!is_null($this->categoriaFiltro)) {
            $query->where('categoria_id_competencia', $this->categoriaFiltro);
        }

        // Obtener los resultados paginados
        $competencias = $query->orderBy('nombre_competencia')->paginate(5); // 5 por página para que no sea muy largo

        return view('livewire.encuesta.competencia.revisar-comptencia', [
            'competencias' => $competencias,
        ])->layout('layouts.app');
    }


    // public function render()
    // {
    //     return view('livewire.encuesta.competencia.revisar-comptencia')->layout('layouts.app');
    // }
}
