<?php

namespace App\Livewire\Encuesta\Usuario;

use App\Models\Departamento;
use App\Models\User;
use Livewire\Component;

class CrearUsuario extends Component
{

    public string $name = '';
    public ?string $primer_apellido = null;
    public ?string $segundo_apellido = null;
    public ?string $telefono = null;
    public string $email = '';
    public ?string $username = null; // ⭐ NUEVO CAMPO OPCIONAL
    public string $password = '';
    public string $password_confirmation = '';
    public int $rol = 1;
    public ?int $departamento_id = null;
    public ?string $puesto = null;
    public string $estado = 'activo';
    public ?string $genero = null;
    public ?string $escolaridad = null;

    public $departamentos = [];

    /**
     * El método mount se ejecuta al iniciar el componente.
     */
    public function mount(): void
    {
        // Cargamos los departamentos para el selector
        $this->departamentos = Departamento::orderBy('nombre_departamento')->get(['id_departamento', 'nombre_departamento']);
    }

    /**
     * Reglas de validación.
     */
    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'primer_apellido' => 'required|string|max:100',
            'segundo_apellido' => 'nullable|string|max:100',
            'telefono' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:users,email',
             'username' => 'nullable|string|max:100|unique:users,username|alpha_dash', // ⭐ Opcional pero único
            'password' => 'required|string|min:8|confirmed', // 'confirmed' busca un campo 'password_confirmation'
            'rol' => 'required|integer',
            'departamento_id' => 'required|integer|exists:departamentos,id_departamento',
            'puesto' => 'required|string|max:100',
            'estado' => 'required|in:activo,inactivo',
            'genero' => 'nullable|in:masculino,femenino,no definido',
            'escolaridad' => 'nullable|string|max:100',
        ];
    }

    /**
     * Mapeo para mensajes de validación amigables.
     */
   protected $validationAttributes = [
        'name' => 'nombre',
        'primer_apellido' => 'primer apellido',
        'username' => 'nombre de usuario',
        'password' => 'contraseña',
        'departamento_id' => 'departamento',
    ];

    protected $messages = [
        'username.alpha_dash' => 'El nombre de usuario solo puede contener letras, números, guiones y guiones bajos.',
        'username.unique' => 'Este nombre de usuario ya está en uso.',
    ];

    /**
     * Método para guardar el nuevo usuario.
     */
     public function save(): void
    {
        $validatedData = $this->validate();

        try {
            User::create([
                'name' => $validatedData['name'],
                'primer_apellido' => $validatedData['primer_apellido'],
                'segundo_apellido' => $validatedData['segundo_apellido'],
                'telefono' => $validatedData['telefono'],
                'email' => $validatedData['email'],
                'username' => $validatedData['username'], // ⭐ Se guarda si existe
                'password' => $validatedData['password'],
                'rol' => $validatedData['rol'],
                'puesto' => $validatedData['puesto'],
                'estado' => $validatedData['estado'],
                'genero' => $validatedData['genero'],
                'escolaridad' => $validatedData['escolaridad'],
                'fecha_registro_usuario' => now(),
                'departamento_id' => $validatedData['departamento_id'],
            ]);

            session()->flash('message', '¡Usuario creado exitosamente!');
            $this->redirect(route('crear-usuario'), navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Error al crear el usuario: ' . $e->getMessage());
        }
    }


    public function render()
    {
        return view('livewire.encuesta.usuario.crear-usuario')->layout('layouts.app');
    }
}
