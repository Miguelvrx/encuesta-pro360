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

    #[Url(as: 'q', keep: true)]
    public string $busqueda = '';

    #[Url(keep: true)]
    public ?int $categoriaFiltro = null;

    public $categorias;

    public function mount(): void
    {
        // Cambiado de Categoria a CategoriaCompetencia
        $this->categorias = Categoria::orderBy('categoria')->get();
    }

    public function updating($property, $value): void
    {
        if ($property === 'busqueda' || $property === 'categoriaFiltro') {
            $this->resetPage();
        }
    }

    /**
     * ========== MÉTODO FALTANTE: resetFiltros ==========
     * Este método limpia todos los filtros y resetea la paginación
     */
    public function resetFiltros(): void
    {
        $this->reset(['busqueda', 'categoriaFiltro']);
        $this->resetPage();
    }

    public function render()
    {
        // Query con ordenamiento de niveles descendente
        $query = Competencia::with(['categoria', 'niveles' => function ($query) {
            // Asumiendo que tienes una columna 'numero_nivel' o 'valor' que guarda el nivel numérico
            // Si no la tienes, ordena por id_nivel desc
            $query->orderBy('id_nivel', 'desc');
        }]);

        if (!empty($this->busqueda)) {
            $query->where('nombre_competencia', 'like', '%' . $this->busqueda . '%');
        }

        if (!is_null($this->categoriaFiltro)) {
            $query->where('categoria_id_competencia', $this->categoriaFiltro);
        }

        $competencias = $query->orderBy('nombre_competencia')->paginate(5);

        return view('livewire.encuesta.competencia.revisar-comptencia', [
            'competencias' => $competencias,
        ])->layout('layouts.app');
    }

    // public function render()
    // {
    //     return view('livewire.encuesta.competencia.revisar-comptencia')->layout('layouts.app');
    // }
}
