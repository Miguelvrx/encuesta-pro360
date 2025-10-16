{{-- resources/views/evaluacion-completada.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-green-50 via-blue-50 to-purple-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="bg-white rounded-2xl shadow-xl p-8 text-center">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            
            <h2 class="text-3xl font-bold text-gray-900 mb-4">¡Evaluación Completada!</h2>
            <p class="text-gray-600 mb-6">
                Gracias por tomar el tiempo para completar esta evaluación. 
                Tus respuestas han sido guardadas exitosamente.
            </p>
            
            <div class="space-y-4">
                <a href="{{ route('mostrar-evaluaciones') }}" wire:navigate
                   class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                    Volver al Dashboard
                </a>
                <button onclick="window.close()" 
                        class="w-full bg-gray-200 text-gray-700 py-3 px-4 rounded-lg hover:bg-gray-300 transition-colors font-semibold">
                    Cerrar Ventana
                </button>
            </div>
        </div>
    </div>
</div>
@endsections