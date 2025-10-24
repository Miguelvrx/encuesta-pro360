<?php

namespace App\Livewire\Encuesta\Usuario;

use App\Models\Departamento;
use App\Models\Empresa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;

class EditarUsuario extends Component
{

    // Propiedad para el modelo que estamos editando
    public User $user;

    // --- PROPIEDADES DEL FORMULARIO ---
    public string $name = '';
    public ?string $primer_apellido = null;
    public ?string $segundo_apellido = null;
    public ?string $telefono = null;
    public string $email = '';
    public ?string $username = null;
    public string $password = '';
    public string $password_confirmation = '';
    public int $rol = 1;
    public ?int $empresa_id = null; // ⭐ NUEVO: ID de empresa seleccionada
    public ?int $departamento_id = null;
    public ?string $puesto = null;
    public string $estado = 'activo';
    public ?string $genero = null;
    public ?string $escolaridad = null;

    public $empresas = [];
    public $departamentos = [];

    /**
     * El método mount carga los datos del usuario existente.
     */
    public function mount(User $user): void
    {
        $this->user = $user;

        // ⭐ Cargamos todas las empresas para el selector
        $this->empresas = Empresa::orderBy('nombre_comercial')->get(['id_empresa', 'nombre_comercial']);

        // ⭐ Obtenemos la empresa del departamento actual del usuario
        if ($user->departamento_id) {
            $departamento = Departamento::find($user->departamento_id);
            if ($departamento) {
                $this->empresa_id = $departamento->empresa_id_empresa;

                // Cargamos los departamentos de esa empresa
                $this->departamentos = Departamento::where('empresa_id_empresa', $this->empresa_id)
                    ->orderBy('nombre_departamento')
                    ->get(['id_departamento', 'nombre_departamento']);
            }
        }

        // Llenamos el formulario con los datos del usuario
        $this->name = $user->name;
        $this->primer_apellido = $user->primer_apellido;
        $this->segundo_apellido = $user->segundo_apellido;
        $this->telefono = $user->telefono;
        $this->email = $user->email;
        $this->username = $user->username;
        $this->rol = $user->rol;
        $this->departamento_id = $user->departamento_id;
        $this->puesto = $user->puesto;
        $this->estado = $user->estado;
        $this->genero = $user->genero;
        $this->escolaridad = $user->escolaridad;
    }

    /**
     * ⭐ Actualiza los departamentos cuando se selecciona una empresa
     */
    public function updatedEmpresaId($value): void
    {
        if ($value) {
            $this->departamentos = Departamento::where('empresa_id_empresa', $value)
                ->orderBy('nombre_departamento')
                ->get(['id_departamento', 'nombre_departamento']);
        } else {
            $this->departamentos = [];
        }

        // Resetear el departamento seleccionado cuando cambia la empresa
        $this->departamento_id = null;
    }

    /**
     * Reglas de validación para la edición.
     */
    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'primer_apellido' => 'required|string|max:100',
            'segundo_apellido' => 'nullable|string|max:100',
            'telefono' => 'required|string|max:20',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($this->user->id)],
            'username' => [
                'nullable',
                'string',
                'max:100',
                'alpha_dash',
                Rule::unique('users')->ignore($this->user->id)
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'rol' => 'required|integer',
            'empresa_id' => 'required|integer|exists:empresas,id_empresa', // ⭐ NUEVO
            'departamento_id' => 'required|integer|exists:departamentos,id_departamento',
            'puesto' => 'required|string|max:100',
            'estado' => 'required|in:activo,inactivo',
            'genero' => 'nullable|in:masculino,femenino,no definido',
            'escolaridad' => 'nullable|string|max:100',
        ];
    }

    protected $validationAttributes = [
        'name' => 'nombre',
        'primer_apellido' => 'primer apellido',
        'username' => 'nombre de usuario',
        'password' => 'contraseña',
        'empresa_id' => 'empresa', // ⭐ NUEVO
        'departamento_id' => 'departamento',
    ];

    protected $messages = [
        'username.alpha_dash' => 'El nombre de usuario solo puede contener letras, números, guiones y guiones bajos.',
        'username.unique' => 'Este nombre de usuario ya está en uso.',
    ];

    /**
     * Método para ACTUALIZAR el usuario.
     */
    public function update(): void
    {
        $validatedData = $this->validate();

        // Preparamos los datos para la actualización
        $updateData = [
            'name' => $validatedData['name'],
            'primer_apellido' => $validatedData['primer_apellido'],
            'segundo_apellido' => $validatedData['segundo_apellido'],
            'telefono' => $validatedData['telefono'],
            'email' => $validatedData['email'],
            'username' => $validatedData['username'],
            'rol' => $validatedData['rol'],
            'puesto' => $validatedData['puesto'],
            'estado' => $validatedData['estado'],
            'genero' => $validatedData['genero'],
            'escolaridad' => $validatedData['escolaridad'],
            'departamento_id' => $validatedData['departamento_id'],
        ];

        // Solo actualizamos la contraseña si el usuario ha escrito una nueva.
        if (!empty($validatedData['password'])) {
            $updateData['password'] = Hash::make($validatedData['password']);
        }

        try {
            $this->user->update($updateData);
            session()->flash('message', '¡Usuario actualizado exitosamente!');
            $this->redirect(route('mostrar-usuario'), navigate: true);
        } catch (\Exception $e) {
            session()->flash('error', 'Error al actualizar el usuario: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.encuesta.usuario.editar-usuario')->layout('layouts.app');
    }
}
