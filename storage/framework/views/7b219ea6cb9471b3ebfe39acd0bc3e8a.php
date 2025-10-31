<div>
    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">

            <!-- Header -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="bg-indigo-600 text-white rounded-full w-12 h-12 flex items-center justify-center font-bold text-xl">
                        📝
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Crear Compromiso de Mejora</h1>
                        <p class="text-sm text-gray-600">Plan de acción basado en resultados de evaluación 360°</p>
                    </div>
                </div>

                <!-- Información del contexto -->
                <!--[if BLOCK]><![endif]--><?php if($competencia && $puntuacionActual): ?>
                <div class="bg-indigo-50 rounded-lg p-4 mb-6">
                    <h3 class="font-semibold text-indigo-800 mb-2">Contexto de la Evaluación</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                        <div>
                            <p class="text-gray-600">Competencia</p>
                            <p class="font-semibold"><?php echo e($competencia); ?></p>
                        </div>
                        <div>
                            <p class="text-gray-600">Puntuación Actual</p>
                            <p class="font-semibold"><?php echo e($puntuacionActual); ?></p>
                        </div>
                        <div>
                            <p class="text-gray-600">Nivel Actual</p>
                            <!-- CORRECCIÓN: Mostrar correctamente el nivel actual -->
                            <p class="font-semibold"><?php echo e($nivelActual ? ($nivelesEvaluacion[$nivelActual] ?? 'N/A') : 'N/A'); ?></p>
                            <!--[if BLOCK]><![endif]--><?php if($nivelActual): ?>
                            <p class="text-xs text-gray-500">(Nivel <?php echo e($nivelActual); ?>)</p>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div>
                            <p class="text-gray-600">Evaluación</p>
                            <p class="font-semibold"><?php echo e($evaluaciones->firstWhere('id_evaluacion', $evaluacionId)->tipo_evaluacion ?? 'N/A'); ?></p>
                        </div>
                    </div>
                </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <!-- Formulario -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <form wire:submit="crearCompromiso">

                        <!-- Información Básica -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Evaluación Relacionada
                                </label>
                                <select wire:model="evaluacionId"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Seleccionar evaluación</option>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $evaluaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $eval): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($eval->id_evaluacion); ?>">
                                        <?php echo e($eval->tipo_evaluacion); ?> (<?php echo e($eval->fecha_inicio->format('d/m/Y')); ?>)
                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </select>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['evaluacionId'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Evaluado
                                </label>
                                <select wire:model="usuarioId"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Seleccionar evaluado</option>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($usuario->id); ?>">
                                        <?php echo e($usuario->name); ?> <?php echo e($usuario->primer_apellido); ?>

                                    </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </select>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['usuarioId'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>

                        <!-- Detalles del Compromiso -->
                        <div class="space-y-6">

                            <!-- Título y Tipo -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Título del Compromiso *
                                    </label>
                                    <input type="text" wire:model="titulo"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="Ej: Mejora en Comunicación Efectiva">
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['titulo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Tipo de Compromiso *
                                    </label>
                                    <select wire:model="tipoCompromiso"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="mejora">Mejora</option>
                                        <option value="mantenimiento">Mantenimiento</option>
                                        <option value="desarrollo">Desarrollo</option>
                                    </select>
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['tipoCompromiso'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                            

                            <!-- Descripción -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Descripción del Compromiso *
                                </label>
                                <textarea wire:model="descripcion" rows="3"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="Describe el propósito y objetivos del compromiso..."></textarea>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>

                            <!-- Niveles y Fechas -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Nivel Actual
                                    </label>
                                    <!-- CORRECCIÓN: Usar $nivelActual para obtener el nombre del nivel -->
                                    <input type="text"
                                        value="<?php echo e($nivelActual ? ($nivelesEvaluacion[$nivelActual] ?? 'N/A') : 'N/A'); ?>"
                                        class="w-full border-gray-300 rounded-lg shadow-sm bg-gray-50" readonly>
                                    <!--[if BLOCK]><![endif]--><?php if($nivelActual): ?>
                                    <p class="text-xs text-gray-500 mt-1">Nivel <?php echo e($nivelActual); ?></p>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Nivel Objetivo *
                                    </label>
                                    <select wire:model="nivelObjetivo"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Seleccionar nivel</option>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $nivelesEvaluacion; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nivel => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($nivel); ?>">
                                            <?php echo e($nivel); ?> - <?php echo e($nombre); ?>

                                            <!--[if BLOCK]><![endif]--><?php if($nivelActual && $nivel == $nivelActual): ?>
                                            (Actual)
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </select>
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['nivelObjetivo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Fecha Vencimiento *
                                    </label>
                                    <input type="date" wire:model="fechaVencimiento"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        min="<?php echo e(now()->addDay()->format('Y-m-d')); ?>">
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['fechaVencimiento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                            <!-- Acciones Específicas -->
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <label class="block text-sm font-medium text-gray-700">
                                        Acciones Específicas *
                                    </label>
                                    <!--[if BLOCK]><![endif]--><?php if($competencia): ?>
                                    <button type="button" wire:click="sugerirAcciones"
                                        class="text-sm text-indigo-600 hover:text-indigo-800">
                                        🚀 Sugerir Acciones
                                    </button>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                                <textarea wire:model="accionesEspecificas" rows="4"
                                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    placeholder="Lista las acciones concretas a realizar..."></textarea>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['accionesEspecificas'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>

                            <!-- Recursos y Responsable -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Recursos de Apoyo
                                    </label>
                                    <textarea wire:model="recursosApoyo" rows="3"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="Recursos, herramientas o apoyo necesario..."></textarea>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Responsable del Seguimiento *
                                    </label>
                                    <select wire:model="responsableId"
                                        class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Seleccionar responsable</option>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $responsables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $responsable): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($responsable->id); ?>">
                                            <?php echo e($responsable->name); ?> <?php echo e($responsable->primer_apellido); ?>

                                        </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </select>
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['responsableId'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="flex justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                            <a href=""
                                class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                                Cancelar
                            </a>
                            <button type="submit"
                                class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                                Crear Compromiso
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Mensajes de éxito/error -->
                <!--[if BLOCK]><![endif]--><?php if(session()->has('success')): ?>
                <div class="mt-6 bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="text-green-600 mr-3">✅</div>
                        <p class="text-green-800"><?php echo e(session('success')); ?></p>
                    </div>
                </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <?php if(session()->has('error')): ?>
                <div class="mt-6 bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <div class="text-red-600 mr-3">❌</div>
                        <p class="text-red-800"><?php echo e(session('error')); ?></p>
                    </div>
                </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>
    </div><?php /**PATH D:\laragon\www\encuesta-pro360\resources\views/livewire/encuesta/compromiso/crear-compromiso.blade.php ENDPATH**/ ?>