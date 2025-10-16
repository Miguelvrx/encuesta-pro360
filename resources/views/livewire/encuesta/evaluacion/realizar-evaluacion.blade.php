{{-- resources/views/livewire/encuesta/evaluacion/realizar-evaluacion.blade.php --}}
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">

        <!-- Header de la Evaluación -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div class="flex-1">
                    <h1 class="text-2xl font-bold text-gray-900">{{ $evaluacion->tipo_evaluacion }}</h1>
                    <p class="text-gray-600 mt-1">{{ $evaluacion->descripcion_evaluacion }}</p>
                    
                    <div class="flex items-center gap-4 mt-3 text-sm text-gray-500">
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>Evaluando a: <strong>{{ $evaluado->name ?? 'N/A' }}</strong></span>
                        </div>
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>Vence: {{ $evaluacion->fecha_cierre->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Progreso -->
                <div class="bg-blue-50 rounded-lg p-4 min-w-48">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-blue-900">Progreso</span>
                        <span class="text-sm font-bold text-blue-700">{{ $progreso }}%</span>
                    </div>
                    <div class="w-full bg-blue-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" 
                             style="width: {{ $progreso }}%"></div>
                    </div>
                    <p class="text-xs text-blue-600 mt-1 text-center">
                        {{ count($respuestas) }} de {{ $competencias->sum(function($c) { return $c->preguntas->count(); }) }} preguntas
                    </p>
                </div>
            </div>
        </div>

        <!-- Navegación de Competencias -->
        @if($competencias->count() > 1)
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Competencias a Evaluar</h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-{{ min($competencias->count(), 5) }} gap-2">
                @foreach($competencias as $index => $competencia)
                <button
                    wire:click="irAPaso({{ $index + 1 }})"
                    class="p-3 rounded-lg text-center transition-all duration-200 {{ $pasoActual == $index + 1 ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}"
                    title="{{ $competencia->nombre_competencia }}">
                    <div class="font-semibold text-sm">{{ $index + 1 }}</div>
                    <div class="text-xs mt-1 truncate">{{ \Illuminate\Support\Str::limit($competencia->nombre_competencia, 15) }}</div>
                </button>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Formulario de Evaluación -->
        @if($competenciaActual)
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Header de Competencia -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                            <span class="text-white font-bold text-lg">{{ $pasoActual }}</span>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-white">{{ $competenciaActual->nombre_competencia }}</h2>
                            <p class="text-indigo-100 text-sm">{{ $competenciaActual->definicion_competencia }}</p>
                        </div>
                    </div>
                    <div class="text-white text-sm">
                        Paso {{ $pasoActual }} de {{ $totalPasos }}
                    </div>
                </div>
            </div>

            <!-- Preguntas -->
            <div class="p-6 space-y-8">
                @foreach($competenciaActual->preguntas as $pregunta)
                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-blue-600 font-semibold text-sm">{{ $loop->iteration }}</span>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $pregunta->pregunta }}</h3>
                            @if($pregunta->descripcion_pregunta)
                            <p class="text-gray-600 text-sm">{{ $pregunta->descripcion_pregunta }}</p>
                            @endif
                        </div>
                    </div>

                    <!-- Escala de Respuesta -->
                    <div class="ml-12">
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
                            @foreach($competenciaActual->niveles->sortBy('orden') as $nivel)
                            <label class="relative">
                                <input 
                                    type="radio" 
                                    name="pregunta_{{ $pregunta->id_pregunta }}" 
                                    wire:click="guardarRespuesta({{ $pregunta->id_pregunta }}, {{ $nivel->orden }})"
                                    @checked(isset($respuestas[$pregunta->id_pregunta]) && $respuestas[$pregunta->id_pregunta] == $nivel->orden)
                                    class="sr-only peer">
                                <div class="p-4 border-2 border-gray-200 rounded-lg text-center cursor-pointer transition-all duration-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:shadow-md hover:border-gray-300">
                                    <div class="text-2xl font-bold text-gray-700 mb-1">{{ $nivel->orden }}</div>
                                    <div class="text-xs font-semibold text-gray-600">{{ $nivel->nombre_nivel }}</div>
                                    <div class="text-xs text-gray-500 mt-1 leading-tight">{{ \Illuminate\Support\Str::limit($nivel->descripcion_nivel, 40) }}</div>
                                </div>
                                <div class="absolute top-2 right-2 w-4 h-4 border-2 border-white rounded-full bg-gray-300 peer-checked:bg-blue-500 transition-colors"></div>
                            </label>
                            @endforeach
                        </div>

                        <!-- Leyenda de la Escala -->
                        <div class="flex justify-between items-center mt-4 pt-4 border-t border-gray-200">
                            <span class="text-xs text-gray-500">1 - Requiere Apoyo</span>
                            <span class="text-xs text-gray-500">5 - Excepcional</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Navegación -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                <div class="flex justify-between items-center">
                    <button
                        wire:click="anteriorPaso"
                        class="px-6 py-2 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 transition-colors flex items-center gap-2 {{ $pasoActual == 1 ? 'opacity-50 cursor-not-allowed' : '' }}"
                        {{ $pasoActual == 1 ? 'disabled' : '' }}>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Anterior
                    </button>

                    @if($pasoActual == $totalPasos)
                    <button
                        wire:click="enviarEvaluacion"
                        class="px-8 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Enviar Evaluación
                    </button>
                    @else
                    <button
                        wire:click="siguientePaso"
                        class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
                        Siguiente
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                    @endif
                </div>
            </div>
        </div>
        @else
        <div class="bg-white rounded-xl shadow-lg p-8 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No hay competencias para evaluar</h3>
            <p class="mt-1 text-sm text-gray-500">Esta evaluación no tiene competencias configuradas.</p>
        </div>
        @endif

        <!-- Información Adicional -->
        <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
            <div class="flex">
                <svg class="h-5 w-5 text-blue-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                </svg>
                <p class="ml-3 text-sm text-blue-700">
                    <strong>Instrucciones:</strong> Selecciona el nivel que mejor represente el desempeño observado. 
                    Tu evaluación será confidencial y solo se mostrarán resultados agregados.
                </p>
            </div>
        </div>
    </div>
</div>