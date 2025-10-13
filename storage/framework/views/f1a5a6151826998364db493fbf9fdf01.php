<div>
    <div class="flex items-center justify-between h-16 w-full bg-white border-b border-gray-300 shadow-md px-4">
        <!-- Left side elements -->
        <div class="flex items-center space-x-4">
            <!-- Elementos de la izquierda -->
        </div>
        
        <!-- Right side elements with user button -->
        <div class="flex items-center space-x-4">
            <!-- Botón de usuario -->
            <div class="relative">
                <button wire:click="toggleDropdown"
                    class="flex text-sm border-2 border-transparent rounded-full focus:outline-none transition">
                    <!--[if BLOCK]><![endif]--><?php if(Laravel\Jetstream\Jetstream::managesProfilePhotos()): ?>
                        <img class="h-8 w-8 rounded-full object-cover" 
                             src="<?php echo e($user->profile_photo_url); ?>"
                             alt="<?php echo e($user->name); ?>" />
                    <?php else: ?>
                        <span class="inline-flex rounded-md">
                            <span class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                <?php echo e($user->name); ?>

                                <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </span>
                        </span>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </button>

                <!-- Contenido del Dropdown -->
                <!--[if BLOCK]><![endif]--><?php if($dropdownOpen): ?>
                <div class="absolute right-0 mt-2 w-48 bg-white border border-gray-300 shadow-lg rounded-md z-50"
                    x-on:click.outside="$wire.closeDropdown()">
                    <div class="block px-4 py-2 text-xs text-gray-400">
                        <?php echo e(__('Administrar Cuenta')); ?>

                    </div>
                    
                    <!--[if BLOCK]><![endif]--><?php if(Laravel\Jetstream\Jetstream::hasApiFeatures()): ?>
                    <a href="<?php echo e(route('api-tokens.index')); ?>" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                        <?php echo e(__('API Tokens')); ?>

                    </a>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    
                    <div class="border-t border-gray-200"></div>
                    
                    <!-- Logout -->
                    <form method="POST" action="<?php echo e(route('logout')); ?>" x-data>
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                            <?php echo e(__('Cerrar Sesión')); ?>

                        </button>
                    </form>
                </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>
    </div>
</div><?php /**PATH C:\laragon\www\encuesta-pro360\resources\views/livewire/header-navegacion.blade.php ENDPATH**/ ?>