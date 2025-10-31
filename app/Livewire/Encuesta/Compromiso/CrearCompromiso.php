<?php

namespace App\Livewire\Encuesta\Compromiso;

use App\Models\Compromiso;
use App\Models\Evaluacion;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class CrearCompromiso extends Component
{

    
    public function render()
    {
        return view('livewire.encuesta.compromiso.crear-compromiso')->layout('layouts.app');
    }
}
