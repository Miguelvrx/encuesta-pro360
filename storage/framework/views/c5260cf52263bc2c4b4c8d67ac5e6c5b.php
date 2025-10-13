<div>
    <!-- Botón para alternar el sidebar (solo visible en móviles) -->
    <div class="absolute top-4 left-4 z-50 md:hidden">
        <button wire:click="toggleSidebar" class="text-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 rounded-md p-1 transition-all duration-200 ease-in-out hover:scale-105">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <!-- Sidebar -->
    <div id="sidebar"
        class="fixed left-0 top-0 w-64 h-full bg-white shadow-xl z-50 transition-all duration-300 ease-in-out transform 
        md:translate-x-0 <?php echo e(!$isSidebarOpen && ! $this->isDesktop() ? '-translate-x-full' : 'translate-x-0'); ?>">

        <!-- Contenido del Sidebar -->


        

        <!-- Contenido del Sidebar -->
        <div class="flex items-center justify-between px-6 h-16 border-b border-gray-200 shadow-sm">
            
            <div class="flex items-center gap-3 group cursor-pointer">
                
                <div class="relative w-12 h-12">
                    
                    <div class="absolute -inset-1 rounded-full bg-gradient-to-r from-blue-500 via-cyan-400 via-emerald-400 via-yellow-400 via-red-500 via-purple-500 to-blue-500 animate-spin opacity-75 group-hover:opacity-100 transition-opacity duration-300" style="animation-duration: 3s;"></div>

                    
                    <div class="relative w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-700 rounded-full flex items-center justify-center shadow-lg transform transition-all duration-300 group-hover:scale-110 group-hover:shadow-xl animate-pulse">
                        <span class="text-white text-sm font-bold drop-shadow-sm select-none">360°</span>
                    </div>
                </div>

                
                <h1 class="text-2xl font-bold flex items-baseline select-none">
                    <span class="text-blue-600 transition-all duration-300 group-hover:text-blue-800 transform group-hover:scale-105">E360</span>
                    <span class="text-red-500 ml-1 transition-all duration-300 group-hover:text-red-700 transform group-hover:scale-105">Pro</span>
                </h1>
            </div>
        </div>

        
        <?php $__env->startPush('styles'); ?>
        <style>
            /* Animación de rotación lenta para el borde */
            @keyframes slow-spin {
                from {
                    transform: rotate(0deg);
                }

                to {
                    transform: rotate(360deg);
                }
            }

            /* Aplicar la animación lenta */
            .animate-slow-spin {
                animation: slow-spin 3s linear infinite;
            }

            /* Animación de entrada para el texto */
            @keyframes fade-in-left {
                0% {
                    opacity: 0;
                    transform: translateX(-20px);
                }

                100% {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            @keyframes fade-in-right {
                0% {
                    opacity: 0;
                    transform: translateX(20px);
                }

                100% {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            /* Clases para las animaciones de entrada */
            .animate-fade-in-left {
                animation: fade-in-left 0.8s ease-out;
            }

            .animate-fade-in-right {
                animation: fade-in-right 0.8s ease-out 0.2s both;
            }
        </style>
        <?php $__env->stopPush(); ?>

        <!-- Menú de navegación -->
        <nav class="px-4 py-4 overflow-y-auto h-[calc(100%-4rem)]">
            <!-- Dashboard -->
            <a href="<?php echo e(route('dashboard')); ?>"
                wire:click="closeMenus"
                class="flex items-center px-3 py-2.5 rounded-lg group transition-all duration-200 ease-in-out 
                <?php echo e($this->isActiveRoute('dashboard') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600 shadow-sm' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 hover:shadow-md'); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 transition-colors duration-200 
                    <?php echo e($this->isActiveRoute('dashboard') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500'); ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0 1 20.25 6v12A2.25 2.25 0 0 1 18 20.25H6A2.25 2.25 0 0 1 3.75 18V6A2.25 2.25 0 0 1 6 3.75h1.5m9 0h-9" />
                </svg>
                <span class="text-sm font-medium">Dashboard</span>
            </a>

            <!-- Sección Administración -->
            <div class="mt-6">
                <span class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Gestión Organizacional </span>

                <!-- Gestión de Usuarios -->
                <div class="mt-3">
                    <button wire:click="toggleMenu('usuarios')" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg group transition-all duration-200 ease-in-out 
                        <?php echo e($this->isActiveRouteGroup(['crear-empresa', 'bienvenido', 'evaluacion', 'mis-resultados', 'resultado-jefe']) ? 'bg-blue-50 text-blue-600 shadow-sm' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 hover:shadow-md'); ?>">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 transition-colors duration-200 
                                <?php echo e($this->isActiveRouteGroup(['crear-empresa', 'bienvenido', 'evaluacion', 'mis-resultados', 'resultado-jefe']) ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500'); ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 22V4a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v18Z"></path>
                                <path d="M6 12H4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2"></path>
                                <path d="M18 9h2a2 2 0 0 1 2 2v9a2 2 0 0 1-2 2h-2"></path>
                                <path d="M10 6h4"></path>
                                <path d="M10 10h4"></path>
                                <path d="M10 14h4"></path>
                                <path d="M10 18h4">
                            </svg>
                            <span class="text-sm font-medium">Empresa</span>
                        </div>
                        <svg class="w-4 h-4 transition-all duration-300 ease-in-out 
                            <?php echo e($this->isActiveRouteGroup(['crear-empresa', 'mostrar-empresa']) ? 'text-blue-400' : 'text-gray-400'); ?> 
                            <?php echo e($this->isMenuOpen('usuarios') ? 'rotate-180' : 'rotate-0'); ?>" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div class="overflow-hidden transition-all duration-300 ease-in-out 
                        <?php echo e($this->isMenuOpen('usuarios') ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0'); ?> mt-1 ml-4 space-y-1">
                        <a href="<?php echo e(route('crear-empresa')); ?>"
                            wire:click="closeMenus"
                            class="flex items-center px-3 py-2.5 rounded-lg group transition-all duration-200 ease-in-out 
                            <?php echo e($this->isActiveRoute('crear-empresa') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600 shadow-sm' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 hover:shadow-md'); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 transition-colors duration-200 
                                <?php echo e($this->isActiveRoute('crear-empresa') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500'); ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <span class="text-sm">Crear Empresa</span>
                        </a>
                        <a href="<?php echo e(route('mostrar-empresa')); ?>"
                            wire:click="closeMenus"
                            class="flex items-center px-3 py-2.5 rounded-lg group transition-all duration-200 ease-in-out 
                            <?php echo e($this->isActiveRoute('mostrar-empresa') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600 shadow-sm' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 hover:shadow-md'); ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 transition-colors duration-200 
                                <?php echo e($this->isActiveRoute('crear-empresa') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500'); ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                                <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                            </svg>
                            <span class="text-sm">Mostrar Empresa</span>
                        </a>
                    </div>
                    <div class="mt-3">
                        <button wire:click="toggleMenu('departamentos')" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg group transition-all duration-200 ease-in-out 
                        <?php echo e($this->isActiveRouteGroup(['crear-departamento']) ? 'bg-blue-50 text-blue-600 shadow-sm' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 hover:shadow-md'); ?>">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 transition-colors duration-200 
                                <?php echo e($this->isActiveRouteGroup(['crear-departamento', 'mostrar-departamento']) ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500'); ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                                </svg>
                                <span class="text-sm font-medium">Departamento</span>
                            </div>
                            <svg class="w-4 h-4 transition-all duration-300 ease-in-out 
                            <?php echo e($this->isActiveRouteGroup(['crear-departamento',  'mostrar-departamento']) ? 'text-blue-400' : 'text-gray-400'); ?> 
                            <?php echo e($this->isMenuOpen('departamentos') ? 'rotate-180' : 'rotate-0'); ?>" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div class="overflow-hidden transition-all duration-300 ease-in-out 
                        <?php echo e($this->isMenuOpen('departamentos') ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0'); ?> mt-1 ml-4 space-y-1">
                            <a href="<?php echo e(route('crear-departamento')); ?>"
                                wire:click="closeMenus"
                                class="flex items-center px-3 py-2.5 rounded-lg group transition-all duration-200 ease-in-out 
                            <?php echo e($this->isActiveRoute('crear-departamento', 'mostrar-departamento') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600 shadow-sm' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 hover:shadow-md'); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 transition-colors duration-200 
                                <?php echo e($this->isActiveRoute('crear-empresa') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500'); ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <span class="text-sm">Crear Departamento</span>
                            </a>
                            <a href="<?php echo e(route('mostrar-departamento')); ?>"
                                
                                wire:click="closeMenus"
                                class="flex items-center px-3 py-2.5 rounded-lg group transition-all duration-200 ease-in-out 
    
    <?php echo e($this->isActiveRoute('mostrar-departamento') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600 shadow-sm' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 hover:shadow-md'); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 transition-colors duration-200 
        <?php echo e($this->isActiveRoute('mostrar-departamento' ) ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500'); ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z">
                                </svg>
                                <span class="text-sm">Mostrar Departamentos</span>
                            </a>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button wire:click="toggleMenu('users')" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg group transition-all duration-200 ease-in-out 
                        <?php echo e($this->isActiveRouteGroup(['crear-usuario', 'mostrar-usuario']) ? 'bg-blue-50 text-blue-600 shadow-sm' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 hover:shadow-md'); ?>">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 transition-colors duration-200 
                                <?php echo e($this->isActiveRouteGroup(['crear-usuario', 'mostrar-usuario']) ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500'); ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                <span class="text-sm font-medium">Usuario</span>
                            </div>
                            <svg class="w-4 h-4 transition-all duration-300 ease-in-out 
                            <?php echo e($this->isActiveRouteGroup(['crear-usuario', 'mostrar-usuario']) ? 'text-blue-400' : 'text-gray-400'); ?> 
                            <?php echo e($this->isMenuOpen('users') ? 'rotate-180' : 'rotate-0'); ?>" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="overflow-hidden transition-all duration-300 ease-in-out 
                        <?php echo e($this->isMenuOpen('users') ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0'); ?> mt-1 ml-4 space-y-1">
                            <a href="<?php echo e(route('crear-usuario')); ?>"
                                wire:click="closeMenus"
                                class="flex items-center px-3 py-2.5 rounded-lg group transition-all duration-200 ease-in-out 
                            <?php echo e($this->isActiveRoute('crear-usuario') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600 shadow-sm' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 hover:shadow-md'); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 transition-colors duration-200 
                                <?php echo e($this->isActiveRoute('crear-usuario') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500'); ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <span class="text-sm">Crear Usuario</span>
                            </a>
                            <a href="<?php echo e(route('mostrar-usuario')); ?>"
                                
                                wire:click="closeMenus"
                                class="flex items-center px-3 py-2.5 rounded-lg group transition-all duration-200 ease-in-out 
    
    <?php echo e($this->isActiveRoute('mostrar-usuario') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600 shadow-sm' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 hover:shadow-md'); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 transition-colors duration-200 
        <?php echo e($this->isActiveRoute('mostrar-usuario' ) ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500'); ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z">
                                </svg>
                                <span class="text-sm">Mostrar Usuario</span>
                            </a>
                            <!-- Repetir para los demás enlaces, ajustando el estado activo y clases similares -->
                        </div>
                         <div class="mt-3">
                        <button wire:click="toggleMenu('competencias')" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg group transition-all duration-200 ease-in-out 
                        <?php echo e($this->isActiveRouteGroup(['crear-competencia', 'revisar-competencia','catalogo-competencia']) ? 'bg-blue-50 text-blue-600 shadow-sm' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 hover:shadow-md'); ?>">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 transition-colors duration-200 
                                <?php echo e($this->isActiveRouteGroup(['crear-competencia', 'revisar-competencia','catalogo-competencia']) ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500'); ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                <span class="text-sm font-medium">Competencia</span>
                            </div>
                            <svg class="w-4 h-4 transition-all duration-300 ease-in-out 
                            <?php echo e($this->isActiveRouteGroup(['crear-competencia', 'revisar-competencia', 'catalogo-competencia']) ? 'text-blue-400' : 'text-gray-400'); ?> 
                            <?php echo e($this->isMenuOpen('competencias') ? 'rotate-180' : 'rotate-0'); ?>" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="overflow-hidden transition-all duration-300 ease-in-out 
                        <?php echo e($this->isMenuOpen('competencias') ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0'); ?> mt-1 ml-4 space-y-1">
                            <a href="<?php echo e(route('crear-competencia')); ?>"
                                wire:click="closeMenus"
                                class="flex items-center px-3 py-2.5 rounded-lg group transition-all duration-200 ease-in-out 
                            <?php echo e($this->isActiveRoute('crear-competencia', 'revisar-competencia', 'catalogo-competencia') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600 shadow-sm' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 hover:shadow-md'); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 transition-colors duration-200 
                                <?php echo e($this->isActiveRoute('crear-usuario') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500'); ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <span class="text-sm">Crear Competencia</span>
                            </a>
                            <a href="<?php echo e(route('revisar-competencia')); ?>"
                                
                                wire:click="closeMenus"
                                class="flex items-center px-3 py-2.5 rounded-lg group transition-all duration-200 ease-in-out 
    
    <?php echo e($this->isActiveRoute('revisar-competencia') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600 shadow-sm' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 hover:shadow-md'); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 transition-colors duration-200 
        <?php echo e($this->isActiveRoute('mostrar-usuario' ) ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500'); ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z">
                                </svg>
                                <span class="text-sm">Revisar Competencia</span>
                            </a>
                             <a href="<?php echo e(route('catalogo-competencia')); ?>"
                                
                                wire:click="closeMenus"
                                class="flex items-center px-3 py-2.5 rounded-lg group transition-all duration-200 ease-in-out 
    
    <?php echo e($this->isActiveRoute('catalogo-competencia') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600 shadow-sm' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 hover:shadow-md'); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 transition-colors duration-200 
        <?php echo e($this->isActiveRoute('catalogo-competencia' ) ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500'); ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z">
                                </svg>
                                <span class="text-sm">Catalogo Competencia</span>
                            </a>
                    </div>
                </div>
            </div> <!-- Resto del código del sidebar (agrega secciones similares con las mismas mejoras) -->
        </nav>
    </div>
</div><?php /**PATH C:\laragon\www\encuesta-pro360\resources\views/livewire/menu-navegacion.blade.php ENDPATH**/ ?>