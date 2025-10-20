<?php

namespace App\Livewire\Encuesta\Resultado;

use App\Models\Competencia;
use App\Models\Evaluacion;
use App\Models\Respuesta;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class VerResultado extends Component
{

     public $evaluacionId;
    public $usuarioId;
    public $evaluacion;
    public $usuario;
    public $resultados = [];
    public $calificadores = [];
    public $filtroCalificador = '';

    // Eliminar el constructor si existe, ya que puede causar problemas con Livewire

    public function mount($evaluacion, $usuario)
    {
        $this->evaluacionId = $evaluacion;
        $this->usuarioId = $usuario;
        
        $this->cargarDatos();
    }

    protected function cargarDatos()
    {
        try {
            $this->evaluacion = Evaluacion::with(['usuarios'])->findOrFail($this->evaluacionId);
            $this->usuario = User::with(['departamento.empresa'])->findOrFail($this->usuarioId);
            
            $this->calcularResultados();
            $this->cargarCalificadores();
        } catch (\Exception $e) {
            session()->flash('error', 'Error al cargar los datos: ' . $e->getMessage());
        }
    }

    protected function calcularResultados()
    {
        $this->resultados = []; // Limpiar resultados anteriores
        
        $competenciaIds = $this->evaluacion->configuracion_data['competencias'] ?? [];
        
        if (empty($competenciaIds)) {
            session()->flash('error', 'No se encontraron competencias configuradas para esta evaluación.');
            return;
        }

        $competencias = Competencia::with(['preguntas'])->whereIn('id_competencia', $competenciaIds)->get();

        foreach ($competencias as $competencia) {
            $preguntasIds = $competencia->preguntas->pluck('id_pregunta');
            
            if ($preguntasIds->isEmpty()) {
                continue; // Saltar competencias sin preguntas
            }
            
            // Obtener todas las respuestas para esta competencia
            $respuestasQuery = Respuesta::whereIn('pregunta_id_pregunta', $preguntasIds)
                ->where('evaluacion_id_evaluacion', $this->evaluacionId)
                ->where('usuario_rol', $this->usuarioId);

            if ($this->filtroCalificador) {
                $respuestasQuery->where('user_id', $this->filtroCalificador);
            }

            $respuestas = $respuestasQuery->get();

            $puntuacionesPorPregunta = [];
            foreach ($competencia->preguntas as $pregunta) {
                $preguntaRespuestas = $respuestas->where('pregunta_id_pregunta', $pregunta->id_pregunta);
                
                $puntuacionesPorPregunta[] = [
                    'pregunta' => $pregunta->pregunta,
                    'puntuacion_promedio' => $preguntaRespuestas->avg('puntuacion') ?? 0,
                    'total_respuestas' => $preguntaRespuestas->count(),
                    'detalles' => $preguntaRespuestas->map(function($respuesta) {
                        $calificador = User::find($respuesta->user_id);
                        return [
                            'calificador' => $calificador ? $calificador->name . ' ' . $calificador->primer_apellido : 'N/A',
                            'puntuacion' => $respuesta->puntuacion,
                            'fecha' => $respuesta->created_at->format('d/m/Y H:i')
                        ];
                    })->toArray()
                ];
            }

            $this->resultados[] = [
                'competencia' => $competencia->nombre_competencia,
                'descripcion' => $competencia->descripcion_competencia,
                'puntuacion_promedio' => $respuestas->avg('puntuacion') ?? 0,
                'total_respuestas' => $respuestas->count(),
                'preguntas' => $puntuacionesPorPregunta,
                'nivel' => $this->obtenerNivel($respuestas->avg('puntuacion') ?? 0)
            ];
        }
    }

    protected function cargarCalificadores()
    {
        $this->calificadores = []; // Limpiar calificadores anteriores
        
        $respuestas = Respuesta::where('evaluacion_id_evaluacion', $this->evaluacionId)
            ->where('usuario_rol', $this->usuarioId)
            ->get()
            ->unique('user_id');

        foreach ($respuestas as $respuesta) {
            $calificador = User::find($respuesta->user_id);
            if ($calificador) {
                $this->calificadores[] = [
                    'id' => $calificador->id,
                    'nombre' => $calificador->name . ' ' . $calificador->primer_apellido,
                    'tipo_rol' => $this->obtenerTipoRol($calificador->id),
                    'total_respuestas' => Respuesta::where('user_id', $calificador->id)
                        ->where('evaluacion_id_evaluacion', $this->evaluacionId)
                        ->where('usuario_rol', $this->usuarioId)
                        ->count()
                ];
            }
        }
    }

    protected function obtenerTipoRol($calificadorId)
    {
        try {
            $relacion = DB::table('evaluacion_has_usuario')
                ->where('evaluacion_id_evaluacion', $this->evaluacionId)
                ->where('user_id', $calificadorId)
                ->where('usuario_rol', $this->usuarioId)
                ->first();

            return $relacion->tipo_rol ?? 'N/A';
        } catch (\Exception $e) {
            return 'N/A';
        }
    }

    protected function obtenerNivel($puntuacion)
    {
        $puntuacion = (float) $puntuacion;
        
        if ($puntuacion >= 4.5) return 'Excepcional';
        if ($puntuacion >= 3.5) return 'Supera las Expectativas';
        if ($puntuacion >= 2.5) return 'Competente';
        if ($puntuacion >= 1.5) return 'En Desarrollo';
        return 'Requiere Apoyo';
    }

    public function updatedFiltroCalificador()
    {
        $this->calcularResultados();
    }

    // Métodos auxiliares para colores
    public function getBadgeColor($puntuacion)
    {
        $puntuacion = (float) $puntuacion;
        if ($puntuacion >= 4.5) return 'success';
        if ($puntuacion >= 3.5) return 'info';
        if ($puntuacion >= 2.5) return 'warning';
        if ($puntuacion >= 1.5) return 'secondary';
        return 'danger';
    }

    public function getLevelBadgeColor($nivel)
    {
        return match($nivel) {
            'Excepcional' => 'success',
            'Supera las Expectativas' => 'info',
            'Competente' => 'warning',
            'En Desarrollo' => 'secondary',
            default => 'danger'
        };
    }

    public function render()
    {
        $puntuacionGeneral = collect($this->resultados)->avg('puntuacion_promedio') ?? 0;
        
        return view('livewire.encuesta.resultado.ver-resultado', [
            'puntuacion_general' => round($puntuacionGeneral, 2),
            'nivel_general' => $this->obtenerNivel($puntuacionGeneral),
            'total_competencias' => count($this->resultados)
        ])->layout('layouts.app');
    }
    // public function render()
    // {
    //     return view('livewire.encuesta.resultado.ver-resultado')->layout('layouts.app');
    // }
}
