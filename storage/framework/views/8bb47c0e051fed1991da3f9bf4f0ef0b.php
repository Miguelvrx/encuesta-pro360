<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        <!-- Header -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-4">
                        <a href="<?php echo e(route('mostrar-evaluaciones')); ?>" wire:navigate 
                           class="p-2 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </a>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900"><?php echo e($evaluacion->tipo_evaluacion ?? 'Evaluación'); ?></h1>
                            <p class="text-gray-600 mt-1"><?php echo e($evaluacion->descripcion_evaluacion ?? 'Sin descripción'); ?></p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                        <div class="flex items-center gap-3 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <div>
                                <div class="font-semibold">Período</div>
                                <div>
                                    <?php echo e(\Carbon\Carbon::parse($evaluacion->fecha_inicio)->format('d M Y')); ?> - 
                                    <?php echo e(\Carbon\Carbon::parse($evaluacion->fecha_cierre)->format('d M Y')); ?>

                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <div>
                                <div class="font-semibold">Estado</div>
                                <div class="capitalize"><?php echo e($evaluacion->estado ?? 'Desconocido'); ?></div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <div>
                                <div class="font-semibold">Evaluadores</div>
                                <div><?php echo e($estadisticas['evaluadores_completados'] ?? 0); ?>/<?php echo e($estadisticas['total_evaluadores'] ?? 0); ?> completados</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ID de Evaluación -->
                <div class="bg-gray-50 rounded-lg p-4 min-w-64">
                    <div class="text-sm font-medium text-gray-600 mb-2">ID de Evaluación</div>
                    <div class="font-mono text-sm text-gray-900 bg-white p-2 rounded border"><?php echo e($evaluacion->uuid_encuesta ?? 'N/A'); ?></div>
                </div>
            </div>
        </div>

        <!-- Estadísticas Principales COMPLETAS -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Progreso General</p>
                        <p class="text-2xl font-bold text-gray-900"><?php echo e($estadisticas['progreso'] ?? 0); ?>%</p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Evaluadores</p>
                        <p class="text-2xl font-bold text-gray-900"><?php echo e($estadisticas['total_evaluadores'] ?? 0); ?></p>
                        <p class="text-xs text-green-600"><?php echo e($estadisticas['evaluadores_completados'] ?? 0); ?> completados</p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Respuestas</p>
                        <p class="text-2xl font-bold text-gray-900"><?php echo e($estadisticas['total_respuestas'] ?? 0); ?></p>
                    </div>
                    <div class="p-3 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-orange-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Competencias</p>
                        <p class="text-2xl font-bold text-gray-900">
                            <?php
                                $competenciaIds = $evaluacion->configuracion_data['competencias'] ?? [];
                                echo count($competenciaIds);
                            ?>
                        </p>
                    </div>
                    <div class="p-3 bg-orange-100 rounded-lg">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información adicional -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Información de la Evaluación</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Detalles</h3>
                    <dl class="space-y-2">
                        <div class="flex justify-between">
                            <dt class="text-gray-600">Fecha de creación:</dt>
                            <dd class="text-gray-900"><?php echo e(\Carbon\Carbon::parse($evaluacion->created_at)->format('d M Y H:i')); ?></dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-600">Última actualización:</dt>
                            <dd class="text-gray-900"><?php echo e(\Carbon\Carbon::parse($evaluacion->updated_at)->format('d M Y H:i')); ?></dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-600">Paso actual:</dt>
                            <dd class="text-gray-900"><?php echo e($evaluacion->paso_actual ?? 'N/A'); ?></dd>
                        </div>
                    </dl>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Resumen</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="text-gray-700">Evaluadores asignados</span>
                            <span class="font-semibold text-blue-600"><?php echo e($estadisticas['total_evaluadores'] ?? 0); ?></span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-green-50 rounded-lg">
                            <span class="text-gray-700">Completados</span>
                            <span class="font-semibold text-green-600"><?php echo e($estadisticas['evaluadores_completados'] ?? 0); ?></span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                            <span class="text-gray-700">Pendientes</span>
                            <span class="font-semibold text-yellow-600">
                                <?php echo e(($estadisticas['total_evaluadores'] ?? 0) - ($estadisticas['evaluadores_completados'] ?? 0)); ?>

                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botones de acción -->
        <div class="mt-8 flex justify-center gap-4">
            <button class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                Exportar Reporte
            </button>
            <button class="px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors">
                Enviar Recordatorios
            </button>
            <a href="<?php echo e(route('mostrar-evaluaciones')); ?>" wire:navigate
               class="px-6 py-3 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 transition-colors">
                Volver a Evaluaciones
            </a>
        </div>
    </div>
</div><?php /**PATH D:\laragon\www\encuesta-pro360\resources\views/livewire/encuesta/evaluacion/ver-evaluacion.blade.php ENDPATH**/ ?>