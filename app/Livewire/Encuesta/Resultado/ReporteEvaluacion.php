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
        1 => ['nombre' => 'Necesita acompañamiento', 'color' => '#EF4444', 'descripcion' => 'Necesita acompañamiento para el estándar'],
        2 => ['nombre' => 'Avanza con áreas por fortalecer', 'color' => '#F97316', 'descripcion' => 'Avanza con áreas por fortalecer'],
        3 => ['nombre' => 'Cumple lo esperado', 'color' => '#8B5CF6', 'descripcion' => 'Cumple de forma confiable lo esperado'],
        4 => ['nombre' => 'Desempeño superior', 'color' => '#3B82F6', 'descripcion' => 'Desempeño consistentemente superior'],
        5 => ['nombre' => 'Modelo a seguir', 'color' => '#10B981', 'descripcion' => 'Modelo a seguir con impacto sostenido']
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

            // Obtener datos del usuario
            $datosEvaluado = collect($evaluacion->encuestados_data)->firstWhere('id', $evaluado->id);

            $resultadosPorEvaluado[$evaluado->id] = [
                'id' => $evaluado->id,
                'nombre' => $evaluado->name . ' ' . $evaluado->primer_apellido,
                'empresa' => $datosEvaluado['empresa'] ?? 'N/A',
                'departamento' => $datosEvaluado['departamento'] ?? 'N/A',
                'puesto' => $datosEvaluado['puesto'] ?? 'N/A',
                'competencias' => [],
                'promedio_general' => 0,
                'calificadores' => $calificadoresDelEvaluado,
                'total_calificadores' => count($calificadoresDelEvaluado),
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
                        'nivel' => $this->obtenerNivel($promedioCompetencia),
                    ];
                }
            }

            if ($totalRespuestasGeneral > 0) {
                $promedioGeneral = $totalPuntuacionGeneral / $totalRespuestasGeneral;
                $resultadosPorEvaluado[$evaluado->id]['promedio_general'] = round($promedioGeneral, 2);
                $resultadosPorEvaluado[$evaluado->id]['nivel_general'] = $this->obtenerNivel($promedioGeneral);
            }
        }

        $this->resultadosEvaluacion = $resultadosPorEvaluado;
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


    public function generarUrlGraficaRadar($evaluadoId)
    {
        if (!isset($this->resultadosEvaluacion[$evaluadoId])) {
            return '';
        }

        $resultado = $this->resultadosEvaluacion[$evaluadoId];
        $competencias = $resultado['competencias'];

        $labels = [];
        $datos = [];

        foreach ($competencias as $comp) {
            $labels[] = $comp['nombre'];
            $datos[] = $comp['promedio'];
        }

        $chartConfig = [
            'type' => 'radar',
            'data' => [
                'labels' => $labels,
                'datasets' => [[
                    'label' => 'Promedio',
                    'data' => $datos,
                    'fill' => true,
                    'backgroundColor' => 'rgba(99, 102, 241, 0.2)',
                    'borderColor' => 'rgb(99, 102, 241)',
                    'pointBackgroundColor' => 'rgb(99, 102, 241)',
                    'pointBorderColor' => '#fff',
                    'pointHoverBackgroundColor' => '#fff',
                    'pointHoverBorderColor' => 'rgb(99, 102, 241)'
                ]]
            ],
            'options' => [
                'elements' => [
                    'line' => ['borderWidth' => 3]
                ],
                'scales' => [
                    'r' => [
                        'min' => 0,
                        'max' => 5,
                        'ticks' => ['stepSize' => 1]
                    ]
                ]
            ]
        ];

        return 'https://quickchart.io/chart?width=800&height=300&chart=' . urlencode(json_encode($chartConfig));
    }

    public function generarUrlGraficaBarrasHorizontal($evaluadoId)
    {
        if (!isset($this->resultadosEvaluacion[$evaluadoId])) {
            return '';
        }

        $resultado = $this->resultadosEvaluacion[$evaluadoId];
        $competencias = $resultado['competencias'];

        $labels = [];
        $datosPromedio = [];
        $datosAutoevaluacion = [];
        $coloresPromedio = [];

        foreach ($competencias as $comp) {
            $labels[] = $comp['nombre'];
            $datosPromedio[] = $comp['promedio'];

            // Obtener autoevaluación si existe
            $autoevaluacion = $comp['promedios_por_rol']['Autoevaluación'] ?? null;
            $datosAutoevaluacion[] = $autoevaluacion;

            $nivel = $comp['nivel'];
            $coloresPromedio[] = $this->nivelesEvaluacion[$nivel]['color'];
        }

        $chartConfig = [
            'type' => 'bar',
            'data' => [
                'labels' => $labels,
                'datasets' => [
                    [
                        'label' => 'Promedio',
                        'data' => $datosPromedio,
                        'backgroundColor' => $coloresPromedio,
                        'borderColor' => $coloresPromedio,
                        'borderWidth' => 1,
                        'barThickness' => 15,
                    ],
                    [
                        'label' => 'Autoevaluación',
                        'data' => $datosAutoevaluacion,
                        'backgroundColor' => '#f65c5cff',
                        'borderColor' => '#f65c5cff',
                        'borderWidth' => 1,
                        'barThickness' => 15,
                    ]
                ]
            ],
            'options' => [
                'indexAxis' => 'y', // Esta es la clave para hacer el gráfico horizontal
                'responsive' => true,
                'maintainAspectRatio' => false,
                'layout' => [
                    'padding' => [
                        'right' => 50
                    ]
                ],
                'scales' => [
                    'x' => [
                        'beginAtZero' => true,
                        'min' => 0,
                        'max' => 5,
                        'ticks' => [
                            'stepSize' => 0.5,
                            'color' => 'black',
                            'font' => [
                                'size' => 10,
                            ],
                        ],
                        'grid' => [
                            'color' => 'rgba(0, 0, 0, 0.1)',
                        ],
                    ],
                    'y' => [
                        'ticks' => [
                            'color' => 'black',
                            'font' => [
                                'size' => 11,
                            ],
                        ],
                        'grid' => [
                            'display' => false,
                        ],
                    ],
                ],
                'plugins' => [
                    'legend' => [
                        'display' => true,
                        'position' => 'top',
                        'labels' => [
                            'color' => 'black',
                            'font' => [
                                'size' => 12
                            ]
                        ]
                    ],
                    'datalabels' => [
                        'anchor' => 'end',
                        'align' => 'end',
                        'color' => '#000',
                        'font' => [
                            'weight' => 'bold',
                            'size' => 10
                        ]
                    ]
                ]
            ]
        ];

        return 'https://quickchart.io/chart?width=1000&height=400&v=' . time() . '&c=' . urlencode(json_encode($chartConfig));
    }
    // public function generarUrlGraficaBarrasHorizontal($evaluadoId)
    // {
    //     if (!isset($this->resultadosEvaluacion[$evaluadoId])) {
    //         return '';
    //     }

    //     $resultado = $this->resultadosEvaluacion[$evaluadoId];
    //     $competencias = $resultado['competencias'];

    //     $labels = [];
    //     $datos = [];
    //     $colores = [];

    //     foreach ($competencias as $comp) {
    //         $labels[] = $comp['nombre'];
    //         $datos[] = $comp['promedio'];
    //         $nivel = $comp['nivel'];
    //         $colores[] = $this->nivelesEvaluacion[$nivel]['color'];
    //     }

    //     $chartConfig = [
    //         'type' => 'horizontalBar',
    //         'data' => [
    //             'labels' => $labels,
    //             'datasets' => [[
    //                 'label' => 'Promedio',
    //                 'data' => $datos,
    //                 'backgroundColor' => $colores,
    //                 'borderColor' => $colores,
    //                 'borderWidth' => 1,
    //                 'barThickness' => 20,
    //             ]]
    //         ],
    //         'options' => [
    //             'indexAxis' => 'y',
    //             'scales' => [
    //                 'x' => [
    //                     'min' => 0,
    //                     'max' => 5,
    //                     'ticks' => ['stepSize' => 1]
    //                 ]
    //             ],
    //             'plugins' => [
    //                 'datalabels' => [
    //                     'anchor' => 'end',
    //                     'align' => 'end',
    //                     'color' => '#000',
    //                     'font' => ['weight' => 'bold']
    //                 ]
    //             ]
    //         ]
    //     ];

    //     return 'https://quickchart.io/chart?width=700&height=300&chart=' . urlencode(json_encode($chartConfig));
    // }

 public function generarUrlGraficaComparativaRoles($evaluadoId, $competenciaId)
{
    if (!isset($this->resultadosEvaluacion[$evaluadoId]['competencias'][$competenciaId])) {
        return '';
    }

    $competencia = $this->resultadosEvaluacion[$evaluadoId]['competencias'][$competenciaId];
    $promediosPorRol = $competencia['promedios_por_rol'];

    $labels = array_keys($promediosPorRol);
    $datos = array_values($promediosPorRol);

    $chartConfig = [
        'type' => 'horizontalBar', // Usar el tipo antiguo pero compatible
        'data' => [
            'labels' => $labels,
            'datasets' => [[
                'label' => $competencia['nombre'],
                'data' => $datos,
                'backgroundColor' => ['#6366F1', '#EC4899', '#10B981', '#F59E0B'],
                'barThickness' => 30,
            ]]
        ],
        'options' => [
            'scales' => [
                'xAxes' => [[
                    'ticks' => [
                        'beginAtZero' => true,
                        'min' => 0,
                        'max' => 5,
                        'stepSize' => 1,
                        'fontColor' => 'black',
                        'fontSize' => 10,
                    ],
                    'gridLines' => [
                        'color' => 'rgba(0, 0, 0, 0.1)',
                        'zeroLineWidth' => 1,
                        'zeroLineColor' => 'black',
                    ],
                ]],
                'yAxes' => [[
                    'ticks' => [
                        'fontColor' => 'black',
                        'fontSize' => 11,
                    ],
                    'gridLines' => [
                        'display' => false,
                    ],
                ]],
            ],
            'legend' => [
                'display' => true,
                'position' => 'top',
                'labels' => [
                    'fontColor' => 'black',
                    'fontSize' => 12
                ]
            ]
        ]
    ];

    return 'https://quickchart.io/chart?width=800&height=300&chart=' . urlencode(json_encode($chartConfig));
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
