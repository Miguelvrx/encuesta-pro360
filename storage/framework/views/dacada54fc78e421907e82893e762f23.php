
<div>
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        
        <div class="bg-white rounded-lg shadow-md border border-gray-200/80">
            <div class="bg-blue-700 rounded-t-lg p-4 flex justify-between items-center">
                <h1 class="text-xl font-bold text-white">Gestión de Competencias</h1>
                <a href="#" class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md text-blue-700 bg-white hover:bg-blue-50 transition-colors">
                    <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                    </svg>
                    Manual de Usuario
                </a>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                
                <div>
                    <label for="categoria" class="block text-sm font-medium text-gray-700">Categoría</label>
                    <select
                        wire:model.live="categoriaSeleccionada"
                        id="categoria"
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                        <option value="">Selecciona una categoría</option>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($categoria->id_categoria_competencia); ?>"><?php echo e($categoria->categoria); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </select>
                </div>

                
                <div>
                    <label for="competencia" class="block text-sm font-medium text-gray-700">Competencia</label>
                    <select
                        wire:model.live="competenciaSeleccionada"
                        id="competencia"
                        class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md disabled:bg-gray-100 disabled:cursor-not-allowed"
                        <?php if($competenciasFiltradas->isEmpty()): ?> disabled <?php endif; ?>>
                        <option value="">
                            <!--[if BLOCK]><![endif]--><?php if($categoriaSeleccionada && $competenciasFiltradas->isNotEmpty()): ?>
                            Selecciona una competencia
                            <?php else: ?>
                            Primero selecciona una categoría
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </option>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $competenciasFiltradas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($comp->id_competencia); ?>"><?php echo e($comp->nombre_competencia); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </select>
                </div>

                
                <button
                    wire:click="verCatalogoCompleto"
                    class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                    <?php if(!$categoriaSeleccionada || $competenciasFiltradas->isEmpty()): ?> disabled <?php endif; ?>>
                    <svg class="w-5 h-5 mr-2 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                    </svg>
                    Ver Catálogo Completo
                </button>

                
                <a
                    href="<?php echo e(route('crear-competencia')); ?>"
                    wire:navigate
                    class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 transition-colors">
                    <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Crear Nueva Competencia
                </a>
            </div>
        </div>

        
        <div class="mt-8">
            
            <!--[if BLOCK]><![endif]--><?php if($competenciaActual && !$vistaCatalogo): ?>
            <?php
            $escalaDeNiveles = [
            'Excepcional' => ['numero' => 5, 'tagline' => 'Modelo a seguir con impacto sostenido', 'color' => 'text-emerald-600'],
            'Supera las Expectativas' => ['numero' => 4, 'tagline' => 'Desempeño consistentemente superior', 'color' => 'text-blue-600'],
            'Competente' => ['numero' => 3, 'tagline' => 'Cumple de forma confiable lo esperado', 'color' => 'text-indigo-600'],
            'En Desarrollo' => ['numero' => 2, 'tagline' => 'Avanza con áreas por fortalecer', 'color' => 'text-amber-600'],
            'Requiere Apoyo' => ['numero' => 1, 'tagline' => 'Necesita acompañamiento para el estándar', 'color' => 'text-red-600'],
            ];
            ?>

            
            <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200/80">
                <div class="p-6 sm:p-8">
                    
                    <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
                        <div class="flex-1">
                            <span class="inline-block px-3 py-1 text-xs font-semibold leading-5 rounded-full bg-blue-100 text-blue-800">
                                <?php echo e($competenciaActual->categoria->categoria ?? 'Sin categoría'); ?>

                            </span>
                            <h2 class="mt-3 text-2xl font-bold text-gray-900"><?php echo e($competenciaActual->nombre_competencia); ?></h2>
                            <p class="mt-2 text-base text-gray-600 max-w-3xl"><?php echo e($competenciaActual->definicion_competencia); ?></p>
                        </div>
                        <a
                            href="<?php echo e(route('editar-competencia', ['competencia' => $competenciaActual->id_competencia])); ?>"
                            class="flex-shrink-0 inline-flex items-center justify-center px-6 py-2 border border-transparent text-sm font-semibold rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all">
                            <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                            Editar
                        </a>
                    </div>

                    
                    <div class="mt-8 pt-8 border-t border-gray-200">
                        <h4 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-6">Niveles de Comportamiento</h4>

                        
                        <div class="space-y-6">
                            <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $competenciaActual->niveles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nivel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
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
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
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

            
            <?php elseif($vistaCatalogo && $competenciasCatalogo->isNotEmpty()): ?>
            <?php
            $escalaDeNiveles = [
            'Excepcional' => ['numero' => 5, 'tagline' => 'Modelo a seguir con impacto sostenido', 'color' => 'text-emerald-600'],
            'Supera las Expectativas' => ['numero' => 4, 'tagline' => 'Desempeño consistentemente superior', 'color' => 'text-blue-600'],
            'Competente' => ['numero' => 3, 'tagline' => 'Cumple de forma confiable lo esperado', 'color' => 'text-indigo-600'],
            'En Desarrollo' => ['numero' => 2, 'tagline' => 'Avanza con áreas por fortalecer', 'color' => 'text-amber-600'],
            'Requiere Apoyo' => ['numero' => 1, 'tagline' => 'Necesita acompañamiento para el estándar', 'color' => 'text-red-600'],
            ];
            ?>

            <div class="space-y-8">
                
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg shadow-sm">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                Mostrando <span class="font-semibold"><?php echo e($competenciasCatalogo->count()); ?></span> competencia(s) de esta categoría
                            </p>
                        </div>
                    </div>
                </div>

                
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $competenciasCatalogo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $competencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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

                        
                        <div class="mt-8 pt-8 border-t border-gray-200">
                            <h4 class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-6">Niveles de Comportamiento</h4>

                            
                            <div class="space-y-6">
                                <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $competencia->niveles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nivel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
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
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
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
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </div>

            
            <?php else: ?>
            <div class="text-center bg-white p-12 rounded-lg shadow-md border">
                <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">Catálogo de Competencias</h3>
                <p class="mt-1 text-sm text-gray-500">Selecciona una categoría y una competencia para ver sus detalles, o usa "Ver Catálogo Completo" para ver todas las competencias de la categoría en una sola página.</p>
            </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>
</div>
</div><?php /**PATH D:\laragon\www\encuesta-pro360\resources\views/livewire/encuesta/competencia/catalogo-competencia.blade.php ENDPATH**/ ?>