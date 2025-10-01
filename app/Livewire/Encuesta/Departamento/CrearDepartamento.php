<?php

namespace App\Livewire\Encuesta\Departamento;

use App\Models\Departamento;
use App\Models\Empresa;
use Livewire\Component;

class CrearDepartamento extends Component
{

     // 2. Propiedades para los campos del formulario
    public string $nombre_departamento = '';
    public string $descripcion = '';
    public string $estado = 'activo'; // Valor por defecto
    public string $puesto = '';
    public string $fecha_registro_departamento = '';
    public ?int $empresa_id_empresa = null; // El ID de la empresa seleccionada

    // 3. Propiedad para la lista de empresas del selector
    public $empresas = [];

    /**
     * El método mount se ejecuta al iniciar el componente.
     * Lo usamos para cargar datos iniciales.
     */
    public function mount(): void
    {
        // Cargamos todas las empresas para que el usuario pueda elegir una.
        // Seleccionamos solo el ID y el nombre para optimizar la consulta.
        $this->empresas = Empresa::orderBy('nombre_comercial')->get(['id_empresa', 'nombre_comercial']);
        
        // Establecemos la fecha de hoy como valor por defecto.
        $this->fecha_registro_departamento = now()->format('Y-m-d');
    }

    /**
     * 4. Reglas de validación para el formulario.
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
     * Mapeo para mensajes de validación amigables.
     */
    protected $validationAttributes = [
        'nombre_departamento' => 'nombre del departamento',
        'fecha_registro_departamento' => 'fecha de registro',
        'empresa_id_empresa' => 'empresa',
    ];

    /**
     * 5. Método para guardar el nuevo departamento.
     */
    public function save(): void
    {
        // Validamos los datos usando las reglas definidas.
        $validatedData = $this->validate();

        try {
            // Creamos el departamento en la base de datos.
            Departamento::create($validatedData);

            // Guardamos un mensaje de éxito en la sesión.
            session()->flash('message', '¡Departamento creado exitosamente!');

            // Redirigimos al usuario (puedes cambiar esta ruta a donde quieras mostrar los departamentos).
            $this->redirect(route('crear-departamento'), navigate: true); // Asumiendo que tienes una ruta llamada 'crear-departamento'

        } catch (\Exception $e) {
            // Si algo falla, guardamos el error en la sesión.
            session()->flash('error', 'Error al crear el departamento: ' . $e->getMessage());
        }
    }


    public function render()
    {
        return view('livewire.encuesta.departamento.crear-departamento')->layout('layouts.app');
    }
}
