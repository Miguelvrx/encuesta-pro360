<div>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-white py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">

            <!-- Cabecera -->
            <header class="mb-8">
                <div class="flex justify-between items-center bg-white p-6 rounded-xl shadow-md">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">Papelera de Reciclaje</h1>
                        <p class="mt-1 text-sm text-gray-500">Empresas eliminadas recientemente.</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <!-- Botón Vaciar Papelera -->
                        <button
                            x-data
                            @click="$dispatch('confirm-empty-trash')"
                            class="inline-flex items-center px-4 py-2 bg-red-600 text-white font-semibold text-sm rounded-lg shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Vaciar Papelera
                        </button>

                        <!-- Botón Volver -->
                        <a href="<?php echo e(route('mostrar-empresa')); ?>" wire:navigate class="inline-flex items-center px-4 py-2 bg-gray-600 text-white font-semibold text-sm rounded-lg shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Volver
                        </a>
                    </div>
                </div>
            </header>

            <!-- Barra de Búsqueda -->
            <div class="mb-6">
                <div class="relative max-w-md">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="search" wire:model.live.debounce.300ms="busqueda" placeholder="Buscar empresas eliminadas..." class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <!-- Tabla de Empresas Eliminadas -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" wire:click="ordenar('nombre_comercial')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                    Empresa
                                </th>
                                <th scope="col" wire:click="ordenar('rfc')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                    RFC
                                </th>
                                <th scope="col" wire:click="ordenar('sector')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                    Sector
                                </th>
                                <th scope="col" wire:click="ordenar('deleted_at')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                    Eliminado el
                                </th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $empresas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empresa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <!--[if BLOCK]><![endif]--><?php if($empresa->logo): ?>
                                        <div class="h-10 w-10 rounded-lg bg-white border border-gray-200 flex items-center justify-center p-1 flex-shrink-0">
                                            <img src="<?php echo e(asset('storage/' . $empresa->logo)); ?>" alt="Logo" class="max-h-full max-w-full object-contain">
                                        </div>
                                        <?php else: ?>
                                        <span class="h-10 w-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-600 font-bold flex-shrink-0 text-sm">
                                            <?php echo e(strtoupper(substr($empresa->nombre_comercial, 0, 2))); ?>

                                        </span>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900"><?php echo e($empresa->nombre_comercial); ?></div>
                                            <div class="text-sm text-gray-500"><?php echo e($empresa->razon_social); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">
                                    <?php echo e($empresa->rfc); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?php echo e($empresa->sector); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <?php echo e($empresa->deleted_at->format('d/m/Y H:i')); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <!-- Botón Restaurar -->
                                        <button
                                            wire:click="restaurarEmpresa(<?php echo e($empresa->id_empresa); ?>)"
                                            wire:confirm="¿Restaurar esta empresa?"
                                            class="inline-flex items-center p-2 bg-green-50 text-green-600 rounded-lg hover:bg-green-100 transition-colors duration-200"
                                            title="Restaurar empresa">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6" />
                                            </svg>
                                        </button>

                                        <!-- Botón Eliminar Permanentemente -->
                                        <button
                                            x-data
                                            @click="$dispatch('confirm-delete-permanent', { id: <?php echo e($empresa->id_empresa); ?> })"
                                            class="inline-flex items-center p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors duration-200"
                                            title="Eliminar permanentemente">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">Papelera vacía</h3>
                                        <p class="mt-1 text-sm text-gray-500">No hay empresas eliminadas.</p>
                                    </div>
                                </td>
                            </tr>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Paginación -->
            <div class="mt-6">
                <?php echo e($empresas->links()); ?>

            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('livewire:init', () => {
        // Escuchar eventos despachados desde Alpine.js (usando window)
        window.addEventListener('confirm-empty-trash', () => {
            Swal.fire({
                title: '¿Vaciar papelera?',
                text: "¡Esta acción eliminará permanentemente todas las empresas en la papelera!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, vaciar papelera',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('empty-trash-confirmed');
                }
            });
        });

        window.addEventListener('confirm-delete-permanent', (event) => {
            const id = event.detail.id;
            Swal.fire({
                title: '¿Eliminar permanentemente?',
                text: "¡Esta acción no se puede deshacer! La empresa se eliminará para siempre.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar permanentemente',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.dispatch('delete-permanent-confirmed', {
                        id: id
                    });
                }
            });
        });
    });
</script><?php /**PATH D:\laragon\www\encuesta-pro360\resources\views/livewire/encuesta/papelera-empresas.blade.php ENDPATH**/ ?>