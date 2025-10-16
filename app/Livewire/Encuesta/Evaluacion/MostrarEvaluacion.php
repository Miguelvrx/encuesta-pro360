<?php

namespace App\Livewire\Encuesta\Evaluacion;

use App\Models\Evaluacion;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class MostrarEvaluacion extends Component
{

    use WithPagination;

    #[Url(except: '')]
    public string $busqueda = '';

    #[Url(except: '')]
    public string $filtroEstado = '';

    public string $ordenarPor = 'created_at';
    public string $direccionOrden = 'desc';

    public function updating($property): void
    {
        if (in_array($property, ['busqueda', 'filtroEstado'])) {
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

    public function render()
    {
        $evaluacionesQuery = Evaluacion::with(['usuarios']);

        // Aplicar filtros
        if ($this->busqueda) {
            $evaluacionesQuery->where(function ($query) {
                $query->where('tipo_evaluacion', 'like', '%' . $this->busqueda . '%')
                    ->orWhere('descripcion_evaluacion', 'like', '%' . $this->busqueda . '%');
            });
        }

        if ($this->filtroEstado) {
            $evaluacionesQuery->where('estado', $this->filtroEstado);
        }

        // Aplicar ordenación
        $evaluacionesQuery->orderBy($this->ordenarPor, $this->direccionOrden);

        $evaluaciones = $evaluacionesQuery->paginate(10);

        return view('livewire.encuesta.evaluacion.mostrar-evaluacion', [
            'evaluaciones' => $evaluaciones,
        ])->layout('layouts.app');
    }


    // public function render()
    // {
    //     return view('livewire.encuesta.evaluacion.mostrar-evaluacion')->layout("layouts.app");
    // }
}
