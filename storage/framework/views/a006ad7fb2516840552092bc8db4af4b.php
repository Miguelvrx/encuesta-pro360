<div>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-white py-8 px-4 sm:px-6 lg:px-8">

        <form wire:submit.prevent="update" class="space-y-8 max-w-5xl mx-auto">

            <!-- Cabecera del Formulario -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-2xl font-bold text-white">Editar Usuario</h1>
                            <p class="text-sm text-indigo-200 mt-1">Modifica la información del miembro del sistema.</p>
                        </div>
                    </div>
                </div>

                <!-- Sección: Información Personal -->
                <div class="p-6">
                    <h2 class="text-lg font-semibold text-gray-800 border-b pb-4">Información Personal</h2>
                    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nombre(s)</label>
                            <input type="text" wire:model="name" id="name" class="mt-1 w-full input-style <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error-message"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div>
                            <label for="primer_apellido" class="block text-sm font-medium text-gray-700">Primer Apellido</label>
                            <input type="text" wire:model="primer_apellido" id="primer_apellido" class="mt-1 w-full input-style <?php $__errorArgs = ['primer_apellido'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['primer_apellido'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error-message"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <div>
                            <label for="segundo_apellido" class="block text-sm font-medium text-gray-700">Segundo Apellido <span class="text-gray-400">(Opcional)</span></label>
                            <input type="text" wire:model="segundo_apellido" id="segundo_apellido" class="mt-1 w-full input-style">
                        </div>
                        <div>
                            <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                            <input type="tel" wire:model="telefono" id="telefono" class="mt-1 w-full input-style <?php $__errorArgs = ['telefono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['telefono'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error-message"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>
                </div>

                <!-- Sección: Seguridad de Acceso -->
                <div class="p-6 border-t">
                    <h2 class="text-lg font-semibold text-gray-800 border-b pb-4">Seguridad de Acceso</h2>
                    <div class="mt-6 space-y-6">
                        <!-- Email - OBLIGATORIO -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">
                                Correo Electrónico <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="email"
                                wire:model="email"
                                id="email"
                                class="mt-1 w-full input-style <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <p class="mt-1 text-xs text-gray-500">Se utiliza para enviar encuestas y notificaciones</p>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error-message"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Username - OPCIONAL -->
                        <div>
                            <label for="username" class="block text-sm font-medium text-gray-700">
                                Nombre de Usuario <span class="text-gray-400">(Opcional)</span>
                            </label>
                            <input
                                type="text"
                                wire:model="username"
                                id="username"
                                placeholder="usuario123"
                                class="mt-1 w-full input-style <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                            <p class="mt-1 text-xs text-gray-500">
                                <!--[if BLOCK]><![endif]--><?php if($username): ?>
                                Puede iniciar sesión con: <span class="font-semibold"><?php echo e($username); ?></span> o su correo electrónico
                                <?php else: ?>
                                Si se proporciona, podrá iniciar sesión con este nombre de usuario o su correo
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </p>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error-message"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Contraseñas -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">
                                    Nueva Contraseña <span class="text-gray-400">(Opcional)</span>
                                </label>
                                <input
                                    type="password"
                                    wire:model="password"
                                    id="password"
                                    placeholder="Dejar en blanco para no cambiar"
                                    class="mt-1 w-full input-style <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error-message"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                                    Confirmar Nueva Contraseña
                                </label>
                                <input
                                    type="password"
                                    wire:model="password_confirmation"
                                    id="password_confirmation"
                                    placeholder="Repite la nueva contraseña"
                                    class="mt-1 w-full input-style">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sección: Asignación Organizacional -->
                <div class="p-6 border-t">
                    <h2 class="text-lg font-semibold text-gray-800 border-b pb-4">Asignación Organizacional <span class="text-sm font-normal text-gray-500">/ Obligatorio</span></h2>
                    <div class="mt-6 space-y-6">
                        <!-- ⭐ NUEVO: Selector de Empresa -->
                        <div>
                            <label for="empresa_id" class="block text-sm font-medium text-gray-700">
                                Empresa <span class="text-red-500">*</span>
                            </label>
                            <select 
                                wire:model.live="empresa_id" 
                                id="empresa_id" 
                                class="mt-1 w-full input-style <?php $__errorArgs = ['empresa_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            >
                                <option value="">Selecciona una empresa</option>
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $empresas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empresa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($empresa->id_empresa); ?>"><?php echo e($empresa->nombre_comercial); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </select>
                            <p class="mt-1 text-xs text-gray-500">Primero selecciona la empresa para ver sus departamentos</p>
                            <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['empresa_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error-message"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>

                        <!-- Grid para Departamento y Puesto -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Selector de Departamento -->
                            <div>
                                <label for="departamento_id" class="block text-sm font-medium text-gray-700">
                                    Departamento <span class="text-red-500">*</span>
                                </label>
                                <select 
                                    wire:model="departamento_id" 
                                    id="departamento_id" 
                                    class="mt-1 w-full input-style <?php $__errorArgs = ['departamento_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    <?php if(!$empresa_id): ?> disabled <?php endif; ?>
                                >
                                    <option value="">
                                        <!--[if BLOCK]><![endif]--><?php if($empresa_id): ?>
                                            Selecciona un departamento
                                        <?php else: ?>
                                            Primero selecciona una empresa
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </option>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $departamentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $departamento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($departamento->id_departamento); ?>"><?php echo e($departamento->nombre_departamento); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </select>
                                <!--[if BLOCK]><![endif]--><?php if(!$empresa_id): ?>
                                <p class="mt-1 text-xs text-amber-600">⚠️ Selecciona primero una empresa</p>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['departamento_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error-message"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>

                            <!-- Input de Puesto -->
                            <div>
                                <label for="puesto" class="block text-sm font-medium text-gray-700">
                                    Puesto <span class="text-red-500">*</span>
                                </label>
                                <input 
                                    type="text" 
                                    wire:model="puesto" 
                                    id="puesto" 
                                    placeholder="Ej. Analista de Datos" 
                                    class="mt-1 w-full input-style <?php $__errorArgs = ['puesto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                >
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['puesto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="error-message"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sección: Información Adicional -->
                <div class="p-6 border-t">
                    <h2 class="text-lg font-semibold text-gray-800 border-b pb-4">Información Adicional <span class="text-sm font-normal text-gray-500">/ Opcional</span></h2>
                    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="genero" class="block text-sm font-medium text-gray-700">Género</label>
                            <select wire:model="genero" id="genero" class="mt-1 w-full input-style">
                                <option value="">Selecciona un género</option>
                                <option value="masculino">Masculino</option>
                                <option value="femenino">Femenino</option>
                                <option value="no definido">Prefiero no decirlo</option>
                            </select>
                        </div>
                        <div>
                            <label for="escolaridad" class="block text-sm font-medium text-gray-700">Nivel de Escolaridad</label>
                            <select wire:model="escolaridad" id="escolaridad" class="mt-1 w-full input-style">
                                <option value="">Selecciona nivel de escolaridad</option>

                                <optgroup label="Educación Básica">
                                    <option value="Preescolar">Preescolar</option>
                                    <option value="Primaria">Primaria</option>
                                    <option value="Secundaria">Secundaria</option>
                                </optgroup>

                                <optgroup label="Educación Media">
                                    <option value="Bachillerato">Bachillerato</option>
                                    <option value="Preparatoria">Preparatoria</option>
                                </optgroup>

                                <optgroup label="Educación Superior">
                                    <option value="Licenciatura">Licenciatura</option>
                                    <option value="Ingeniería">Ingeniería</option>
                                    <option value="Maestría">Maestría</option>
                                    <option value="Doctorado">Doctorado</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="flex justify-center space-x-4 pt-6">
                <a href="<?php echo e(route('mostrar-usuario')); ?>" wire:navigate class="px-8 py-3 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 transition-colors">
                    Cancelar
                </a>
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-medium rounded-lg hover:from-indigo-700 hover:to-indigo-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 shadow-lg hover:shadow-xl transition-all duration-200">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div><?php /**PATH D:\laragon\www\encuesta-pro360\resources\views/livewire/encuesta/usuario/editar-usuario.blade.php ENDPATH**/ ?>