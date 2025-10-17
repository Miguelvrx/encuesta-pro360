{{-- resources/views/livewire/encuesta/evaluacion/mis-evaluaciones.blade.php --}}
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Mis Evaluaciones Pendientes</h1>
            <p class="text-gray-600">Aquí puedes encontrar todas las evaluaciones que tienes pendientes por completar.</p>
        </div>

        @if($evaluacionesPendientes->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($evaluacionesPendientes as $evaluacion)
                    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $evaluacion->tipo_evaluacion }}</h3>
                        <p class="text-gray-600 text-sm mb-4">{{ $evaluacion->descripcion_evaluacion }}</p>
                        
                        <div class="flex items-center justify-between text-sm text-gray-500 mb-4">
                            <div>
                                <span class="font-medium">Vence:</span> 
                                {{ $evaluacion->fecha_cierre->format('d M Y') }}
                            </div>
                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded">
                                Pendiente
                            </span>
                        </div>

                        <a href="{{ route('realizar-evaluacion', ['uuid' => $evaluacion->uuid_encuesta]) }}" 
                           class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors text-center block font-semibold">
                            Comenzar Evaluación
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-xl shadow-lg p-8 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No tienes evaluaciones pendientes</h3>
                <p class="mt-1 text-sm text-gray-500">Cuando te asignen una evaluación, aparecerá aquí.</p>
            </div>
        @endif
    </div>
</div>