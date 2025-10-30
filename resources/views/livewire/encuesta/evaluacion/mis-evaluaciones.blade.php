{{-- resources/views/livewire/encuesta/evaluacion/mis-evaluaciones.blade.php --}}
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto">
        {{-- Header mejorado --}}
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8 border-l-4 border-indigo-500">
            <div class="flex flex-col md:flex-row md:items-center justify-between">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Evaluaciones Pendientes</h1>
                    <p class="text-gray-600">Revisa y completa las evaluaciones asignadas dentro de los plazos establecidos.</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        {{ $evaluacionesPendientes->count() }} pendientes
                    </span>
                </div>
            </div>
        </div>

        @if($evaluacionesPendientes->count() > 0)
            {{-- Grid de evaluaciones mejorado --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach($evaluacionesPendientes as $evaluacion)
                    @php
                        $diasRestantes = now()->diffInDays($evaluacion->fecha_cierre, false);
                        $estadoColor = $diasRestantes <= 3 ? 'border-red-500' : 
                                      ($diasRestantes <= 7 ? 'border-orange-500' : 'border-blue-500');
                        $badgeColor = $diasRestantes <= 3 ? 'bg-red-100 text-red-800' : 
                                     ($diasRestantes <= 7 ? 'bg-orange-100 text-orange-800' : 'bg-yellow-100 text-yellow-800');
                        $badgeText = $diasRestantes <= 3 ? 'Urgente' : 
                                    ($diasRestantes <= 7 ? 'Próximo a vencer' : 'Pendiente');
                    @endphp

                    <div class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 p-6 border-l-4 {{ $estadoColor }}">
                        {{-- Header de la evaluación --}}
                        <div class="flex items-start justify-between mb-3">
                            <h3 class="text-lg font-semibold text-gray-900 leading-tight">
                                {{ $evaluacion->tipo_evaluacion }}
                            </h3>
                            <span class="px-3 py-1 {{ $badgeColor }} text-xs font-semibold rounded-full whitespace-nowrap ml-2">
                                {{ $badgeText }}
                            </span>
                        </div>

                        {{-- Descripción --}}
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                            {{ $evaluacion->descripcion_evaluacion }}
                        </p>
                        
                        {{-- Información de fecha --}}
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="font-medium">Vence:</span> 
                                    <span class="ml-1 {{ $diasRestantes <= 3 ? 'text-red-600 font-semibold' : '' }}">
                                        {{ $evaluacion->fecha_cierre->format('d M Y') }}
                                    </span>
                                </div>
                                
                                @if($diasRestantes > 0)
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span>{{ $diasRestantes }} días restantes</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Botón de acción --}}
                        <a href="{{ route('realizar-evaluacion', ['uuid' => $evaluacion->uuid_encuesta]) }}" 
                           class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 px-4 rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 text-center block font-semibold shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                            <div class="flex items-center justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Iniciar Evaluación
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Estado vacío mejorado --}}
            <div class="bg-white rounded-xl shadow-lg p-8 text-center max-w-md mx-auto">
                <div class="mx-auto h-16 w-16 rounded-full bg-green-100 flex items-center justify-center mb-4">
                    <svg class="h-8 w-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">¡Todo al día!</h3>
                <p class="text-gray-500 mb-4">No tienes evaluaciones pendientes en este momento.</p>
                <p class="text-sm text-gray-400">Cuando te asignen una nueva evaluación, aparecerá aquí.</p>
            </div>
        @endif
    </div>
</div>