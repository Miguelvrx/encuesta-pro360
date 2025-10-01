<?php

namespace App\Livewire;

use Livewire\Component;

class HeaderNavegacion extends Component
{

    public $dropdownOpen = false;

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
