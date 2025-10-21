<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        <!-- Cabecera del Reporte -->
        <header class="mb-8">
            <div class="flex flex-col md:flex-row justify-between items-center bg-white p-6 rounded-xl shadow-md">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Reporte de Evaluación</h1>
                    <p class="mt-1 text-sm text-gray-500">Análisis detallado de los resultados de las evaluaciones 360°.</p>
                </div>
            </div>
        </header>

        <!-- Controles de Filtro -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <!-- Filtro por Evaluación -->
                <div>
                    <label for="select-evaluacion" class="block text-sm font-medium text-gray-700">Seleccionar Evaluación</label>
                    <select wire:model.live="evaluacionIdSeleccionada" id="select-evaluacion" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="">-- Selecciona una Evaluación --</option>
                        @foreach($evaluaciones as $eval)
                        <option value="{{ $eval->id_evaluacion }}">{{ $eval->tipo_evaluacion }} ({{ $eval->fecha_inicio->format('d/m/Y') }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filtro por Empresa -->
                <div>
                    <label for="select-empresa" class="block text-sm font-medium text-gray-700">Filtrar por Empresa</label>
                    <select wire:model.live="empresaSeleccionada" id="select-empresa" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="">-- Todas las Empresas --</option>
                        @foreach($empresas as $empresa)
                        <option value="{{ $empresa->id_empresa }}">{{ $empresa->nombre_comercial }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filtro por Departamento -->
                <div>
                    <label for="select-departamento" class="block text-sm font-medium text-gray-700">Filtrar por Departamento</label>
                    <select wire:model.live="departamentoSeleccionado" id="select-departamento" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" @if(!$departamentos->count()) disabled @endif>
                        <option value="">-- Todos los Departamentos --</option>
                        @foreach($departamentos as $departamento)
                        <option value="{{ $departamento->id_departamento }}">{{ $departamento->nombre_departamento }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filtro por Usuario Evaluado -->
                <div>
                    <label for="select-evaluado" class="block text-sm font-medium text-gray-700">Seleccionar Evaluado</label>
                    <select wire:model.live="usuarioEvaluadoSeleccionado" id="select-evaluado" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" @if(!$usuariosEvaluados->count()) disabled @endif>
                        <option value="">-- Todos los Evaluados --</option>
                        @foreach($usuariosEvaluados as $usuario)
                        <option value="{{ $usuario->id }}">{{ $usuario->name }} {{ $usuario->primer_apellido }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Selección de Tipo de Reporte -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Reporte:</label>
                <div class="flex space-x-4">
                    <button wire:click="$set('tipoReporte', 'general')" class="px-4 py-2 rounded-md text-sm font-medium {{ $tipoReporte === 'general' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                        General
                    </button>
                    <button wire:click="$set('tipoReporte', 'por_competencia')" class="px-4 py-2 rounded-md text-sm font-medium {{ $tipoReporte === 'por_competencia' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                        Por Competencia
                    </button>
                    <button wire:click="$set('tipoReporte', 'por_evaluado')" class="px-4 py-2 rounded-md text-sm font-medium {{ $tipoReporte === 'por_evaluado' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                        Por Evaluado
                    </button>
                </div>
            </div>
        </div>

        <!-- Contenido del Reporte -->
        @if(empty($resultados))
        <div class="bg-white rounded-xl shadow-lg p-6 text-center text-gray-500">
            <p>Selecciona una evaluación para ver los resultados.</p>
        </div>
        @else
        <!-- Vista de Tabla -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Evaluado</th>
                            @if($tipoReporte === 'general' || $tipoReporte === 'por_evaluado')
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Promedio General</th>
                            @endif
                            @if($tipoReporte === 'por_competencia' || $tipoReporte === 'por_evaluado')
                            @foreach(head($resultados)['competencias'] ?? [] as $competencia)
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $competencia['nombre'] }}</th>
                            @endforeach
                            @endif
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($resultados as $evaluado)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $evaluado['nombre'] }}</td>
                            @if($tipoReporte === 'general' || $tipoReporte === 'por_evaluado')
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $evaluado['promedio_general'] }}</td>
                            @endif
                            @if($tipoReporte === 'por_competencia' || $tipoReporte === 'por_evaluado')
                            @foreach($evaluado['competencias'] as $competencia)
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $competencia['promedio'] }}</td>
                            @endforeach
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if($usuarioEvaluadoSeleccionado && $tipoReporte === 'por_evaluado')
        <div class="bg-white rounded-xl shadow-lg overflow-hidden mt-8 p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Detalle por Rol para {{ $resultados[$usuarioEvaluadoSeleccionado]['nombre'] }}</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Competencia</th>
                            @php
                            $rolesUnicos = [];
                            foreach ($resultados[$usuarioEvaluadoSeleccionado]['competencias'] as $comp) {
                            foreach ($comp['promedios_por_rol'] as $rol => $prom) {
                            if (!in_array($rol, $rolesUnicos)) $rolesUnicos[] = $rol;
                            }
                            }
                            @endphp
                            @foreach($rolesUnicos as $rol)
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $rol }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($resultados[$usuarioEvaluadoSeleccionado]['competencias'] as $competencia)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $competencia['nombre'] }}</td>
                            @foreach($rolesUnicos as $rol)
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $competencia['promedios_por_rol'][$rol] ?? 'N/A' }}</td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
        @endif
    </div>
</div>