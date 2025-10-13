<div>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-white py-8 px-4 sm:px-6 lg:px-8">
        <form wire:submit.prevent="update" class="space-y-8 max-w-5xl mx-auto">
            
            <!--[if BLOCK]><![endif]--><?php if(session()->has("message")): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6" role="alert">
                <p class="font-bold">¡Éxito!</p>
                <p><?php echo e(session("message")); ?></p>
            </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            <?php if(session()->has("error")): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6" role="alert">
                <p class="font-bold">¡Error!</p>
                <p><?php echo e(session("error")); ?></p>
            </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <!-- SECCIÓN 1: Información Básica -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4">
                    <h2 class="text-lg font-semibold text-white">Editar Información Básica</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="nombre_comercial" class="block text-sm font-medium text-gray-700 mb-2">Nombre Comercial</label>
                            <input type="text" wire:model="nombre_comercial" id="nombre_comercial" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["nombre_comercial"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div>
                            <label for="razon_social" class="block text-sm font-medium text-gray-700 mb-2">Razón Social</label>
                            <input type="text" wire:model="razon_social" id="razon_social" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["razon_social"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div>
                            <label for="sector" class="block text-sm font-medium text-gray-700 mb-2">Sector/Industria</label>
                            <select wire:model="sector" id="sector" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Selecciona el sector</option>
                                <option value="Tecnología">Tecnología</option>
                                <option value="Manufactura">Manufactura</option>
                                <option value="Servicios">Servicios</option>
                                <option value="Comercio">Comercio</option>
                                <option value="Construcción">Construcción</option>
                                <option value="Salud">Salud</option>
                                <option value="Educación">Educación</option>
                                <option value="Turismo">Turismo</option>
                                <option value="Otros">Otros</option>
                            </select>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["sector"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div>
                            <label for="estado_inicial" class="block text-sm font-medium text-gray-700 mb-2">Estado Inicial</label>
                            <select wire:model="estado_inicial" id="estado_inicial" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Selecciona el estado inicial</option>
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                                <option value="En Proceso">En Proceso</option>
                                <option value="Suspendido">Suspendido</option>
                            </select>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["estado_inicial"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div>
                            <label for="numero_empleados" class="block text-sm font-medium text-gray-700 mb-2">Número de Empleados</label>
                            <select wire:model="numero_empleados" id="numero_empleados" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Selecciona un rango</option>
                                <option value="1-10">1-10</option>
                                <option value="11-50">11-50</option>
                                <option value="51-100">51-100</option>
                                <option value="101-500">101-500</option>
                                <option value="500+">500+</option>
                            </select>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["numero_empleados"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div>
                            <label for="fecha_registro" class="block text-sm font-medium text-gray-700 mb-2">Fecha de Registro</label>
                            <input type="date" wire:model="fecha_registro" id="fecha_registro" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["fecha_registro"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div>
                            <label for="ano_mercado" class="block text-sm font-medium text-gray-700 mb-2">Año en el mercado</label>
                            <input type="number" wire:model="ano_mercado" id="ano_mercado" placeholder="Ej. 1987" min="1900" max="<?php echo e(date('Y')); ?>" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["ano_mercado"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div>
                            <label for="tipo_organizacion" class="block text-sm font-medium text-gray-700 mb-2">Tipo de Organización</label>
                            <select wire:model="tipo_organizacion" id="tipo_organizacion" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Selecciona el tipo</option>
                                <option value="S.A. de C.V.">S.A. de C.V.</option>
                                <option value="S.R.L.">S.R.L.</option>
                                <option value="S.C.">S.C.</option>
                                <option value="Persona Física">Persona Física</option>
                                <option value="Asociación Civil">Asociación Civil</option>
                                <option value="Cooperativa">Cooperativa</option>
                            </select>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["tipo_organizacion"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECCIÓN 2: Logo de la Empresa -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-gray-600 to-gray-700 px-6 py-4">
                    <h2 class="text-lg font-semibold text-white">Logo de la Empresa</h2>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
                    <!-- Columna de Carga de Nuevo Logo -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                            Actualizar Logo (Opcional)
                        </label>
                        <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-indigo-500 transition-colors duration-300">
                            <input
                                type="file"
                                wire:model="image"
                                id="image"
                                accept="image/png,image/jpeg,image/jpg"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">

                            <!-- Indicador de carga -->
                            <div
                                wire:loading
                                wire:target="image"
                                class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-80 rounded-lg z-20">
                                <div class="flex flex-col items-center space-y-2">
                                    <div class="w-8 h-8 border-4 border-indigo-500 border-t-transparent rounded-full animate-spin"></div>
                                    <p class="text-sm text-gray-600">Cargando imagen...</p>
                                </div>
                            </div>

                            <!-- Área de carga -->
                            <div wire:loading.remove wire:target="image" class="flex flex-col items-center justify-center space-y-2 text-gray-500">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                <p class="text-sm font-semibold text-gray-700">Arrastra o haz click para subir</p>
                                <p class="text-xs">PNG, JPG, JPEG hasta 5MB</p>
                            </div>
                        </div>
                        <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["image"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="text-red-500 text-sm mt-2 block"><?php echo e($message); ?></span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <!-- Columna de Previsualización -->
                    <div class="flex flex-col items-center justify-center space-y-4 pt-5">
                        <!--[if BLOCK]><![endif]--><?php if($image): ?>
                        <!-- Previsualización del Nuevo Logo -->
                        <div class="text-center">
                            <p class="font-semibold text-gray-800 mb-2">Nuevo Logo:</p>
                            <div class="relative w-48 h-48 rounded-lg overflow-hidden shadow-lg border-4 border-indigo-500 bg-white flex items-center justify-center p-3">
                                <!--[if BLOCK]><![endif]--><?php if(method_exists($image, 'temporaryUrl')): ?>
                                <img
                                    src="<?php echo e($image->temporaryUrl()); ?>"
                                    class="max-w-full max-h-full object-contain"
                                    alt="Previsualización del nuevo logo">
                                <?php else: ?>
                                <div class="w-8 h-8 border-4 border-indigo-500 border-t-transparent rounded-full animate-spin"></div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <button
                                type="button"
                                wire:click="$set('image', null)"
                                class="mt-3 text-sm text-red-600 hover:text-red-800 font-medium">
                                Cancelar
                            </button>
                        </div>
                        <?php elseif($imageExistente && \Illuminate\Support\Facades\Storage::disk('public')->exists($imageExistente)): ?>
                        <!-- Visualización del Logo Actual -->
                        <div class="text-center">
                            <p class="font-semibold text-gray-800 mb-2">Logo Actual:</p>
                            <div class="relative w-48 h-48 rounded-lg overflow-hidden shadow-md border-4 border-gray-200 bg-white flex items-center justify-center p-3">
                                <img
                                    src="<?php echo e(asset('storage/' . $imageExistente)); ?>"
                                    class="max-w-full max-h-full object-contain"
                                    alt="Logo actual">
                            </div>
                        </div>
                        <?php else: ?>
                        <!-- Placeholder si no hay logo -->
                        <div class="text-center text-gray-500">
                            <p class="font-semibold text-gray-800 mb-2">Logo:</p>
                            <div class="relative w-48 h-48 rounded-lg bg-gray-100 flex items-center justify-center border-4 border-gray-200 shadow-inner">
                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <p class="mt-2 text-sm">No hay logo disponible.</p>
                        </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
            </div>

            <!-- SECCIÓN 3: Información Fiscal y Ubicación -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4">
                    <h2 class="text-lg font-semibold text-white">Información Fiscal y Ubicación</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="rfc" class="block text-sm font-medium text-gray-700 mb-2">RFC</label>
                            <input type="text" wire:model="rfc" id="rfc" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["rfc"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div>
                            <label for="pais" class="block text-sm font-medium text-gray-700 mb-2">País</label>
                            <select wire:model.live="pais" id="pais" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="">Selecciona un país</option>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($country); ?>"><?php echo e($country); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </select>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["pais"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div>
                            <label for="estado" class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                            <select wire:model.live="estado" id="estado" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" <?php echo e(empty($states) ? 'disabled' : ''); ?>>
                                <option value="">Selecciona un estado</option>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($state); ?>"><?php echo e($state); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </select>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["estado"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div>
                            <label for="ciudad" class="block text-sm font-medium text-gray-700 mb-2">Ciudad</label>
                            <select wire:model="ciudad" id="ciudad" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500" <?php echo e(empty($cities) ? 'disabled' : ''); ?>>
                                <option value="">Selecciona una ciudad</option>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($city); ?>"><?php echo e($city); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </select>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["ciudad"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div>
                            <label for="municipio" class="block text-sm font-medium text-gray-700 mb-2">Localidad / Municipio</label>
                            <input type="text" wire:model="municipio" id="municipio" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["municipio"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div>
                            <label for="codigo_postal" class="block text-sm font-medium text-gray-700 mb-2">Código Postal</label>
                            <input type="text" wire:model="codigo_postal" id="codigo_postal" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["codigo_postal"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div class="sm:col-span-2">
                            <label for="direccion" class="block text-sm font-medium text-gray-700 mb-2">Dirección</label>
                            <input type="text" wire:model="direccion" id="direccion" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["direccion"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECCIÓN 4: Contacto Principal -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                    <h2 class="text-lg font-semibold text-white">Contacto Principal</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="contacto_nombre" class="block text-sm font-medium text-gray-700 mb-2">Nombre completo</label>
                            <input type="text" wire:model="contacto_nombre" id="contacto_nombre" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["contacto_nombre"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div>
                            <label for="contacto_puesto" class="block text-sm font-medium text-gray-700 mb-2">Puesto</label>
                            <input type="text" wire:model="contacto_puesto" id="contacto_puesto" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["contacto_puesto"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div>
                            <label for="contacto_telefono" class="block text-sm font-medium text-gray-700 mb-2">Teléfono</label>
                            <input type="tel" wire:model="contacto_telefono" id="contacto_telefono" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["contacto_telefono"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div>
                            <label for="contacto_correo" class="block text-sm font-medium text-gray-700 mb-2">Correo electrónico</label>
                            <input type="email" wire:model="contacto_correo" id="contacto_correo" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ["contacto_correo"];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECCIÓN 5: Botones de Acción -->
            <div class="flex justify-center space-x-4 pt-6">
                <a href="<?php echo e(route('mostrar-empresa')); ?>" wire:navigate class="px-8 py-3 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition-colors">
                    Cancelar
                </a>
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-medium rounded-lg hover:from-indigo-700 hover:to-indigo-800 transition-all shadow-md hover:shadow-lg">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.2/color-thief.umd.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const img = document.getElementById('preview-logo');
        const colorContainer = document.getElementById('color-preview');

        if (img && colorContainer) {
            img.addEventListener('load', () => {
                const colorThief = new ColorThief();
                const palette = colorThief.getPalette(img, 5);

                colorContainer.innerHTML = ''; // Limpia antes de pintar
                palette.forEach(color => {
                    const colorBox = document.createElement('div');
                    colorBox.style.width = '24px';
                    colorBox.style.height = '24px';
                    colorBox.style.borderRadius = '50%';
                    colorBox.style.backgroundColor = `rgb(${color[0]}, ${color[1]}, ${color[2]})`;
                    colorBox.title = `rgb(${color[0]}, ${color[1]}, ${color[2]})`;
                    colorBox.style.boxShadow = '0 0 2px rgba(0,0,0,0.3)';
                    colorContainer.appendChild(colorBox);
                });
            });
        }
    });
</script><?php /**PATH C:\laragon\www\encuesta-pro360\resources\views/livewire/encuesta/editar-empresa.blade.php ENDPATH**/ ?>