<?php

namespace App\Livewire\Encuesta\Evaluacion;

use App\Models\Evaluacion;
use App\Models\Respuesta;
use Livewire\Component;

class VerEvaluacion extends Component
{

      public $evaluacionId;
    public $evaluacion;
    public $resultados;
    public $estadisticas;
    public $evaluadores;

    public function mount($id)
    {
        $this->evaluacionId = $id;
        $this->evaluacion = Evaluacion::with([
            'usuarios.departamento.empresa',
            'competencias.preguntas',
            'competencias.niveles'
        ])->findOrFail($id);

        $this->cargarResultados();
        $this->calcularEstadisticas();
        $this->cargarEvaluadores();
    }

    protected function cargarResultados()
    {
        $competenciaIds = $this->evaluacion->configuracion_data['competencias'] ?? [];
        
        $this->resultados = Respuesta::with(['pregunta.competencia', 'usuario'])
            ->where('evaluacion_id_evaluacion', $this->evaluacionId)
            ->whereIn('pregunta_id', function($query) use ($competenciaIds) {
                $query->select('id_pregunta')
                    ->from('preguntas')
                    ->whereIn('competencia_id', $competenciaIds);
            })
            ->get()
            ->groupBy('pregunta.competencia.nombre_competencia');
    }

    protected function calcularEstadisticas()
    {
        $this->estadisticas = [
            'total_evaluadores' => $this->evaluacion->usuarios->count(),
            'evaluadores_completados' => $this->evaluacion->usuarios->where('pivot.evaluado', true)->count(),
            'total_respuestas' => Respuesta::where('evaluacion_id_evaluacion', $this->evaluacionId)->count(),
            'progreso' => $this->evaluacion->usuarios->count() > 0 ? 
                round(($this->evaluacion->usuarios->where('pivot.evaluado', true)->count() / $this->evaluacion->usuarios->count()) * 100) : 0
        ];

        // Calcular promedios por competencia
        $this->estadisticas['competencias'] = [];
        foreach ($this->resultados as $competencia => $respuestas) {
            $promedio = $respuestas->avg('valor_respuesta');
            $this->estadisticas['competencias'][$competencia] = [
                'promedio' => round($promedio, 2),
                'total_respuestas' => $respuestas->count(),
                'maximo' => 5, // Asumiendo escala 1-5
                'porcentaje' => round(($promedio / 5) * 100, 1)
            ];
        }
    }

    protected function cargarEvaluadores()
    {
        $this->evaluadores = $this->evaluacion->usuarios->map(function($usuario) {
            return [
                'nombre' => $usuario->name . ' ' . $usuario->primer_apellido,
                'email' => $usuario->email,
                'puesto' => $usuario->puesto,
                'departamento' => $usuario->departamento->nombre_departamento ?? 'N/A',
                'empresa' => $usuario->departamento->empresa->nombre_comercial ?? 'N/A',
                'tipo_rol' => $usuario->pivot->tipo_rol,
                'completado' => $usuario->pivot->evaluado,
                'fecha_evaluacion' => $usuario->pivot->fecha_evaluacion
            ];
        });
    }

    public function render()
    {
        return view('livewire.encuesta.evaluacion.ver-evaluacion')->layout('layouts.app');
    }


    // public function render()
    // {
    //     return view('livewire.encuesta.evaluacion.ver-evaluacion');
    // }
}
