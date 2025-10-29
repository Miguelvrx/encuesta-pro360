<div>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50/30 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">

            
            <header class="mb-8">
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100/50 backdrop-blur-sm">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                        <div class="space-y-3">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl shadow-md">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                                <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">Banco de Competencias</h1>
                            </div>
                            <p class="text-gray-600 max-w-2xl">
                                Gestiona y organiza las competencias esenciales para el desarrollo organizacional
                            </p>
                            <div class="flex items-center gap-4">
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-700 font-medium text-sm shadow-sm border border-indigo-200/50">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    <?php echo e($competencias->total()); ?> <?php echo e($competencias->total() == 1 ? 'Competencia' : 'Competencias'); ?>

                                </span>
                                <!--[if BLOCK]><![endif]--><?php if($busqueda || $categoriaFiltro): ?>
                                <span class="text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded-md">
                                    (Filtros aplicados)
                                </span>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>

                        
                        <div class="flex items-center gap-3 flex-wrap">
                            <!-- Botón Nueva Competencia -->
                            <a href="<?php echo e(route('crear-competencia')); ?>" wire:navigate
                                class="group relative inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold text-sm rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <div class="absolute inset-0 bg-white/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Nueva Competencia
                            </a>

                            <!-- Botón Manual de Usuario -->
                            <a href="#"
                                class="group relative inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold text-sm rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <div class="absolute inset-0 bg-white/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z" />
                                </svg>
                                Manual de Usuario
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            
            <div class="mb-8 bg-white p-5 rounded-2xl shadow-lg border border-gray-100/50">
                <form @submit.prevent>
                    <div class="flex flex-col sm:flex-row items-center gap-4">
                        <div class="relative flex-grow w-full">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input
                                type="search"
                                wire:model.live.debounce.300ms="busqueda"
                                id="busqueda"
                                class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl leading-5 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200"
                                placeholder="Buscar por nombre de competencia..."
                                autocomplete="off">
                        </div>
                        <div class="w-full sm:w-64">
                            <select
                                wire:model.live="categoriaFiltro"
                                id="categoria"
                                class="w-full rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500/50 py-3 transition-all duration-200">
                                <option value="">Todas las Categorías</option>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($categoria->id_categoria_competencia); ?>"><?php echo e($categoria->categoria); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </select>
                        </div>
                    </div>
                </form>

                <!--[if BLOCK]><![endif]--><?php if($busqueda || $categoriaFiltro): ?>
                <div class="mt-4 flex flex-wrap gap-2">
                    <!--[if BLOCK]><![endif]--><?php if($busqueda): ?>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        Búsqueda: "<?php echo e($busqueda); ?>"
                        <button type="button" wire:click="$set('busqueda', '')" class="ml-1.5 hover:bg-blue-200 rounded-full p-0.5">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </span>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <!--[if BLOCK]><![endif]--><?php if($categoriaFiltro): ?>
                    <?php
                    $categoriaSeleccionada = $categorias->firstWhere('id_categoria_competencia', $categoriaFiltro);
                    ?>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                        Categoría: <?php echo e($categoriaSeleccionada->categoria ?? 'Seleccionada'); ?>

                        <button type="button" wire:click="$set('categoriaFiltro', null)" class="ml-1.5 hover:bg-indigo-200 rounded-full p-0.5">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </span>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <button
                        type="button"
                        wire:click="resetFiltros"
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700 hover:bg-gray-200 transition-colors">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Limpiar filtros
                    </button>
                </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>


            
            <div class="space-y-6">
                <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $competencias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $competencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div wire:key="competencia-<?php echo e($competencia->id_competencia); ?>"
                    class="group bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100/50 hover:shadow-xl transition-all duration-500 hover:border-indigo-200/50">

                    
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100/80 p-6 border-b border-gray-200/50">
                        <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-3">
                                    <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-700 border border-indigo-200/50 shadow-sm">
                                        <?php echo e($competencia->categoria->categoria ?? 'Sin categoría'); ?>

                                    </span>
                                    <div class="h-2 w-2 rounded-full bg-indigo-300"></div>
                                    <span class="text-xs text-gray-500 font-medium">
                                        <?php echo e($competencia->niveles->count()); ?> Niveles
                                    </span>
                                </div>
                                <h2 class="text-2xl font-bold text-gray-900 group-hover:text-indigo-700 transition-colors duration-300">
                                    <?php echo e($competencia->nombre_competencia); ?>

                                </h2>
                                <p class="mt-3 text-gray-600 leading-relaxed max-w-3xl">
                                    <?php echo e($competencia->definicion_competencia); ?>

                                </p>
                            </div>
                            <a
                                href="<?php echo e(route('editar-competencia', ['competencia' => $competencia->id_competencia])); ?>"
                                wire:navigate 
                                class="relative inline-flex items-center mt-4 px-4 py-2 text-sm font-medium text-indigo-600 hover:text-indigo-700 transition-colors z-10">
                                <div class="absolute inset-0 bg-white/20 rounded-xl opacity-0 group-hover/edit:opacity-100 transition-opacity duration-300"></div>
                                <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                                Editar

                            </a>
                        </div>
                    </div>

                    
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-6">
                            <div class="p-1.5 bg-indigo-100 rounded-lg">
                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                            </div>
                            <h4 class="text-sm font-bold text-gray-700 uppercase tracking-widest">Niveles de Comportamiento</h4>
                        </div>

                        
                        <?php
                        $escalaDeNiveles = [
                        'Excepcional' => ['numero' => 5, 'tagline' => 'Modelo a seguir con impacto sostenido', 'color' => 'from-emerald-500 to-green-600', 'bg' => 'bg-gradient-to-r from-emerald-50 to-green-50', 'border' => 'border-emerald-200'],
                        'Supera las Expectativas' => ['numero' => 4, 'tagline' => 'Desempeño consistentemente superior', 'color' => 'from-blue-500 to-indigo-600', 'bg' => 'bg-gradient-to-r from-blue-50 to-indigo-50', 'border' => 'border-blue-200'],
                        'Competente' => ['numero' => 3, 'tagline' => 'Cumple de forma confiable lo esperado', 'color' => 'from-indigo-500 to-purple-600', 'bg' => 'bg-gradient-to-r from-indigo-50 to-purple-50', 'border' => 'border-indigo-200'],
                        'En Desarrollo' => ['numero' => 2, 'tagline' => 'Avanza con áreas por fortalecer', 'color' => 'from-amber-500 to-orange-600', 'bg' => 'bg-gradient-to-r from-amber-50 to-orange-50', 'border' => 'border-amber-200'],
                        'Requiere Apoyo' => ['numero' => 1, 'tagline' => 'Necesita acompañamiento para el estándar', 'color' => 'from-red-500 to-rose-600', 'bg' => 'bg-gradient-to-r from-red-50 to-rose-50', 'border' => 'border-red-200'],
                        ];
                        ?>

                        
                        <div class="space-y-4">
                            <!--[if BLOCK]><![endif]--><?php $__empty_2 = true; $__currentLoopData = $competencia->niveles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nivel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                            <?php
                            $datosNivel = $escalaDeNiveles[$nivel->nombre_nivel] ?? null;
                            ?>

                            <div class="group/nivel <?php echo e($datosNivel['bg'] ?? 'bg-gray-50'); ?> rounded-xl border <?php echo e($datosNivel['border'] ?? 'border-gray-200'); ?> p-5 transition-all duration-300 hover:shadow-md hover:scale-[1.02]">
                                <div class="grid grid-cols-12 gap-6 items-start">
                                    
                                    <div class="col-span-12 md:col-span-5">
                                        <!--[if BLOCK]><![endif]--><?php if($datosNivel): ?>
                                        <div class="flex items-center gap-4">
                                            <div class="flex-shrink-0">
                                                <div class="h-14 w-14 rounded-xl bg-gradient-to-r <?php echo e($datosNivel['color']); ?> flex items-center justify-center text-white font-bold text-lg shadow-md">
                                                    <?php echo e($datosNivel['numero']); ?>

                                                </div>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-lg font-bold text-gray-800 group-hover/nivel:text-gray-900 transition-colors">
                                                    <?php echo e($nivel->nombre_nivel); ?>

                                                </p>
                                                <p class="text-sm text-gray-500 italic mt-1 leading-tight">"<?php echo e($datosNivel['tagline']); ?>"</p>
                                            </div>
                                        </div>
                                        <?php else: ?>
                                        <div class="flex items-center gap-4">
                                            <div class="h-14 w-14 rounded-xl bg-gradient-to-r from-gray-400 to-gray-600 flex items-center justify-center text-white font-bold text-lg shadow-md">
                                                ?
                                            </div>
                                            <p class="text-lg font-bold text-gray-800"><?php echo e($nivel->nombre_nivel); ?></p>
                                        </div>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>

                                    
                                    <div class="col-span-12 md:col-span-7">
                                        <p class="text-gray-600 leading-relaxed group-hover/nivel:text-gray-700 transition-colors">
                                            <?php echo e($nivel->descripcion_nivel); ?>

                                        </p>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                            <div class="text-center py-12 bg-gradient-to-br from-gray-50 to-gray-100/50 rounded-xl border-2 border-dashed border-gray-300/50">
                                <div class="mx-auto h-16 w-16 bg-gradient-to-r from-gray-200 to-gray-300 rounded-full flex items-center justify-center mb-4">
                                    <svg class="h-8 w-8 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Sin niveles definidos</h3>
                                <p class="text-gray-500 max-w-md mx-auto">Esta competencia aún no tiene niveles de comportamiento configurados.</p>
                                <a href="<?php echo e(route('editar-competencia', ['competencia' => $competencia->id_competencia])); ?>"
                                    wire:navigate 
                                    class="relative inline-flex items-center mt-4 px-4 py-2 text-sm font-medium text-indigo-600 hover:text-indigo-700 transition-colors z-10">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Agregar niveles
                                </a>
                            </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-center bg-white p-16 rounded-2xl shadow-lg border border-gray-100/50">
                    <div class="mx-auto h-20 w-20 bg-gradient-to-r from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-6">
                        <svg class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No se encontraron competencias</h3>
                    <p class="text-gray-600 mb-6 max-w-md mx-auto">Intenta ajustar los filtros de búsqueda o crea una nueva competencia para comenzar.</p>
                    <a href="<?php echo e(route('crear-competencia')); ?>" wire:navigate
                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Crear Primera Competencia
                    </a>
                </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>

            
            <!--[if BLOCK]><![endif]--><?php if($competencias->hasPages()): ?>
            <div class="mt-8">
                <?php echo e($competencias->links()); ?>

            </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>
</div><?php /**PATH D:\laragon\www\encuesta-pro360\resources\views/livewire/encuesta/competencia/revisar-comptencia.blade.php ENDPATH**/ ?>