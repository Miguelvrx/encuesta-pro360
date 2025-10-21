<?php

namespace App\Livewire\Encuesta\Resultado;

use App\Models\Competencia;
use App\Models\Departamento;
use App\Models\Empresa;
use App\Models\Evaluacion;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class ReporteEvaluacion extends Component
{

    use WithPagination;

    public $evaluacionIdSeleccionada = null;
    public $empresaSeleccionada = null;
    public $departamentoSeleccionado = null;
    public $usuarioEvaluadoSeleccionado = null;
    public $tipoReporte = 'general';

    public $evaluaciones;
    public $empresas;
    public $departamentos;
    public $usuariosEvaluados;
    public $resultadosEvaluacion = [];

    public $nivelesEvaluacion = [
        1 => ['nombre' => 'Requiere Apoyo', 'descripcion' => 'Evita tomar decisiones o delegar responsabilidades'],
        2 => ['nombre' => 'En Desarrollo', 'descripcion' => 'Intenta liderar pero requiere guía para avanzar'],
        3 => ['nombre' => 'Competente', 'descripcion' => 'Toma decisiones alineadas con los objetivos'],
        4 => ['nombre' => 'Supera las Expectativas', 'descripcion' => 'Inspira confianza y compromiso en su equipo'],
        5 => ['nombre' => 'Excepcional', 'descripcion' => 'Es referente de liderazgo dentro y fuera del equipo']
    ];

    public function mount()
    {
        $this->evaluaciones = Evaluacion::where('estado', 'completada')->orderBy('fecha_cierre', 'desc')->get();
        $this->empresas = Empresa::all();
        $this->departamentos = collect();
        $this->usuariosEvaluados = collect();

        if ($this->evaluaciones->count() > 0) {
            $this->evaluacionIdSeleccionada = $this->evaluaciones->first()->id_evaluacion;
            $this->actualizarUsuariosEvaluados();
            $this->calcularResultados();
        }
    }

    public function updatedEvaluacionIdSeleccionada($value)
    {
        $this->reset(['empresaSeleccionada', 'departamentoSeleccionado', 'usuarioEvaluadoSeleccionado']);
        $this->departamentos = collect();
        $this->usuariosEvaluados = collect();
        if ($value) {
            $this->actualizarUsuariosEvaluados();
            $this->calcularResultados();
        } else {
            $this->reset(['resultadosEvaluacion']);
        }
    }

    public function updatedEmpresaSeleccionada($value)
    {
        $this->reset(['departamentoSeleccionado', 'usuarioEvaluadoSeleccionado']);
        $this->usuariosEvaluados = collect();
        if ($value) {
            $this->departamentos = Departamento::where('empresa_id_empresa', $value)->orderBy('nombre_departamento')->get();
        } else {
            $this->departamentos = collect();
        }
        $this->actualizarUsuariosEvaluados();
        $this->calcularResultados();
    }

    public function updatedDepartamentoSeleccionado()
    {
        $this->reset(['usuarioEvaluadoSeleccionado']);
        $this->actualizarUsuariosEvaluados();
        $this->calcularResultados();
    }

    public function updatedUsuarioEvaluadoSeleccionado()
    {
        $this->calcularResultados();
    }

    public function updatedTipoReporte()
    {
        $this->calcularResultados();
    }

    protected function actualizarUsuariosEvaluados()
    {
        if (!$this->evaluacionIdSeleccionada) {
            $this->usuariosEvaluados = collect();
            return;
        }

        $evaluacion = Evaluacion::find($this->evaluacionIdSeleccionada);
        if (!$evaluacion || !$evaluacion->encuestados_data) {
            $this->usuariosEvaluados = collect();
            return;
        }

        $idsEncuestados = collect($evaluacion->encuestados_data)->pluck('id')->toArray();
        $query = User::whereIn('id', $idsEncuestados);

        if ($this->empresaSeleccionada) {
            $query->whereHas('departamento', function ($q) {
                $q->where('empresa_id_empresa', $this->empresaSeleccionada);
            });
        }

        if ($this->departamentoSeleccionado) {
            $query->where('departamento_id', $this->departamentoSeleccionado);
        }

        $this->usuariosEvaluados = $query->orderBy('name')->get();
    }

    public function calcularResultados()
    {
        $this->resultadosEvaluacion = [];

        if (!$this->evaluacionIdSeleccionada) {
            return;
        }

        $evaluacion = Evaluacion::with(['respuestas.pregunta.competencia'])
            ->find($this->evaluacionIdSeleccionada);

        if (!$evaluacion) {
            return;
        }

        $usuariosParaReporte = $this->usuariosEvaluados;
        if ($this->usuarioEvaluadoSeleccionado) {
            $usuariosParaReporte = $this->usuariosEvaluados->where('id', $this->usuarioEvaluadoSeleccionado);
        }

        $resultadosPorEvaluado = [];

        foreach ($usuariosParaReporte as $evaluado) {
            $indiceEvaluado = collect($evaluacion->encuestados_data)
                ->search(fn($e) => $e['id'] == $evaluado->id);

            if ($indiceEvaluado === false) {
                continue;
            }

            $calificadoresDelEvaluado = $evaluacion->calificadores_data[$indiceEvaluado] ?? [];

            if (empty($calificadoresDelEvaluado)) {
                continue;
            }

            $idsCalificadores = collect($calificadoresDelEvaluado)->pluck('id')->toArray();

            $registrosEvaluacionUsuario = DB::table('evaluacion_usuario')
                ->where('evaluacion_id_evaluacion', $evaluacion->id_evaluacion)
                ->where('user_id', $evaluado->id)
                ->first();

            if (!$registrosEvaluacionUsuario) {
                continue;
            }

            $idEvaluadoEnTabla = $registrosEvaluacionUsuario->evaluado;

            $respuestasParaEvaluado = $evaluacion->respuestas->filter(function ($respuesta) use ($idsCalificadores, $idEvaluadoEnTabla, $evaluacion) {
                if (!in_array($respuesta->user_id, $idsCalificadores)) {
                    return false;
                }

                $esEvaluacionDeEsteUsuario = DB::table('evaluacion_usuario')
                    ->where('evaluacion_id_evaluacion', $evaluacion->id_evaluacion)
                    ->where('user_id', $respuesta->user_id)
                    ->where('evaluado', $idEvaluadoEnTabla)
                    ->exists();

                return $esEvaluacionDeEsteUsuario;
            });

            $resultadosPorEvaluado[$evaluado->id] = [
                'id' => $evaluado->id,
                'nombre' => $evaluado->name . ' ' . $evaluado->primer_apellido,
                'competencias' => [],
                'promedio_general' => 0,
                'calificadores' => $calificadoresDelEvaluado,
            ];

            $competenciasIds = $evaluacion->configuracion_data['competencias'] ?? [];
            $competenciasEvaluacion = Competencia::with('preguntas')
                ->whereIn('id_competencia', $competenciasIds)
                ->get();

            $totalPuntuacionGeneral = 0;
            $totalRespuestasGeneral = 0;

            foreach ($competenciasEvaluacion as $competencia) {
                $puntuacionesCompetencia = [];
                $puntuacionesPorRol = [];

                $preguntaIds = $competencia->preguntas->pluck('id_pregunta');
                $respuestasCompetencia = $respuestasParaEvaluado->whereIn('pregunta_id_pregunta', $preguntaIds);

                foreach ($respuestasCompetencia as $respuesta) {
                    $puntuacionesCompetencia[] = $respuesta->puntuacion;

                    $rol = $this->getRolCalificador($calificadoresDelEvaluado, $respuesta->user_id);
                    if ($rol) {
                        if (!isset($puntuacionesPorRol[$rol])) {
                            $puntuacionesPorRol[$rol] = [];
                        }
                        $puntuacionesPorRol[$rol][] = $respuesta->puntuacion;
                    }
                }

                if (!empty($puntuacionesCompetencia)) {
                    $promedioCompetencia = array_sum($puntuacionesCompetencia) / count($puntuacionesCompetencia);
                    $totalPuntuacionGeneral += array_sum($puntuacionesCompetencia);
                    $totalRespuestasGeneral += count($puntuacionesCompetencia);

                    $promediosPorRol = [];
                    foreach ($puntuacionesPorRol as $rol => $puntuaciones) {
                        $promediosPorRol[$rol] = round(array_sum($puntuaciones) / count($puntuaciones), 2);
                    }

                    $resultadosPorEvaluado[$evaluado->id]['competencias'][$competencia->id_competencia] = [
                        'nombre' => $competencia->nombre_competencia,
                        'promedio' => round($promedioCompetencia, 2),
                        'promedios_por_rol' => $promediosPorRol,
                        'total_respuestas' => count($puntuacionesCompetencia),
                    ];
                }
            }

            if ($totalRespuestasGeneral > 0) {
                $resultadosPorEvaluado[$evaluado->id]['promedio_general'] = round($totalPuntuacionGeneral / $totalRespuestasGeneral, 2);
            }
        }

        $this->resultadosEvaluacion = $resultadosPorEvaluado;
    }

    protected function getRolCalificador($calificadores, $calificadorId)
    {
        $calificador = collect($calificadores)->firstWhere('id', $calificadorId);
        return $calificador['tipo_rol'] ?? 'Desconocido';
    }

    public function render()
    {
        return view('livewire.encuesta.resultado.reporte-evaluacion', [
            'resultados' => $this->resultadosEvaluacion,
        ])->layout('layouts.app');
    }
    // public function render()
    // {
    //     return view('livewire.encuesta.resultado.reporte-evaluacion')->layout('layouts.app');
    // }

}
