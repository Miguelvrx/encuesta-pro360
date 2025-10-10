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
        $this->categorias = Categoria::orderBy('categoria')->get(); // Corregido
    }

    public function updating($property, $value): void
    {
        if ($property === 'busqueda' || $property === 'categoriaFiltro') {
            $this->resetPage();
        }
    }

    public function render()
    {
        // --- INICIO DE LA SOLUCIÓN ---
        // 1. Modificamos la consulta para ordenar los niveles en orden descendente.
        //    Esto asume que los niveles se guardan en orden ascendente de importancia (1 a 5).
        $query = Competencia::with(['categoria', 'niveles' => function ($query) {
            $query->orderBy('id_nivel', 'desc'); // Ordenar de mayor a menor
        }]);
        // --- FIN DE LA SOLUCIÓN ---

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
