<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        <!-- Header -->
        <header class="mb-8">
            <div class="flex flex-col md:flex-row justify-between items-center bg-white p-6 rounded-xl shadow-md">
                <div>
                    <div class="flex items-center space-x-3">
                        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white rounded-full w-12 h-12 flex items-center justify-center text-2xl">
                            🔐
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800">Gestión de Roles y Permisos</h1>
                            <p class="text-sm text-indigo-600 font-semibold">Control de acceso del sistema</p>
                        </div>
                    </div>
                </div>
                <div class="mt-4 md:mt-0">
                    <button wire:click="abrirModal"
                        class="bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white px-6 py-3 rounded-lg font-medium shadow-lg transition-all flex items-center gap-2">
                        <span class="text-xl">➕</span> Crear Nuevo Rol
                    </button>
                </div>
            </div>
        </header>

        <!-- Mensajes Flash -->
        <!--[if BLOCK]><![endif]--><?php if(session()->has('mensaje')): ?>
        <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-md animate-fade-in">
            <div class="flex items-center">
                <span class="text-2xl mr-3">✅</span>
                <p class="font-medium"><?php echo e(session('mensaje')); ?></p>
            </div>
        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <?php if(session()->has('error')): ?>
        <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-md animate-fade-in">
            <div class="flex items-center">
                <span class="text-2xl mr-3">⚠️</span>
                <p class="font-medium"><?php echo e(session('error')); ?></p>
            </div>
        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <!-- Búsqueda y Filtros -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">🔍 Buscar Rol</label>
                    <input type="text" wire:model.live.debounce.300ms="busqueda"
                        placeholder="Nombre del rol..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>
        </div>

        <!-- Tabla de Roles -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-indigo-50 to-purple-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Rol
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Permisos Asignados
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Usuarios
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold">
                                        <?php echo e(substr($role->name, 0, 1)); ?>

                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900"><?php echo e($role->name); ?></div>
                                        <div class="text-xs text-gray-500">Creado: <?php echo e($role->created_at->format('d/m/Y')); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    <!--[if BLOCK]><![endif]--><?php if($role->permissions->count() > 0): ?>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $role->permissions->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permiso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                        <?php echo e($permiso->name); ?>

                                    </span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($role->permissions->count() > 3): ?>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        +<?php echo e($role->permissions->count() - 3); ?> más
                                    </span>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <?php else: ?>
                                    <span class="text-sm text-gray-400">Sin permisos asignados</span>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-purple-100 text-purple-800 font-bold">
                                    <?php echo e($role->users->count()); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button wire:click="editar(<?php echo e($role->id); ?>)"
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-1">
                                        ✏️ Editar
                                    </button>
                                    <!--[if BLOCK]><![endif]--><?php if(!in_array($role->name, ['Super Admin', 'Administrador'])): ?>
                                    <button wire:click="eliminar(<?php echo e($role->id); ?>)"
                                        wire:confirm="¿Estás seguro de eliminar este rol?"
                                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-1">
                                        🗑️ Eliminar
                                    </button>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="text-gray-400">
                                    <svg class="mx-auto h-12 w-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                    <p class="text-lg">No se encontraron roles</p>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <?php echo e($roles->links()); ?>

            </div>
        </div>

        <!-- Modal Crear/Editar -->
        <!--[if BLOCK]><![endif]--><?php if($modalAbierto): ?>
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                <!-- Overlay -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="cerrarModal"></div>

                <!-- Modal Panel -->
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="flex items-start justify-between mb-6">
                            <div class="flex items-center space-x-3">
                                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-full w-12 h-12 flex items-center justify-center text-2xl">
                                    <?php echo e($roleIdEditar ? '✏️' : '➕'); ?>

                                </div>
                                <h3 class="text-2xl font-bold text-gray-900">
                                    <?php echo e($roleIdEditar ? 'Editar Rol' : 'Crear Nuevo Rol'); ?>

                                </h3>
                            </div>
                            <button wire:click="cerrarModal" class="text-gray-400 hover:text-gray-500">
                                <span class="text-2xl">×</span>
                            </button>
                        </div>

                        <form wire:submit="guardar">
                            <!-- Nombre del Rol -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Nombre del Rol <span class="text-red-500">*</span>
                                </label>
                                <input type="text" wire:model="nombre"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    placeholder="Ej: Supervisor, Auditor, etc.">
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <p class="mt-2 text-sm text-red-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>

                            <!-- Permisos -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    Permisos Asignados
                                </label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-h-96 overflow-y-auto p-4 bg-gray-50 rounded-lg">
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $permisosAgrupados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria => $permisos): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="bg-white rounded-lg p-4 border border-gray-200">
                                        <div class="flex items-center justify-between mb-3">
                                            <h4 class="font-semibold text-gray-800 capitalize">
                                                📁 <?php echo e(ucfirst($categoria)); ?>

                                            </h4>
                                            <button type="button"
                                                wire:click="togglePermiso('<?php echo e($categoria); ?>')"
                                                class="text-xs text-indigo-600 hover:text-indigo-800 font-medium">
                                                Seleccionar todos
                                            </button>
                                        </div>
                                        <div class="space-y-2">
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $permisos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permiso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <label class="flex items-center space-x-2 cursor-pointer hover:bg-indigo-50 p-2 rounded">
                                                <input type="checkbox"
                                                    wire:model="permisosSeleccionados"
                                                    value="<?php echo e($permiso->name); ?>"
                                                    class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                                <span class="text-sm text-gray-700"><?php echo e($permiso->name); ?></span>
                                            </label>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                                <p class="mt-2 text-sm text-gray-500">
                                    Permisos seleccionados: <strong><?php echo e(count($permisosSeleccionados)); ?></strong>
                                </p>
                            </div>

                            <!-- Botones -->
                            <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                                <button type="button" wire:click="cerrarModal"
                                    class="px-6 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors">
                                    Cancelar
                                </button>
                                <button type="submit"
                                    class="px-6 py-2 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white rounded-lg font-medium transition-all shadow-lg">
                                    <?php echo e($roleIdEditar ? 'Actualizar Rol' : 'Crear Rol'); ?>

                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    </div>
</div><?php /**PATH D:\laragon\www\encuesta-pro360\resources\views/livewire/encuesta/rolesx/gestion-roles.blade.php ENDPATH**/ ?>