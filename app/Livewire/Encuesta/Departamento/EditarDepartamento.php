<?php

namespace App\Livewire\Encuesta\Departamento;

use App\Models\Departamento;
use App\Livewire\Encuesta\Departamento\CrearDepartamento;
use App\Models\Empresa;
use Livewire\Component;

class EditarDepartamento extends CrearDepartamento
{
    public ?Departamento $departamento = null;

    public function mount(?Departamento $departamento = null): void
    {
        if (is_null($departamento)) {
            $this->redirect(route('mostrar-departamento'));
            return;
        }

        $this->departamento = $departamento;

        // Llenamos el formulario
        $this->nombre_departamento = $departamento->nombre_departamento;
        $this->descripcion = $departamento->descripcion;
        $this->estado = $departamento->estado;
        $this->puesto = $departamento->puesto;
        $this->fecha_registro_departamento = $departamento->fecha_registro_departamento->format('Y-m-d');
        $this->empresa_id_empresa = $departamento->empresa_id_empresa;

        parent::mount($departamento);
    }

    /**
     * Sobrescribimos el método save() para que ACTUALICE.
     * Añadimos el tipo de retorno ': void' para que sea compatible con el padre.
     */
    // --- INICIO DE LA CORRECCIÓN ---
    public function save(): void
    // --- FIN DE LA CORRECCIÓN ---
    {
        // Validamos los datos usando las reglas heredadas.
        $validatedData = $this->validate();

        try {
            $this->departamento->update($validatedData);
            session()->flash('message', '¡Departamento actualizado exitosamente!');
            $this->redirect(route('mostrar-departamento'), navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Error al actualizar el departamento: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.encuesta.departamento.editar-departamento')->layout('layouts.app');
    }
}
