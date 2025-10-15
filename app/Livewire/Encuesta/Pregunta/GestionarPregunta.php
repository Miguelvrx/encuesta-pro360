<?php

namespace App\Livewire\Encuesta\Pregunta;

use App\Models\Categoria;
use App\Models\Competencia;
use App\Models\Pregunta;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class GestionarPregunta extends Component
{

    // Filtros
    public ?int $categoriaSeleccionada = null;
    public ?int $competenciaSeleccionada = null;

    // Colecciones
    public Collection $categorias;
    public Collection $competenciasFiltradas;
    public ?Competencia $competenciaActual = null;

    // Modal/Form
    public bool $modalAbierto = false;
    public ?int $preguntaEditando = null;

    // Campos del formulario
    public string $texto_pregunta = '';
    public string $descripcion_pregunta = '';
    public int $puntuacion_maxima = 5;
    public int $orden = 1;
    public bool $activa = true;

    protected $rules = [
        'texto_pregunta' => 'required|string|min:10',
        'descripcion_pregunta' => 'required|string|min:10',
        'puntuacion_maxima' => 'required|integer|min:1|max:10',
        'orden' => 'required|integer|min:1',
        'activa' => 'boolean',
    ];

    protected $messages = [
        'texto_pregunta.required' => 'El texto de la pregunta es obligatorio',
        'texto_pregunta.min' => 'El texto debe tener al menos 10 caracteres',
        'descripcion_pregunta.required' => 'La descripción es obligatoria',
        'descripcion_pregunta.min' => 'La descripción debe tener al menos 10 caracteres',
        'puntuacion_maxima.required' => 'La puntuación máxima es obligatoria',
        'puntuacion_maxima.min' => 'La puntuación mínima es 1',
        'puntuacion_maxima.max' => 'La puntuación máxima es 10',
        'orden.required' => 'El orden es obligatorio',
        'orden.min' => 'El orden mínimo es 1',
    ];

    public function mount(): void
    {
        $this->categorias = Categoria::orderBy('categoria')->get();
        $this->competenciasFiltradas = new Collection();
    }

    public function updatedCategoriaSeleccionada($value): void
    {
        if (!is_null($value) && $value !== '') {
            $this->competenciasFiltradas = Competencia::where('categoria_id_competencia', $value)
                ->distinct()
                ->orderBy('nombre_competencia')
                ->get();
        } else {
            $this->competenciasFiltradas = new Collection();
        }

        $this->reset(['competenciaSeleccionada', 'competenciaActual']);
    }

    public function updatedCompetenciaSeleccionada($value): void
    {
        if (!is_null($value) && $value !== '') {
            $this->competenciaActual = Competencia::with(['categoria', 'niveles', 'preguntas' => function ($query) {
                $query->orderBy('orden');
            }])->find($value);

            // Calcular el siguiente número de orden
            if ($this->competenciaActual && $this->competenciaActual->preguntas->isNotEmpty()) {
                $this->orden = $this->competenciaActual->preguntas->max('orden') + 1;
            }
        } else {
            $this->competenciaActual = null;
        }
    }

    public function abrirModal(): void
    {
        $this->reset(['texto_pregunta', 'descripcion_pregunta', 'puntuacion_maxima', 'preguntaEditando']);
        $this->puntuacion_maxima = 5;
        $this->activa = true;

        // Calcular el siguiente orden
        if ($this->competenciaActual && $this->competenciaActual->preguntas->isNotEmpty()) {
            $this->orden = $this->competenciaActual->preguntas->max('orden') + 1;
        } else {
            $this->orden = 1;
        }

        $this->modalAbierto = true;
    }

    public function editarPregunta(int $preguntaId): void
    {
        $pregunta = Pregunta::findOrFail($preguntaId);

        $this->preguntaEditando = $preguntaId;
        $this->texto_pregunta = $pregunta->texto_pregunta;
        $this->descripcion_pregunta = $pregunta->descripcion_pregunta;
        $this->puntuacion_maxima = $pregunta->puntuacion_maxima;
        $this->orden = $pregunta->orden;
        $this->activa = $pregunta->activa;

        $this->modalAbierto = true;
    }

    public function guardarPregunta(): void
    {
        $this->validate();

        if ($this->preguntaEditando) {
            // Actualizar pregunta existente
            $pregunta = Pregunta::findOrFail($this->preguntaEditando);
            $pregunta->update([
                'texto_pregunta' => $this->texto_pregunta,
                'descripcion_pregunta' => $this->descripcion_pregunta,
                'puntuacion_maxima' => $this->puntuacion_maxima,
                'orden' => $this->orden,
                'activa' => $this->activa,
            ]);

            session()->flash('message', 'Pregunta actualizada exitosamente.');
        } else {
            // Crear nueva pregunta
            Pregunta::create([
                'texto_pregunta' => $this->texto_pregunta,
                'descripcion_pregunta' => $this->descripcion_pregunta,
                'puntuacion_maxima' => $this->puntuacion_maxima,
                'orden' => $this->orden,
                'activa' => $this->activa,
                'competencia_id_competencia' => $this->competenciaSeleccionada,
            ]);

            session()->flash('message', 'Pregunta creada exitosamente.');
        }

        // Recargar la competencia con sus preguntas actualizadas
        $this->competenciaActual = Competencia::with(['categoria', 'niveles', 'preguntas' => function ($query) {
            $query->orderBy('orden');
        }])->find($this->competenciaSeleccionada);

        $this->cerrarModal();
    }

    public function cambiarEstado(int $preguntaId): void
    {
        $pregunta = Pregunta::findOrFail($preguntaId);
        $pregunta->update(['activa' => !$pregunta->activa]);

        // Recargar
        $this->competenciaActual = Competencia::with(['categoria', 'niveles', 'preguntas' => function ($query) {
            $query->orderBy('orden');
        }])->find($this->competenciaSeleccionada);

        session()->flash('message', 'Estado actualizado correctamente.');
    }

    public function eliminarPregunta(int $preguntaId): void
    {
        Pregunta::findOrFail($preguntaId)->delete();

        // Recargar
        $this->competenciaActual = Competencia::with(['categoria', 'niveles', 'preguntas' => function ($query) {
            $query->orderBy('orden');
        }])->find($this->competenciaSeleccionada);

        session()->flash('message', 'Pregunta eliminada correctamente.');
    }

    public function cerrarModal(): void
    {
        $this->modalAbierto = false;
        $this->reset(['texto_pregunta', 'descripcion_pregunta', 'puntuacion_maxima', 'preguntaEditando']);
    }

    public function render()
    {
        return view('livewire.encuesta.pregunta.gestionar-pregunta')
            ->layout('layouts.app');
    }


    // public function render()
    // {
    //     return view('livewire.encuesta.pregunta.gestionar-pregunta');
    // }
}
