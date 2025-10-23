<div>
    <div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

        <!-- Botón para volver al listado -->
        <div class="mb-6">
            <a href="<?php echo e(route('mostrar-usuario')); ?>" wire:navigate class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-900">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver al Listado de Usuarios
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <!-- Cabecera del Perfil -->
            <div class="bg-gray-50 p-6 border-b border-gray-200">
                <div class="flex items-center">
                    <img class="h-24 w-24 rounded-full object-cover ring-4 ring-blue-200" src="<?php echo e($user->profile_photo_url); ?>" alt="<?php echo e($user->name); ?>">
                    <div class="ml-6">
                        <h1 class="text-3xl font-bold text-gray-900"><?php echo e($user->name); ?> <?php echo e($user->primer_apellido); ?></h1>
                        <p class="text-lg text-gray-600"><?php echo e($user->puesto); ?></p>
                        <span class="mt-2 inline-flex items-center px-3 py-1 text-sm font-semibold rounded-full <?php echo e($user->estado == 'activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                            <?php echo e(ucfirst($user->estado)); ?>

                        </span>
                    </div>
                </div>
            </div>

            <!-- Cuerpo con Detalles -->
            <div class="p-6">
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-8">

                    
                    <div class="sm:col-span-2">
                        <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Información de Contacto</h3>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Correo Electrónico</dt>
                        <dd class="mt-1 text-sm text-gray-900"><?php echo e($user->email); ?></dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Teléfono</dt>
                        <dd class="mt-1 text-sm text-gray-900"><?php echo e($user->telefono ?? 'No especificado'); ?></dd>
                    </div>

                    
                    <div class="sm:col-span-2 mt-4">
                        <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Organización</h3>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Empresa</dt>
                        <dd class="mt-1 text-sm text-gray-900"><?php echo e($user->departamento->empresa->nombre_comercial ?? 'No asignada'); ?></dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Departamento</dt>
                        <dd class="mt-1 text-sm text-gray-900"><?php echo e($user->departamento->nombre_departamento ?? 'No asignado'); ?></dd>
                    </div>

                    
                    <div class="sm:col-span-2 mt-4">
                        <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Detalles del Sistema</h3>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Rol</dt>
                        <dd class="mt-1 text-sm text-gray-900"><?php echo e($roles[$user->rol] ?? 'Desconocido'); ?></dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Miembro desde</dt>
                        <dd class="mt-1 text-sm text-gray-900"><?php echo e($user->created_at->format('d \d\e F \d\e Y')); ?></dd>
                    </div>

                    
                    <div class="sm:col-span-2 mt-4">
                        <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Información Adicional</h3>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Género</dt>
                        <dd class="mt-1 text-sm text-gray-900"><?php echo e(ucfirst($user->genero) ?? 'No especificado'); ?></dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Escolaridad</dt>
                        <dd class="mt-1 text-sm text-gray-900"><?php echo e($user->escolaridad ?? 'No especificada'); ?></dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</div><?php /**PATH D:\laragon\www\encuesta-pro360\resources\views/livewire/encuesta/usuario/ver-usuario.blade.php ENDPATH**/ ?>