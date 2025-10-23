<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        <!-- Header -->
        <header class="mb-8">
            <div class="bg-white p-6 rounded-xl shadow-md">
                <div class="flex items-center space-x-3">
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-full w-12 h-12 flex items-center justify-center text-2xl">
                        👥
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">Asignar Roles a Usuarios</h1>
                        <p class="text-sm text-indigo-600 font-semibold">Gestiona los permisos de cada usuario</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Mensajes Flash -->
        <!--[if BLOCK]><![endif]--><?php if(session()->has('mensaje')): ?>
        <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg shadow-md">
            <div class="flex items-center">
                <span class="text-2xl mr-3">✅</span>
                <p class="font-medium"><?php echo e(session('mensaje')); ?></p>
            </div>
        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <?php if(session()->has('error')): ?>
        <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-md">
            <div class="flex items-center">
                <span class="text-2xl mr-3">⚠️</span>
                <p class="font-medium"><?php echo e(session('error')); ?></p>
            </div>
        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <!-- Filtros -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">🔍 Buscar Usuario</label>
                    <input type="text" wire:model.live.debounce.300ms="busqueda"
                        placeholder="Nombre, email o apellido..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">🎭 Filtrar por Rol</label>
                    <select wire:model.live="rolFiltro"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Todos los roles</option>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($rol->name); ?>"><?php echo e($rol->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </select>
                </div>
            </div>
        </div>

        <!-- Estadísticas Rápidas -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-xl p-6 shadow-lg">
                <div class="text-sm opacity-90 mb-1">Total Usuarios</div>
                <div class="text-3xl font-bold"><?php echo e($usuarios->total()); ?></div>
            </div>
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $roles->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-white rounded-xl p-6 shadow-lg border-l-4 border-indigo-500">
                <div class="text-sm text-gray-600 mb-1"><?php echo e($rol->name); ?></div>
                <div class="text-3xl font-bold text-indigo-600"><?php echo e($rol->users->count()); ?></div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <!-- Tabla de Usuarios -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-indigo-50 to-purple-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Usuario
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Información
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Roles Actuales
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $usuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <!-- Usuario -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12">
                                        <!--[if BLOCK]><![endif]--><?php if($usuario->profile_photo_path): ?>
                                        <img class="h-12 w-12 rounded-full object-cover"
                                            src="<?php echo e(asset('storage/' . $usuario->profile_photo_path)); ?>"
                                            alt="<?php echo e($usuario->name); ?>">
                                        <?php else: ?>
                                        <div class="h-12 w-12 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-lg">
                                            <?php echo e(substr($usuario->name, 0, 1)); ?>

                                        </div>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900">
                                            <?php echo e($usuario->name); ?> <?php echo e($usuario->primer_apellido); ?>

                                        </div>
                                        <div class="text-xs text-gray-500"><?php echo e($usuario->email); ?></div>
                                    </div>
                                </div>
                            </td>

                            <!-- Información -->
                            <td class="px-6 py-4">
                                <div class="text-sm">
                                    <div class="font-medium text-gray-900"><?php echo e($usuario->puesto ?? 'Sin puesto'); ?></div>
                                    <div class="text-gray-500">
                                        <?php echo e($usuario->departamento->nombre_departamento ?? 'Sin departamento'); ?>

                                    </div>
                                    <div class="text-xs text-gray-400">
                                        <?php echo e($usuario->departamento->empresa->nombre_comercial ?? ''); ?>

                                    </div>
                                </div>
                            </td>

                            <!-- Roles Actuales -->
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-2">
                                    <!--[if BLOCK]><![endif]--><?php $__empty_2 = true; $__currentLoopData = $usuario->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-800">
                                        <span class="mr-1">🎭</span> <?php echo e($rol->name); ?>

                                    </span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                                        Sin roles asignados
                                    </span>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </td>

                            <!-- Acciones -->
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <button wire:click="abrirModal(<?php echo e($usuario->id); ?>)"
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-1">
                                        ✏️ Gestionar
                                    </button>
                                    <!--[if BLOCK]><![endif]--><?php if($usuario->roles->count() > 0): ?>
                                    <button wire:click="removerTodosLosRoles(<?php echo e($usuario->id); ?>)"
                                        wire:confirm="¿Remover todos los roles de <?php echo e($usuario->name); ?>?"
                                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center gap-1">
                                        🗑️ Limpiar
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
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                    <p class="text-lg">No se encontraron usuarios</p>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                <?php echo e($usuarios->links()); ?>

            </div>
        </div>

        <!-- Modal Asignar Roles -->
        <!--[if BLOCK]><![endif]--><?php if($modalAbierto && $usuarioSeleccionado): ?>
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">

                <!-- Overlay -->
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="cerrarModal"></div>

                <!-- Modal Panel -->
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">

                        <!-- Header del Modal -->
                        <div class="flex items-start justify-between mb-6">
                            <div class="flex items-center space-x-4">
                                <!--[if BLOCK]><![endif]--><?php if($usuarioSeleccionado->profile_photo_path): ?>
                                <img class="h-16 w-16 rounded-full object-cover"
                                    src="<?php echo e(asset('storage/' . $usuarioSeleccionado->profile_photo_path)); ?>"
                                    alt="<?php echo e($usuarioSeleccionado->name); ?>">
                                <?php else: ?>
                                <div class="h-16 w-16 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-2xl">
                                    <?php echo e(substr($usuarioSeleccionado->name, 0, 1)); ?>

                                </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <div>
                                    <h3 class="text-2xl font-bold text-gray-900">
                                        <?php echo e($usuarioSeleccionado->name); ?> <?php echo e($usuarioSeleccionado->primer_apellido); ?>

                                    </h3>
                                    <p class="text-sm text-gray-500"><?php echo e($usuarioSeleccionado->email); ?></p>
                                    <p class="text-xs text-gray-400"><?php echo e($usuarioSeleccionado->puesto); ?></p>
                                </div>
                            </div>
                            <button wire:click="cerrarModal" class="text-gray-400 hover:text-gray-500">
                                <span class="text-3xl">×</span>
                            </button>
                        </div>

                        <!-- Formulario -->
                        <form wire:submit="guardarRoles">
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    🎭 Selecciona los Roles
                                </label>
                                <div class="grid grid-cols-1 gap-3 max-h-96 overflow-y-auto p-4 bg-gray-50 rounded-lg">
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <label class="flex items-start space-x-3 cursor-pointer hover:bg-white p-4 rounded-lg border-2 transition-all
                                        <?php echo e(in_array($rol->name, $rolesSeleccionados) ? 'border-indigo-500 bg-indigo-50' : 'border-gray-200'); ?>">
                                        <input type="checkbox"
                                            wire:model="rolesSeleccionados"
                                            value="<?php echo e($rol->name); ?>"
                                            class="w-5 h-5 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500 mt-1">
                                        <div class="flex-1">
                                            <div class="font-semibold text-gray-900"><?php echo e($rol->name); ?></div>
                                            <div class="text-xs text-gray-500 mt-1">
                                                <?php echo e($rol->permissions->count()); ?> permisos asignados
                                            </div>
                                            <div class="flex flex-wrap gap-1 mt-2">
                                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $rol->permissions->take(4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permiso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-gray-200 text-gray-700">
                                                    <?php echo e($permiso->name); ?>

                                                </span>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                                <!--[if BLOCK]><![endif]--><?php if($rol->permissions->count() > 4): ?>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-gray-300 text-gray-700">
                                                    +<?php echo e($rol->permissions->count() - 4); ?>

                                                </span>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                        </div>
                                    </label>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                                <p class="mt-3 text-sm text-gray-600">
                                    Roles seleccionados: <strong class="text-indigo-600"><?php echo e(count($rolesSeleccionados)); ?></strong>
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
                                    Guardar Cambios
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    </div>
</div><?php /**PATH D:\laragon\www\encuesta-pro360\resources\views/livewire/encuesta/rolesx/asignar-roles.blade.php ENDPATH**/ ?>