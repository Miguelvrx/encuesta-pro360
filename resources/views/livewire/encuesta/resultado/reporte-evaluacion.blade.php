<div>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">

            <!-- Cabecera del Reporte -->
            <header class="mb-8">
                <div class="flex flex-col md:flex-row justify-between items-center bg-white p-6 rounded-xl shadow-md">
                    <div>
                        <div class="flex items-center space-x-3">
                            <div class="bg-indigo-600 text-white rounded-full w-12 h-12 flex items-center justify-center font-bold text-xl">
                                E360
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold text-gray-800">E360 Pro</h1>
                                <p class="text-sm text-indigo-600 font-semibold">Reporte de Evaluación 360°</p>
                            </div>
                        </div>
                        <p class="mt-3 text-sm text-gray-500">Análisis detallado de resultados basado en retroalimentación multifuente</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <button onclick="window.print()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-medium shadow-md transition-colors">
                            📄 Descargar PDF
                        </button>
                    </div>
                </div>
            </header>

            <!-- Controles de Filtro -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Filtros de Búsqueda</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <!-- Filtro por Evaluación -->
                    <div>
                        <label for="select-evaluacion" class="block text-sm font-medium text-gray-700 mb-1">Evaluación</label>
                        <select wire:model.live="evaluacionIdSeleccionada" id="select-evaluacion"
                            class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg">
                            <option value="">-- Selecciona una Evaluación --</option>
                            @foreach($evaluaciones as $eval)
                            <option value="{{ $eval->id_evaluacion }}">{{ $eval->tipo_evaluacion }} ({{ $eval->fecha_inicio->format('d/m/Y') }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filtro por Empresa -->
                    <div>
                        <label for="select-empresa" class="block text-sm font-medium text-gray-700 mb-1">Empresa</label>
                        <select wire:model.live="empresaSeleccionada" id="select-empresa"
                            class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg">
                            <option value="">-- Todas las Empresas --</option>
                            @foreach($empresas as $empresa)
                            <option value="{{ $empresa->id_empresa }}">{{ $empresa->nombre_comercial }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filtro por Departamento -->
                    <div>
                        <label for="select-departamento" class="block text-sm font-medium text-gray-700 mb-1">Departamento</label>
                        <select wire:model.live="departamentoSeleccionado" id="select-departamento"
                            class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg"
                            @if(!$departamentos->count()) disabled @endif>
                            <option value="">-- Todos los Departamentos --</option>
                            @foreach($departamentos as $departamento)
                            <option value="{{ $departamento->id_departamento }}">{{ $departamento->nombre_departamento }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filtro por Usuario Evaluado -->
                    <div>
                        <label for="select-evaluado" class="block text-sm font-medium text-gray-700 mb-1">Evaluado</label>
                        <select wire:model.live="usuarioEvaluadoSeleccionado" id="select-evaluado"
                            class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg"
                            @if(!$usuariosEvaluados->count()) disabled @endif>
                            <option value="">-- Todos los Evaluados --</option>
                            @foreach($usuariosEvaluados as $usuario)
                            <option value="{{ $usuario->id }}">{{ $usuario->name }} {{ $usuario->primer_apellido }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Selección de Tipo de Reporte -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Reporte:</label>
                    <div class="flex flex-wrap gap-3">
                        <button wire:click="$set('tipoReporte', 'general')"
                            class="px-5 py-2.5 rounded-lg text-sm font-semibold transition-all shadow-sm {{ $tipoReporte === 'general' ? 'bg-indigo-600 text-white shadow-indigo-200' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            📊 General
                        </button>
                        <button wire:click="$set('tipoReporte', 'por_competencia')"
                            class="px-5 py-2.5 rounded-lg text-sm font-semibold transition-all shadow-sm {{ $tipoReporte === 'por_competencia' ? 'bg-indigo-600 text-white shadow-indigo-200' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            🎯 Por Competencia
                        </button>
                        <button wire:click="$set('tipoReporte', 'por_evaluado')"
                            class="px-5 py-2.5 rounded-lg text-sm font-semibold transition-all shadow-sm {{ $tipoReporte === 'por_evaluado' ? 'bg-indigo-600 text-white shadow-indigo-200' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                            👤 Por Evaluado
                        </button>
                    </div>
                </div>
            </div>

            <!-- Contenido del Reporte -->
            @if(empty($resultados))
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                <div class="text-gray-400 mb-4">
                    <svg class="mx-auto h-24 w-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <p class="text-lg text-gray-500">Selecciona una evaluación para ver los resultados</p>
            </div>
            @else
            @if($tipoReporte === 'por_evaluado' && $usuarioEvaluadoSeleccionado)
            @php
            $evaluado = $resultados[$usuarioEvaluadoSeleccionado];
            $evaluacionActual = $evaluaciones->firstWhere('id_evaluacion', $evaluacionIdSeleccionada);
            @endphp

            <!-- Reporte Individual Detallado -->
            <div class="space-y-6">
                <!-- Encabezado del Evaluado -->
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl shadow-lg p-8 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="text-2xl font-bold mb-2">{{ $evaluado['nombre'] }}</h2>
                            <div class="space-y-1 text-indigo-100">
                                <p><span class="font-semibold">Empresa:</span> {{ $evaluado['empresa'] }}</p>
                                <p><span class="font-semibold">Departamento:</span> {{ $evaluado['departamento'] }}</p>
                                <p><span class="font-semibold">Puesto:</span> {{ $evaluado['puesto'] }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-indigo-200">Reporte Generado</p>
                            <p class="text-lg font-semibold">{{ now()->format('d/m/Y') }}</p>
                            <p class="text-xs text-indigo-200 mt-2">ID: E360-{{ date('Y-m-d') }}-{{ str_pad($usuarioEvaluadoSeleccionado, 3, '0', STR_PAD_LEFT) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Guía de Interpretación -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">📋 Evaluación 360° – Guía de Interpretación</h3>
                    <p class="text-gray-600 mb-4">
                        La Evaluación 360° ofrece una visión integral de su desempeño, recopilando retroalimentación desde diferentes perspectivas.
                        Este enfoque permite identificar fortalezas y áreas de mejora con el fin de impulsar su crecimiento profesional.
                    </p>

                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-semibold text-gray-800 mb-3">Niveles de Comportamiento</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                            @foreach($nivelesEvaluacion as $nivel => $info)
                            <div class="flex items-center space-x-3">
                                <div class="w-4 h-4 rounded-full" style="background-color: {{ $info['color'] }}"></div>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">Nivel {{ $nivel }}: {{ $info['nombre'] }}</p>
                                    <p class="text-xs text-gray-500">{{ $info['descripcion'] }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- KPIs Resumen -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Promedio General</p>
                                <p class="text-4xl font-bold text-indigo-600 mt-2">{{ $evaluado['promedio_general'] }}</p>
                            </div>
                            <div class="w-16 h-16 rounded-full flex items-center justify-center"
                                style="background-color: {{ $nivelesEvaluacion[$evaluado['nivel_general']]['color'] }}20">
                                <span class="text-2xl">📊</span>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium text-white"
                                style="background-color: {{ $nivelesEvaluacion[$evaluado['nivel_general']]['color'] }}">
                                {{ $nivelesEvaluacion[$evaluado['nivel_general']]['nombre'] }}
                            </span>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Participantes</p>
                                <p class="text-4xl font-bold text-purple-600 mt-2">{{ $evaluado['total_calificadores'] }}</p>
                            </div>
                            <div class="w-16 h-16 rounded-full bg-purple-100 flex items-center justify-center">
                                <span class="text-2xl">👥</span>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <p class="text-xs text-gray-500">Evaluadores en esta retroalimentación</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Competencias</p>
                                <p class="text-4xl font-bold text-green-600 mt-2">{{ count($evaluado['competencias']) }}</p>
                            </div>
                            <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center">
                                <span class="text-2xl">🎯</span>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <p class="text-xs text-gray-500">Evaluadas en este proceso</p>
                        </div>
                    </div>
                </div>

                <!-- Participación en esta evaluación -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">👥 Participación en esta Evaluación</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($evaluado['calificadores'] as $calificador)
                        <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-lg p-4 border border-indigo-100">
                            <div class="flex items-center space-x-2 mb-2">
                                <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center text-sm font-bold">
                                    {{ substr($calificador['nombre'], 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">{{ explode(' ', $calificador['nombre'])[0] }}</p>
                                </div>
                            </div>
                            <span class="inline-block px-2 py-1 bg-indigo-600 text-white text-xs rounded-full">
                                {{ $calificador['tipo_rol'] }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Gráfica de Radar -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">📊 Visión General de Competencias</h3>
                    <p class="text-sm text-gray-600 mb-6">Distribución del desempeño en todas las competencias evaluadas</p>
                    <div class="flex justify-center">
                        <img src="{{ $this->generarUrlGraficaRadar($evaluado['id']) }}"
                            alt="Gráfica de competencias"
                            class="max-w-full h-auto rounded-lg shadow-sm">
                    </div>
                </div>

                <!-- Detalle de Competencias -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-6">🎯 Análisis Detallado por Competencia</h3>
                    <div class="space-y-8">
                        @foreach($evaluado['competencias'] as $idComp => $competencia)
                        <div class="border-l-4 pl-6 py-4" style="border-color: {{ $nivelesEvaluacion[$competencia['nivel']]['color'] }}">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <h4 class="text-lg font-semibold text-gray-800">{{ $competencia['nombre'] }}</h4>
                                    <div class="mt-2 flex items-center space-x-3">
                                        <span class="text-3xl font-bold text-gray-800">{{ $competencia['promedio'] }}</span>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium text-white"
                                            style="background-color: {{ $nivelesEvaluacion[$competencia['nivel']]['color'] }}">
                                            {{ $nivelesEvaluacion[$competencia['nivel']]['nombre'] }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Barra de progreso visual -->
                            <div class="mb-4">
                                <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                                    <div class="h-3 rounded-full transition-all duration-500"
                                        style="width: {{ ($competencia['promedio'] / 5) * 100 }}%; background-color: {{ $nivelesEvaluacion[$competencia['nivel']]['color'] }}">
                                    </div>
                                </div>
                                <div class="flex justify-between text-xs text-gray-500 mt-1">
                                    <span>0</span>
                                    <span>2.5</span>
                                    <span>5.0</span>
                                </div>
                            </div>

                            <!-- Evaluación por Relaciones -->
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm font-semibold text-gray-700 mb-3">Evaluación por Relaciones:</p>
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                                    @foreach($competencia['promedios_por_rol'] as $rol => $promedio)
                                    <div class="bg-white rounded-lg p-3 border border-gray-200">
                                        <p class="text-xs text-gray-500 mb-1">{{ $rol }}</p>
                                        <p class="text-2xl font-bold text-indigo-600">{{ $promedio }}</p>
                                    </div>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Mini gráfica comparativa -->
                            <div class="mt-4">
                                <img src="{{ $this->generarUrlGraficaComparativaRoles($evaluado['id'], $idComp) }}"
                                    alt="Comparativa por roles"
                                    class="max-w-full h-auto rounded-lg">
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Gráfica de Barras Horizontales -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">📈 Ranking de Competencias</h3>
                    <p class="text-sm text-gray-600 mb-6">Comparación visual del desempeño en cada competencia</p>
                    <div class="flex justify-center">
                        <img src="{{ $this->generarUrlGraficaBarrasHorizontal($evaluado['id']) }}&t={{ now()->timestamp }}"
                            alt="Ranking de competencias"
                            class="max-w-full h-auto rounded-lg shadow-sm">
                    </div>
                </div>

                <!-- Tabla Detalle por Rol -->
                <!-- Tabla Detalle por Rol -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">📋 Competencia Comparativa</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-indigo-50 to-purple-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Competencia
                                    </th>
                                    @php
                                    // Definir todos los roles posibles en el orden deseado
                                    $rolesPosibles = ['Autoevaluación', 'Jefe', 'Par', 'Colaborador', 'Cliente'];
                                    $rolesPresentes = [];

                                    foreach ($evaluado['competencias'] as $comp) {
                                    foreach ($comp['promedios_por_rol'] as $rol => $prom) {
                                    if (!in_array($rol, $rolesPresentes)) $rolesPresentes[] = $rol;
                                    }
                                    }

                                    // Ordenar los roles según el orden definido
                                    $rolesUnicos = array_intersect($rolesPosibles, $rolesPresentes);
                                    @endphp
                                    @foreach($rolesUnicos as $rol)
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        {{ $rol }}
                                    </th>
                                    @endforeach
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Promedio
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Diferencia
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Tendencia
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($evaluado['competencias'] as $competencia)
                                @php
                                // Calcular diferencia entre autoevaluación y promedio de otros roles
                                $autoevaluacion = $competencia['promedios_por_rol']['Autoevaluación'] ?? null;

                                // Calcular promedio de todos los roles excepto autoevaluación
                                $otrosRoles = array_filter($competencia['promedios_por_rol'], function($rol) {
                                return $rol !== 'Autoevaluación';
                                }, ARRAY_FILTER_USE_KEY);

                                $promedioOtrosRoles = null;
                                $diferencia = null;
                                $tendencia = null;
                                $colorTendencia = 'gray';

                                if ($autoevaluacion !== null && count($otrosRoles) > 0) {
                                $promedioOtrosRoles = round(array_sum($otrosRoles) / count($otrosRoles), 2);
                                $diferencia = round($autoevaluacion - $promedioOtrosRoles, 2);

                                // Determinar tendencia basada en la diferencia
                                if ($diferencia > 0.5) {
                                $tendencia = 'Sobrevalorado';
                                $colorTendencia = 'yellow';
                                } elseif ($diferencia < -0.5) {
                                    $tendencia='Subvalorado' ;
                                    $colorTendencia='blue' ;
                                    } else {
                                    $tendencia='Alineado' ;
                                    $colorTendencia='green' ;
                                    }
                                    }

                                    // También calcular diferencia específica con Jefe si existe
                                    $diferenciaJefe=null;
                                    $jefeEvaluacion=$competencia['promedios_por_rol']['Jefe'] ?? null;
                                    if ($autoevaluacion !==null && $jefeEvaluacion !==null) {
                                    $diferenciaJefe=round($autoevaluacion - $jefeEvaluacion, 2);
                                    }
                                    @endphp
                                    <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                        {{ $competencia['nombre'] }}
                                    </td>
                                    @foreach($rolesUnicos as $rol)
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if(isset($competencia['promedios_por_rol'][$rol]))
                                        @php
                                        $promedioRol = $competencia['promedios_por_rol'][$rol];
                                        $nivelRol = $promedioRol >= 4.5 ? 5 : ($promedioRol >= 3.5 ? 4 : ($promedioRol >= 2.5 ? 3 : ($promedioRol >= 1.5 ? 2 : 1)));
                                        @endphp
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold text-white"
                                            style="background-color: {{ $nivelesEvaluacion[$nivelRol]['color'] }}">
                                            {{ $promedioRol }}
                                        </span>
                                        @else
                                        <span class="text-gray-400 text-sm">N/A</span>
                                        @endif
                                    </td>
                                    @endforeach
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold text-white"
                                            style="background-color: {{ $nivelesEvaluacion[$competencia['nivel']]['color'] }}">
                                            {{ $competencia['promedio'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($diferencia !== null)
                                        <div class="flex flex-col items-center space-y-1">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold 
                                {{ $diferencia > 0 ? 'bg-yellow-100 text-yellow-800' : ($diferencia < 0 ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                                                {{ $diferencia > 0 ? '+' : '' }}{{ $diferencia }}
                                            </span>
                                            @if($diferenciaJefe !== null)
                                            <span class="text-xs text-gray-500">
                                                Jefe: {{ $diferenciaJefe > 0 ? '+' : '' }}{{ $diferenciaJefe }}
                                            </span>
                                            @endif
                                        </div>
                                        @else
                                        <span class="text-gray-400 text-sm">N/A</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        @if($tendencia)
                                        <div class="flex flex-col items-center space-y-1">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                                {{ $colorTendencia === 'yellow' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($colorTendencia === 'blue' ? 'bg-blue-100 text-blue-800' : 
                                   ($colorTendencia === 'green' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800')) }}">
                                                @if($tendencia === 'Sobrevalorado')
                                                ⬆️ {{ $tendencia }}
                                                @elseif($tendencia === 'Subvalorado')
                                                ⬇️ {{ $tendencia }}
                                                @else
                                                ✅ {{ $tendencia }}
                                                @endif
                                            </span>
                                            @if($promedioOtrosRoles !== null)
                                            <span class="text-xs text-gray-500">
                                                vs otros: {{ $promedioOtrosRoles }}
                                            </span>
                                            @endif
                                        </div>
                                        @else
                                        <span class="text-gray-400 text-sm">N/A</span>
                                        @endif
                                    </td>
                                    </tr>
                                    @endforeach
                            </tbody>
                        </table>

                        <!-- Leyenda de la tabla -->
                        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                            <div class="flex flex-wrap items-center justify-center gap-4 text-xs text-gray-600">
                                <div class="flex items-center space-x-1">
                                    <span class="w-3 h-3 bg-yellow-100 border border-yellow-300 rounded"></span>
                                    <span>Sobrevalorado: Autoevaluación > Otros por +0.5</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <span class="w-3 h-3 bg-blue-100 border border-blue-300 rounded"></span>
                                    <span>Subvalorado: Autoevaluación < Otros por -0.5</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <span class="w-3 h-3 bg-green-100 border border-green-300 rounded"></span>
                                    <span>Alineado: Diferencia dentro de ±0.5</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @else
                <!-- Vista de Tabla Resumen para múltiples evaluados -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="p-6 bg-gradient-to-r from-indigo-50 to-purple-50 border-b border-gray-200">
                        <h3 class="text-xl font-bold text-gray-800">
                            @if($tipoReporte === 'general')
                            📊 Resumen General
                            @elseif($tipoReporte === 'por_competencia')
                            🎯 Resultados por Competencia
                            @else
                            👥 Resultados por Evaluado
                            @endif
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">
                            Mostrando {{ count($resultados) }} evaluado(s)
                        </p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-10">
                                        Evaluado
                                    </th>
                                    @if($tipoReporte === 'general' || $tipoReporte === 'por_evaluado')
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Promedio General
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nivel
                                    </th>
                                    @endif
                                    @if($tipoReporte === 'por_competencia' || $tipoReporte === 'por_evaluado')
                                    @foreach(head($resultados)['competencias'] ?? [] as $competencia)
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        {{ $competencia['nombre'] }}
                                    </th>
                                    @endforeach
                                    @endif
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Acción
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($resultados as $evaluado)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 sticky left-0 bg-white">
                                        <div>
                                            <p class="font-semibold">{{ $evaluado['nombre'] }}</p>
                                            <p class="text-xs text-gray-500">{{ $evaluado['puesto'] }}</p>
                                        </div>
                                    </td>
                                    @if($tipoReporte === 'general' || $tipoReporte === 'por_evaluado')
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="text-2xl font-bold text-indigo-600">{{ $evaluado['promedio_general'] }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium text-white"
                                            style="background-color: {{ $nivelesEvaluacion[$evaluado['nivel_general']]['color'] }}">
                                            Nivel {{ $evaluado['nivel_general'] }}
                                        </span>
                                    </td>
                                    @endif
                                    @if($tipoReporte === 'por_competencia' || $tipoReporte === 'por_evaluado')
                                    @foreach($evaluado['competencias'] as $competencia)
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold text-white"
                                            style="background-color: {{ $nivelesEvaluacion[$competencia['nivel']]['color'] }}">
                                            {{ $competencia['promedio'] }}
                                        </span>
                                    </td>
                                    @endforeach
                                    @endif
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <button wire:click="$set('usuarioEvaluadoSeleccionado', {{ $evaluado['id'] }})"
                                            onclick="$wire.set('tipoReporte', 'por_evaluado')"
                                            class="text-indigo-600 hover:text-indigo-900 font-medium text-sm">
                                            Ver Detalle →
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>


                <!-- Gráfica comparativa general (solo para múltiples evaluados) -->
                @if(count($resultados) > 1 && $tipoReporte === 'general')
                <div class="bg-white rounded-xl shadow-lg p-6 mt-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">📊 Comparativa General</h3>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-600 mb-4">Distribución de Niveles de Desempeño</p>
                            @php
                            $distribucionNiveles = array_count_values(array_column($resultados, 'nivel_general'));
                            @endphp
                            <div class="space-y-3">
                                @foreach($nivelesEvaluacion as $nivel => $info)
                                @php
                                $cantidad = $distribucionNiveles[$nivel] ?? 0;
                                $porcentaje = count($resultados) > 0 ? ($cantidad / count($resultados)) * 100 : 0;
                                @endphp
                                <div>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="font-medium">Nivel {{ $nivel }}: {{ $info['nombre'] }}</span>
                                        <span class="text-gray-600">{{ $cantidad }} ({{ number_format($porcentaje, 1) }}%)</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="h-2.5 rounded-full"
                                            style="width: {{ $porcentaje }}%; background-color: {{ $info['color'] }}">
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-4">Estadísticas Generales</p>
                            @php
                            $promedios = array_column($resultados, 'promedio_general');
                            $promedioGlobal = count($promedios) > 0 ? array_sum($promedios) / count($promedios) : 0;
                            $maximo = count($promedios) > 0 ? max($promedios) : 0;
                            $minimo = count($promedios) > 0 ? min($promedios) : 0;
                            @endphp
                            <div class="grid grid-cols-3 gap-4">
                                <div class="bg-indigo-50 rounded-lg p-4 text-center">
                                    <p class="text-xs text-gray-600 mb-1">Promedio</p>
                                    <p class="text-2xl font-bold text-indigo-600">{{ number_format($promedioGlobal, 2) }}</p>
                                </div>
                                <div class="bg-green-50 rounded-lg p-4 text-center">
                                    <p class="text-xs text-gray-600 mb-1">Máximo</p>
                                    <p class="text-2xl font-bold text-green-600">{{ number_format($maximo, 2) }}</p>
                                </div>
                                <div class="bg-red-50 rounded-lg p-4 text-center">
                                    <p class="text-xs text-gray-600 mb-1">Mínimo</p>
                                    <p class="text-2xl font-bold text-red-600">{{ number_format($minimo, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @endif
                @endif

                <!-- Footer del Reporte -->
                <footer class="mt-8 bg-white rounded-xl shadow-lg p-6 text-center text-gray-500 text-sm">
                    <p class="font-semibold text-gray-700">E360 Pro - Sistema de Evaluación 360°</p>
                    <p class="mt-2">© {{ date('Y') }} - Todos los derechos reservados</p>
                    <p class="mt-1 text-xs">Este reporte es confidencial y está destinado únicamente para uso interno</p>
                </footer>
            </div>
        </div>
    </div>