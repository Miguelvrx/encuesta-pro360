<?php

namespace App\Livewire\Encuesta;

use App\Models\Empresa;
use Livewire\Component;

class VerEmpresa extends Component
{
    // 1. Propiedad pública para almacenar la empresa que estamos viendo.
    public Empresa $empresa;

    /**
     * 2. El método mount() se ejecuta al crear el componente.
     *    Gracias al "Route Model Binding" de Laravel, podemos inyectar
     *    directamente el modelo Empresa que corresponde al ID de la URL.
     */
    public function mount(Empresa $empresa): void
    {
        $this->empresa = $empresa;
    }

    /**
     * 3. El método render simplemente muestra la vista.
     *    No necesitamos pasarle la empresa explícitamente, ya que al ser
     *    una propiedad pública, la vista ya tiene acceso a ella.
     */
    public function render()
    {
        return view('livewire.encuesta.ver-empresa')->layout('layouts.app');
    }


    // public function render()
    // {
    //     return view('livewire.encuesta.ver-empresa');
    // }
}
