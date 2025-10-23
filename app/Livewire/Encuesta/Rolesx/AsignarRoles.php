<?php

namespace App\Livewire\Encuesta\Rolesx;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class AsignarRoles extends Component
{
    use WithPagination;

    public $busqueda = '';
    public $rolFiltro = '';
    public $usuarioSeleccionado = null;
    public $rolesSeleccionados = [];
    public $modalAbierto = false;

    public function render()
    {
        $usuarios = User::with(['roles', 'departamento.empresa'])
            ->when($this->busqueda, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->busqueda . '%')
                        ->orWhere('email', 'like', '%' . $this->busqueda . '%')
                        ->orWhere('primer_apellido', 'like', '%' . $this->busqueda . '%');
                });
            })
            ->when($this->rolFiltro, function ($query) {
                $query->whereHas('roles', function ($q) {
                    $q->where('name', $this->rolFiltro);
                });
            })
            ->orderBy('name')
            ->paginate(15);

        $roles = Role::all();

        return view('livewire.encuesta.rolesx.asignar-roles', [
            'usuarios' => $usuarios,
            'roles' => $roles,
        ])->layout('layouts.app');
    }

    public function abrirModal($usuarioId)
    {
        $this->usuarioSeleccionado = User::with('roles')->find($usuarioId);

        if ($this->usuarioSeleccionado) {
            $this->rolesSeleccionados = $this->usuarioSeleccionado->roles->pluck('name')->toArray();
            $this->modalAbierto = true;
        }
    }

    public function cerrarModal()
    {
        $this->modalAbierto = false;
        $this->reset(['usuarioSeleccionado', 'rolesSeleccionados']);
    }

    public function guardarRoles()
    {
        if (!$this->usuarioSeleccionado) {
            return;
        }

        $this->usuarioSeleccionado->syncRoles($this->rolesSeleccionados);

        session()->flash('mensaje', 'Roles asignados exitosamente a ' . $this->usuarioSeleccionado->name);
        $this->cerrarModal();
    }

    public function asignacionRapida($usuarioId, $rolName)
    {
        $usuario = User::find($usuarioId);

        if (!$usuario) {
            session()->flash('error', 'Usuario no encontrado');
            return;
        }

        if ($usuario->hasRole($rolName)) {
            $usuario->removeRole($rolName);
            session()->flash('mensaje', 'Rol removido de ' . $usuario->name);
        } else {
            $usuario->assignRole($rolName);
            session()->flash('mensaje', 'Rol asignado a ' . $usuario->name);
        }
    }

    public function removerTodosLosRoles($usuarioId)
    {
        $usuario = User::find($usuarioId);

        if (!$usuario) {
            session()->flash('error', 'Usuario no encontrado');
            return;
        }

        $usuario->syncRoles([]);
        session()->flash('mensaje', 'Todos los roles removidos de ' . $usuario->name);
    }

    // public function render()
    // {
    //     return view('livewire.encuesta.rolesx.asignar-roles');
    // }
}
