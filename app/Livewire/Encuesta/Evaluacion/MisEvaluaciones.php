<?php

namespace App\Livewire\Encuesta\Evaluacion;

use App\Models\Evaluacion;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MisEvaluaciones extends Component
{

    
    public $evaluacionesPendientes;

    public function mount()
    {
        $this->evaluacionesPendientes = Evaluacion::whereHas('usuarios', function($query) {
            $query->where('user_id', Auth::id())
                  ->where('evaluado', false);
        })->where('estado', 'completada')
          ->get();
    }


    public function render()
    {
        return view('livewire.encuesta.evaluacion.mis-evaluaciones')->layout('layouts.app');
    }
}
