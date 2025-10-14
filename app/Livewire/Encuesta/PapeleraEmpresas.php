<?php

namespace App\Livewire\Encuesta;

use App\Models\Empresa;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class PapeleraEmpresas extends Component
{
     use WithPagination;

    public string $busqueda = '';
    public string $ordenarPor = 'deleted_at';
    public string $direccionOrden = 'desc';

    #[\Livewire\Attributes\Url]
    protected $queryString = [
        'busqueda' => ['except' => ''],
    ];

    public function updating($property): void
    {
        if ($property === 'busqueda') {
            $this->resetPage();
        }
    }

    public function ordenar($columna): void
    {
        if ($this->ordenarPor === $columna) {
            $this->direccionOrden = $this->direccionOrden === 'asc' ? 'desc' : 'asc';
        } else {
            $this->ordenarPor = $columna;
            $this->direccionOrden = 'asc';
        }
    }

    // Restaurar empresa
    public function restaurarEmpresa($id): void
    {
        try {
            $empresa = Empresa::onlyTrashed()->findOrFail($id);
            $empresa->restore();
            
            $this->dispatch('toastr-success', message: 'Empresa restaurada exitosamente.');
        } catch (\Exception $e) {
            $this->dispatch('toastr-error', message: 'Error al restaurar la empresa: ' . $e->getMessage());
        }
    }

    // CORREGIDO: Cambiar el nombre del evento que se escucha
    #[On('delete-permanent-confirmed')] // ← Este debe coincidir con lo que despacha JavaScript
    public function eliminarPermanentemente($id): void
    {
        try {
            $empresa = Empresa::onlyTrashed()->findOrFail($id);
            
            // Eliminar logo si existe
            if ($empresa->logo) {
                Storage::disk('public')->delete($empresa->logo);
            }
            
            $empresa->forceDelete();
            
            $this->dispatch('toastr-success', message: 'Empresa eliminada permanentemente.');
        } catch (\Exception $e) {
            $this->dispatch('toastr-error', message: 'Error al eliminar permanentemente: ' . $e->getMessage());
        }
    }

    // CORREGIDO: Cambiar el nombre del evento que se escucha
    #[On('empty-trash-confirmed')] // ← Este debe coincidir con lo que despacha JavaScript
    public function vaciarPapelera(): void
    {
        try {
            $empresasEliminadas = Empresa::onlyTrashed()->get();
            
            foreach ($empresasEliminadas as $empresa) {
                if ($empresa->logo) {
                    Storage::disk('public')->delete($empresa->logo);
                }
                $empresa->forceDelete();
            }
            
            $this->dispatch('toastr-success', message: 'Papelera vaciada exitosamente.');
        } catch (\Exception $e) {
            $this->dispatch('toastr-error', message: 'Error al vaciar la papelera: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $empresasQuery = Empresa::onlyTrashed();

        if ($this->busqueda) {
            $empresasQuery->where(function ($query) {
                $query->where('nombre_comercial', 'like', '%' . $this->busqueda . '%')
                    ->orWhere('razon_social', 'like', '%' . $this->busqueda . '%')
                    ->orWhere('rfc', 'like', '%' . $this->busqueda . '%');
            });
        }

        $empresasQuery->orderBy($this->ordenarPor, $this->direccionOrden);
        $empresas = $empresasQuery->paginate(10);

        return view('livewire.encuesta.papelera-empresas', [
            'empresas' => $empresas,
        ])->layout('layouts.app');
    }

    // public function render()
    // {
    //     return view('livewire.encuesta.papelera-empresas');
    // }
}
