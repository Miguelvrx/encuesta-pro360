<?php

namespace App\Livewire\Encuesta\Evaluacion;

use App\Models\Evaluacion;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Str;

class CrearEvaluacion extends Component
{
    public $tipo_evaluacion = "";
    public $fecha_inicio = "";
    public $fecha_cierre = "";
    public $descripcion_evaluacion = "";

    public function mount()
    {
        $this->fecha_inicio = now()->format("Y-m-d");
        $this->fecha_cierre = now()->addMonth()->format("Y-m-d");
    }

    protected function rules()
    {
        return [
            "tipo_evaluacion" => "required|string|max:100",
            "fecha_inicio" => "required|date",
            "fecha_cierre" => "required|date|after_or_equal:fecha_inicio",
            "descripcion_evaluacion" => "required|string",
        ];
    }

    public function saveEvaluacion()
    {
        $this->validate(); // Llama a las reglas definidas en el método rules()

        Evaluacion::create([
            "tipo_evaluacion" => $this->tipo_evaluacion,
            "fecha_inicio" => $this->fecha_inicio,
            "fecha_cierre" => $this->fecha_cierre,
            "descripcion_evaluacion" => $this->descripcion_evaluacion,
            "uuid_encuesta" => Str::uuid(),
        ]);

        session()->flash("message", "¡Evaluación creada exitosamente!");
        return $this->redirect(route("mostrar-evaluaciones"), navigate: true);
    }

    public function render()
    {
        return view("livewire.encuesta.evaluacion.crear-evaluacion")->layout("layouts.app");
    }
}
