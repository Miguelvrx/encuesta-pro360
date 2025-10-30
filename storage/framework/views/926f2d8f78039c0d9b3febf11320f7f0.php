
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        <!-- Cabecera -->
        <header class="mb-8">
            <div class="flex justify-between items-center bg-white p-6 rounded-xl shadow-md">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Evaluaciones 360°</h1>
                    <p class="mt-1 text-sm text-gray-500">Gestiona y monitorea las evaluaciones del sistema.</p>
                </div>
                <a href="<?php echo e(route('crear-evaluacion')); ?>" wire:navigate class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold text-sm rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Nueva Evaluación
                </a>
            </div>
        </header>

        <!-- Barra de Filtros -->
        <div class="mb-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="col-span-1 sm:col-span-2">
                <input type="search" wire:model.live.debounce.300ms="busqueda" placeholder="Buscar por tipo o descripción..." class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div>
                <select wire:model.live="filtroEstado" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Todos los Estados</option>
                    <option value="borrador">Borrador</option>
                    <option value="completada">Completada</option>
                    <option value="en_progreso">En Progreso</option>
                </select>
            </div>
            <div class="flex items-center justify-end">
                <span class="text-sm text-gray-500"><?php echo e($evaluaciones->total()); ?> evaluaciones</span>
            </div>
        </div>

        <!-- Tarjetas de Estadísticas -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total</p>
                        <p class="text-2xl font-bold text-gray-900"><?php echo e($estadisticas['total']); ?></p>
                    </div>
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Completadas</p>
                        <p class="text-2xl font-bold text-gray-900"><?php echo e($estadisticas['completadas']); ?></p>
                    </div>
                    <div class="p-3 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-yellow-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">En Progreso</p>
                        <p class="text-2xl font-bold text-gray-900"><?php echo e($estadisticas['en_progreso']); ?></p>
                    </div>
                    <div class="p-3 bg-yellow-100 rounded-lg">
                        <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-gray-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Borradores</p>
                        <p class="text-2xl font-bold text-gray-900"><?php echo e($estadisticas['borradores']); ?></p>
                    </div>
                    <div class="p-3 bg-gray-100 rounded-lg">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista de Evaluaciones -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" wire:click="ordenar('tipo_evaluacion')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                Evaluación <!--[if BLOCK]><![endif]--><?php if($ordenarPor === 'tipo_evaluacion'): ?><span><?php echo e($direccionOrden === 'asc' ? '▲' : '▼'); ?></span><?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Período
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Evaluadores
                            </th>
                            <th scope="col" wire:click="ordenar('estado')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                Estado <!--[if BLOCK]><![endif]--><?php if($ordenarPor === 'estado'): ?><span><?php echo e($direccionOrden === 'asc' ? '▲' : '▼'); ?></span><?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </th>
                            <th scope="col" wire:click="ordenar('created_at')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                Creado <!--[if BLOCK]><![endif]--><?php if($ordenarPor === 'created_at'): ?><span><?php echo e($direccionOrden === 'asc' ? '▲' : '▼'); ?></span><?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Acciones</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $evaluaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $evaluacion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr wire:key="<?php echo e($evaluacion->id_evaluacion); ?>" class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <div class="text-sm font-semibold text-gray-900"><?php echo e($evaluacion->tipo_evaluacion); ?></div>
                                    <div class="text-sm text-gray-500"><?php echo e(Str::limit($evaluacion->descripcion_evaluacion, 50)); ?></div>
                                    <div class="text-xs text-gray-400 mt-1">ID: <?php echo e($evaluacion->uuid_encuesta); ?></div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="flex flex-col">
                                    <span class="font-medium"><?php echo e($evaluacion->fecha_inicio->format('d M Y')); ?></span>
                                    <span class="text-gray-400">al</span>
                                    <span class="font-medium"><?php echo e($evaluacion->fecha_cierre->format('d M Y')); ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex -space-x-2">
                                        <?php
                                        $totalEvaluadores = $evaluacion->usuarios->count();
                                        $mostrados = min($totalEvaluadores, 3);
                                        ?>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $evaluacion->usuarios->take($mostrados); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="w-8 h-8 bg-gradient-to-br from-purple-400 to-pink-400 rounded-full border-2 border-white flex items-center justify-center text-white text-xs font-bold">
                                            <?php echo e(substr($usuario->name, 0, 1)); ?><?php echo e(substr($usuario->primer_apellido, 0, 1)); ?>

                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                    <!--[if BLOCK]><![endif]--><?php if($totalEvaluadores > 3): ?>
                                    <span class="ml-2 text-xs text-gray-500">+<?php echo e($totalEvaluadores - 3); ?> más</span>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php
                                $estados = [
                                'borrador' => ['color' => 'gray', 'text' => 'Borrador'],
                                'completada' => ['color' => 'green', 'text' => 'Completada'],
                                'en_progreso' => ['color' => 'yellow', 'text' => 'En Progreso']
                                ];
                                $estado = $estados[$evaluacion->estado] ?? $estados['borrador'];
                                ?>
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    bg-<?php echo e($estado['color']); ?>-100 text-<?php echo e($estado['color']); ?>-800">
                                    <?php echo e($estado['text']); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e($evaluacion->created_at->format('d M Y')); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="<?php echo e(route('ver-evaluacion', $evaluacion->id_evaluacion)); ?>" wire:navigate
                                        class="text-blue-600 hover:text-blue-900 px-3 py-1 rounded-lg hover:bg-blue-50 transition-colors">
                                        Ver
                                    </a>
                                    <!--[if BLOCK]><![endif]--><?php if($evaluacion->estado === 'borrador'): ?>
                                    <a href="<?php echo e(route('editar-evaluacion', $evaluacion->id_evaluacion)); ?>" wire:navigate
                                        class="text-indigo-600 hover:text-indigo-900 px-3 py-1 rounded-lg hover:bg-indigo-50 transition-colors">
                                        Editar
                                    </a>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <button class="text-red-600 hover:text-red-900 px-3 py-1 rounded-lg hover:bg-red-50 transition-colors">
                                        Eliminar
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No se encontraron evaluaciones</h3>
                                    <p class="mt-1 text-sm text-gray-500">Comienza creando tu primera evaluación.</p>
                                    <div class="mt-6">
                                        <a href="<?php echo e(route('crear-evaluacion')); ?>" wire:navigate class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Nueva Evaluación
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                <?php echo e($evaluaciones->links()); ?>

            </div>
        </div>
    </div>
</div><?php /**PATH D:\laragon\www\encuesta-pro360\resources\views/livewire/encuesta/evaluacion/mostrar-evaluacion.blade.php ENDPATH**/ ?>