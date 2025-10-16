<?php

namespace App\Livewire\Encuesta\Evaluacion;

use App\Models\Competencia;
use App\Models\Evaluacion;
use App\Models\Respuesta;
use Illuminate\Support\Facades\Auth;
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

    public function mount($uuid)
    {
        $this->uuid = $uuid;
        $this->evaluacion = Evaluacion::with(['competencias.preguntas', 'usuarios'])
            ->where('uuid_encuesta', $uuid)
            ->where('estado', 'completada')
            ->firstOrFail();

        $this->evaluado = $this->evaluacion->usuarios->first();
        
        // Cargar competencias y preguntas
        $competenciaIds = $this->evaluacion->configuracion_data['competencias'] ?? [];
        $this->competencias = Competencia::with(['preguntas', 'niveles'])
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
            $this->respuestas[$respuesta->pregunta_id] = $respuesta->valor_respuesta;
        }
    }

    protected function calcularProgreso()
    {
        $totalPreguntas = $this->competencias->sum(function($competencia) {
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

    public function guardarRespuesta($preguntaId, $valor)
    {
        $this->respuestas[$preguntaId] = $valor;
        
        // Guardar en base de datos
        Respuesta::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'pregunta_id' => $preguntaId,
                'evaluacion_id_evaluacion' => $this->evaluacion->id_evaluacion
            ],
            [
                'valor_respuesta' => $valor,
                'fecha_respuesta' => now()
            ]
        );

        $this->calcularProgreso();
        $this->dispatch('respuesta-guardada');
    }

    public function enviarEvaluacion()
    {
        // Validar que todas las preguntas estén respondidas
        $totalPreguntas = $this->competencias->sum(function($competencia) {
            return $competencia->preguntas->count();
        });

        if (count($this->respuestas) < $totalPreguntas) {
            $this->dispatch('swal-toast', [
                'icon' => 'warning',
                'title' => 'Evaluación incompleta',
                'text' => 'Por favor responde todas las preguntas antes de enviar.'
            ]);
            return;
        }

        // Marcar como evaluado en la relación
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
