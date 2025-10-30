<div class="min-h-screen bg-gradient-to-br from-green-50 via-blue-50 to-purple-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        
        <!-- Tarjeta Principal -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <!-- Header con Gradiente -->
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-8 py-12 text-center">
                <div class="max-w-md mx-auto">
                    <!-- Ícono de éxito -->
                    <div class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    
                    <h1 class="text-4xl font-bold text-white mb-4">¡Evaluación Completada!</h1>
                    <p class="text-green-100 text-lg">
                        Gracias por tu tiempo y valiosa contribución
                    </p>
                </div>
            </div>

            <!-- Contenido -->
            <div class="px-8 py-12">
                <div class="max-w-2xl mx-auto">
                    
                    <!-- Mensaje de agradecimiento -->
                    <div class="text-center mb-12">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-4">
                            Tu evaluación ha sido registrada exitosamente
                        </h2>
                        <p class="text-gray-600 text-lg leading-relaxed">
                            Tus respuestas han sido guardadas de forma segura y serán procesadas 
                            para generar reportes consolidados. Tu participación es fundamental 
                            para el crecimiento y desarrollo continuo.
                        </p>
                    </div>

                    <!-- Información adicional -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                        <div class="text-center p-6 bg-green-50 rounded-xl">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="font-semibold text-gray-800 mb-1">Tiempo Invertido</h3>
                            <p class="text-sm text-gray-600">Tu contribución es valiosa</p>
                        </div>

                        <div class="text-center p-6 bg-blue-50 rounded-xl">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <h3 class="font-semibold text-gray-800 mb-1">Confidencialidad</h3>
                            <p class="text-sm text-gray-600">Tus respuestas son anónimas</p>
                        </div>

                        <div class="text-center p-6 bg-purple-50 rounded-xl">
                            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <h3 class="font-semibold text-gray-800 mb-1">Impacto</h3>
                            <p class="text-sm text-gray-600">Contribuyes al desarrollo</p>
                        </div>
                    </div>

                    <!-- Próximos pasos -->
                    <div class="bg-gray-50 rounded-xl p-6 mb-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">¿Qué sigue?</h3>
                        <ul class="space-y-3 text-gray-600">
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Los resultados se consolidarán con todas las evaluaciones
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Recibirás un reporte general cuando esté disponible
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Puedes continuar con otras evaluaciones pendientes
                            </li>
                        </ul>
                    </div>

                    <!-- Botones de acción -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <button 
                            wire:click="irADashboard"
                            class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5"
                        >
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            Ir al Dashboard
                        </button>

                        <button 
                            wire:click="irAMisEvaluaciones"
                            class="inline-flex items-center justify-center px-6 py-3 border-2 border-gray-300 text-gray-700 font-semibold rounded-lg hover:border-gray-400 hover:bg-gray-50 transition-all duration-200"
                        >
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Ver Mis Evaluaciones
                        </button>
                    </div>

                    <!-- Mensaje final -->
                    <div class="text-center mt-8 pt-6 border-t border-gray-200">
                        <p class="text-sm text-gray-500">
                            ¿Necesitas ayuda? <a href="#" class="text-blue-600 hover:text-blue-700 font-medium">Contacta al administrador</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Elementos decorativos -->
        <div class="absolute top-0 left-0 w-32 h-32 bg-green-200 rounded-full -translate-x-16 -translate-y-16 opacity-20"></div>
        <div class="absolute bottom-0 right-0 w-48 h-48 bg-blue-200 rounded-full translate-x-24 translate-y-24 opacity-20"></div>
        <div class="absolute top-1/2 left-1/4 w-24 h-24 bg-purple-200 rounded-full opacity-20"></div>
    </div>
</div><?php /**PATH D:\laragon\www\encuesta-pro360\resources\views/livewire/encuesta/evaluacion/evaluacion-completada.blade.php ENDPATH**/ ?>