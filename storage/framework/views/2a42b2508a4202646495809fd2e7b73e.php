
<div>
    <div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <form wire:submit.prevent="update" class="space-y-8">

            
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4">
                    <h1 class="text-2xl font-bold text-white">Editar Competencia</h1>
                    <p class="text-sm text-indigo-200 mt-1">Modifica la categoría, competencia y sus niveles de comportamiento.</p>
                </div>
                <div class="p-6 space-y-6">
                    
                    
                    <div>
                        <label for="categoria" class="block text-sm font-medium text-gray-700">
                            Categoría <span class="text-red-500">*</span>
                        </label>
                        <select 
                            wire:model.live="categoria_id_competencia" 
                            id="categoria" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Selecciona una categoría</option>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($categoria->id_categoria_competencia); ?>"><?php echo e($categoria->categoria); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </select>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['categoria_id_competencia'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                            <span class="text-red-500 text-sm"><?php echo e($message); ?></span> 
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    
                    <div>
                        <label for="nombre_competencia" class="block text-sm font-medium text-gray-700">
                            Nombre de la Competencia <span class="text-red-500">*</span>
                        </label>
                        <select 
                            wire:model.live="nombre_competencia" 
                            id="nombre_competencia"
                            <?php if(!$categoria_id_competencia): ?> disabled <?php endif; ?>
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:bg-gray-100 disabled:cursor-not-allowed">
                            <option value="">
                                <!--[if BLOCK]><![endif]--><?php if($categoria_id_competencia): ?>
                                    Selecciona una competencia
                                <?php else: ?>
                                    Primero selecciona una categoría
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </option>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $competenciasDisponibles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $competencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($competencia); ?>"><?php echo e($competencia); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </select>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['nombre_competencia'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                            <span class="text-red-500 text-sm"><?php echo e($message); ?></span> 
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    
                    <div>
                        <label for="definicion_competencia" class="block text-sm font-medium text-gray-700">
                            Definición de la Competencia <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            wire:model="definicion_competencia" 
                            id="definicion_competencia" 
                            rows="3" 
                            placeholder="Selecciona una competencia para ver su definición..."
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['definicion_competencia'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                            <span class="text-red-500 text-sm"><?php echo e($message); ?></span> 
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        <!--[if BLOCK]><![endif]--><?php if($nombre_competencia): ?>
                            <p class="text-xs text-gray-500 mt-1">
                                💡 Puedes editar la definición si lo necesitas
                            </p>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
            </div>

            
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-6 py-4">
                    <h2 class="text-lg font-semibold text-white">Niveles de Comportamiento</h2>
                    <p class="text-sm text-gray-300 mt-1">Describe el comportamiento observable para cada nivel estándar.</p>
                </div>
                <div class="p-6 space-y-6">
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $niveles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $nivel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div wire:key="nivel-<?php echo e($index); ?>" class="p-4 border border-gray-200 rounded-lg hover:border-gray-300 transition-colors">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-4 items-start">
                            
                            
                            <div class="md:col-span-1">
                                <label class="block text-sm font-medium text-gray-700">Nivel</label>
                                <div class="mt-2 flex items-baseline gap-3">
                                    <span class="text-3xl font-bold text-indigo-600"><?php echo e($nivel['numero']); ?></span>
                                    <div>
                                        <p class="text-lg font-semibold text-gray-800"><?php echo e($nivel['nombre_nivel']); ?></p>
                                        <p class="text-xs text-gray-500 italic">"<?php echo e($nivel['tagline']); ?>"</p>
                                    </div>
                                </div>
                                <input type="hidden" wire:model="niveles.<?php echo e($index); ?>.nombre_nivel">
                                <input type="hidden" wire:model="niveles.<?php echo e($index); ?>.id_nivel">
                            </div>

                            
                            <div class="md:col-span-2">
                                <label for="nivel_descripcion_<?php echo e($index); ?>" class="block text-sm font-medium text-gray-700">
                                    Descripción del Comportamiento Observable <span class="text-red-500">*</span>
                                </label>
                                <textarea
                                    wire:model="niveles.<?php echo e($index); ?>.descripcion_nivel"
                                    id="nivel_descripcion_<?php echo e($index); ?>"
                                    rows="4"
                                    placeholder="Describe qué hace una persona en el nivel '<?php echo e($nivel['nombre_nivel']); ?>'..."
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['niveles.'.$index.'.descripcion_nivel'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                    <span class="text-red-500 text-sm"><?php echo e($message); ?></span> 
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>

            
            <div class="flex justify-center space-x-4 pt-4">
                <a 
                    href="<?php echo e(route('revisar-competencia')); ?>" 
                    wire:navigate 
                    class="px-8 py-3 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition-colors">
                    Cancelar
                </a>
                <button 
                    type="submit" 
                    class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-medium rounded-lg hover:from-indigo-700 hover:to-indigo-800 transition-all">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div><?php /**PATH D:\laragon\www\encuesta-pro360\resources\views/livewire/encuesta/competencia/editar-comptencia.blade.php ENDPATH**/ ?>