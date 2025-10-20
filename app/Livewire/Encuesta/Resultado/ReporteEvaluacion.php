<?php

namespace App\Livewire\Encuesta\Resultado;

use App\Models\Competencia;
use App\Models\Departamento;
use App\Models\Empresa;
use App\Models\Evaluacion;
use App\Models\Respuesta;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;

class ReporteEvaluacion extends Component
{

 use WithPagination;

    // Propiedades para filtros
    public $evaluacionIdSeleccionada = null;
    public $empresaSeleccionada = null;
    public $departamentoSeleccionado = null;
    public $usuarioEvaluadoSeleccionado = null;

    // Propiedades para el tipo de reporte y visualización
    public $tipoReporte = 'general'; // 'general', 'por_competencia', 'por_evaluado'
    public $tipoVisualizacion = 'tabla'; // 'tabla', 'grafico'

    // Datos para selects
    public $evaluaciones;
    public $empresas;
    public $departamentos;
    public $usuariosEvaluados;

    // Resultados procesados
    public $resultadosEvaluacion = [];
    public $datosGraficos = [];

    // Niveles de evaluación estáticos (copiados de RealizarEvaluacion para consistencia)
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
            $this->reset(['resultadosEvaluacion', 'datosGraficos']);
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

    public function updatedTipoVisualizacion()
    {
        // No es necesario recalcular, la vista maneja el cambio
    }

    protected function actualizarUsuariosEvaluados()
    {
        if (!$this->evaluacionIdSeleccionada) {
            $this->usuariosEvaluados = collect();
            return;
        }

        $evaluacion = Evaluacion::find($this->evaluacionIdSeleccionada);
        if (!$evaluacion) {
            $this->usuariosEvaluados = collect();
            return;
        }

        $query = User::query()
            ->whereIn('id', function ($subQuery) use ($evaluacion) {
                $subQuery->select('user_id')
                    ->from('evaluacion_usuario')
                    ->where('evaluacion_id_evaluacion', $evaluacion->id_evaluacion);
            });

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
        $this->datosGraficos = [];

        if (!$this->evaluacionIdSeleccionada) {
            return;
        }

        $evaluacion = Evaluacion::with(['usuarios', 'respuestas.pregunta.competencia', 'respuestas.usuario'])
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

            // La estructura de `calificadores_data` es un array de arrays de calificadores.
            // Cada sub-array corresponde a un encuestado en el mismo orden que `encuestados_data`.
            // Necesitamos encontrar el índice del evaluado actual en `encuestados_data` para obtener sus calificadores.
            $indiceEvaluado = collect($evaluacion->encuestados_data)->search(fn($e) => $e['id'] == $evaluado->id);
            $calificadoresDelEvaluado = $evaluacion->calificadores_data[$indiceEvaluado] ?? [];

            $idsCalificadores = collect($calificadoresDelEvaluado)->pluck('id')->toArray();

            $respuestasParaEvaluado = $evaluacion->respuestas->whereIn('user_id', $idsCalificadores);

            $resultadosPorEvaluado[$evaluado->id] = [
                'id' => $evaluado->id,
                'nombre' => $evaluado->name . ' ' . $evaluado->primer_apellido,
                'competencias' => [],
                'promedio_general' => 0,
            ];

            $competenciasIds = $evaluacion->configuracion_data['competencias'] ?? [];
            $competenciasEvaluacion = Competencia::with('preguntas')->whereIn('id_competencia', $competenciasIds)->get();

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
                    ];
                }
            }

            if ($totalRespuestasGeneral > 0) {
                $resultadosPorEvaluado[$evaluado->id]['promedio_general'] = round($totalPuntuacionGeneral / $totalRespuestasGeneral, 2);
            }
        }

        $this->resultadosEvaluacion = $resultadosPorEvaluado;
        $this->generarDatosGraficos();
    }

    protected function getRolCalificador($calificadores, $calificadorId)
    {
        $calificador = collect($calificadores)->firstWhere('id', $calificadorId);
        return $calificador['tipo_rol'] ?? 'Desconocido';
    }

    protected function generarDatosGraficos()
    {
        $this->datosGraficos = [];

        if (empty($this->resultadosEvaluacion)) {
            return;
        }

        // Si hay un solo evaluado seleccionado, o si el tipo de reporte es 'por_evaluado'
        if ($this->usuarioEvaluadoSeleccionado && isset($this->resultadosEvaluacion[$this->usuarioEvaluadoSeleccionado])) {
            $evaluado = $this->resultadosEvaluacion[$this->usuarioEvaluadoSeleccionado];
            $labels = [];
            $dataPromedios = [];

            foreach ($evaluado['competencias'] as $competencia) {
                $labels[] = $competencia['nombre'];
                $dataPromedios[] = $competencia['promedio'];
            }

            $this->datosGraficos['radar'] = [
                'labels' => $labels,
                'datasets' => [
                    [
                        'label' => 'Promedio General',
                        'data' => $dataPromedios,
                        'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                        'borderColor' => 'rgba(54, 162, 235, 1)',
                        'pointBackgroundColor' => 'rgba(54, 162, 235, 1)',
                        'pointBorderColor' => '#fff',
                        'pointHoverBackgroundColor' => '#fff',
                        'pointHoverBorderColor' => 'rgba(54, 162, 235, 1)'
                    ]
                ]
            ];

            // También podemos generar datos para un gráfico de barras por roles si hay datos
            $roles = [];
            foreach ($evaluado['competencias'] as $competencia) {
                foreach ($competencia['promedios_por_rol'] as $rol => $promedio) {
                    if (!in_array($rol, $roles)) {
                        $roles[] = $rol;
                    }
                }
            }

            if (!empty($roles)) {
                $datasetsPorRol = [];
                foreach ($roles as $rol) {
                    $data = [];
                    foreach ($evaluado['competencias'] as $competencia) {
                        $data[] = $competencia['promedios_por_rol'][$rol] ?? 0;
                    }
                    $datasetsPorRol[] = [
                        'label' => $rol,
                        'data' => $data,
                        'backgroundColor' => 'rgba(' . rand(0, 255) . ',' . rand(0, 255) . ',' . rand(0, 255) . ', 0.6)', // Color aleatorio
                        'borderColor' => 'rgba(' . rand(0, 255) . ',' . rand(0, 255) . ',' . rand(0, 255) . ', 1)',
                        'borderWidth' => 1
                    ];
                }
                $this->datosGraficos['barras_roles'] = [
                    'labels' => $labels,
                    'datasets' => $datasetsPorRol
                ];
            }
        } else { // Reporte general o por competencia para múltiples evaluados
            $labels = []; // Nombres de evaluados
            $datasets = []; // Promedios por competencia para cada evaluado

            $competenciasUnicas = [];
            foreach ($this->resultadosEvaluacion as $evaluado) {
                foreach ($evaluado["competencias"] as $competenciaId => $competenciaData) {
                    $competenciasUnicas[$competenciaId] = $competenciaData["nombre"];
                }
            }

            foreach ($this->resultadosEvaluacion as $evaluado) {
                $labels[] = $evaluado['nombre'];
                $datasets[] = [
                    'label' => $evaluado['nombre'],
                    'data' => array_column($evaluado['competencias'], 'promedio'),
                    'backgroundColor' => 'rgba(' . rand(0, 255) . ',' . rand(0, 255) . ',' . rand(0, 255) . ', 0.6)',
                    'borderColor' => 'rgba(' . rand(0, 255) . ',' . rand(0, 255) . ',' . rand(0, 255) . ', 1)',
                    'borderWidth' => 1
                ];
            }

            if ($this->tipoReporte === 'general') {
                 // Gráfico de barras para promedios generales de evaluados
                $labelsEvaluados = [];
                $dataPromediosGenerales = [];
                foreach ($this->resultadosEvaluacion as $evaluado) {
                    $labelsEvaluados[] = $evaluado['nombre'];
                    $dataPromediosGenerales[] = $evaluado['promedio_general'];
                }

                $this->datosGraficos['barras_generales'] = [
                    'labels' => $labelsEvaluados,
                    'datasets' => [
                        [
                            'label' => 'Promedio General',
                            'data' => $dataPromediosGenerales,
                            'backgroundColor' => 'rgba(75, 192, 192, 0.6)',
                            'borderColor' => 'rgba(75, 192, 192, 1)',
                            'borderWidth' => 1
                        ]
                    ]
                ];
            } elseif ($this->tipoReporte === 'por_competencia' && !empty($competenciasUnicas)) {
                // Gráfico de barras agrupadas por competencia, mostrando a los evaluados
                $labelsCompetencias = array_values($competenciasUnicas);
                $datasetsCompetencias = [];

                foreach ($this->resultadosEvaluacion as $evaluado) {
                    $data = [];
                    foreach ($competenciasUnicas as $comp_id => $comp_nombre) {
                        $promedio = $evaluado["competencias"][$comp_id]["promedio"] ?? 0;
                        $data[] = $promedio;
                    }
                    $datasetsCompetencias[] = [
                        'label' => $evaluado['nombre'],
                        'data' => $data,
                        'backgroundColor' => 'rgba(' . rand(0, 255) . ',' . rand(0, 255) . ',' . rand(0, 255) . ', 0.6)',
                        'borderColor' => 'rgba(' . rand(0, 255) . ',' . rand(0, 255) . ',' . rand(0, 255) . ', 1)',
                        'borderWidth' => 1
                    ];
                }
                $this->datosGraficos['barras_competencias'] = [
                    'labels' => $labelsCompetencias,
                    'datasets' => $datasetsCompetencias
                ];
            }
        }
    }

    public function render()
    {
        return view('livewire.encuesta.resultado.reporte-evaluacion', [
            'resultados' => $this->resultadosEvaluacion,
            'graficos' => $this->datosGraficos,
        ])->layout('layouts.app');
    }

    // public function render()
    // {
    //     return view('livewire.encuesta.resultado.reporte-evaluacion')->layout('layouts.app');
    // }
}
