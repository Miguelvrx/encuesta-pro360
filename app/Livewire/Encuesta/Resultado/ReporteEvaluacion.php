<?php

namespace App\Livewire\Encuesta\Resultado;

use App\Models\Competencia;
use App\Models\Compromiso;
use App\Models\Departamento;
use App\Models\Empresa;
use App\Models\Evaluacion;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
    public $totalEvaluados = 0;
    public $empresaActual = null;
    public $departamentoActual = null;
    public $empresasDisponibles = [];
    public $departamentosPorUsuario = [];

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
        $this->evaluaciones = $this->obtenerEvaluacionesUnicas();
        $this->empresas = Empresa::all();
        $this->departamentos = collect();
        $this->usuariosEvaluados = collect();

        if ($this->evaluaciones->count() > 0) {
            $this->evaluacionIdSeleccionada = $this->evaluaciones->first()->id_evaluacion;
            $this->actualizarDatosContextuales();
            $this->actualizarUsuariosEvaluados();
            $this->calcularResultados();
        }
    }





    // NUEVO MÉTODO: Agrupar evaluaciones por nombre y fecha
    protected function obtenerEvaluacionesUnicas()
    {
        $evaluacionesCompletadas = Evaluacion::where('estado', 'completada')
            ->orderBy('fecha_cierre', 'desc')
            ->get();

        // Agrupar por tipo_evaluacion y fecha_inicio para evitar duplicados
        $evaluacionesUnicas = collect();
        $evaluacionesVistas = [];

        foreach ($evaluacionesCompletadas as $evaluacion) {
            $clave = $evaluacion->tipo_evaluacion . '_' . $evaluacion->fecha_inicio->format('Y-m-d');

            if (!in_array($clave, $evaluacionesVistas)) {
                $evaluacionesUnicas->push($evaluacion);
                $evaluacionesVistas[] = $clave;
            }
        }

        return $evaluacionesUnicas;
    }

    protected function actualizarDatosContextuales()
    {
        if (!$this->evaluacionIdSeleccionada) {
            $this->reset(['empresasDisponibles', 'departamentosPorUsuario', 'empresaActual', 'departamentoActual', 'totalEvaluados']);
            return;
        }

        $evaluacion = Evaluacion::find($this->evaluacionIdSeleccionada);

        if (!$evaluacion || !$evaluacion->encuestados_data) {
            $this->reset(['empresasDisponibles', 'departamentosPorUsuario', 'empresaActual', 'departamentoActual', 'totalEvaluados']);
            return;
        }

        // Extraer empresas únicas de la evaluación
        $this->empresasDisponibles = $this->extraerEmpresasDeEvaluacion($evaluacion);

        // Extraer departamentos por usuario
        $this->departamentosPorUsuario = $this->extraerDepartamentosPorUsuario($evaluacion);

        // Calcular total de evaluados
        $this->totalEvaluados = count($evaluacion->encuestados_data);

        // Determinar empresa y departamento actual (si es único)
        $empresasUnicas = array_unique(array_column($evaluacion->encuestados_data, 'empresa'));
        $departamentosUnicos = array_unique(array_column($evaluacion->encuestados_data, 'departamento'));

        $this->empresaActual = count($empresasUnicas) === 1 ? $empresasUnicas[0] : null;
        $this->departamentoActual = count($departamentosUnicos) === 1 ? $departamentosUnicos[0] : null;
    }

    protected function extraerEmpresasDeEvaluacion($evaluacion)
    {
        if (!$evaluacion->encuestados_data) {
            return collect();
        }

        $empresasNombres = array_unique(array_column($evaluacion->encuestados_data, 'empresa'));
        return Empresa::whereIn('nombre_comercial', $empresasNombres)->get();
    }

    protected function extraerDepartamentosPorUsuario($evaluacion)
    {
        if (!$evaluacion->encuestados_data) {
            return [];
        }

        $departamentosPorUsuario = [];
        foreach ($evaluacion->encuestados_data as $encuestado) {
            $departamentosPorUsuario[$encuestado['id']] = $encuestado['departamento'] ?? 'N/A';
        }

        return $departamentosPorUsuario;
    }

    public function getEmpresasFromEvaluacion($eval)
    {
        if (!$eval->encuestados_data) {
            return [];
        }

        return array_unique(array_column($eval->encuestados_data, 'empresa'));
    }

    public function getPuestoFromEvaluacion($usuarioId, $evaluacionId)
    {
        if (!$evaluacionId) {
            return null;
        }

        $evaluacion = Evaluacion::find($evaluacionId);
        if (!$evaluacion || !$evaluacion->encuestados_data) {
            return null;
        }

        $encuestado = collect($evaluacion->encuestados_data)->firstWhere('id', $usuarioId);
        return $encuestado['puesto'] ?? null;
    }

    // NUEVO MÉTODO: Obtener todas las evaluaciones con el mismo nombre y fecha
    public function getEvaluacionesAgrupadas($tipoEvaluacion, $fecha)
    {
        return Evaluacion::where('tipo_evaluacion', $tipoEvaluacion)
            ->whereDate('fecha_inicio', $fecha)
            ->where('estado', 'completada')
            ->get();
    }

    public function updatedEvaluacionIdSeleccionada($value)
    {
        $this->reset(['empresaSeleccionada', 'departamentoSeleccionado', 'usuarioEvaluadoSeleccionado']);
        $this->departamentos = collect();
        $this->usuariosEvaluados = collect();
        if ($value) {
            $this->actualizarDatosContextuales();
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

        $evaluacionSeleccionada = Evaluacion::find($this->evaluacionIdSeleccionada);
        if (!$evaluacionSeleccionada) {
            $this->usuariosEvaluados = collect();
            return;
        }

        // Obtener todas las evaluaciones con el mismo nombre y fecha
        $evaluacionesAgrupadas = $this->getEvaluacionesAgrupadas(
            $evaluacionSeleccionada->tipo_evaluacion,
            $evaluacionSeleccionada->fecha_inicio->format('Y-m-d')
        );

        // Recolectar todos los IDs de encuestados de todas las evaluaciones agrupadas
        $todosLosIdsEncuestados = collect();

        foreach ($evaluacionesAgrupadas as $eval) {
            if ($eval->encuestados_data) {
                $idsDeEstaEvaluacion = collect($eval->encuestados_data)->pluck('id')->toArray();
                $todosLosIdsEncuestados = $todosLosIdsEncuestados->merge($idsDeEstaEvaluacion);
            }
        }

        $todosLosIdsEncuestados = $todosLosIdsEncuestados->unique()->toArray();

        if (empty($todosLosIdsEncuestados)) {
            $this->usuariosEvaluados = collect();
            return;
        }

        $query = User::whereIn('id', $todosLosIdsEncuestados);

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

    public function verDetalle($evaluadoId)
    {
        $this->usuarioEvaluadoSeleccionado = $evaluadoId;
        $this->tipoReporte = 'por_evaluado';
        $this->calcularResultados();
    }

    public function calcularResultados()
    {
        $this->resultadosEvaluacion = [];

        if (!$this->evaluacionIdSeleccionada) {
            return;
        }

        $evaluacionSeleccionada = Evaluacion::find($this->evaluacionIdSeleccionada);
        if (!$evaluacionSeleccionada) {
            return;
        }

        // Obtener todas las evaluaciones con el mismo nombre y fecha
        $evaluacionesAgrupadas = $this->getEvaluacionesAgrupadas(
            $evaluacionSeleccionada->tipo_evaluacion,
            $evaluacionSeleccionada->fecha_inicio->format('Y-m-d')
        );

        $usuariosParaReporte = $this->usuariosEvaluados;
        if ($this->usuarioEvaluadoSeleccionado) {
            $usuariosParaReporte = $this->usuariosEvaluados->where('id', $this->usuarioEvaluadoSeleccionado);
        }

        $resultadosPorEvaluado = [];

        foreach ($usuariosParaReporte as $evaluado) {
            // Buscar el evaluado en todas las evaluaciones agrupadas
            $evaluacionDelEvaluado = null;
            $indiceEvaluado = null;

            foreach ($evaluacionesAgrupadas as $eval) {
                if (!$eval->encuestados_data) continue;

                $indice = collect($eval->encuestados_data)->search(fn($e) => $e['id'] == $evaluado->id);

                if ($indice !== false) {
                    $evaluacionDelEvaluado = $eval;
                    $indiceEvaluado = $indice;
                    break;
                }
            }

            if (!$evaluacionDelEvaluado || $indiceEvaluado === null) {
                continue;
            }

            // Cargar las relaciones necesarias
            $evaluacionDelEvaluado->load(['respuestas.pregunta.competencia']);

            $calificadoresDelEvaluado = $evaluacionDelEvaluado->calificadores_data[$indiceEvaluado] ?? [];

            if (empty($calificadoresDelEvaluado)) {
                continue;
            }

            $idsCalificadores = collect($calificadoresDelEvaluado)->pluck('id')->toArray();

            $registrosEvaluacionUsuario = DB::table('evaluacion_usuario')
                ->where('evaluacion_id_evaluacion', $evaluacionDelEvaluado->id_evaluacion)
                ->where('user_id', $evaluado->id)
                ->first();

            if (!$registrosEvaluacionUsuario) {
                continue;
            }

            $idEvaluadoEnTabla = $registrosEvaluacionUsuario->evaluado;

            $respuestasParaEvaluado = $evaluacionDelEvaluado->respuestas->filter(function ($respuesta) use ($idsCalificadores, $idEvaluadoEnTabla, $evaluacionDelEvaluado) {
                if (!in_array($respuesta->user_id, $idsCalificadores)) {
                    return false;
                }

                $esEvaluacionDeEsteUsuario = DB::table('evaluacion_usuario')
                    ->where('evaluacion_id_evaluacion', $evaluacionDelEvaluado->id_evaluacion)
                    ->where('user_id', $respuesta->user_id)
                    ->where('evaluado', $idEvaluadoEnTabla)
                    ->exists();

                return $esEvaluacionDeEsteUsuario;
            });

            // Obtener datos del usuario
            $datosEvaluado = collect($evaluacionDelEvaluado->encuestados_data)->firstWhere('id', $evaluado->id);

            $resultadosPorEvaluado[$evaluado->id] = [
                'id' => $evaluado->id,
                'nombre' => $evaluado->name . ' ' . $evaluado->primer_apellido,
                'empresa' => $datosEvaluado['empresa'] ?? 'N/A',
                'departamento' => $datosEvaluado['departamento'] ?? 'N/A',
                'puesto' => $datosEvaluado['puesto'] ?? 'N/A',
                'competencias' => [],
                'promedio_general' => 0,
                'nivel_general' => 1, // Valor por defecto
                'calificadores' => $calificadoresDelEvaluado,
                'total_calificadores' => count($calificadoresDelEvaluado),
                'evaluacion_id' => $evaluacionDelEvaluado->id_evaluacion,
            ];

            $competenciasIds = $evaluacionDelEvaluado->configuracion_data['competencias'] ?? [];
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

            // Asegurar que siempre se calcule el nivel_general
            if ($totalRespuestasGeneral > 0) {
                $promedioGeneral = $totalPuntuacionGeneral / $totalRespuestasGeneral;
                $resultadosPorEvaluado[$evaluado->id]['promedio_general'] = round($promedioGeneral, 2);
                $resultadosPorEvaluado[$evaluado->id]['nivel_general'] = $this->obtenerNivel($promedioGeneral);
            } else {
                // Si no hay respuestas, establecer valores por defecto
                $resultadosPorEvaluado[$evaluado->id]['promedio_general'] = 0;
                $resultadosPorEvaluado[$evaluado->id]['nivel_general'] = 1;
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

// Agregar estas propiedades al inicio de la clase ReporteEvaluacion

public $mostrarFormularioCompromiso = false;
public $compromisoEditando = null;

// Datos del formulario de compromiso
public $compromiso_titulo = '';
public $compromiso_descripcion = '';
public $compromiso_fecha_vencimiento = '';
public $compromiso_competencia = '';
public $compromiso_nivel_actual = '';
public $compromiso_nivel_objetivo = '';
public $compromiso_acciones = '';
public $compromiso_recursos = '';

// Agregar estos métodos al componente

public function cargarCompromisos($evaluadoId)
{
    if (!$this->evaluacionIdSeleccionada) {
        return collect();
    }

    return Compromiso::where('user_id', $evaluadoId)
        ->where('evaluacion_id', $this->evaluacionIdSeleccionada)
        ->with(['seguimientos', 'responsable'])
        ->orderBy('fecha_alta', 'desc')
        ->get();
}

public function abrirFormularioCompromiso($competenciaId = null)
{
    $this->mostrarFormularioCompromiso = true;
    $this->compromiso_competencia = $competenciaId;
    
    // Pre-cargar datos si hay una competencia seleccionada
    if ($competenciaId && isset($this->resultadosEvaluacion[$this->usuarioEvaluadoSeleccionado]['competencias'][$competenciaId])) {
        $competencia = $this->resultadosEvaluacion[$this->usuarioEvaluadoSeleccionado]['competencias'][$competenciaId];
        $this->compromiso_nivel_actual = $competencia['nivel'];
        $this->compromiso_titulo = "Mejora en " . $competencia['nombre'];
    }
}

public function cerrarFormularioCompromiso()
{
    $this->mostrarFormularioCompromiso = false;
    $this->reset([
        'compromiso_titulo',
        'compromiso_descripcion',
        'compromiso_fecha_vencimiento',
        'compromiso_competencia',
        'compromiso_nivel_actual',
        'compromiso_nivel_objetivo',
        'compromiso_acciones',
        'compromiso_recursos',
        'compromisoEditando'
    ]);
}

public function guardarCompromiso()
{
    $this->validate([
        'compromiso_titulo' => 'required|string|max:255',
        'compromiso_descripcion' => 'required|string',
        'compromiso_fecha_vencimiento' => 'required|date|after:today',
        'compromiso_nivel_objetivo' => 'required|integer|min:1|max:5',
        'compromiso_acciones' => 'required|string',
    ], [
        'compromiso_titulo.required' => 'El título es obligatorio',
        'compromiso_descripcion.required' => 'La descripción es obligatoria',
        'compromiso_fecha_vencimiento.required' => 'La fecha de vencimiento es obligatoria',
        'compromiso_fecha_vencimiento.after' => 'La fecha debe ser posterior a hoy',
        'compromiso_nivel_objetivo.required' => 'El nivel objetivo es obligatorio',
        'compromiso_acciones.required' => 'Las acciones específicas son obligatorias',
    ]);

    $evaluado = $this->resultadosEvaluacion[$this->usuarioEvaluadoSeleccionado];
    
    $datosCompromiso = [
        'fecha_alta' => now(),
        'fecha_vencimiento' => $this->compromiso_fecha_vencimiento,
        'titulo' => $this->compromiso_titulo,
        'descripcion_compromiso' => $this->compromiso_descripcion,
        'estado' => 'pendiente',
        'verificado_cumplido' => false,
        'puntuacion_inicial' => $evaluado['promedio_general'],
        'puntuacion_actual' => $evaluado['promedio_general'],
        'user_id' => $this->usuarioEvaluadoSeleccionado,
        'responsable_id' => Auth::id(),
        'evaluacion_id' => $this->evaluacionIdSeleccionada,
        'tipo_compromiso' => 'mejora_competencia',
        'usuario_rol' => Auth::user()->getRoleNames()->first() ?? 'evaluador',
        'competencia' => $this->compromiso_competencia ?: null,
        'nivel_actual' => $this->compromiso_nivel_actual ?: null,
        'nivel_objetivo' => $this->compromiso_nivel_objetivo,
        'acciones_especificas' => $this->compromiso_acciones,
        'recursos_apoyo' => $this->compromiso_recursos ?: null,
    ];

    if ($this->compromisoEditando) {
        $compromiso = Compromiso::find($this->compromisoEditando);
        $compromiso->update($datosCompromiso);
        session()->flash('mensaje', 'Compromiso actualizado exitosamente');
    } else {
        Compromiso::create($datosCompromiso);
        session()->flash('mensaje', 'Compromiso creado exitosamente');
    }

    $this->cerrarFormularioCompromiso();
}

public function editarCompromiso($compromisoId)
{
    $compromiso = Compromiso::findOrFail($compromisoId);
    
    $this->compromisoEditando = $compromisoId;
    $this->compromiso_titulo = $compromiso->titulo;
    $this->compromiso_descripcion = $compromiso->descripcion_compromiso;
    $this->compromiso_fecha_vencimiento = $compromiso->fecha_vencimiento->format('Y-m-d');
    $this->compromiso_competencia = $compromiso->competencia;
    $this->compromiso_nivel_actual = $compromiso->nivel_actual;
    $this->compromiso_nivel_objetivo = $compromiso->nivel_objetivo;
    $this->compromiso_acciones = $compromiso->acciones_especificas;
    $this->compromiso_recursos = $compromiso->recursos_apoyo;
    
    $this->mostrarFormularioCompromiso = true;
}

public function eliminarCompromiso($compromisoId)
{
    Compromiso::findOrFail($compromisoId)->delete();
    session()->flash('mensaje', 'Compromiso eliminado exitosamente');
}

public function cambiarEstadoCompromiso($compromisoId, $nuevoEstado)
{
    $compromiso = Compromiso::findOrFail($compromisoId);
    $compromiso->update(['estado' => $nuevoEstado]);
    session()->flash('mensaje', 'Estado actualizado exitosamente');
}

    public function render()
    {
        return view('livewire.encuesta.resultado.reporte-evaluacion', [
            'resultados' => $this->resultadosEvaluacion,
            'compromisos' => $this->usuarioEvaluadoSeleccionado
                ? $this->cargarCompromisos($this->usuarioEvaluadoSeleccionado)
                : collect(),
        ])->layout('layouts.app');
    }
    // public function render()
    // {
    //     return view('livewire.encuesta.resultado.reporte-evaluacion')->layout('layouts.app');
    // }

}
