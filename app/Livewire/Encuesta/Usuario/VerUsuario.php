<?php

namespace App\Livewire\Encuesta\Usuario;

use App\Models\User;
use Livewire\Component;

class VerUsuario extends Component
{
     // 1. Propiedad pública para almacenar el usuario
    public User $user;

    // 2. Mapeo de roles para mostrar el nombre en lugar del número
    public array $roles = [
        1 => 'Usuario',
        2 => 'Administrador',
        // Añade más roles si los tienes
    ];

    /**
     * 3. El método mount recibe el usuario gracias a la inyección de ruta-modelo.
     *    Cargamos las relaciones necesarias de forma explícita.
     */
    public function mount(User $user): void
    {
        $this->user = $user->load(['departamento.empresa']);
    }

    public function render()
    {
        return view('livewire.encuesta.usuario.ver-usuario')->layout('layouts.app');
    }
}
