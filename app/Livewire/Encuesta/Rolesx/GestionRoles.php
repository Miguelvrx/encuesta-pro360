<?php

namespace App\Livewire\Encuesta\Rolesx;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class GestionRoles extends Component
{
    use WithPagination;

    public $nombre;
    public $permisosSeleccionados = [];
    public $roleIdEditar = null;
    public $modalAbierto = false;
    public $busqueda = '';
    public $categoriaFiltro = 'todos';

    protected $rules = [
        'nombre' => 'required|string|max:255|unique:roles,name',
        'permisosSeleccionados' => 'array',
    ];

    protected $messages = [
        'nombre.required' => 'El nombre del rol es obligatorio',
        'nombre.unique' => 'Este rol ya existe',
    ];

    public function render()
    {
        $roles = Role::with('permissions')
            ->when($this->busqueda, function ($query) {
                $query->where('name', 'like', '%' . $this->busqueda . '%');
            })
            ->paginate(10);

        $permisos = Permission::all()->groupBy(function ($permission) {
            return explode('-', $permission->name)[0];
        });

        return view('livewire.encuesta.rolesx.gestion-roles', [
            'roles' => $roles,
            'permisosAgrupados' => $permisos,
        ])->layout('layouts.app');
    }

    public function abrirModal()
    {
        $this->reset(['nombre', 'permisosSeleccionados', 'roleIdEditar']);
        $this->modalAbierto = true;
    }

    public function cerrarModal()
    {
        $this->modalAbierto = false;
        $this->reset(['nombre', 'permisosSeleccionados', 'roleIdEditar']);
        $this->resetValidation();
    }

    public function guardar()
    {
        if ($this->roleIdEditar) {
            $this->rules['nombre'] = 'required|string|max:255|unique:roles,name,' . $this->roleIdEditar;
        }

        $this->validate();

        if ($this->roleIdEditar) {
            $role = Role::find($this->roleIdEditar);
            $role->update(['name' => $this->nombre]);
            $role->syncPermissions($this->permisosSeleccionados);

            session()->flash('mensaje', 'Rol actualizado exitosamente');
        } else {
            $role = Role::create(['name' => $this->nombre]);
            $role->givePermissionTo($this->permisosSeleccionados);

            session()->flash('mensaje', 'Rol creado exitosamente');
        }

        $this->cerrarModal();
    }

    public function editar($roleId)
    {
        $role = Role::with('permissions')->find($roleId);

        if (!$role) {
            session()->flash('error', 'Rol no encontrado');
            return;
        }

        $this->roleIdEditar = $role->id;
        $this->nombre = $role->name;
        $this->permisosSeleccionados = $role->permissions->pluck('name')->toArray();
        $this->modalAbierto = true;
    }

    public function eliminar($roleId)
    {
        $role = Role::find($roleId);

        if (!$role) {
            session()->flash('error', 'Rol no encontrado');
            return;
        }

        // Verificar que no sea un rol del sistema
        if (in_array($role->name, ['Super Admin', 'Administrador'])) {
            session()->flash('error', 'No puedes eliminar roles del sistema');
            return;
        }

        // Verificar que no tenga usuarios asignados
        if ($role->users()->count() > 0) {
            session()->flash('error', 'No puedes eliminar un rol con usuarios asignados');
            return;
        }

        $role->delete();
        session()->flash('mensaje', 'Rol eliminado exitosamente');
    }

    public function togglePermiso($categoria)
    {
        $permisos = Permission::all()
            ->filter(fn($p) => str_starts_with($p->name, $categoria . '-'))
            ->pluck('name')
            ->toArray();

        $todosSeleccionados = empty(array_diff($permisos, $this->permisosSeleccionados));

        if ($todosSeleccionados) {
            $this->permisosSeleccionados = array_diff($this->permisosSeleccionados, $permisos);
        } else {
            $this->permisosSeleccionados = array_unique(array_merge($this->permisosSeleccionados, $permisos));
        }
    }
    // public function render()
    // {
    //     return view('livewire.encuesta.rolesx.gestion-roles');
    // }
}
