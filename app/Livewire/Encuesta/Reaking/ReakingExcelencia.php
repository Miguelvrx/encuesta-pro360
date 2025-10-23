<?php

namespace App\Livewire\Encuesta\Reaking;

use App\Models\Departamento;
use App\Models\Empresa;
use App\Models\Evaluacion;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ReakingExcelencia extends Component
{
    public $evaluacionSeleccionada = null;
    public $empresaSeleccionada = null;
    public $departamentoSeleccionado = null;
    public $ordenarPor = 'promedio_general'; // promedio_general, diferencia, autoevaluacion
    public $orden = 'desc'; // desc o asc
    public $busqueda = '';

    public $evaluaciones;
    public $empresas;
    public $departamentos;
    public $rankingData = [];

    public $nivelesEvaluacion = [
        1 => ['nombre' => 'Necesita acompañamiento', 'color' => '#EF4444'],
        2 => ['nombre' => 'Avanza con áreas por fortalecer', 'color' => '#F97316'],
        3 => ['nombre' => 'Cumple lo esperado', 'color' => '#FBBF24'],
        4 => ['nombre' => 'Desempeño superior', 'color' => '#3B82F6'],
        5 => ['nombre' => 'Modelo a seguir', 'color' => '#10B981']
    ];

    public function mount()
    {
        $this->evaluaciones = Evaluacion::where('estado', 'completada')
            ->orderBy('fecha_cierre', 'desc')
            ->get();
        $this->empresas = Empresa::all();
        $this->departamentos = collect();

        if ($this->evaluaciones->count() > 0) {
            $this->evaluacionSeleccionada = $this->evaluaciones->first()->id_evaluacion;
            $this->calcularRanking();
        }
    }

    public function updatedEvaluacionSeleccionada()
    {
        $this->reset(['empresaSeleccionada', 'departamentoSeleccionado']);
        $this->departamentos = collect();
        $this->calcularRanking();
    }

    public function updatedEmpresaSeleccionada($value)
    {
        $this->reset(['departamentoSeleccionado']);
        if ($value) {
            $this->departamentos = Departamento::where('empresa_id_empresa', $value)
                ->orderBy('nombre_departamento')
                ->get();
        } else {
            $this->departamentos = collect();
        }
        $this->calcularRanking();
    }

    public function updatedDepartamentoSeleccionado()
    {
        $this->calcularRanking();
    }

    public function updatedOrdenarPor()
    {
        $this->calcularRanking();
    }

    public function updatedOrden()
    {
        $this->calcularRanking();
    }

    public function updatedBusqueda()
    {
        $this->calcularRanking();
    }

    public function calcularRanking()
    {
        $this->rankingData = [];

        if (!$this->evaluacionSeleccionada) {
            return;
        }

        $evaluacion = Evaluacion::with(['respuestas.pregunta.competencia'])
            ->find($this->evaluacionSeleccionada);

        if (!$evaluacion || !$evaluacion->encuestados_data) {
            return;
        }

        $idsEncuestados = collect($evaluacion->encuestados_data)->pluck('id')->toArray();
        $query = User::whereIn('id', $idsEncuestados);

        // Aplicar filtros
        if ($this->empresaSeleccionada) {
            $query->whereHas('departamento', function ($q) {
                $q->where('empresa_id_empresa', $this->empresaSeleccionada);
            });
        }

        if ($this->departamentoSeleccionado) {
            $query->where('departamento_id', $this->departamentoSeleccionado);
        }

        if ($this->busqueda) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->busqueda . '%')
                    ->orWhere('primer_apellido', 'like', '%' . $this->busqueda . '%');
            });
        }

        $usuariosEvaluados = $query->get();
        $resultados = [];

        foreach ($usuariosEvaluados as $evaluado) {
            $indiceEvaluado = collect($evaluacion->encuestados_data)
                ->search(fn($e) => $e['id'] == $evaluado->id);

            if ($indiceEvaluado === false) continue;

            $calificadoresDelEvaluado = $evaluacion->calificadores_data[$indiceEvaluado] ?? [];
            if (empty($calificadoresDelEvaluado)) continue;

            $idsCalificadores = collect($calificadoresDelEvaluado)->pluck('id')->toArray();

            $registrosEvaluacionUsuario = DB::table('evaluacion_usuario')
                ->where('evaluacion_id_evaluacion', $evaluacion->id_evaluacion)
                ->where('user_id', $evaluado->id)
                ->first();

            if (!$registrosEvaluacionUsuario) continue;

            $idEvaluadoEnTabla = $registrosEvaluacionUsuario->evaluado;

            $respuestasParaEvaluado = $evaluacion->respuestas->filter(function ($respuesta) use ($idsCalificadores, $idEvaluadoEnTabla, $evaluacion) {
                if (!in_array($respuesta->user_id, $idsCalificadores)) return false;

                return DB::table('evaluacion_usuario')
                    ->where('evaluacion_id_evaluacion', $evaluacion->id_evaluacion)
                    ->where('user_id', $respuesta->user_id)
                    ->where('evaluado', $idEvaluadoEnTabla)
                    ->exists();
            });

            // Obtener datos del usuario
            $datosEvaluado = collect($evaluacion->encuestados_data)->firstWhere('id', $evaluado->id);

            // Calcular promedios
            $autoevaluacion = null;
            $evaluadoresSinAuto = [];

            foreach ($respuestasParaEvaluado as $respuesta) {
                $rol = $this->getRolCalificador($calificadoresDelEvaluado, $respuesta->user_id);

                if ($rol === 'Autoevaluación') {
                    if ($autoevaluacion === null) $autoevaluacion = [];
                    $autoevaluacion[] = $respuesta->puntuacion;
                } else {
                    $evaluadoresSinAuto[] = $respuesta->puntuacion;
                }
            }

            $promedioAutoevaluacion = !empty($autoevaluacion) ?
                round(array_sum($autoevaluacion) / count($autoevaluacion), 2) : null;

            $promedioEvaluadores = !empty($evaluadoresSinAuto) ?
                round(array_sum($evaluadoresSinAuto) / count($evaluadoresSinAuto), 2) : null;

            $todasPuntuaciones = $respuestasParaEvaluado->pluck('puntuacion')->toArray();
            $promedioGeneral = !empty($todasPuntuaciones) ?
                round(array_sum($todasPuntuaciones) / count($todasPuntuaciones), 2) : 0;

            // Calcular diferencia y tendencia
            $diferencia = null;
            $tendencia = 'Sin datos';
            $colorTendencia = 'gray';

            if ($promedioAutoevaluacion !== null && $promedioEvaluadores !== null) {
                $diferencia = round($promedioAutoevaluacion - $promedioEvaluadores, 2);

                if ($diferencia > 0.5) {
                    $tendencia = 'Sobrevalorado';
                    $colorTendencia = 'yellow';
                } elseif ($diferencia < -0.5) {
                    $tendencia = 'Subvalorado';
                    $colorTendencia = 'blue';
                } else {
                    $tendencia = 'Alineado';
                    $colorTendencia = 'green';
                }
            }

            $resultados[] = [
                'id' => $evaluado->id,
                'nombre' => $evaluado->name . ' ' . $evaluado->primer_apellido,
                'empresa' => $datosEvaluado['empresa'] ?? 'N/A',
                'departamento' => $datosEvaluado['departamento'] ?? 'N/A',
                'puesto' => $datosEvaluado['puesto'] ?? 'N/A',
                'autoevaluacion' => $promedioAutoevaluacion,
                'evaluadores' => $promedioEvaluadores,
                'promedio_general' => $promedioGeneral,
                'diferencia' => $diferencia,
                'tendencia' => $tendencia,
                'color_tendencia' => $colorTendencia,
                'nivel' => $this->obtenerNivel($promedioGeneral),
                'total_calificadores' => count($calificadoresDelEvaluado),
            ];
        }

        // Ordenar resultados
        usort($resultados, function ($a, $b) {
            $valorA = $a[$this->ordenarPor] ?? 0;
            $valorB = $b[$this->ordenarPor] ?? 0;

            if ($this->orden === 'desc') {
                return $valorB <=> $valorA;
            }
            return $valorA <=> $valorB;
        });

        // Agregar posición de ranking
        foreach ($resultados as $index => $resultado) {
            $resultados[$index]['ranking'] = $index + 1;
        }

        $this->rankingData = $resultados;
    }

    protected function getRolCalificador($calificadores, $calificadorId)
    {
        $calificador = collect($calificadores)->firstWhere('id', $calificadorId);
        return $calificador['tipo_rol'] ?? 'Desconocido';
    }

    protected function obtenerNivel($promedio)
    {
        if ($promedio >= 4.5) return 5;
        if ($promedio >= 3.5) return 4;
        if ($promedio >= 2.5) return 3;
        if ($promedio >= 1.5) return 2;
        return 1;
    }

    public function exportarExcel()
    {
        // Implementar exportación a Excel
        $this->dispatch('exportar-excel', $this->rankingData);
    }

    public function exportarPDF()
    {
        // Implementar exportación a PDF
        $this->dispatch('exportar-pdf', $this->rankingData);
    }

    public function render()
    {
        return view('livewire.encuesta.reaking.reaking-excelencia')->layout('layouts.app');
    }



    // public function render()
    // {
    //     return view('livewire.encuesta.reaking.reaking-excelencia')->layout('layouts.app');
    // }
}
