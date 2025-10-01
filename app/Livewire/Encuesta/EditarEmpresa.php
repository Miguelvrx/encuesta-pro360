<?php

namespace App\Livewire\Encuesta;

use App\Models\Empresa;
use Livewire\Component;

class EditarEmpresa extends CrearEmpresa
{
    public ?Empresa $empresa = null;

    public function mount(?Empresa $empresa = null): void
    {
        if (is_null($empresa)) {
            $this->redirect(route('mostrar-empresas'));
            return;
        }

        $this->empresa = $empresa;
        $this->fill($empresa->toArray());
        $this->fecha_registro = $empresa->fecha_registro->format('Y-m-d');

        parent::mount();

        $this->paisSeleccionado = $empresa->pais;
        if ($this->paisSeleccionado) {
            $this->updatedPaisSeleccionado($this->paisSeleccionado);
        }

        $this->estadoSeleccionado = $empresa->estado;
        if ($this->estadoSeleccionado) {
            $this->updatedEstadoSeleccionado($this->estadoSeleccionado);
        }

        $this->ciudadSeleccionada = $empresa->ciudad;
    }

    // --- INICIO DE LA SOLUCIÓN: AÑADIR ESTE MÉTODO ---
    /**
     * Sobrescribimos el método save() para que ACTUALICE en lugar de CREAR.
     */
    public function save()
    {
        // La validación del RFC debe ignorar el RFC de la empresa actual.
        $rules = $this->rules();
        $rules['rfc'] = 'required|string|max:20|unique:empresas,rfc,' . $this->empresa->id_empresa . ',id_empresa';

        $validatedData = $this->validate($rules);

        // Asignamos los valores de los selectores al array validado
        $validatedData['pais'] = $this->paisSeleccionado;
        $validatedData['estado'] = $this->estadoSeleccionado;
        $validatedData['ciudad'] = $this->ciudadSeleccionada;

        // Manejo del logo
        if ($this->image && method_exists($this->image, 'isFile')) {
            $validatedData['image'] = $this->image->store('images', 'public');
        }

        try {
            // Usamos el método update() en la instancia de la empresa existente.
            $this->empresa->update($validatedData);

            session()->flash('message', '¡Empresa actualizada exitosamente!');
            $this->redirect(route('mostrar-empresa'), navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Error al actualizar la empresa: ' . $e->getMessage());
        }
    }
    // --- FIN DE LA SOLUCIÓN ---
    public function render()
    {
        return view('livewire.encuesta.editar-empresa')->layout('layouts.app');
    }
}
