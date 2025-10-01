<?php

namespace App\Livewire\Encuesta\Departamento;

use Livewire\Attributes\On;
use Livewire\Component;

class ManualUsuarioDepModal extends Component
{
    public bool $mostrarModal = false;
    public string $titulo = '';
    public string $contenido = '';

    /**
     * Escucha el evento para abrir el modal y recibe los datos.
     */
    #[On('abrir-manual')]
    public function abrirModal(string $titulo, string $contenido): void
    {
        $this->titulo = $titulo;
        $this->contenido = $contenido;
        $this->mostrarModal = true;
    }

    /**
     * Cierra el modal.
     */
    public function cerrarModal(): void
    {
        $this->mostrarModal = false;
        $this->reset(['titulo', 'contenido']); // Limpia el contenido para la próxima vez
    }


    public function render()
    {
        return view('livewire.encuesta.departamento.manual-usuario-dep-modal')->layout('layouts.app');
    }
}
