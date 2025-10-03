<?php

namespace App\Livewire\Encuesta\Competencia;

use App\Models\CategoriaCompetencia;
use App\Models\Competencia;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class CatalogoCompetencia extends Component
{
      // Propiedades para los filtros
    public ?int $categoriaSeleccionada = null;
    public ?int $competenciaSeleccionada = null;

    // Colecciones para llenar los selects
    public Collection $categorias;
    public Collection $competenciasFiltradas;

    // Propiedad para mostrar los detalles de la competencia elegida
    public ?Competencia $competenciaActual = null;

    public function mount(): void
    {
        // Cargar todas las categorías y inicializar la lista de competencias
        $this->categorias = CategoriaCompetencia::orderBy('categoria')->get();
        $this->competenciasFiltradas = new Collection(); // Empezar con una colección vacía
    }

    // Hook que se ejecuta cuando se actualiza 'categoriaSeleccionada'
    public function updatedCategoriaSeleccionada($value): void
    {
        if (!is_null($value) && $value !== '') {
            // Si se selecciona una categoría, filtramos las competencias
            $this->competenciasFiltradas = Competencia::where('categoria_id_competencia', $value)
                ->orderBy('nombre_competencia')
                ->get();
        } else {
            // Si se deselecciona, vaciamos la lista
            $this->competenciasFiltradas = new Collection();
        }
        // Reseteamos la competencia seleccionada y los detalles
        $this->reset(['competenciaSeleccionada', 'competenciaActual']);
    }

    // Hook que se ejecuta cuando se actualiza 'competenciaSeleccionada'
    public function updatedCompetenciaSeleccionada($value): void
    {
        if (!is_null($value) && $value !== '') {
            // Si se selecciona una competencia, la cargamos con sus relaciones
            $this->competenciaActual = Competencia::with('categoria', 'niveles')->find($value);
        } else {
            $this->competenciaActual = null;
        }
    }

    public function render()
    {
        return view('livewire.encuesta.competencia.catalogo-competencia')->layout('layouts.app');
    }
}
