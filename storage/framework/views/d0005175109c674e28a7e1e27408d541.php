<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-blue-50 to-purple-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto space-y-6">

        <!-- ENCABEZADO -->
        <div class="bg-white shadow rounded-xl p-6 flex flex-col sm:flex-row justify-between items-start sm:items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-chart-bar text-blue-500 mr-2"></i> Resultados de Evaluación
                </h2>
                <p class="text-gray-500 text-sm mt-1">Visualiza y analiza los resultados individuales de la evaluación 360°</p>
            </div>
            <a href="<?php echo e(route('reporte-evaluacion')); ?>"
                class="mt-3 sm:mt-0 inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-blue-700 transition">
                <i class="fas fa-arrow-left mr-2"></i> Volver al Reporte
            </a>
        </div>

        <!-- INFORMACIÓN DEL EVALUADO -->
        <div class="bg-white rounded-xl shadow p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Información del Colaborador</h3>
                    <ul class="text-gray-600 space-y-1 text-sm">
                        <li><strong>Nombre:</strong> <?php echo e($usuario->name); ?> <?php echo e($usuario->primer_apellido); ?></li>
                        <li><strong>Puesto:</strong> <?php echo e($usuario->puesto ?? 'N/A'); ?></li>
                        <li><strong>Empresa:</strong> <?php echo e($usuario->departamento->empresa->nombre_comercial ?? 'N/A'); ?></li>
                        <li><strong>Departamento:</strong> <?php echo e($usuario->departamento->nombre_departamento ?? 'N/A'); ?></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Información de la Evaluación</h3>
                    <ul class="text-gray-600 space-y-1 text-sm">
                        <li><strong>Evaluación:</strong> <?php echo e($evaluacion->descripcion_evaluacion); ?></li>
                        <li><strong>Fecha Inicio:</strong> <?php echo e($evaluacion->fecha_inicio->format('d/m/Y')); ?></li>
                        <li><strong>Fecha Cierre:</strong> <?php echo e($evaluacion->fecha_cierre->format('d/m/Y')); ?></li>
                        <li>
                            <strong>Estado:</strong>
                            <span
                                class="px-2 py-1 text-xs font-semibold rounded-full
                                    <?php echo e($evaluacion->estado === 'Activo' ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-700'); ?>">
                                <?php echo e($evaluacion->estado); ?>

                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- RESUMEN GENERAL -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div class="bg-blue-600 text-white rounded-xl shadow p-6 text-center">
                <h4 class="text-3xl font-bold"><?php echo e($puntuacion_general); ?></h4>
                <p class="text-sm mt-1">Puntuación General</p>
            </div>
            <div class="bg-indigo-500 text-white rounded-xl shadow p-6 text-center">
                <h4 class="text-2xl font-semibold"><?php echo e($nivel_general); ?></h4>
                <p class="text-sm mt-1">Nivel General</p>
            </div>
            <div class="bg-green-500 text-white rounded-xl shadow p-6 text-center">
                <h4 class="text-3xl font-bold"><?php echo e($total_competencias); ?></h4>
                <p class="text-sm mt-1">Competencias Evaluadas</p>
            </div>
        </div>

        <!-- FILTRO POR CALIFICADOR -->
        <!--[if BLOCK]><![endif]--><?php if(count($calificadores) > 0): ?>
            <div class="bg-white rounded-xl shadow p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-end">
                    <div>
                        <label for="filtroCalificador" class="block text-sm font-medium text-gray-700 mb-1">
                            <i class="fas fa-user-check text-indigo-500 mr-1"></i> Filtrar por Calificador:
                        </label>
                        <select wire:model.live="filtroCalificador" id="filtroCalificador"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                            <option value="">Todos los calificadores</option>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $calificadores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $calificador): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($calificador['id']); ?>">
                                    <?php echo e($calificador['nombre']); ?> (<?php echo e($calificador['tipo_rol']); ?>)
                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </select>
                    </div>
                    <div class="text-gray-500 text-sm">
                        <i class="fas fa-info-circle text-blue-500 mr-1"></i>
                        Mostrando resultados de
                        <!--[if BLOCK]><![endif]--><?php if($filtroCalificador): ?>
                            <span class="font-medium text-gray-800">
                                <?php echo e(collect($calificadores)->firstWhere('id', $filtroCalificador)['nombre'] ?? 'Calificador seleccionado'); ?>

                            </span>
                        <?php else: ?>
                            todos los calificadores (<?php echo e(count($calificadores)); ?>)
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <!-- RESULTADOS POR COMPETENCIA -->
        <!--[if BLOCK]><![endif]--><?php if(count($resultados) > 0): ?>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $resultados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $resultado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white rounded-xl shadow overflow-hidden">
                    <div class="bg-gradient-to-r from-gray-700 to-gray-800 text-white px-6 py-4 flex justify-between items-center">
                        <h3 class="text-base font-semibold">Competencia: <?php echo e($resultado['competencia']); ?></h3>
                        <div class="flex items-center space-x-2">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                bg-<?php echo e($this->getBadgeColor($resultado['puntuacion_promedio'])); ?>-100 text-<?php echo e($this->getBadgeColor($resultado['puntuacion_promedio'])); ?>-800">
                                Puntuación: <?php echo e(number_format($resultado['puntuacion_promedio'], 2)); ?>

                            </span>
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                bg-<?php echo e($this->getLevelBadgeColor($resultado['nivel'])); ?>-100 text-<?php echo e($this->getLevelBadgeColor($resultado['nivel'])); ?>-800">
                                <?php echo e($resultado['nivel']); ?>

                            </span>
                        </div>
                    </div>

                    <div class="p-6">
                        <p class="text-gray-600 text-sm mb-4"><?php echo e($resultado['descripcion']); ?></p>

                        <!--[if BLOCK]><![endif]--><?php if(count($resultado['preguntas']) > 0): ?>
                            <div class="overflow-x-auto">
                                <table class="min-w-full text-sm text-left text-gray-600 border-t border-gray-100">
                                    <thead class="bg-gray-50 text-gray-700 uppercase text-xs font-semibold">
                                        <tr>
                                            <th class="px-4 py-2 w-1/2">Pregunta</th>
                                            <th class="px-4 py-2 text-center">Puntuación</th>
                                            <th class="px-4 py-2 text-center">Respuestas</th>
                                            <th class="px-4 py-2 text-center">Nivel</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $resultado['preguntas']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pregunta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="hover:bg-gray-50">
                                                <td class="px-4 py-2"><?php echo e($pregunta['pregunta']); ?></td>
                                                <td class="px-4 py-2 text-center">
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                                        bg-<?php echo e($this->getBadgeColor($pregunta['puntuacion_promedio'])); ?>-100 text-<?php echo e($this->getBadgeColor($pregunta['puntuacion_promedio'])); ?>-800">
                                                        <?php echo e(number_format($pregunta['puntuacion_promedio'], 2)); ?>

                                                    </span>
                                                </td>
                                                <td class="px-4 py-2 text-center">
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-700">
                                                        <?php echo e($pregunta['total_respuestas']); ?>

                                                    </span>
                                                </td>
                                                <td class="px-4 py-2 text-center">
                                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                                        bg-<?php echo e($this->getLevelBadgeColor($this->obtenerNivel($pregunta['puntuacion_promedio']))); ?>-100
                                                        text-<?php echo e($this->getLevelBadgeColor($this->obtenerNivel($pregunta['puntuacion_promedio']))); ?>-800">
                                                        <?php echo e($this->obtenerNivel($pregunta['puntuacion_promedio'])); ?>

                                                    </span>
                                                </td>
                                            </tr>

                                            <!--[if BLOCK]><![endif]--><?php if(count($pregunta['detalles']) > 0): ?>
                                                <tr class="bg-gray-50">
                                                    <td colspan="4" class="px-4 py-2 text-xs text-gray-500">
                                                        <strong>Detalles:</strong>
                                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $pregunta['detalles']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detalle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php echo e($detalle['calificador']); ?>:
                                                            <span class="font-medium text-gray-700"><?php echo e($detalle['puntuacion']); ?></span>
                                                            (<?php echo e($detalle['fecha']); ?>)
                                                            <?php echo e(!$loop->last ? ' | ' : ''); ?>

                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                    </td>
                                                </tr>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 text-sm rounded-lg p-4">
                                No hay preguntas disponibles para esta competencia.
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        <?php else: ?>
            <!-- SIN RESULTADOS -->
            <div class="bg-white rounded-xl shadow p-10 text-center">
                <i class="fas fa-exclamation-triangle text-yellow-400 text-4xl mb-3"></i>
                <h4 class="text-lg font-semibold text-gray-700">No hay resultados disponibles</h4>
                <p class="text-gray-500 text-sm mt-1">No se encontraron respuestas para esta evaluación o los filtros aplicados.</p>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <!-- MENSAJES FLASH -->
        <!--[if BLOCK]><![endif]--><?php if(session()->has('error')): ?>
            <div class="bg-red-100 border border-red-300 text-red-700 rounded-lg p-4 flex items-center space-x-2">
                <i class="fas fa-exclamation-circle"></i>
                <span><?php echo e(session('error')); ?></span>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <?php if(session()->has('message')): ?>
            <div class="bg-green-100 border border-green-300 text-green-700 rounded-lg p-4 flex items-center space-x-2">
                <i class="fas fa-check-circle"></i>
                <span><?php echo e(session('message')); ?></span>
            </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>
</div>
<?php /**PATH D:\laragon\www\encuesta-pro360\resources\views/livewire/encuesta/resultado/ver-resultado.blade.php ENDPATH**/ ?>