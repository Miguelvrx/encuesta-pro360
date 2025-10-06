<?php

namespace App\Livewire\Encuesta\Departamento;

use App\Models\Departamento;
use App\Models\Empresa;
use Livewire\Component;

class EditarDepartamento extends Component
{
    // Propiedad para el modelo que estamos editando
    public Departamento $departamento;

    // --- PROPIEDADES DEL FORMULARIO (copiadas de CrearDepartamento) ---
    public string $nombre_departamento = '';
    public string $descripcion = '';
    public string $estado = 'activo';
    public string $puesto = '';
    public string $fecha_registro_departamento = '';
    public ?int $empresa_id_empresa = null;

    // Propiedad para la lista de empresas del selector
    public $empresas = [];

    /**
     * El método mount carga los datos del departamento existente.
     */
    public function mount(Departamento $departamento): void
    {
        $this->departamento = $departamento;

        // Cargamos la lista de empresas para el selector
        $this->empresas = Empresa::orderBy('nombre_comercial')->get(['id_empresa', 'nombre_comercial']);

        // Llenamos el formulario con los datos del departamento
        $this->nombre_departamento = $departamento->nombre_departamento;
        $this->descripcion = $departamento->descripcion;
        $this->estado = $departamento->estado;
        $this->puesto = $departamento->puesto;
        $this->fecha_registro_departamento = $departamento->fecha_registro_departamento->format('Y-m-d');
        $this->empresa_id_empresa = $departamento->empresa_id_empresa;
    }

    /**
     * Reglas de validación (copiadas de CrearDepartamento).
     */
    protected function rules(): array
    {
        return [
            'nombre_departamento' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'estado' => 'required|in:activo,inactivo',
            'puesto' => 'required|string|max:100',
            'fecha_registro_departamento' => 'required|date',
            'empresa_id_empresa' => 'required|integer|exists:empresas,id_empresa',
        ];
    }

    /**
     * Mapeo para mensajes de validación (copiado de CrearDepartamento).
     */
    protected $validationAttributes = [
        'nombre_departamento' => 'nombre del departamento',
        'fecha_registro_departamento' => 'fecha de registro',
        'empresa_id_empresa' => 'empresa',
    ];

    /**
     * Método para ACTUALIZAR el departamento.
     */
    public function update(): void
    {
        $validatedData = $this->validate();

        try {
            $this->departamento->update($validatedData);
            session()->flash('message', '¡Departamento actualizado exitosamente!');
            $this->redirect(route('mostrar-departamento'), navigate: true); // Asumiendo que tienes esta ruta
        } catch (\Exception $e) {
            session()->flash('error', 'Error al actualizar el departamento: ' . $e->getMessage());
        }
    }


    public function render()
    {
        return view('livewire.encuesta.departamento.editar-departamento')->layout('layouts.app');
    }
}
