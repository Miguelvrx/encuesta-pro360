<?php

namespace App\Livewire\Encuesta\Competencia;

use App\Models\Categoria;
use App\Models\CategoriaCompetencia;
use App\Models\Competencia;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;
use Livewire\WithPagination;

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

    public int $competenciasTotales = 0;

    // Nueva propiedad para la vista de catálogo completo
    public $vistaCatalogo = false;
    public Collection $competenciasCatalogo;

    public function mount(): void
    {
        // Cargar todas las categorías y inicializar colecciones vacías
        $this->categorias = Categoria::orderBy('categoria')->get();
        $this->competenciasFiltradas = new Collection();
        $this->competenciasCatalogo = new Collection();

        // Calcular el total de competencias
        $this->competenciasTotales = Competencia::distinct('id_competencia')->count();
    }

    // Hook que se ejecuta cuando se actualiza 'categoriaSeleccionada'
    public function updatedCategoriaSeleccionada($value): void
    {
        if (!is_null($value) && $value !== '') {
            // Filtramos las competencias ELIMINANDO DUPLICADOS con distinct()
            $this->competenciasFiltradas = Competencia::where('categoria_id_competencia', $value)
                ->distinct() // Elimina duplicados
                ->orderBy('nombre_competencia')
                ->get();
        } else {
            $this->competenciasFiltradas = new Collection();
        }

        // Reseteamos la competencia seleccionada y los detalles
        $this->reset(['competenciaSeleccionada', 'competenciaActual', 'vistaCatalogo']);
        $this->competenciasCatalogo = new Collection();
    }

    // Hook que se ejecuta cuando se actualiza 'competenciaSeleccionada'
    public function updatedCompetenciaSeleccionada($value): void
    {
        if (!is_null($value) && $value !== '') {
            // Si se selecciona una competencia, la cargamos con sus relaciones
            $this->competenciaActual = Competencia::with('categoria', 'niveles')->find($value);
            $this->vistaCatalogo = false;
            $this->competenciasCatalogo = new Collection();
        } else {
            $this->competenciaActual = null;
        }
    }

    // Método para ver todas las competencias de una categoría en una sola página
    public function verCatalogoCompleto()
    {
        if ($this->categoriaSeleccionada) {
            $this->vistaCatalogo = true;
            $this->competenciaActual = null;
            $this->competenciaSeleccionada = null;

            // Cargar todas las competencias de la categoría con sus relaciones
            $this->competenciasCatalogo = Competencia::with('categoria', 'niveles')
                ->where('categoria_id_competencia', $this->categoriaSeleccionada)
                ->distinct() // Elimina duplicados
                ->orderBy('nombre_competencia')
                ->get();
        }
    }

    public function resetFiltros(): void
    {
        // Resetear todas las propiedades relacionadas con filtros
        $this->reset([
            'categoriaSeleccionada',
            'competenciaSeleccionada',
            'competenciaActual',
            'vistaCatalogo'
        ]);

        // Limpiar las colecciones
        $this->competenciasFiltradas = new Collection();
        $this->competenciasCatalogo = new Collection();
    }

    public function render()
    {
        return view('livewire.encuesta.competencia.catalogo-competencia')
            ->layout('layouts.app');
    }
}
