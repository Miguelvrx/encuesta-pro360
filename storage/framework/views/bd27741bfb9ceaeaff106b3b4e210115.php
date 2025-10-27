
<div>
    <div class="min-h-screen bg-gradient-to-b from-blue-50 to-white max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        
        <div class="bg-blue-700 rounded-lg shadow-lg p-4 mb-6 flex justify-between items-center">
            <h1 class="text-xl font-bold text-white">Banco de Competencias</h1>
            <a href="#" class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md text-blue-700 bg-white hover:bg-blue-50 transition-colors">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
                Manual de Usuario
            </a>
        </div>

        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="md:col-span-2">
                <label for="busqueda" class="block text-sm font-medium text-gray-700">Buscar</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input 
                        type="search" 
                        wire:model.live.debounce.300ms="busqueda" 
                        id="busqueda" 
                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                        placeholder="Buscar por nombre de competencia...">
                </div>
            </div>
            <div>
                <label for="categoria" class="block text-sm font-medium text-gray-700">Categoría</label>
                <select 
                    wire:model.live="categoriaFiltro" 
                    id="categoria" 
                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                    <option value="">Todas</option>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($categoria->id_categoria_competencia); ?>"><?php echo e($categoria->categoria); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </select>
            </div>
        </div>

        
        <div class="space-y-8">
            <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $competencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $competencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div wire:key="competencia-<?php echo e($competencia->id_competencia); ?>" class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200/80">
                <div class="p-6 sm:p-8">
                    
                    <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
                        <div class="flex-1">
                            <span class="inline-block px-3 py-1 text-xs font-semibold leading-5 rounded-full bg-blue-100 text-blue-800">
                                <?php echo e($competencia->categoria->categoria ?? 'Sin categoría'); ?>

                            </span>
                            <h2 class="mt-3 text-2xl font-bold text-gray-900"><?php echo e($competencia->nombre_competencia); ?></h2>
                            <p class="mt-2 text-base text-gray-600 max-w-3xl"><?php echo e($competencia->definicion_competencia); ?></p>
                        </div>
                        <a 
                            href="<?php echo e(route('editar-competencia', ['competencia' => $competencia->id_competencia])); ?>" 
                            class="flex-shrink-0 inline-flex items-center justify-center px-6 py-2 border border-transparent text-sm font-semibold rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all">
                            <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                            Editar
                        </a>
                    </div>

                    
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h4 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-6">Niveles de Comportamiento</h4>

                        
                        <?php
                        $escalaDeNiveles = [
                            'Excepcional' => ['numero' => 5, 'tagline' => 'Modelo a seguir con impacto sostenido', 'color' => 'text-emerald-600'],
                            'Supera las Expectativas' => ['numero' => 4, 'tagline' => 'Desempeño consistentemente superior', 'color' => 'text-blue-600'],
                            'Competente' => ['numero' => 3, 'tagline' => 'Cumple de forma confiable lo esperado', 'color' => 'text-indigo-600'],
                            'En Desarrollo' => ['numero' => 2, 'tagline' => 'Avanza con áreas por fortalecer', 'color' => 'text-amber-600'],
                            'Requiere Apoyo' => ['numero' => 1, 'tagline' => 'Necesita acompañamiento para el estándar', 'color' => 'text-red-600'],
                        ];
                        ?>

                        
                        <div class="space-y-6">
                            <!--[if BLOCK]><![endif]--><?php $__empty_2 = true; $__currentLoopData = $competencia->niveles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nivel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                <?php
                                $datosNivel = $escalaDeNiveles[$nivel->nombre_nivel] ?? null;
                                ?>

                                <div class="grid grid-cols-12 gap-x-6 gap-y-3 items-start">
                                    
                                    <div class="col-span-12 md:col-span-5">
                                        <!--[if BLOCK]><![endif]--><?php if($datosNivel): ?>
                                        <div class="flex items-baseline gap-3">
                                            <span class="text-3xl font-bold <?php echo e($datosNivel['color']); ?> min-w-[2rem] text-center">
                                                <?php echo e($datosNivel['numero']); ?>

                                            </span>
                                            <div>
                                                <p class="text-base font-semibold text-gray-800"><?php echo e($nivel->nombre_nivel); ?></p>
                                                <p class="text-xs text-gray-500 italic mt-0.5">"<?php echo e($datosNivel['tagline']); ?>"</p>
                                            </div>
                                        </div>
                                        <?php else: ?>
                                        <p class="font-semibold text-gray-900"><?php echo e($nivel->nombre_nivel); ?></p>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>

                                    
                                    <div class="col-span-12 md:col-span-7">
                                        <p class="text-gray-600 leading-relaxed"><?php echo e($nivel->descripcion_nivel); ?></p>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                            <div class="text-center py-8 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                                <svg class="mx-auto h-10 w-10 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                                </svg>
                                <p class="text-gray-500 italic mt-2">Esta competencia aún no tiene niveles definidos.</p>
                            </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="text-center bg-white p-12 rounded-lg shadow-md border">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No se encontraron competencias</h3>
                <p class="mt-1 text-sm text-gray-500">Intenta ajustar los filtros o crea una nueva competencia.</p>
            </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        
        <!--[if BLOCK]><![endif]--><?php if($competencias->hasPages()): ?>
        <div class="mt-8">
            <?php echo e($competencias->links()); ?>

        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>
</div><?php /**PATH D:\laragon\www\encuesta-pro360\resources\views/livewire/encuesta/competencia/revisar-comptencia.blade.php ENDPATH**/ ?>