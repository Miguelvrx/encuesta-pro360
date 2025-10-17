
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">

        <!-- Header de la Evaluación -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div class="flex-1">
                    <h1 class="text-2xl font-bold text-gray-900"><?php echo e($evaluacion->tipo_evaluacion); ?></h1>
                    <p class="text-gray-600 mt-1"><?php echo e($evaluacion->descripcion_evaluacion); ?></p>
                    
                    <div class="flex items-center gap-4 mt-3 text-sm text-gray-500">
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span>Evaluando a: <strong><?php echo e($evaluado->name ?? 'N/A'); ?></strong></span>
                        </div>
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>Vence: <?php echo e($evaluacion->fecha_cierre->format('d M Y')); ?></span>
                        </div>
                    </div>
                </div>

                <!-- Progreso -->
                <div class="bg-blue-50 rounded-lg p-4 min-w-48">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-sm font-medium text-blue-900">Progreso</span>
                        <span class="text-sm font-bold text-blue-700"><?php echo e($progreso); ?>%</span>
                    </div>
                    <div class="w-full bg-blue-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full transition-all duration-300" 
                             style="width: <?php echo e($progreso); ?>%"></div>
                    </div>
                    <p class="text-xs text-blue-600 mt-1 text-center">
                        <?php echo e(count($respuestas)); ?> de <?php echo e($competencias->sum(function($c) { return $c->preguntas->count(); })); ?> preguntas
                    </p>
                </div>
            </div>
        </div>

        <!-- Navegación de Competencias -->
        <!--[if BLOCK]><![endif]--><?php if($competencias->count() > 1): ?>
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Competencias a Evaluar</h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-<?php echo e(min($competencias->count(), 5)); ?> gap-2">
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $competencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $competencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <button
                    wire:click="irAPaso(<?php echo e($index + 1); ?>)"
                    class="p-3 rounded-lg text-center transition-all duration-200 <?php echo e($pasoActual == $index + 1 ? 'bg-blue-600 text-white shadow-md' : 'bg-gray-100 text-gray-700 hover:bg-gray-200'); ?>"
                    title="<?php echo e($competencia->nombre_competencia); ?>">
                    <div class="font-semibold text-sm"><?php echo e($index + 1); ?></div>
                    <div class="text-xs mt-1 truncate"><?php echo e(\Illuminate\Support\Str::limit($competencia->nombre_competencia, 15)); ?></div>
                </button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <!-- Formulario de Evaluación -->
        <!--[if BLOCK]><![endif]--><?php if($competenciaActual): ?>
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Header de Competencia -->
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                            <span class="text-white font-bold text-lg"><?php echo e($pasoActual); ?></span>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-white"><?php echo e($competenciaActual->nombre_competencia); ?></h2>
                            <p class="text-indigo-100 text-sm"><?php echo e($competenciaActual->definicion_competencia); ?></p>
                        </div>
                    </div>
                    <div class="text-white text-sm">
                        Paso <?php echo e($pasoActual); ?> de <?php echo e($totalPasos); ?>

                    </div>
                </div>
            </div>

            <!-- Preguntas -->
            <div class="p-6 space-y-8">
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $competenciaActual->preguntas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pregunta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-start gap-4 mb-4">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-blue-600 font-semibold text-sm"><?php echo e($loop->iteration); ?></span>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2"><?php echo e($pregunta->texto_pregunta); ?></h3>
                            <!--[if BLOCK]><![endif]--><?php if($pregunta->descripcion_pregunta): ?>
                            <p class="text-gray-600 text-sm"><?php echo e($pregunta->descripcion_pregunta); ?></p>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>

                    <!-- Escala de Respuesta -->
                    <div class="ml-12">
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $nivelesEvaluacion; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $valor => $nivel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="relative cursor-pointer" 
                                   wire:key="pregunta-<?php echo e($pregunta->id_pregunta); ?>-nivel-<?php echo e($valor); ?>"
                                   x-data="{ preguntaId: <?php echo e($pregunta->id_pregunta); ?>, valorNivel: <?php echo e($valor); ?> }">
                                <input 
                                    type="radio" 
                                    name="pregunta_<?php echo e($pregunta->id_pregunta); ?>" 
                                    value="<?php echo e($valor); ?>"
                                    <?php if(isset($respuestas[$pregunta->id_pregunta]) && $respuestas[$pregunta->id_pregunta] == $valor): echo 'checked'; endif; ?>
                                    @click="$wire.seleccionarRespuesta(preguntaId, valorNivel)"
                                    class="sr-only peer">
                                <div class="p-4 border-2 border-gray-200 rounded-lg text-center transition-all duration-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 peer-checked:shadow-md hover:border-gray-300">
                                    <div class="text-2xl font-bold text-gray-700 mb-1"><?php echo e($valor); ?></div>
                                    <div class="text-xs font-semibold text-gray-600"><?php echo e($nivel['nombre']); ?></div>
                                    <div class="text-xs text-gray-500 mt-1 leading-tight"><?php echo e(\Illuminate\Support\Str::limit($nivel['descripcion'], 40)); ?></div>
                                </div>
                                <div class="absolute top-2 right-2 w-4 h-4 border-2 border-white rounded-full bg-gray-300 peer-checked:bg-blue-500 transition-colors"></div>
                            </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Leyenda de la Escala -->
                        <div class="flex justify-between items-center mt-4 pt-4 border-t border-gray-200">
                            <span class="text-xs text-gray-500">1 - Requiere Apoyo</span>
                            <span class="text-xs text-gray-500">5 - Excepcional</span>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </div>

            <!-- Navegación -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                <div class="flex justify-between items-center">
                    <button
                        wire:click="anteriorPaso"
                        class="px-6 py-2 bg-gray-600 text-white font-semibold rounded-lg hover:bg-gray-700 transition-colors flex items-center gap-2 <?php echo e($pasoActual == 1 ? 'opacity-50 cursor-not-allowed' : ''); ?>"
                        <?php echo e($pasoActual == 1 ? 'disabled' : ''); ?>>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                        Anterior
                    </button>

                    <!--[if BLOCK]><![endif]--><?php if($pasoActual == $totalPasos): ?>
                    <button
                        wire:click="enviarEvaluacion"
                        class="px-8 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        Enviar Evaluación
                    </button>
                    <?php else: ?>
                    <button
                        wire:click="siguientePaso"
                        class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
                        Siguiente
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </button>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>
        </div>
        <?php else: ?>
        <div class="bg-white rounded-xl shadow-lg p-8 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No hay competencias para evaluar</h3>
            <p class="mt-1 text-sm text-gray-500">Esta evaluación no tiene competencias configuradas.</p>
        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

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
</div><?php /**PATH D:\laragon\www\encuesta-pro360\resources\views/livewire/encuesta/evaluacion/realizar-evaluacion.blade.php ENDPATH**/ ?>