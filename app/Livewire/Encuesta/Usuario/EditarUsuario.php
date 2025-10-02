<?php

namespace App\Livewire\Encuesta\Usuario;

use App\Models\Departamento;
use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Component;

class EditarUsuario extends CrearUsuario
{
  
     // 2. Propiedad para guardar la instancia del usuario
    public ?User $user = null;

    /**
     * 3. El mount del HIJO. Su trabajo es recibir el usuario y llenar el formulario.
     */
    public function mount(?User $user = null): void
    {
        // Si no se pasa un usuario, redirigir.
        if (is_null($user)) {
            $this->redirect(route('mostrar-usuario'));
            return;
        }

        $this->user = $user;

        // Llama al mount del PADRE para que haga su trabajo (cargar departamentos).
        parent::mount($user);

        // Llena las propiedades (que fueron heredadas) con los datos del usuario.
        $this->fill($user->toArray());
        
        // Asigna manualmente las que no coinciden o necesitan formato.
        $this->departamento_id = $user->departamento_id;
    }

    /**
     * 4. Sobrescribe las reglas de validación para la edición.
     */
    protected function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'primer_apellido' => 'required|string|max:100',
            'segundo_apellido' => 'nullable|string|max:100',
            'telefono' => 'required|string|max:20',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($this->user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'rol' => 'required|integer',
            'departamento_id' => 'required|integer|exists:departamentos,id_departamento',
            'puesto' => 'required|string|max:100',
            'estado' => 'required|in:activo,inactivo',
            'genero' => 'nullable|in:masculino,femenino,no definido',
            'escolaridad' => 'nullable|string|max:100',
        ];
    }

    /**
     * 5. Sobrescribe el método save() para que ACTUALICE.
     */
    public function save(): void
    {
        $validatedData = $this->validate();

        try {
            // Si se proporcionó una nueva contraseña, la actualizamos.
            if (!empty($validatedData['password'])) {
                $this->user->password = $validatedData['password'];
            }
            
            // Actualizamos el resto de los datos.
            $this->user->fill($validatedData);
            $this->user->departamento_id = $validatedData['departamento_id'];
            $this->user->save();

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
