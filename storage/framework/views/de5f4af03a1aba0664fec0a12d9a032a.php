<div>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-white py-8 px-4 sm:px-6 lg:px-8">
        <form wire:submit.prevent="save" class="space-y-8 max-w-5xl mx-auto">
            
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
                    <h2 class="text-lg font-semibold text-white">Información Básica</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="nombre_comercial" class="block text-sm font-medium text-gray-700 mb-2">Nombre Comercial</label>
                            <input type="text" wire:model="nombre_comercial" id="nombre_comercial" placeholder="Ej. TechCorp Solutions" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
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
                            <input type="text" wire:model="razon_social" id="razon_social" placeholder="Ej. TechCorp S.A. de C.V." class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
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
                    <h2 class="text-lg font-semibold text-white">Logo de la Empresa / (Opcional)</h2>
                </div>
                <div class="p-6">
                    <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-400 transition-colors">
                        <input type="file" wire:model="logo" id="logo" accept="image/png,image/jpeg,image/jpg" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                        <div wire:loading wire:target="logo" class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-75 z-20">
                            <div class="text-blue-600 flex items-center">
                                <svg class="animate-spin h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span class="ml-2 font-semibold">Subiendo...</span>
                            </div>
                        </div>
                        <div wire:loading.remove wire:target="logo" class="flex flex-col items-center">
                            <svg class="h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <p class="text-sm font-medium text-gray-900 mb-1">Haz click para subir el logo</p>
                            <p class="text-sm text-gray-500 mb-2">o arrastra y suelta aquí</p>
                            <p class="text-xs text-gray-400">PNG, JPG, JPEG hasta 5MB</p>
                        </div>
                    </div>
                    <!--[if BLOCK]><![endif]--><?php if($logo): ?>
                    <div class="mt-4" wire:loading.remove wire:target="logo">
                        <p class="text-sm font-medium text-gray-700 mb-2 text-center">Previsualización:</p>
                        <img src="<?php echo e($logo->temporaryUrl()); ?>" class="w-32 h-32 object-cover rounded-lg mx-auto shadow-md" alt="Previsualización del logo">
                    </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['logo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm mt-1 block text-center"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
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
                            <input type="text" wire:model="rfc" id="rfc" placeholder="Ej. XAXX010101000" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
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
                            <label for="municipio" class="block text-sm font-medium text-gray-700 mb-2">Municipio/Localidad</label>
                            <input type="text" wire:model="municipio" id="municipio" placeholder="Ej. Puebla" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
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
                            <input type="text" wire:model="codigo_postal" id="codigo_postal" placeholder="Ej. 72000" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
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
                            <input type="text" wire:model="direccion" id="direccion" placeholder="Ej. Av. Principal 123" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
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
                            <input type="text" wire:model="contacto_nombre" id="contacto_nombre" placeholder="Ej. Juan Pérez" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
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
                            <input type="text" wire:model="contacto_puesto" id="contacto_puesto" placeholder="Ej. Gerente General" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
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
                            <input type="tel" wire:model="contacto_telefono" id="contacto_telefono" placeholder="Ej. +52 222 123 4567" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
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
                            <input type="email" wire:model="contacto_correo" id="contacto_correo" placeholder="Ej. juan.perez@empresa.com" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
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
                    Crear Empresa
                </button>
            </div>
        </form>
    </div>
</div>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    window.addEventListener('mostrar-empresa', event => {
        toastr.success(event.detail.message);
    });

    // window.addEventListener('empresa-error', event => {
    //     toastr.error(event.detail.message);
    // });
</script> -->





<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    window.addEventListener('mostrar-empresa', event => {
        toastr.success(event.detail.message);
    });

    // window.addEventListener('empresa-error', event => {
    //     toastr.error(event.detail.message);
    // });
</script> --><?php /**PATH C:\laragon\www\encuesta-pro360\resources\views/livewire/encuesta/crear-empresa.blade.php ENDPATH**/ ?>