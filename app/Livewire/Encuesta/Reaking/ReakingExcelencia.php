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
    public $empresas = []; // Cambiar a array vacío
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
        $this->evaluaciones = $this->obtenerEvaluacionesUnicas();
        
        // Inicialmente no cargar todas las empresas
        $this->empresas = collect();
        $this->departamentos = collect();

        if ($this->evaluaciones->count() > 0) {
            $this->evaluacionSeleccionada = $this->evaluaciones->first()->id_evaluacion;
            $this->cargarEmpresasPorEvaluacion();
            $this->calcularRanking();
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

    // NUEVO MÉTODO: Obtener todas las evaluaciones con el mismo nombre y fecha
    public function getEvaluacionesAgrupadas($tipoEvaluacion, $fecha)
    {
        return Evaluacion::where('tipo_evaluacion', $tipoEvaluacion)
            ->whereDate('fecha_inicio', $fecha)
            ->where('estado', 'completada')
            ->get();
    }

    public function updatedEvaluacionSeleccionada()
    {
        $this->reset(['empresaSeleccionada', 'departamentoSeleccionado']);
        $this->departamentos = collect();
        $this->cargarEmpresasPorEvaluacion();
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

    protected function cargarEmpresasPorEvaluacion()
    {
        if (!$this->evaluacionSeleccionada) {
            $this->empresas = collect();
            return;
        }

        $evaluacionSeleccionada = Evaluacion::find($this->evaluacionSeleccionada);
        if (!$evaluacionSeleccionada) {
            $this->empresas = collect();
            return;
        }

        // Obtener todas las evaluaciones con el mismo nombre y fecha
        $evaluacionesAgrupadas = $this->getEvaluacionesAgrupadas(
            $evaluacionSeleccionada->tipo_evaluacion,
            $evaluacionSeleccionada->fecha_inicio->format('Y-m-d')
        );

        // Recolectar todas las empresas únicas de todas las evaluaciones agrupadas
        $todasLasEmpresas = collect();
        
        foreach ($evaluacionesAgrupadas as $eval) {
            if ($eval->encuestados_data) {
                $empresasDeEstaEvaluacion = collect($eval->encuestados_data)
                    ->pluck('empresa')
                    ->unique()
                    ->filter()
                    ->values();
                $todasLasEmpresas = $todasLasEmpresas->merge($empresasDeEstaEvaluacion);
            }
        }

        $empresasUnicas = $todasLasEmpresas->unique()->values();

        // Buscar las empresas en la base de datos que coincidan con los nombres
        $this->empresas = Empresa::whereIn('nombre_comercial', $empresasUnicas)
            ->orWhereIn('razon_social', $empresasUnicas)
            ->orderBy('nombre_comercial')
            ->get();

        // Si no se encuentran empresas en la BD, crear una colección con los nombres
        if ($this->empresas->isEmpty() && $empresasUnicas->isNotEmpty()) {
            $this->empresas = $empresasUnicas->map(function ($nombreEmpresa, $index) {
                return (object) [
                    'id_empresa' => 'temp_' . $index,
                    'nombre_comercial' => $nombreEmpresa,
                    'razon_social' => $nombreEmpresa
                ];
            });
        }
    }

    public function calcularRanking()
    {
        $this->rankingData = [];

        if (!$this->evaluacionSeleccionada) {
            return;
        }

        $evaluacionSeleccionada = Evaluacion::find($this->evaluacionSeleccionada);
        if (!$evaluacionSeleccionada) {
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
            return;
        }

        $query = User::whereIn('id', $todosLosIdsEncuestados);

        // Aplicar filtros
        if ($this->empresaSeleccionada) {
            // Si la empresa seleccionada es temporal (empresa de la evaluación pero no en BD)
            if (str_starts_with($this->empresaSeleccionada, 'temp_')) {
                $empresaNombre = $this->empresas->firstWhere('id_empresa', $this->empresaSeleccionada)->nombre_comercial;
                $query->whereHas('departamento.empresa', function ($q) use ($empresaNombre) {
                    $q->where('nombre_comercial', $empresaNombre)
                        ->orWhere('razon_social', $empresaNombre);
                });
            } else {
                $query->whereHas('departamento', function ($q) {
                    $q->where('empresa_id_empresa', $this->empresaSeleccionada);
                });
            }
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
            if (empty($calificadoresDelEvaluado)) continue;

            $idsCalificadores = collect($calificadoresDelEvaluado)->pluck('id')->toArray();

            $registrosEvaluacionUsuario = DB::table('evaluacion_usuario')
                ->where('evaluacion_id_evaluacion', $evaluacionDelEvaluado->id_evaluacion)
                ->where('user_id', $evaluado->id)
                ->first();

            if (!$registrosEvaluacionUsuario) continue;

            $idEvaluadoEnTabla = $registrosEvaluacionUsuario->evaluado;

            $respuestasParaEvaluado = $evaluacionDelEvaluado->respuestas->filter(function ($respuesta) use ($idsCalificadores, $idEvaluadoEnTabla, $evaluacionDelEvaluado) {
                if (!in_array($respuesta->user_id, $idsCalificadores)) return false;

                return DB::table('evaluacion_usuario')
                    ->where('evaluacion_id_evaluacion', $evaluacionDelEvaluado->id_evaluacion)
                    ->where('user_id', $respuesta->user_id)
                    ->where('evaluado', $idEvaluadoEnTabla)
                    ->exists();
            });

            // Obtener datos del usuario
            $datosEvaluado = collect($evaluacionDelEvaluado->encuestados_data)->firstWhere('id', $evaluado->id);

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
