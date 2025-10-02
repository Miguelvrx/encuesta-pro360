<?php

namespace App\Livewire\Encuesta\Usuario;

use App\Models\Empresa;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class MostrarUsuario extends Component
{
   use WithPagination;

    #[Url(except: '')]
    public string $busqueda = '';

    #[Url(except: '')]
    public string $filtroEmpresa = '';

    #[Url(except: '')]
    public string $filtroRol = '';

    public string $ordenarPor = 'created_at';
    public string $direccionOrden = 'desc';

    public function updating($property): void
    {
        if (in_array($property, ['busqueda', 'filtroEmpresa', 'filtroRol'])) {
            $this->resetPage();
        }
    }

    public function ordenar(string $columna): void
    {
        if ($this->ordenarPor === $columna) {
            $this->direccionOrden = $this->direccionOrden === 'asc' ? 'desc' : 'asc';
        } else {
            $this->ordenarPor = $columna;
            $this->direccionOrden = 'asc';
        }
    }

     /**
     * 3. Escucha el evento 'confirm-delete' despachado por el botón en la vista.
     *    Su única función es despachar otro evento que el script global de SweetAlert pueda capturar.
     */
    #[On('confirm-delete')]
    public function showDeleteConfirmation(int $id): void
    {
        $this->dispatch('show-swal-delete', [
            'id' => $id,
            'title' => '¿Estás seguro?',
            'text' => 'Vas a eliminar este usuario. ¡Esta acción no se puede deshacer!',
            'icon' => 'warning',
        ]);
    }

    /**
     * 4. Escucha el evento de confirmación final desde JavaScript ('delete-confirmed')
     *    y elimina el usuario.
     */
    #[On('delete-confirmed')]
    public function deleteUsuario(int $id): void
    {
        try {
            $user = User::findOrFail($id);

            // Opcional pero recomendado: Si el usuario tiene una foto de perfil, bórrala.
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }

            $user->delete();

            // Despachamos un toast de éxito usando nuestro sistema de eventos global.
            $this->dispatch('swal-toast', [
                'icon' => 'success',
                'title' => 'Usuario eliminado exitosamente'
            ]);

        } catch (\Exception $e) {
            $this->dispatch('swal-toast', [
                'icon' => 'error',
                'title' => 'Error al eliminar el usuario',
                'text' => $e->getMessage()
            ]);
        }
    }

    public function render()
    {
        // 1. Iniciar la consulta con la relación anidada.
        $usuariosQuery = User::with(['departamento.empresa']);

        // 2. Aplicar filtros
        if ($this->busqueda) {
            $usuariosQuery->where(function ($query) {
                $query->where('name', 'like', '%' . $this->busqueda . '%')
                      ->orWhere('email', 'like', '%' . $this->busqueda . '%')
                      ->orWhere('primer_apellido', 'like', '%' . $this->busqueda . '%');
            });
        }

        if ($this->filtroEmpresa) {
            $usuariosQuery->whereHas('departamento.empresa', function ($query) {
                $query->where('id_empresa', $this->filtroEmpresa);
            });
        }

        if ($this->filtroRol) {
            $usuariosQuery->where('rol', $this->filtroRol);
        }

        // 3. Obtener datos para los filtros
        $empresasFiltro = Empresa::orderBy('nombre_comercial')->get(['id_empresa', 'nombre_comercial']);
        // Asumiendo que tienes un mapeo de roles, ej. 1 => 'Admin', 2 => 'Usuario'
        $rolesFiltro = [1 => 'Usuario', 2 => 'Administrador']; // Ajusta esto a tus roles reales

        // 4. Aplicar ordenación
        $usuariosQuery->orderBy($this->ordenarPor, $this->direccionOrden);

        // 5. Paginar resultados
        $usuarios = $usuariosQuery->paginate(10);

        return view('livewire.encuesta.usuario.mostrar-usuario', [
            'usuarios' => $usuarios,
            'empresasFiltro' => $empresasFiltro,
            'rolesFiltro' => $rolesFiltro,
        ])->layout('layouts.app');
    }


    // public function render()
    // {
    //     return view('livewire.encuesta.usuario.mostrar-usuario')->layout('layouts.app');
    // }
}
