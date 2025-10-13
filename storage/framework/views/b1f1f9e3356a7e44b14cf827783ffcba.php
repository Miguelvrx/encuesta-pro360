<div>
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

        <!-- Cabecera -->
        <header class="mb-8">
            <div class="flex justify-between items-center bg-white p-6 rounded-xl shadow-md">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Listado de Usuarios</h1>
                    <p class="mt-1 text-sm text-gray-500">Gestiona los usuarios del sistema.</p>
                </div>
                <a href="<?php echo e(route('crear-usuario')); ?>" wire:navigate class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold text-sm rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.5a2.25 2.25 0 0 1 2.25-2.25H18.75a2.25 2.25 0 0 1 2.25 2.25V21" />
                    </svg>
                    Nuevo Usuario
                </a>
            </div>
        </header>

        <!-- Barra de Filtros -->
        <div class="mb-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="col-span-1 sm:col-span-2">
                <input type="search" wire:model.live.debounce.300ms="busqueda" placeholder="Buscar por nombre, apellido o email..." class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div>
                <select wire:model.live="filtroEmpresa" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Todas las Empresas</option>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $empresasFiltro; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empresa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($empresa->id_empresa); ?>"><?php echo e($empresa->nombre_comercial); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </select>
            </div>
            <div>
                <select wire:model.live="filtroRol" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Todos los Roles</option>
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $rolesFiltro; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $nombre): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($id); ?>"><?php echo e($nombre); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </select>
            </div>
        </div>

        <!-- Tabla de Usuarios -->
        

        <!-- Tabla de Usuarios -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            

                            
                            <th scope="col" wire:click="ordenar('name')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                Nombre <!--[if BLOCK]><![endif]--><?php if($ordenarPor === 'name'): ?><span><?php echo e($direccionOrden === 'asc' ? '▲' : '▼'); ?></span><?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </th>

                            
                            <th scope="col" wire:click="ordenar('email')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                Email <!--[if BLOCK]><![endif]--><?php if($ordenarPor === 'email'): ?><span><?php echo e($direccionOrden === 'asc' ? '▲' : '▼'); ?></span><?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </th>

                            
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Empresa
                            </th>

                            
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Departamento
                            </th>

                            
                            <th scope="col" wire:click="ordenar('puesto')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                Puesto <!--[if BLOCK]><![endif]--><?php if($ordenarPor === 'puesto'): ?><span><?php echo e($direccionOrden === 'asc' ? '▲' : '▼'); ?></span><?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </th>

                            
                            <th scope="col" wire:click="ordenar('rol')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                Rol <!--[if BLOCK]><![endif]--><?php if($ordenarPor === 'rol'): ?><span><?php echo e($direccionOrden === 'asc' ? '▲' : '▼'); ?></span><?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </th>

                            
                            <th scope="col" wire:click="ordenar('estado')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                Estado <!--[if BLOCK]><![endif]--><?php if($ordenarPor === 'estado'): ?><span><?php echo e($direccionOrden === 'asc' ? '▲' : '▼'); ?></span><?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </th>

                            
                            <th scope="col" class="relative px-6 py-3"><span class="sr-only">Acciones</span></th>

                            
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr wire:key="<?php echo e($usuario->id); ?>" class="hover:bg-gray-50">

                            

                            
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <img class="h-10 w-10 rounded-full object-cover" src="<?php echo e($usuario->profile_photo_url); ?>" alt="<?php echo e($usuario->name); ?>">
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900"><?php echo e($usuario->name); ?> <?php echo e($usuario->primer_apellido); ?></div>
                                        <div class="text-sm text-gray-500"><?php echo e($usuario->puesto); ?></div>
                                    </div>
                                </div>
                            </td>

                            
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e($usuario->email); ?>

                            </td>

                            
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e($usuario->departamento->empresa->nombre_comercial ?? 'N/A'); ?>

                            </td>

                            
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e($usuario->departamento->nombre_departamento ?? 'N/A'); ?>

                            </td>

                            
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e($usuario->puesto); ?>

                            </td>

                            
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e($rolesFiltro[$usuario->rol] ?? 'Rol Desconocido'); ?>

                            </td>

                            
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?php echo e($usuario->estado == 'activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                    <?php echo e(ucfirst($usuario->estado)); ?>

                                </span>
                            </td>

                            
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="<?php echo e(route('ver-usuario', $usuario)); ?>" wire:navigate class="text-blue-600 hover:text-blue-900">Ver</a>
                                <a href="<?php echo e(route('editar-usuario', $usuario)); ?>" wire:navigate class="ml-4 text-indigo-600 hover:text-indigo-900">Editar</a>
                                <button
                                    x-data
                                    @click="$dispatch('confirm-delete', { id: <?php echo e($usuario->id); ?> })"
                                    class="ml-4 text-red-600 hover:text-red-900 font-medium">
                                    Eliminar
                                </button>
                            </td>

                            
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            
                            <td colspan="8" class="px-6 py-12 text-center">
                                <h3 class="text-sm font-medium text-gray-900">No se encontraron usuarios</h3>
                                <p class="mt-1 text-sm text-gray-500">Intenta ajustar tu búsqueda o crea un nuevo usuario.</p>
                            </td>
                        </tr>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 4. Acciones Post-Tabla y Paginación -->
        <div class="mt-6 flex flex-col sm:flex-row justify-between items-center gap-4">

            
            <div class="flex items-center gap-2">
                <span class="text-sm font-medium text-gray-600">Exportar vista actual:</span>

                
                <button
                    wire:click="exportarZip"
                    wire:loading.attr="disabled" wire:target="exportarZip"
                    title="Descargar todo en un archivo ZIP"
                    class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white font-semibold text-sm rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 ease-in-out transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="fas fa-file-archive mr-2"></i>
                    <span wire:loading.remove wire:target="exportarZip">Descargar Todo (.zip)</span>
                    <span wire:loading wire:target="exportarZip">Generando...</span>
                </button>

                
                <div class="border-l pl-3 ml-1 flex items-center gap-3">
                    <button
                        wire:click="exportarExcel"
                        wire:loading.attr="disabled" wire:target="exportarExcel"
                        title="Exportar solo a Excel"
                        class="inline-flex items-center justify-center p-2 bg-green-600 text-white rounded-lg shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 ease-in-out transform hover:scale-110 disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-file-archive mr-2"></i>
                        <span wire:loading.remove wire:target="exportarExcel">Exportar Excel</span>
                    </button>
                    <button
                        wire:click="exportarPdf"
                        wire:loading.attr="disabled" wire:target="exportarPdf"
                        title="Exportar solo a PDF"
                        class="inline-flex items-center justify-center p-2 bg-red-600 text-white rounded-lg shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200 ease-in-out transform hover:scale-110 disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-file-archive mr-2"></i>
                        <span wire:loading.remove wire:target="exportarPdf">Exportar PDF</span>
                    </button>
                </div>
            </div>


            <!-- Paginación -->
            <div class="mt-6">
                <?php echo e($usuarios->links()); ?>

            </div>
        </div>
    </div>


    <?php $__env->startPush('scripts'); ?>
    <script>
        // Nos aseguramos de que este script se ejecute después de que Livewire se haya inicializado.
        document.addEventListener('livewire:init', () => {

            // Listener para el modal de confirmación de eliminación
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
                        // Si se confirma, despachamos el evento final que el backend escuchará.
                        Livewire.dispatch('delete-confirmed', {
                            id: data.id
                        });
                    }
                });
            });
        });
    </script>
    <?php $__env->stopPush(); ?><?php /**PATH D:\laragon\www\encuesta-pro360\resources\views/livewire/encuesta/usuario/mostrar-usuario.blade.php ENDPATH**/ ?>