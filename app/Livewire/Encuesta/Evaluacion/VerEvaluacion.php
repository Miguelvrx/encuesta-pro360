<?php

namespace App\Livewire\Encuesta\Evaluacion;

use App\Models\Competencia;
use App\Models\Evaluacion;
use App\Models\Respuesta;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class VerEvaluacion extends Component
{

     public $evaluacionId;
    public $evaluacion;
    public $estadisticas;

    public function mount($id)
    {
        try {
            $this->evaluacionId = $id;
            
            // Cargar evaluación con relaciones básicas - VERIFICAR NOMBRE DE RELACIÓN
            $this->evaluacion = Evaluacion::with([
                'usuarios', // Verifica que esta relación exista en el modelo
                'respuestas' // Agregar esta relación si existe
            ])->findOrFail($id);
            
            $this->calcularEstadisticasBasicas();
            
        } catch (\Exception $e) {
            Log::error('Error en VerEvaluacion mount: ' . $e->getMessage());
            session()->flash('error', 'No se pudo cargar la evaluación.');
        }
    }

    protected function calcularEstadisticasBasicas()
    {
        try {
            // Verificar si la relación usuarios existe
            $totalEvaluadores = $this->evaluacion->usuarios ? $this->evaluacion->usuarios->count() : 0;
            
            $evaluadoresCompletados = 0;
            if ($this->evaluacion->usuarios) {
                $evaluadoresCompletados = $this->evaluacion->usuarios->filter(function($usuario) {
                    // Verificar la estructura del pivot
                    return isset($usuario->pivot->evaluado) && $usuario->pivot->evaluado == true;
                })->count();
            }

            $this->estadisticas = [
                'total_evaluadores' => $totalEvaluadores,
                'evaluadores_completados' => $evaluadoresCompletados,
                'total_respuestas' => Respuesta::where('evaluacion_id_evaluacion', $this->evaluacionId)->count(),
                'progreso' => $totalEvaluadores > 0 ? 
                    round(($evaluadoresCompletados / $totalEvaluadores) * 100) : 0
            ];
            
        } catch (\Exception $e) {
            Log::error('Error calculando estadísticas: ' . $e->getMessage());
            $this->estadisticas = [
                'total_evaluadores' => 0,
                'evaluadores_completados' => 0,
                'total_respuestas' => 0,
                'progreso' => 0
            ];
        }
    }

    public function render()
    {
        return view('livewire.encuesta.evaluacion.ver-evaluacion')
            ->layout('layouts.app');
    }
    // public function render()
    // {
    //     return view('livewire.encuesta.evaluacion.ver-evaluacion');
    // }
}
