<div>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50/30 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">

            <!-- Cabecera Mejorada -->
            <header class="mb-8">
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100/50 backdrop-blur-sm">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                        <div class="space-y-3">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl shadow-md">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">Gestión de Departamentos</h1>
                            </div>
                            <p class="text-gray-600 max-w-2xl">
                                Administra, busca y organiza los departamentos registrados en el sistema
                            </p>
                            <div class="flex items-center gap-4">
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-700 font-medium text-sm shadow-sm border border-indigo-200/50">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    <?php echo e($departamentos->total()); ?> <?php echo e($departamentos->total() == 1 ? 'Departamento' : 'Departamentos'); ?>

                                </span>
                                <!--[if BLOCK]><![endif]--><?php if($busqueda || $filtroEmpresa || $filtroEstado): ?>
                                <span class="text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded-md">
                                    (Filtros aplicados)
                                </span>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>

                        <!-- Botones de acción mejorados -->
                        <div class="flex items-center gap-3 flex-wrap">
                            <!-- Botón Nuevo Departamento -->
                            <a href="<?php echo e(route('crear-departamento')); ?>" wire:navigate
                                class="group relative inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold text-sm rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <div class="absolute inset-0 bg-white/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Nuevo Departamento
                            </a>

                            <!-- Botón Manual de Usuario -->
                            <a href="" wire:navigate
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

            <!-- Barra de Filtros y Búsqueda Mejorada -->
            <div class="mb-8 bg-white p-5 rounded-2xl shadow-lg border border-gray-100/50">
                <div class="flex flex-col sm:flex-row items-center gap-4">
                    <div class="relative flex-grow w-full">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="search" id="busqueda" wire:model.live.debounce.300ms="busqueda"
                            placeholder="Buscar por nombre, puesto o descripción..."
                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl leading-5 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200">
                    </div>

                    <div class="flex items-center gap-4 w-full sm:w-auto">
                        <select id="filtroEmpresa" wire:model.live="filtroEmpresa"
                            class="w-full sm:w-56 rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500/50 py-3 transition-all duration-200">
                            <option value="">Todas las Empresas</option>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $empresasFiltro; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empresa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($empresa->id_empresa); ?>"><?php echo e($empresa->nombre_comercial); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </select>

                        <select id="filtroEstado" wire:model.live="filtroEstado"
                            class="w-full sm:w-48 rounded-xl border-gray-200 shadow-sm focus:border-indigo-500 focus:ring-indigo-500/50 py-3 transition-all duration-200">
                            <option value="">Todos los Estados</option>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $estadosFiltro; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($estado); ?>"><?php echo e(ucfirst($estado)); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </select>
                    </div>
                </div>
            </div>

            <!-- Tabla de Departamentos Mejorada -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100/50">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100/80">
                            <tr>
                                <!-- Columna: ID Departamento -->
                                <th scope="col" wire:click="ordenar('id_departamento')"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider cursor-pointer group transition-colors duration-200 hover:bg-gray-100/50">
                                    <div class="flex items-center">
                                        <span>ID</span>
                                        <!--[if BLOCK]><![endif]--><?php if($ordenarPor === 'id_departamento'): ?>
                                        <span class="ml-1 transform transition-transform duration-200 <?php echo e($direccionOrden === 'asc' ? 'rotate-0' : 'rotate-180'); ?>">
                                            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                            </svg>
                                        </span>
                                        <?php else: ?>
                                        <svg class="w-4 h-4 ml-1 text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                        </svg>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                </th>

                                <!-- Columna: Nombre Departamento -->
                                <th scope="col" wire:click="ordenar('nombre_departamento')"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider cursor-pointer group transition-colors duration-200 hover:bg-gray-100/50">
                                    <div class="flex items-center">
                                        <span>Departamento</span>
                                        <!--[if BLOCK]><![endif]--><?php if($ordenarPor === 'nombre_departamento'): ?>
                                        <span class="ml-1 transform transition-transform duration-200 <?php echo e($direccionOrden === 'asc' ? 'rotate-0' : 'rotate-180'); ?>">
                                            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                            </svg>
                                        </span>
                                        <?php else: ?>
                                        <svg class="w-4 h-4 ml-1 text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                        </svg>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                </th>

                                <!-- Columna: Descripción -->
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Descripción
                                </th>

                                <!-- Columna: Empresa -->
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Empresa
                                </th>

                                <!-- Columna: Puesto -->
                                <th scope="col" wire:click="ordenar('puesto')"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider cursor-pointer group transition-colors duration-200 hover:bg-gray-100/50">
                                    <div class="flex items-center">
                                        <span>Puesto Principal</span>
                                        <!--[if BLOCK]><![endif]--><?php if($ordenarPor === 'puesto'): ?>
                                        <span class="ml-1 transform transition-transform duration-200 <?php echo e($direccionOrden === 'asc' ? 'rotate-0' : 'rotate-180'); ?>">
                                            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                            </svg>
                                        </span>
                                        <?php else: ?>
                                        <svg class="w-4 h-4 ml-1 text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                        </svg>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                </th>

                                <!-- Columna: Fecha de Registro -->
                                <th scope="col" wire:click="ordenar('fecha_registro_departamento')"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider cursor-pointer group transition-colors duration-200 hover:bg-gray-100/50">
                                    <div class="flex items-center">
                                        <span>Fecha de Registro</span>
                                        <!--[if BLOCK]><![endif]--><?php if($ordenarPor === 'fecha_registro_departamento'): ?>
                                        <span class="ml-1 transform transition-transform duration-200 <?php echo e($direccionOrden === 'asc' ? 'rotate-0' : 'rotate-180'); ?>">
                                            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                            </svg>
                                        </span>
                                        <?php else: ?>
                                        <svg class="w-4 h-4 ml-1 text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                        </svg>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                </th>

                                <!-- Columna: Estado -->
                                <th scope="col" wire:click="ordenar('estado')"
                                    class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider cursor-pointer group transition-colors duration-200 hover:bg-gray-100/50">
                                    <div class="flex items-center justify-center">
                                        <span>Estado</span>
                                        <!--[if BLOCK]><![endif]--><?php if($ordenarPor === 'estado'): ?>
                                        <span class="ml-1 transform transition-transform duration-200 <?php echo e($direccionOrden === 'asc' ? 'rotate-0' : 'rotate-180'); ?>">
                                            <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                            </svg>
                                        </span>
                                        <?php else: ?>
                                        <svg class="w-4 h-4 ml-1 text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                        </svg>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                </th>

                                <!-- Columna: Acciones -->
                                <th scope="col" class="relative px-6 py-4">
                                    <span class="sr-only">Acciones</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $departamentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $departamento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr wire:key="<?php echo e($departamento->id_departamento); ?>"
                                class="hover:bg-gradient-to-r hover:from-indigo-50/30 hover:to-purple-50/20 transition-all duration-300 group">

                                <!-- Celda: ID Departamento -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 group-hover:text-indigo-700 transition-colors duration-200">
                                    <?php echo e($departamento->id_departamento); ?>

                                </td>

                                <!-- Celda: Nombre Departamento -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="h-12 w-12 rounded-xl bg-gradient-to-br from-indigo-100 to-purple-200 flex items-center justify-center text-indigo-700 font-bold flex-shrink-0 text-sm border border-indigo-200 group-hover:shadow-md transition-shadow duration-300">
                                            <?php echo e(strtoupper(substr($departamento->nombre_departamento, 0, 2))); ?>

                                        </span>
                                        <div class="ml-4">
                                            <div class="text-sm font-semibold text-gray-900 group-hover:text-indigo-700 transition-colors duration-200">
                                                <?php echo e($departamento->nombre_departamento); ?>

                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Celda: Descripción -->
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    <div class="max-w-xs" title="<?php echo e($departamento->descripcion); ?>">
                                        <?php echo e(\Illuminate\Support\Str::limit($departamento->descripcion, 60)); ?>

                                    </div>
                                </td>

                                <!-- Celda: Empresa -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <!--[if BLOCK]><![endif]--><?php if($departamento->empresa && $departamento->empresa->logo): ?>
                                        <div class="h-12 w-12 rounded-xl bg-white border border-gray-200 flex items-center justify-center p-1.5 flex-shrink-0 shadow-sm group-hover:shadow-md transition-shadow duration-300">
                                            <img
                                                src="<?php echo e(asset('storage/' . $departamento->empresa->logo)); ?>"
                                                alt="Logo de <?php echo e($departamento->empresa->nombre_comercial); ?>"
                                                class="max-h-full max-w-full object-contain rounded-lg">
                                        </div>
                                        <?php else: ?>
                                        <span class="h-12 w-12 rounded-xl bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center text-gray-600 font-bold flex-shrink-0 text-sm border border-gray-200 group-hover:shadow-md transition-shadow duration-300">
                                            <?php echo e($departamento->empresa ? strtoupper(substr($departamento->empresa->nombre_comercial, 0, 2)) : 'N/A'); ?>

                                        </span>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        <div class="ml-4">
                                            <div class="text-sm font-semibold text-gray-900 group-hover:text-indigo-700 transition-colors duration-200">
                                                <?php echo e($departamento->empresa->nombre_comercial ?? 'N/A'); ?>

                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Celda: Puesto -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono bg-gray-50/50 rounded-lg mx-2">
                                    <?php echo e($departamento->puesto); ?>

                                </td>

                                <!-- Celda: Fecha de Registro -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <?php echo e($departamento->fecha_registro_departamento ? $departamento->fecha_registro_departamento->format('d/m/Y') : 'N/A'); ?>

                                    </div>
                                </td>

                                <!-- Celda: Estado -->
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-3 py-1.5 inline-flex text-xs leading-5 font-semibold rounded-full shadow-sm transition-all duration-200
                                        <?php if($departamento->estado == 'activo'): ?> bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border border-green-200
                                        <?php else: ?> bg-gradient-to-r from-red-100 to-rose-100 text-red-800 border border-red-200
                                        <?php endif; ?>">
                                        <?php echo e(ucfirst($departamento->estado)); ?>

                                    </span>
                                </td>

                                <!-- Celda: Acciones -->
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <!-- Botón Ver -->
                                        <a
                                            href="<?php echo e(route('ver-departamento', $departamento)); ?>"
                                            wire:navigate
                                            class="group relative inline-flex items-center p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-all duration-200 hover:scale-110 hover:shadow-md"
                                            title="Ver detalles">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-all duration-200 whitespace-nowrap shadow-lg">
                                                Ver detalles
                                                <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1 w-2 h-2 bg-gray-800 rotate-45"></span>
                                            </span>
                                        </a>

                                        <!-- Botón Editar -->
                                        <a
                                            href="<?php echo e(route('editar-departamento', $departamento)); ?>"
                                            wire:navigate
                                            class="group relative inline-flex items-center p-2 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-100 transition-all duration-200 hover:scale-110 hover:shadow-md"
                                            title="Editar departamento">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-all duration-200 whitespace-nowrap shadow-lg">
                                                Editar
                                                <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1 w-2 h-2 bg-gray-800 rotate-45"></span>
                                            </span>
                                        </a>

                                        <!-- Botón Eliminar -->
                                        <button
                                            x-data
                                            @click="$dispatch('confirm-delete', { id: <?php echo e($departamento->id_departamento); ?> })"
                                            class="group relative inline-flex items-center p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-all duration-200 hover:scale-110 hover:shadow-md"
                                            title="Eliminar departamento">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-all duration-200 whitespace-nowrap shadow-lg">
                                                Eliminar
                                                <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1 w-2 h-2 bg-gray-800 rotate-45"></span>
                                            </span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <div class="text-center">
                                        <div class="mx-auto h-16 w-16 bg-gradient-to-r from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-4">
                                            <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                            </svg>
                                        </div>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">No se encontraron departamentos</h3>
                                        <p class="mt-1 text-sm text-gray-500">Intenta ajustar tu búsqueda o filtros.</p>
                                    </div>
                                </td>
                            </tr>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Acciones Post-Tabla y Paginación Mejoradas -->
            <div class="mt-8 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-3 flex-wrap">
                    <span class="text-sm font-medium text-gray-600">Exportar vista actual:</span>
                    <button
                        wire:click="exportarZip"
                        wire:loading.attr="disabled"
                        wire:target="exportarZip"
                        title="Descargar todo en un archivo ZIP"
                        class="group relative inline-flex items-center justify-center px-4 py-2.5 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold text-sm rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">
                        <div class="absolute inset-0 bg-white/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <i class="fas fa-file-archive mr-2"></i>
                        <span wire:loading.remove wire:target="exportarZip">Descargar Todo (.zip)</span>
                        <span wire:loading wire:target="exportarZip">Generando...</span>
                    </button>

                    <button
                        wire:click="exportarExcel"
                        wire:loading.attr="disabled"
                        wire:target="exportarExcel"
                        title="Exportar a Excel"
                        class="group relative inline-flex items-center justify-center px-4 py-2.5 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold text-sm rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">
                        <div class="absolute inset-0 bg-white/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <i class="fas fa-file-excel mr-2"></i>
                        <span wire:loading.remove wire:target="exportarExcel">Exportar Excel</span>
                        <span wire:loading wire:target="exportarExcel">Exportando...</span>
                    </button>

                    <button
                        wire:click="exportarPdf"
                        wire:loading.attr="disabled"
                        wire:target="exportarPdf"
                        title="Exportar a PDF"
                        class="group relative inline-flex items-center justify-center px-4 py-2.5 bg-gradient-to-r from-red-500 to-rose-600 text-white font-semibold text-sm rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">
                        <div class="absolute inset-0 bg-white/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <i class="fas fa-file-pdf mr-2"></i>
                        <span wire:loading.remove wire:target="exportarPdf">Exportar PDF</span>
                        <span wire:loading wire:target="exportarPdf">Exportando...</span>
                    </button>
                </div>

                <div class="w-full sm:w-auto">
                    <?php echo e($departamentos->links()); ?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('show-swal-delete', (event) => {
            const data = event[0];
            Swal.fire({
                title: data.title,
                text: data.text,
                icon: data.icon,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, ¡eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('delete-confirmed', {
                        id: data.id
                    });
                }
            });
        });
    });
</script>
<?php $__env->stopPush(); ?><?php /**PATH D:\laragon\www\encuesta-pro360\resources\views/livewire/encuesta/departamento/mostrar-departamento.blade.php ENDPATH**/ ?>