<div>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50/30 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            <form wire:submit.prevent="save" class="space-y-8">

                
                <header class="mb-8">
                    <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100/50 backdrop-blur-sm">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="p-2 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl shadow-md">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">
                                Crear Nueva Competencia
                            </h1>
                        </div>
                        <p class="text-gray-600 max-w-2xl">
                            Selecciona una categoría y competencia, luego define sus 5 niveles de comportamiento estándar.
                        </p>
                    </div>
                </header>

                
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100/50">
                    <div class="bg-gradient-to-r from-indigo-600 to-purple-600 px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-white">Información de la Competencia</h2>
                                <p class="text-sm text-indigo-200 mt-1">Define los detalles fundamentales de la competencia</p>
                            </div>
                        </div>
                    </div>  
                    
                    <div class="p-6 space-y-6">
                        
                        
                        <div class="group">
                            <label for="categoria" class="block text-sm font-semibold text-gray-700 mb-3">
                                <span class="flex items-center gap-2">
                                    <span class="inline-flex w-2 h-2 bg-indigo-500 rounded-full"></span>
                                    Categoría 
                                    <span class="text-red-500">*</span>
                                </span>
                            </label>
                            <select 
                                wire:model.live="categoria_id_competencia" 
                                id="categoria" 
                                class="w-full pl-4 pr-10 py-3 border border-gray-200 rounded-xl leading-5 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200 group-hover:border-gray-300">
                                <option value="" class="text-gray-400">Selecciona una categoría</option>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($categoria->id_categoria_competencia); ?>" class="text-gray-700"><?php echo e($categoria->categoria); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </select>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['categoria_id_competencia'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                <div class="flex items-center gap-2 mt-2 text-red-600 text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <?php echo e($message); ?>

                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        
                        <div class="group">
                            <label for="nombre_competencia" class="block text-sm font-semibold text-gray-700 mb-3">
                                <span class="flex items-center gap-2">
                                    <span class="inline-flex w-2 h-2 bg-indigo-500 rounded-full"></span>
                                    Nombre de la Competencia 
                                    <span class="text-red-500">*</span>
                                </span>
                            </label>
                            <select 
                                wire:model.live="nombre_competencia" 
                                id="nombre_competencia"
                                <?php if(!$categoria_id_competencia): ?> disabled <?php endif; ?>
                                class="w-full pl-4 pr-10 py-3 border border-gray-200 rounded-xl leading-5 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200 disabled:bg-gray-50 disabled:cursor-not-allowed group-hover:border-gray-300">
                                <option value="" class="text-gray-400">
                                    <!--[if BLOCK]><![endif]--><?php if($categoria_id_competencia): ?>
                                        Selecciona una competencia
                                    <?php else: ?>
                                        Primero selecciona una categoría
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </option>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $competenciasDisponibles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $competencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($competencia); ?>" class="text-gray-700"><?php echo e($competencia); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </select>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['nombre_competencia'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                <div class="flex items-center gap-2 mt-2 text-red-600 text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <?php echo e($message); ?>

                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        
                        <div class="group">
                            <div class="flex items-center justify-between mb-3">
                                <label for="definicion_competencia" class="block text-sm font-semibold text-gray-700">
                                    <span class="flex items-center gap-2">
                                        <span class="inline-flex w-2 h-2 bg-indigo-500 rounded-full"></span>
                                        Definición de la Competencia 
                                        <span class="text-red-500">*</span>
                                    </span>
                                </label>
                                
                                <!--[if BLOCK]><![endif]--><?php if($nombre_competencia && $definicion_competencia): ?>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200 shadow-sm">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        Definición cargada
                                    </span>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            
                            <textarea 
                                wire:model="definicion_competencia" 
                                id="definicion_competencia" 
                                rows="4" 
                                placeholder="Selecciona una competencia para ver su definición..."
                                class="w-full pl-4 pr-4 py-3 border border-gray-200 rounded-xl leading-5 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200 resize-none group-hover:border-gray-300"></textarea>
                            
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['definicion_competencia'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                <div class="flex items-center gap-2 mt-2 text-red-600 text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <?php echo e($message); ?>

                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            
                            <!--[if BLOCK]><![endif]--><?php if($nombre_competencia): ?>
                                <p class="flex items-center gap-2 text-xs text-gray-500 mt-2">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Puedes editar la definición si lo necesitas
                                </p>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>
                </div>

                
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100/50">
                    <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-white">Niveles de Comportamiento</h2>
                                <p class="text-sm text-gray-300 mt-1">Describe el comportamiento observable para cada nivel estándar</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 space-y-6">
                        <?php
                            $coloresNiveles = [
                                5 => ['bg' => 'from-emerald-500 to-green-600', 'border' => 'border-emerald-200', 'text' => 'text-emerald-600'],
                                4 => ['bg' => 'from-blue-500 to-indigo-600', 'border' => 'border-blue-200', 'text' => 'text-blue-600'],
                                3 => ['bg' => 'from-indigo-500 to-purple-600', 'border' => 'border-indigo-200', 'text' => 'text-indigo-600'],
                                2 => ['bg' => 'from-amber-500 to-orange-600', 'border' => 'border-amber-200', 'text' => 'text-amber-600'],
                                1 => ['bg' => 'from-red-500 to-rose-600', 'border' => 'border-red-200', 'text' => 'text-red-600'],
                            ];
                        ?>

                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $niveles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $nivel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div wire:key="nivel-<?php echo e($index); ?>" 
                             class="group/nivel p-6 bg-gradient-to-r from-gray-50 to-gray-100/30 rounded-xl border border-gray-200 hover:border-gray-300 transition-all duration-300 hover:shadow-md">
                            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 items-start">

                                
                                <div class="lg:col-span-1">
                                    <div class="flex items-start gap-4">
                                        <div class="flex-shrink-0">
                                            <div class="h-16 w-16 rounded-xl bg-gradient-to-r <?php echo e($coloresNiveles[$nivel['numero']]['bg']); ?> flex items-center justify-center text-white font-bold text-xl shadow-lg">
                                                <?php echo e($nivel['numero']); ?>

                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-lg font-bold text-gray-800 group-hover/nivel:text-gray-900">
                                                <?php echo e($nivel['nombre_nivel']); ?>

                                            </p>
                                            <p class="text-sm text-gray-500 italic mt-1 leading-tight">
                                                "<?php echo e($nivel['tagline']); ?>"
                                            </p>
                                        </div>
                                    </div>
                                    <input type="hidden" wire:model="niveles.<?php echo e($index); ?>.nombre_nivel">
                                </div>

                                
                                <div class="lg:col-span-3">
                                    <div class="flex items-center justify-between mb-3">
                                        <label for="nivel_descripcion_<?php echo e($index); ?>" class="block text-sm font-semibold text-gray-700">
                                            <span class="flex items-center gap-2">
                                                <span class="inline-flex w-2 h-2 <?php echo e($coloresNiveles[$nivel['numero']]['text']); ?> rounded-full"></span>
                                                Descripción del Comportamiento Observable 
                                                <span class="text-red-500">*</span>
                                            </span>
                                        </label>
                                        
                                        <!--[if BLOCK]><![endif]--><?php if($niveles[$index]['descripcion_nivel']): ?>
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200 shadow-sm">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                Completado
                                            </span>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                    
                                    <textarea
                                        wire:model="niveles.<?php echo e($index); ?>.descripcion_nivel"
                                        id="nivel_descripcion_<?php echo e($index); ?>"
                                        rows="4"
                                        placeholder="Describe qué hace una persona en el nivel '<?php echo e($nivel['nombre_nivel']); ?>'..."
                                        class="w-full pl-4 pr-4 py-3 border border-gray-200 rounded-xl leading-5 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200 resize-none group-hover/nivel:border-gray-300"></textarea>
                                    
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['niveles.'.$index.'.descripcion_nivel'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> 
                                        <div class="flex items-center gap-2 mt-2 text-red-600 text-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <?php echo e($message); ?>

                                        </div>
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

                
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 pt-6">
                    <div class="flex items-center gap-3 text-sm text-gray-500">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Todos los campos marcados con <span class="text-red-500">*</span> son obligatorios</span>
                    </div>
                    
                    <div class="flex gap-3">
                        <button 
                            type="button" 
                            wire:click="$refresh" 
                            class="group relative inline-flex items-center px-6 py-3 bg-gradient-to-r from-gray-200 to-gray-300 text-gray-700 font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            <div class="absolute inset-0 bg-white/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Cancelar
                        </button>
                        <button 
                            type="submit" 
                            class="group relative inline-flex items-center px-8 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <div class="absolute inset-0 bg-white/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Guardar Competencia
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div><?php /**PATH D:\laragon\www\encuesta-pro360\resources\views/livewire/encuesta/competencia/crear-competencia.blade.php ENDPATH**/ ?>