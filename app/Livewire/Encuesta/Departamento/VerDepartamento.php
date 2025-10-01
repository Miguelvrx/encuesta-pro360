<?php

namespace App\Livewire\Encuesta\Departamento;

use App\Models\Departamento;
use Livewire\Component;

class VerDepartamento extends Component
{
    // 2. Propiedad pública para almacenar el departamento
    public Departamento $departamento;

    /**
     * 3. El método mount recibe el modelo gracias al Route Model Binding.
     *    Livewire lo inyecta automáticamente en la propiedad pública.
     */
    public function mount(Departamento $departamento): void
    {
        // 4. Precargamos la relación 'empresa' para tenerla disponible en la vista.
        $this->departamento = $departamento->load('empresa');
    }

    public function render()
    {
        return view('livewire.encuesta.departamento.ver-departamento')->layout('layouts.app');
    }
}
