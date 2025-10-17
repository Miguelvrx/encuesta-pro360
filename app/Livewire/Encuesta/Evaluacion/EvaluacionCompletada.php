<?php

namespace App\Livewire\Encuesta\Evaluacion;

use Livewire\Component;

class EvaluacionCompletada extends Component
{

     public function mount()
    {
        // Opcional: Puedes agregar lógica aquí si necesitas
        // mostrar información específica de la evaluación recién completada
    }

    public function irADashboard()
    {
        return redirect()->route('dashboard');
    }

    public function irAMisEvaluaciones()
    {
        return redirect()->route('mostrar-evaluaciones');
    }


    
    public function render()
    {
        return view('livewire.encuesta.evaluacion.evaluacion-completada')->layout('layouts.app');
    }
}
