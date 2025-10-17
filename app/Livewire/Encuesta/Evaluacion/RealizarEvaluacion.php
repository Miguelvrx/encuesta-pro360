<?php

namespace App\Livewire\Encuesta\Evaluacion;

use App\Models\Competencia;
use App\Models\Evaluacion;
use App\Models\Respuesta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class RealizarEvaluacion extends Component
{
    public $uuid;
    public $evaluacion;
    public $competencias;
    public $respuestas = [];
    public $pasoActual = 1;
    public $totalPasos = 1;
    public $progreso = 0;
    public $evaluado;

    // Definir los niveles de evaluación estáticos
    public $nivelesEvaluacion = [
        1 => ['nombre' => 'Requiere Apoyo', 'descripcion' => 'Evita tomar decisiones o delegar responsabilidades'],
        2 => ['nombre' => 'En Desarrollo', 'descripcion' => 'Intenta liderar pero requiere guía para avanzar'],
        3 => ['nombre' => 'Competente', 'descripcion' => 'Toma decisiones alineadas con los objetivos'],
        4 => ['nombre' => 'Supera las Expectativas', 'descripcion' => 'Inspira confianza y compromiso en su equipo'],
        5 => ['nombre' => 'Excepcional', 'descripcion' => 'Es referente de liderazgo dentro y fuera del equipo']
    ];

    public function mount($uuid)
    {
        $this->uuid = $uuid;

        $this->evaluacion = Evaluacion::with(['usuarios'])
            ->where('uuid_encuesta', $uuid)
            ->where('estado', 'completada')
            ->firstOrFail();

        $this->evaluado = $this->evaluacion->usuarios->first();

        // Cargar competencias desde configuracion_data
        $competenciaIds = $this->evaluacion->configuracion_data['competencias'] ?? [];
        $this->competencias = Competencia::with(['preguntas'])
            ->whereIn('id_competencia', $competenciaIds)
            ->get();

        $this->totalPasos = $this->competencias->count();

        // Cargar respuestas existentes
        $this->cargarRespuestas();
        $this->calcularProgreso();
    }

    protected function cargarRespuestas()
    {
        $respuestasExistentes = Respuesta::where('user_id', Auth::id())
            ->where('evaluacion_id_evaluacion', $this->evaluacion->id_evaluacion)
            ->get();

        foreach ($respuestasExistentes as $respuesta) {
            $this->respuestas[$respuesta->pregunta_id_pregunta] = (int)$respuesta->puntuacion;
        }
    }

    protected function calcularProgreso()
    {
        $totalPreguntas = $this->competencias->sum(function ($competencia) {
            return $competencia->preguntas->count();
        });

        $preguntasRespondidas = count($this->respuestas);
        $this->progreso = $totalPreguntas > 0 ? round(($preguntasRespondidas / $totalPreguntas) * 100) : 0;
    }

    public function siguientePaso()
    {
        if ($this->pasoActual < $this->totalPasos) {
            $this->pasoActual++;
        }
    }

    public function anteriorPaso()
    {
        if ($this->pasoActual > 1) {
            $this->pasoActual--;
        }
    }

    public function irAPaso($paso)
    {
        if ($paso >= 1 && $paso <= $this->totalPasos) {
            $this->pasoActual = $paso;
        }
    }

    public function seleccionarRespuesta($preguntaId, $valor)
    {
        // Convertir a enteros
        $preguntaId = (int)$preguntaId;
        $valor = (int)$valor;

        // Validar que el valor esté entre 1 y 5
        if ($valor < 1 || $valor > 5) {
            return;
        }

        // Actualizar el array de respuestas
        $this->respuestas[$preguntaId] = $valor;

        // Guardar en base de datos
        $this->guardarRespuesta($preguntaId, $valor);
    }

    protected function guardarRespuesta($preguntaId, $valor)
    {
        // Guardar o actualizar en base de datos
        Respuesta::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'pregunta_id_pregunta' => $preguntaId,
                'evaluacion_id_evaluacion' => $this->evaluacion->id_evaluacion
            ],
            [
                'puntuacion' => $valor,
                'evaluacion_has_usuario_evaluacion_id_evaluacion' => $this->evaluacion->id_evaluacion,
                'usuario_rol' => 1 // Ajusta según tu lógica de roles
            ]
        );

        // Recalcular progreso
        $this->calcularProgreso();

        // Emitir evento
        $this->dispatch('respuesta-guardada');
    }

    public function enviarEvaluacion()
    {
        // Validar que todas las preguntas estén respondidas
        $totalPreguntas = $this->competencias->sum(function ($competencia) {
            return $competencia->preguntas->count();
        });

        if (count($this->respuestas) < $totalPreguntas) {
            $this->dispatch('swal-toast', [
                'icon' => 'warning',
                'title' => 'Evaluación incompleta',
                'text' => 'Por favor responde todas las preguntas antes de enviar. (' . ($totalPreguntas - count($this->respuestas)) . ' preguntas pendientes)'
            ]);
            return;
        }

        try {
            // Marcar como evaluado en la relación con fecha
            $this->evaluacion->usuarios()->updateExistingPivot(Auth::id(), [
                'evaluado' => true,
                'fecha_evaluacion' => now()
            ]);

            $this->dispatch('swal-toast', [
                'icon' => 'success',
                'title' => 'Evaluación enviada',
                'text' => '¡Gracias por completar la evaluación!'
            ]);

            // Redirigir a página de confirmación
            return redirect()->route('evaluacion-completada');
        } catch (\Exception $e) {
            Log::error('Error al enviar evaluación: ' . $e->getMessage());
            $this->dispatch('swal-toast', [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'No se pudo enviar la evaluación. Por favor intenta nuevamente.'
            ]);
        }
    }

    public function render()
    {
        $competenciaActual = $this->competencias->get($this->pasoActual - 1);

        return view('livewire.encuesta.evaluacion.realizar-evaluacion', [
            'competenciaActual' => $competenciaActual
        ])->layout('layouts.app');
    }
    // public function render()
    // {
    //     return view('livewire.encuesta.evaluacion.realizar-evaluacion')->layout('layouts.app');
    // }
}
