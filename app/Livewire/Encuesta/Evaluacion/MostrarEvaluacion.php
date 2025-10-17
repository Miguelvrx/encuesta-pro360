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
        try {
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

            // Calcular estadísticas de forma segura
            $estadisticas = [
                'total' => Evaluacion::count(),
                'completadas' => Evaluacion::where('estado', 'completada')->count(),
                'en_progreso' => Evaluacion::where('estado', 'en_progreso')->count(),
                'borradores' => Evaluacion::where('estado', 'borrador')->count(),
            ];

            return view('livewire.encuesta.evaluacion.mostrar-evaluacion', [
                'evaluaciones' => $evaluaciones,
                'estadisticas' => $estadisticas,
            ])->layout('layouts.app');

        } catch (\Exception $e) {
            // En caso de error, mostrar vista vacía
            return view('livewire.encuesta.evaluacion.mostrar-evaluacion', [
                'evaluaciones' => collect([]),
                'estadisticas' => [
                    'total' => 0,
                    'completadas' => 0,
                    'en_progreso' => 0,
                    'borradores' => 0,
                ],
            ])->layout('layouts.app');
        }
    }


    // public function render()
    // {
    //     return view('livewire.encuesta.evaluacion.mostrar-evaluacion')->layout("layouts.app");
    // }
}
