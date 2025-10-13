<div>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-white py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">

            <!-- Botón para volver al listado -->
            <div class="mb-6">
                <a href="<?php echo e(route('mostrar-empresa')); ?>" wire:navigate class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-900">
                    <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                    Volver al listado de empresas
                </a>
            </div>

            <!-- Contenedor Principal de la Ficha -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">

                <!-- Cabecera de la Ficha -->
                <div class="p-6 sm:flex sm:items-center sm:justify-between bg-gray-50 border-b border-gray-200">
                    <div class="flex items-center">
                        <!--[if BLOCK]><![endif]--><?php if($empresa->logo): ?>
                        <div class="h-20 w-20 rounded-lg bg-white border-2 border-gray-200 flex items-center justify-center p-2 shadow-sm">
                            <img
                                class="max-h-full max-w-full object-contain"
                                src="<?php echo e(asset('storage/' . $empresa->logo)); ?>"
                                alt="Logo de <?php echo e($empresa->nombre_comercial); ?>">
                        </div>
                        <?php else: ?>
                        <span class="h-20 w-20 rounded-lg bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center text-gray-600 text-2xl font-bold shadow-sm border-2 border-gray-200">
                            <?php echo e(strtoupper(substr($empresa->nombre_comercial, 0, 2))); ?>

                        </span>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <div class="ml-4">
                            <h1 class="text-2xl font-bold text-gray-900"><?php echo e($empresa->nombre_comercial); ?></h1>
                            <p class="text-sm text-gray-600"><?php echo e($empresa->razon_social); ?></p>
                        </div>
                    </div>
                    <div class="mt-4 sm:mt-0">
                        <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full 
                        <?php if($empresa->estado_inicial == 'Activo'): ?> bg-green-100 text-green-800 <?php endif; ?>
                        <?php if($empresa->estado_inicial == 'Inactivo'): ?> bg-red-100 text-red-800 <?php endif; ?>
                        <?php if($empresa->estado_inicial == 'En Proceso'): ?> bg-yellow-100 text-yellow-800 <?php endif; ?>
                        <?php if($empresa->estado_inicial == 'Suspendido'): ?> bg-gray-100 text-gray-800 <?php endif; ?>
                    ">
                            <?php echo e($empresa->estado_inicial); ?>

                        </span>
                    </div>
                </div>

                <!-- Cuerpo de la Ficha con la Información -->
                <div class="p-6">
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">

                        <!-- Sección de Información General -->
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Sector</dt>
                            <dd class="mt-1 text-sm text-gray-900"><?php echo e($empresa->sector); ?></dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Tipo de Organización</dt>
                            <dd class="mt-1 text-sm text-gray-900"><?php echo e($empresa->tipo_organizacion); ?></dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Número de Empleados</dt>
                            <dd class="mt-1 text-sm text-gray-900"><?php echo e($empresa->numero_empleados); ?></dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Fecha de Registro</dt>
                            <dd class="mt-1 text-sm text-gray-900"><?php echo e($empresa->fecha_registro->format('d/m/Y')); ?></dd>
                        </div>
                        <div class="sm:col-span-1">
                            <dt class="text-sm font-medium text-gray-500">Año en el mercado</dt>
                            <dd class="mt-1 text-sm text-gray-900"><?php echo e($empresa->ano_mercado); ?></dd>
                        </div>

                        <!-- Sección de Información Fiscal y Ubicación -->
                        <div class="sm:col-span-2 pt-6 border-t border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Información Fiscal y Ubicación</h3>
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">RFC</dt>
                                    <dd class="mt-1 text-sm text-gray-900"><?php echo e($empresa->rfc); ?></dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">País</dt>
                                    <dd class="mt-1 text-sm text-gray-900"><?php echo e($empresa->pais); ?></dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Estado</dt>
                                    <dd class="mt-1 text-sm text-gray-900"><?php echo e($empresa->estado); ?></dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Ciudad</dt>
                                    <dd class="mt-1 text-sm text-gray-900"><?php echo e($empresa->ciudad); ?></dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Municipio</dt>
                                    <dd class="mt-1 text-sm text-gray-900"><?php echo e($empresa->municipio ?? '-'); ?></dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Código Postal</dt>
                                    <dd class="mt-1 text-sm text-gray-900"><?php echo e($empresa->codigo_postal); ?></dd>
                                </div>
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Dirección</dt>
                                    <dd class="mt-1 text-sm text-gray-900"><?php echo e($empresa->direccion); ?></dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Sección de Contacto Principal -->
                        <!--[if BLOCK]><![endif]--><?php if($empresa->contacto_nombre): ?>
                        <div class="sm:col-span-2 pt-6 border-t border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Contacto Principal</h3>
                            <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-2">
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Nombre</dt>
                                    <dd class="mt-1 text-sm text-gray-900"><?php echo e($empresa->contacto_nombre); ?></dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Puesto</dt>
                                    <dd class="mt-1 text-sm text-gray-900"><?php echo e($empresa->contacto_puesto); ?></dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Teléfono</dt>
                                    <dd class="mt-1 text-sm text-gray-900"><?php echo e($empresa->contacto_telefono); ?></dd>
                                </div>
                                <div class="sm:col-span-1">
                                    <dt class="text-sm font-medium text-gray-500">Correo Electrónico</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <a href="mailto:<?php echo e($empresa->contacto_correo); ?>" class="text-blue-600 hover:underline">
                                            <?php echo e($empresa->contacto_correo); ?>

                                        </a>
                                    </dd>
                                </div>
                            </dl>
                        </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\laragon\www\encuesta-pro360\resources\views/livewire/encuesta/ver-empresa.blade.php ENDPATH**/ ?>