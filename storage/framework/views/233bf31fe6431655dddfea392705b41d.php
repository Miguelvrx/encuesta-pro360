

<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        
        <!--[if BLOCK]><![endif]--><?php if(session()->has('message')): ?>
        <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-lg shadow-sm">
            <div class="flex">
                <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <p class="ml-3 text-sm text-green-700 font-medium"><?php echo e(session('message')); ?></p>
            </div>
        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <?php if(session()->has('error')): ?>
        <div class="mb-6 bg-red-50 border-l-4 border-red-400 p-4 rounded-lg shadow-sm">
            <div class="flex">
                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                <p class="ml-3 text-sm text-red-700 font-medium"><?php echo e(session('error')); ?></p>
            </div>
        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        
        <div class="bg-white rounded-xl shadow-lg p-4 mb-8">
            <nav aria-label="Progress">
                <ol class="flex items-center justify-between">
                    <?php
                    $pasos = [
                    1 => 'INFO. BÁSICA',
                    2 => 'CONFIG.',
                    3 => 'ENCUESTADO',
                    4 => 'CALIF.',
                    5 => 'ENVÍO'
                    ];
                    ?>

                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $pasos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $num => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="relative flex-1">
                        <!--[if BLOCK]><![endif]--><?php if($num > 1): ?>
                        <div class="absolute left-0 right-0 top-4 h-0.5 -translate-y-1/2 
                    <?php echo e($paso_actual >= $num ? 'bg-green-500' : 'bg-gray-300'); ?>">
                        </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        <div class="relative flex flex-col items-center">
                            <div class="flex items-center justify-center w-8 h-8 rounded-full border-2 transition-all duration-300 mb-2
                        <?php echo e($paso_actual > $num ? 'bg-green-500 border-green-500' : 
                           ($paso_actual == $num ? 'bg-blue-600 border-blue-600' : 'bg-gray-200 border-gray-300')); ?>">
                                <!--[if BLOCK]><![endif]--><?php if($paso_actual > $num): ?>
                                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                </svg>
                                <?php else: ?>
                                <span class="text-xs font-bold <?php echo e($paso_actual == $num ? 'text-white' : 'text-gray-600'); ?>">
                                    <?php echo e($num); ?>

                                </span>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>

                            <span class="text-xs font-medium text-center leading-tight
                        <?php echo e($paso_actual >= $num ? 'text-blue-600' : 'text-gray-500'); ?>">
                                <?php echo e($nombre); ?>

                            </span>
                        </div>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </ol>
            </nav>
        </div>

        
        <!--[if BLOCK]><![endif]--><?php if($paso_actual == 1): ?>
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-white mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h2 class="text-xl font-bold text-white">Información de la Evaluación</h2>
                </div>
            </div>

            <div class="p-6 space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tipo de Evaluación</label>
                    <select wire:model="tipo_evaluacion" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <option value="">Selecciona un tipo</option>
                        <option value="Prueba 360">Prueba 360</option>
                        <option value="Evaluación de Desempeño">Evaluación de Desempeño</option>
                        <option value="Evaluación de Competencias">Evaluación de Competencias</option>
                    </select>
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['tipo_evaluacion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Fecha de inicio</label>
                        <input wire:model="fecha_inicio" type="date" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['fecha_inicio'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Fecha de cierre</label>
                        <input wire:model="fecha_cierre" type="date" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['fecha_cierre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Descripción Opcional</label>
                    <textarea wire:model="descripcion_evaluacion" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all" placeholder="Evaluación 360° para medir competencias y desempeño del área comercial."></textarea>
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['descripcion_evaluacion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>
        </div>

        
        <?php elseif($paso_actual == 2): ?>
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-white mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <h2 class="text-xl font-bold text-white">Configuración de la evaluación 360</h2>
                </div>
            </div>

            <div class="p-6 space-y-6">
                <div class="flex justify-between items-center">
                    <h3 class="text-lg font-semibold text-gray-900">Selecciona las competencias</h3>
                    <div class="flex items-center gap-4">
                        <label class="text-sm font-medium text-gray-700">Categoría</label>
                        <select wire:model.live="categoriaSeleccionada" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                            <option value="">Todas las categorías</option>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($cat->id_categoria_competencia); ?>"><?php echo e($cat->categoria); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </select>

                        <label class="text-sm font-medium text-gray-700">Competencia</label>
                        <select class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent" disabled>
                            <option>Liderazgo</option>
                        </select>
                    </div>
                </div>

                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['competenciasSeleccionadas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-sm text-red-600 mb-4"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->

                <!--[if BLOCK]><![endif]--><?php if($competenciasPorCategoria->isEmpty()): ?>
                <div class="text-center py-12 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="mt-2 text-sm text-gray-500">Selecciona una categoría para ver las competencias disponibles</p>
                </div>
                <?php else: ?>
                <div class="space-y-4">
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $competenciasPorCategoria; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $competencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1">
                                <div class="flex items-center gap-3">
                                    <label class="flex items-center cursor-pointer">
                                        <input
                                            type="checkbox"
                                            wire:click="toggleCompetencia(<?php echo e($competencia->id_competencia); ?>)"
                                            <?php if(in_array($competencia->id_competencia, $competenciasSeleccionadas)): echo 'checked'; endif; ?>
                                        class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                    </label>
                                    <h4 class="text-base font-bold text-gray-900"><?php echo e($competencia->nombre_competencia); ?></h4>
                                </div>
                                <p class="mt-1 text-sm text-gray-600 ml-8"><?php echo e($competencia->definicion_competencia); ?></p>
                            </div>
                        </div>

                        <!--[if BLOCK]><![endif]--><?php if($competencia->niveles->isNotEmpty()): ?>
                        <div class="ml-8 mt-3 space-y-2">
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $competencia->niveles->sortByDesc(function($nivel) {
                            $orden = ['Excepcional' => 5, 'Supera las Expectativas' => 4, 'Competente' => 3, 'En Desarrollo' => 2, 'Requiere Apoyo' => 1];
                            return $orden[$nivel->nombre_nivel] ?? 0;
                            }); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nivel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center gap-3 text-xs">
                                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-gray-100 font-semibold text-gray-700">
                                    <?php echo e(['Excepcional' => 5, 'Supera las Expectativas' => 4, 'Competente' => 3, 'En Desarrollo' => 2, 'Requiere Apoyo' => 1][$nivel->nombre_nivel] ?? '?'); ?>

                                </span>
                                <span class="font-medium text-gray-700"><?php echo e($nivel->nombre_nivel); ?></span>
                                <span class="text-gray-500"><?php echo e($nivel->descripcion_nivel); ?></span>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <div class="mt-6 p-4 bg-blue-50 border-l-4 border-blue-500 rounded-lg">
                    <div class="flex">
                        <svg class="h-5 w-5 text-blue-500 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                        <p class="ml-3 text-sm text-blue-700">
                            <strong>Competencias seleccionadas:</strong> <?php echo e(count($competenciasSeleccionadas)); ?>

                        </p>
                    </div>
                </div>
            </div>
        </div>

        
        <?php elseif($paso_actual == 3): ?>
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-purple-600 to-pink-600 px-6 py-4">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-white mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <h2 class="text-xl font-bold text-white">Persona Evaluada</h2>
                </div>
            </div>

            <div class="p-6 space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Selecciona al Colaborador a Evaluar</label>
                    <p class="text-xs text-gray-500 mb-3">Filtra por empresa y departamento para encontrar al colaborador</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <!-- Select para Empresa -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Empresa</label>
                            <select wire:model.live="empresaSeleccionada" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="">Todas las Empresas</option>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $empresas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empresa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($empresa->id_empresa); ?>"><?php echo e($empresa->nombre_comercial); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </select>
                        </div>

                        <!-- Select para Departamento -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Departamento</label>
                            <select wire:model.live="departamentoSeleccionado" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                <option value="">Todos los Departamentos</option>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $departamentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $departamento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($departamento->id_departamento); ?>"><?php echo e($departamento->nombre_departamento); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </select>
                        </div>
                    </div>
                </div>

                
                <!--[if BLOCK]><![endif]--><?php if($usuarios->count() > 0): ?>
                <div>
                    <h3 class="text-sm font-semibold text-gray-700 mb-4">Colaboradores Disponibles</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow bg-white">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        <div class="w-12 h-12 bg-gradient-to-br from-purple-400 to-pink-400 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                            <?php echo e(substr($usuario->name, 0, 1)); ?><?php echo e(substr($usuario->primer_apellido, 0, 1)); ?>

                                        </div>
                                        <div>
                                            <h4 class="font-bold text-gray-900"><?php echo e($usuario->name); ?> <?php echo e($usuario->primer_apellido); ?> <?php echo e($usuario->segundo_apellido ?? ''); ?></h4>
                                            <p class="text-sm text-gray-600"><?php echo e($usuario->email); ?></p>
                                        </div>
                                    </div>
                                    <div class="space-y-1 text-xs">
                                        <p class="font-semibold text-gray-700">PUESTO: <?php echo e($usuario->puesto ?? 'N/A'); ?></p>
                                        <p class="text-gray-600">EMPRESA: <?php echo e($usuario->departamento->empresa->nombre_comercial ?? 'N/A'); ?></p>
                                        <p class="text-gray-600">DEPTO: <?php echo e($usuario->departamento->nombre_departamento ?? 'N/A'); ?></p>
                                    </div>
                                </div>
                            </div>

                            <!--[if BLOCK]><![endif]--><?php if(collect($encuestados)->contains('id', $usuario->id)): ?>
                            <button class="w-full py-2 bg-green-500 text-white font-semibold rounded-lg cursor-default">
                                ✅ Seleccionado
                            </button>
                            <?php else: ?>
                            <button
                                wire:click="seleccionarEncuestado(<?php echo e($usuario->id); ?>)"
                                class="w-full py-2 bg-purple-600 text-white font-semibold rounded-lg hover:bg-purple-700 transition-colors">
                                Seleccionar
                            </button>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
                <?php else: ?>
                <div class="text-center py-12 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <p class="mt-2 text-sm text-gray-500">No hay colaboradores disponibles con los filtros seleccionados</p>
                </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                
                <!--[if BLOCK]><![endif]--><?php if(count($encuestados) > 0): ?>
                <div class="mt-8">
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Colaborador Seleccionado</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $encuestados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $encuestado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="relative bg-gradient-to-br from-green-400 to-green-500 rounded-lg p-4 text-white shadow-lg">
                            <button
                                wire:click="eliminarEncuestado(<?php echo e($index); ?>)"
                                type="button"
                                class="absolute top-2 right-2 bg-white text-red-500 rounded-full p-1 hover:bg-red-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                            <div class="flex flex-col items-center text-center">
                                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mb-3">
                                    <svg class="w-10 h-10 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <h4 class="font-bold text-sm"><?php echo e($encuestado['nombre']); ?></h4>
                                <p class="text-xs opacity-90 mt-1"><?php echo e($encuestado['email']); ?></p>
                                <p class="text-xs font-semibold mt-2 bg-white/20 px-2 py-1 rounded">PUESTO: <?php echo e($encuestado['puesto'] ?? 'N/A'); ?></p>
                                <!--[if BLOCK]><![endif]--><?php if(isset($encuestado['empresa'])): ?>
                                <p class="text-xs font-semibold mt-1 bg-white/20 px-2 py-1 rounded">EMPRESA: <?php echo e($encuestado['empresa']); ?></p>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <!--[if BLOCK]><![endif]--><?php if(isset($encuestado['departamento'])): ?>
                                <p class="text-xs font-semibold mt-1 bg-white/20 px-2 py-1 rounded">DEPTO: <?php echo e($encuestado['departamento']); ?></p>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
                <?php else: ?>
                <div class="text-center py-8 bg-yellow-50 rounded-lg border-2 border-dashed border-yellow-300">
                    <svg class="mx-auto h-12 w-12 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <p class="mt-2 text-sm text-yellow-700">Selecciona un colaborador para continuar</p>
                </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>
        
        <?php elseif($paso_actual == 4): ?>
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-pink-600 to-red-600 px-6 py-4">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-white mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <h2 class="text-xl font-bold text-white">Calificadores</h2>
                </div>
            </div>

            <div class="p-6">
                <?php if(count($encuestados) === 0): ?>
                <div class="text-center py-12 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <p class="mt-2 text-sm text-gray-500">Primero debes agregar una persona evaluada en el paso anterior</p>
                </div>
                <?php else: ?>
                <div class="space-y-8">
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $encuestados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indexEnc => $encuestado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="border-2 border-gray-200 rounded-xl p-6 bg-white shadow-sm">
                        
                        <div class="flex items-center gap-4 mb-6 pb-4 border-b border-gray-200">
                            <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-gray-900"><?php echo e($encuestado['nombre']); ?></h3>
                                <p class="text-sm text-gray-600"><?php echo e($encuestado['puesto'] ?? 'Sin puesto'); ?></p>
                                <p class="text-xs text-gray-500"><?php echo e($encuestado['departamento'] ?? 'Sin departamento'); ?></p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-semibold text-gray-700">Evaluación 360°</p>
                                <p class="text-xs text-gray-500">Se autoevaluará y recibirá evaluaciones de otros</p>
                            </div>
                        </div>

                        
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold text-gray-800 mb-3">Autoevaluación (Automática)</h4>
                            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                            <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900"><?php echo e($encuestado['nombre']); ?></p>
                                            <p class="text-sm text-gray-600"><?php echo e($encuestado['email']); ?></p>
                                        </div>
                                    </div>
                                    <span class="px-3 py-1 bg-purple-100 text-purple-700 text-sm font-semibold rounded-full">
                                        Autoevaluación
                                    </span>
                                </div>
                                <p class="text-xs text-purple-600 mt-2 italic">
                                    ✅ La autoevaluación se incluye automáticamente en toda evaluación 360°
                                </p>
                            </div>
                        </div>

                        
                        <div class="bg-gray-50 rounded-lg p-4 mb-6">
                            <h4 class="text-lg font-semibold text-gray-800 mb-3">Agregar Otros Evaluadores</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                
                                <select wire:model="calificadorTempSeleccionado.<?php echo e($indexEnc); ?>" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                                    <option value="">Seleccionar evaluador...</option>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $evaluadoresDisponibles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <!--[if BLOCK]><![endif]--><?php if($usuario->id != $encuestado['id']): ?>
                                    <option value="<?php echo e($usuario->id); ?>">
                                        <?php echo e($usuario->name); ?> <?php echo e($usuario->primer_apellido); ?> - <?php echo e($usuario->puesto); ?>

                                        (<?php echo e($usuario->departamento->nombre_departamento ?? 'N/A'); ?>)
                                    </option>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </select>

                                
                                <select wire:model="tipoRolTempSeleccionado.<?php echo e($indexEnc); ?>" class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500">
                                    <option value="">Seleccionar relación...</option>
                                    <option value="Jefe">Jefe Directo</option>
                                    <option value="Par">Par / Colega</option>
                                    <option value="Colaborador">Colaborador</option>
                                    <option value="Cliente">Cliente</option>
                                </select>

                                
                                <button
                                    wire:click="agregarCalificador(<?php echo e($indexEnc); ?>)"
                                    type="button"
                                    class="px-4 py-2 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition-colors focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                    Agregar Evaluador
                                </button>
                            </div>
                        </div>

                        
                        <div>
                            <h4 class="text-lg font-semibold text-gray-800 mb-3">Evaluadores Asignados</h4>

                            <!--[if BLOCK]><![endif]--><?php if(isset($calificadores[$indexEnc]) && count($calificadores[$indexEnc]) > 0): ?>
                            <div class="space-y-3">
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $calificadores[$indexEnc]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indexCal => $calificador): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex items-center justify-between bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 rounded-full flex items-center justify-center 
                                    <?php echo e($calificador['tipo_rol'] == 'Jefe' ? 'bg-red-100' : ''); ?>

                                    <?php echo e($calificador['tipo_rol'] == 'Par' ? 'bg-blue-100' : ''); ?>

                                    <?php echo e($calificador['tipo_rol'] == 'Colaborador' ? 'bg-green-100' : ''); ?>

                                    <?php echo e($calificador['tipo_rol'] == 'Cliente' ? 'bg-yellow-100' : ''); ?>">
                                            <svg class="w-6 h-6 
                                        <?php echo e($calificador['tipo_rol'] == 'Jefe' ? 'text-red-600' : ''); ?>

                                        <?php echo e($calificador['tipo_rol'] == 'Par' ? 'text-blue-600' : ''); ?>

                                        <?php echo e($calificador['tipo_rol'] == 'Colaborador' ? 'text-green-600' : ''); ?>

                                        <?php echo e($calificador['tipo_rol'] == 'Cliente' ? 'text-yellow-600' : ''); ?>"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900"><?php echo e($calificador['nombre']); ?></p>
                                            <p class="text-sm text-gray-600"><?php echo e($calificador['email']); ?></p>
                                            <p class="text-xs text-gray-500">Se enviará invitación por correo</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                    <?php echo e($calificador['tipo_rol'] == 'Jefe' ? 'bg-red-100 text-red-700' : ''); ?>

                                    <?php echo e($calificador['tipo_rol'] == 'Par' ? 'bg-blue-100 text-blue-700' : ''); ?>

                                    <?php echo e($calificador['tipo_rol'] == 'Colaborador' ? 'bg-green-100 text-green-700' : ''); ?>

                                    <?php echo e($calificador['tipo_rol'] == 'Cliente' ? 'bg-yellow-100 text-yellow-700' : ''); ?>">
                                            <?php echo e($calificador['tipo_rol']); ?>

                                        </span>
                                        <button
                                            wire:click="eliminarCalificador(<?php echo e($indexEnc); ?>, <?php echo e($indexCal); ?>)"
                                            type="button"
                                            class="text-red-600 hover:text-red-800 transition-colors p-1">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <?php else: ?>
                            <div class="text-center py-8 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <p class="mt-2 text-sm text-gray-500">No hay otros evaluadores asignados</p>
                                <p class="text-xs text-gray-400 mt-1">Agrega jefes, pares, colaboradores o clientes</p>
                            </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>

        
        <?php elseif($paso_actual == 5): ?>
        <div class="space-y-6">
            
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-green-600 to-teal-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white">Resumen de la Evaluación</h2>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-3">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-gray-700 mb-2 flex items-center justify-between">
                                Información Básica
                                <button wire:click="irAPaso(1)" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Editar</button>
                            </h3>
                            <p class="text-sm"><strong>Nombre:</strong> <?php echo e($tipo_evaluacion); ?></p>
                            <p class="text-sm"><strong>Tipo:</strong> <?php echo e($tipo_evaluacion); ?></p>
                            <p class="text-sm"><strong>Periodo:</strong> <?php echo e(\Carbon\Carbon::parse($fecha_inicio)->format('d M Y')); ?> - <?php echo e(\Carbon\Carbon::parse($fecha_cierre)->format('d M Y')); ?></p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-gray-700 mb-2 flex items-center justify-between">
                                Configuración
                                <button wire:click="irAPaso(2)" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Editar</button>
                            </h3>
                            <p class="text-sm"><strong>Competencia:</strong> <?php echo e(count($competenciasSeleccionadas)); ?> seleccionadas</p>
                            <p class="text-sm"><strong>Preguntas:</strong> <?php echo e(collect($competenciasSeleccionadas)->sum(function($id) {
                                return \App\Models\Competencia::find($id)?->preguntas->count() ?? 0;
                            })); ?> Total</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-gray-700 mb-2 flex items-center justify-between">
                                Evaluado
                                <button wire:click="irAPaso(3)" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Editar</button>
                            </h3>
                            <p class="text-sm"><strong>Total:</strong> <?php echo e(count($encuestados)); ?> <?php echo e(count($encuestados) == 1 ? 'persona' : 'personas'); ?></p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="font-semibold text-gray-700 mb-2 flex items-center justify-between">
                                Evaluadores
                                <button wire:click="irAPaso(4)" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Editar</button>
                            </h3>
                            <p class="text-sm"><strong>Total:</strong> <?php echo e(collect($calificadores)->flatten(1)->count()); ?> Asignados</p>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                    <h2 class="text-xl font-bold text-white">Vista Previa del Envío de Email</h2>
                </div>
                <div class="p-6">
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6">
                        <p class="text-sm text-blue-800">
                            <strong>Asunto:</strong> Invitación - Evaluación 360° <?php echo e($tipo_evaluacion); ?>

                        </p>
                    </div>

                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                        <p class="text-sm text-gray-700 leading-relaxed">
                            Estimado evaluador, has sido seleccionado para participar en la evaluación 360 de
                            <!--[if BLOCK]><![endif]--><?php if(count($encuestados) > 0): ?>
                            <strong><?php echo e($encuestados[0]['nombre']); ?></strong>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </p>
                        <p class="text-sm text-gray-700 mt-4">
                            <strong>Período:</strong> <?php echo e(\Carbon\Carbon::parse($fecha_inicio)->format('d M Y')); ?> - <?php echo e(\Carbon\Carbon::parse($fecha_cierre)->format('d M Y')); ?>

                        </p>
                        <div class="mt-6">
                            <button class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg">
                                [Comenzar Evaluación]
                            </button>
                        </div>
                    </div>

                    <div class="mt-8">
                        <button
                            wire:click="enviarEvaluaciones"
                            type="button"
                            class="w-full px-8 py-4 bg-gradient-to-r from-green-600 to-teal-600 text-white text-lg font-bold rounded-lg hover:from-green-700 hover:to-teal-700 transform hover:scale-[1.02] transition-all shadow-lg flex items-center justify-center gap-3">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Enviar Encuesta
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        
        <div class="flex justify-between mt-8">
            <!--[if BLOCK]><![endif]--><?php if($paso_actual > 1 && $paso_actual < 5): ?>
                <button wire:click="anteriorPaso" type="button" class="px-8 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white font-bold rounded-lg hover:from-red-600 hover:to-red-700 transition-all shadow-md flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Anterior
                </button>
                <?php else: ?>
                <div></div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <!--[if BLOCK]><![endif]--><?php if($paso_actual < 5): ?>
                    <button wire:click="siguientePaso" type="button" class="px-8 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-bold rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all shadow-md flex items-center gap-2">
                    Siguiente
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                    </button>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>
</div><?php /**PATH D:\laragon\www\encuesta-pro360\resources\views/livewire/encuesta/evaluacion/crear-evaluacion.blade.php ENDPATH**/ ?>