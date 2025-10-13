<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class HeaderNavegacion extends Component
{

    public $user;
    public $dropdownOpen = false;

    public function mount()
    {
        // Verificar que haya un usuario autenticado
        if (Auth::check()) {
            $this->user = Auth::user();
        } else {
            // Redirigir al login si no hay usuario
            return redirect()->route('login');
        }
    }

    public function toggleDropdown()
    {
        $this->dropdownOpen = !$this->dropdownOpen;
    }

    public function closeDropdown()
    {
        $this->dropdownOpen = false;
    }


    public function render()
    {
        return view('livewire.header-navegacion')->layout('layouts.app');
    }
}
