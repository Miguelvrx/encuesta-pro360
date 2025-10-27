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
        md:translate-x-0 {{ !$isSidebarOpen && ! $this->isDesktop() ? '-translate-x-full' : 'translate-x-0' }}">

        <!-- Contenido del Sidebar -->


        {{-- Reemplaza la sección del header de tu sidebar actual --}}

        <div class="flex items-center justify-between px-6 h-16 border-b border-gray-200 shadow-sm">
            {{-- Logo E360 Pro animado --}}
            <div class="flex items-center gap-3 group cursor-pointer">
                {{-- Círculo animado con borde rotativo multicolor --}}
                <div class="relative w-12 h-12">
                    {{-- Borde rotativo --}}
                    <div class="absolute -inset-1 rounded-full rotating-border opacity-80 group-hover:opacity-100 transition-opacity duration-300"></div>

                    {{-- Círculo principal --}}
                    <div class="relative w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-700 rounded-full flex items-center justify-center shadow-lg transform transition-all duration-300 group-hover:scale-110 group-hover:shadow-xl z-10">
                        <span class="text-white text-sm font-bold drop-shadow-sm select-none">360°</span>
                    </div>
                </div>

                {{-- Texto del logo --}}
                <h1 class="text-2xl font-bold flex items-baseline select-none">
                    <span class="text-blue-600 transition-all duration-300 group-hover:text-blue-800 transform group-hover:scale-105">E360</span>
                    <span class="text-red-500 ml-1 transition-all duration-300 group-hover:text-red-700 transform group-hover:scale-105">Pro</span>
                </h1>
            </div>
        </div>



        <!-- Menú de navegación -->
        <nav class="px-4 py-4 overflow-y-auto h-[calc(100%-4rem)]">
            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}"
                wire:click="closeMenus"
                class="flex items-center px-3 py-2.5 rounded-lg group transition-all duration-200 ease-in-out 
                {{ $this->isActiveRoute('dashboard') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600 shadow-sm' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 hover:shadow-md' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 transition-colors duration-200 
                    {{ $this->isActiveRoute('dashboard') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.5 3.75V16.5L12 14.25 7.5 16.5V3.75m9 0H18A2.25 2.25 0 0 1 20.25 6v12A2.25 2.25 0 0 1 18 20.25H6A2.25 2.25 0 0 1 3.75 18V6A2.25 2.25 0 0 1 6 3.75h1.5m9 0h-9" />
                </svg>
                <span class="text-sm font-medium">Dashboard</span>
            </a>

            <!-- Sección Administración -->
            <div class="mt-6">
                <span class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Gestión Organizacional </span>
                <!-- Navegación de empresa de mostrar y crear  -->
                <div class="mt-3">
                    <button wire:click="toggleMenu('usuarios')" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg group transition-all duration-200 ease-in-out 
                        {{ $this->isActiveRouteGroup(['crear-empresa', 'mostrar-empresa']) ? 'bg-blue-50 text-blue-600 shadow-sm' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 hover:shadow-md' }}">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 transition-colors duration-200 
                                {{ $this->isActiveRouteGroup(['crear-empresa', 'mostrar-empresa']) ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                            {{ $this->isActiveRouteGroup(['crear-empresa', 'mostrar-empresa']) ? 'text-blue-400' : 'text-gray-400' }} 
                            {{ $this->isMenuOpen('usuarios') ? 'rotate-180' : 'rotate-0' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div class="overflow-hidden transition-all duration-300 ease-in-out 
                        {{ $this->isMenuOpen('usuarios') ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0' }} mt-1 ml-4 space-y-1">
                        @can('crear-empresas')
                        <a href="{{ route('crear-empresa') }}"
                            wire:click="closeMenus"
                            class="flex items-center px-3 py-2.5 rounded-lg group transition-all duration-200 ease-in-out 
                            {{ $this->isActiveRoute('crear-empresa') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600 shadow-sm' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 hover:shadow-md' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 transition-colors duration-200 
                                {{ $this->isActiveRoute('crear-empresa') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <span class="text-sm">Crear Empresa</span>
                        </a>
                        @endcan
                        <a href="{{ route('mostrar-empresa') }}"
                            wire:click="closeMenus"
                            class="flex items-center px-3 py-2.5 rounded-lg group transition-all duration-200 ease-in-out 
                            {{ $this->isActiveRoute('mostrar-empresa') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600 shadow-sm' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 hover:shadow-md' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 transition-colors duration-200 
                                {{ $this->isActiveRoute('mostrar-empresa') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"></path>
                                <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                            </svg>
                            <span class="text-sm">Mostrar Empresa</span>
                        </a>
                    </div>
                    <!-- Navegación de empresa de mostrar y crear final -->

                    <!-- Navegación de departamentos de mostrar y crear -->
                    <div class="mt-3">
                        <button wire:click="toggleMenu('departamentos')" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg group transition-all duration-200 ease-in-out 
                        {{ $this->isActiveRouteGroup(['crear-departamento', 'mostrar-departamento']) ? 'bg-blue-50 text-blue-600 shadow-sm' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 hover:shadow-md' }}">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 transition-colors duration-200 
                                {{ $this->isActiveRouteGroup(['crear-departamento', 'mostrar-departamento']) ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Zm0 3h.008v.008h-.008v-.008Z" />
                                </svg>
                                <span class="text-sm font-medium">Departamento</span>
                            </div>
                            <svg class="w-4 h-4 transition-all duration-300 ease-in-out 
                            {{ $this->isActiveRouteGroup(['crear-departamento',  'mostrar-departamento']) ? 'text-blue-400' : 'text-gray-400' }} 
                            {{ $this->isMenuOpen('departamentos') ? 'rotate-180' : 'rotate-0' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div class="overflow-hidden transition-all duration-300 ease-in-out 
                        {{ $this->isMenuOpen('departamentos') ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0' }} mt-1 ml-4 space-y-1">
                            <a href="{{ route('crear-departamento') }}"
                                wire:click="closeMenus"
                                class="flex items-center px-3 py-2.5 rounded-lg group transition-all duration-200 ease-in-out 
                            {{ $this->isActiveRoute('crear-departamento', 'mostrar-departamento') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600 shadow-sm' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 hover:shadow-md' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 transition-colors duration-200 
                                {{ $this->isActiveRoute('crear-empresa') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <span class="text-sm">Crear Departamento</span>
                            </a>
                            <a href="{{ route('mostrar-departamento') }}"
                                {{-- FIN DE LA CORRECCIÓN --}}
                                wire:click="closeMenus"
                                class="flex items-center px-3 py-2.5 rounded-lg group transition-all duration-200 ease-in-out 
    {{-- Ajusta también la comprobación de la ruta activa si es necesario --}}
    {{ $this->isActiveRoute('mostrar-departamento') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600 shadow-sm' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 hover:shadow-md' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 transition-colors duration-200 
        {{ $this->isActiveRoute('mostrar-departamento' ) ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    {{-- He cambiado el ícono para que sea diferente al de "Crear" --}}
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v16a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM9 4v16M15 4v16">
                                </svg>
                                <span class="text-sm">Mostrar Departamentos</span>
                            </a>
                        </div>
                    </div>
                    <!-- Navegación de departamentos de mostrar y crear final-->

                    <!-- Navegación de usuarios de mostrar y crear -->
                    <div class="mt-3">
                        <button wire:click="toggleMenu('users')" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg group transition-all duration-200 ease-in-out 
                        {{ $this->isActiveRouteGroup(['crear-usuario', 'mostrar-usuario']) ? 'bg-blue-50 text-blue-600 shadow-sm' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 hover:shadow-md' }}">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 transition-colors duration-200 
                                {{ $this->isActiveRouteGroup(['crear-usuario', 'mostrar-usuario']) ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                <span class="text-sm font-medium">Usuario</span>
                            </div>
                            <svg class="w-4 h-4 transition-all duration-300 ease-in-out 
                            {{ $this->isActiveRouteGroup(['crear-usuario', 'mostrar-usuario']) ? 'text-blue-400' : 'text-gray-400' }} 
                            {{ $this->isMenuOpen('users') ? 'rotate-180' : 'rotate-0' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="overflow-hidden transition-all duration-300 ease-in-out 
                        {{ $this->isMenuOpen('users') ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0' }} mt-1 ml-4 space-y-1">
                            <a href="{{ route('crear-usuario') }}"
                                wire:click="closeMenus"
                                class="flex items-center px-3 py-2.5 rounded-lg group transition-all duration-200 ease-in-out 
                            {{ $this->isActiveRoute('crear-usuario') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600 shadow-sm' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 hover:shadow-md' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 transition-colors duration-200 
                                {{ $this->isActiveRoute('crear-usuario') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <span class="text-sm">Crear Usuario</span>
                            </a>
                            <a href="{{ route('mostrar-usuario') }}"
                                {{-- FIN DE LA CORRECCIÓN --}}
                                wire:click="closeMenus"
                                class="flex items-center px-3 py-2.5 rounded-lg group transition-all duration-200 ease-in-out 
    {{-- Ajusta también la comprobación de la ruta activa si es necesario --}}
    {{ $this->isActiveRoute('mostrar-usuario') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600 shadow-sm' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 hover:shadow-md' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 transition-colors duration-200 
        {{ $this->isActiveRoute('mostrar-usuario' ) ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    {{-- He cambiado el ícono para que sea diferente al de "Crear" --}}
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                                </svg>
                                <span class="text-sm">Mostrar Usuario</span>
                            </a>
                        </div>
                        <!-- Navegación de usuarios de mostrar y crear final-->

                        <!-- Navegación de competencias de mostrar y crear-->
                        <div class="mt-3">
                            <button wire:click="toggleMenu('competencias')" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg group transition-all duration-200 ease-in-out 
                        {{ $this->isActiveRouteGroup(['crear-competencia', 'revisar-competencia','catalogo-competencia']) ? 'bg-blue-50 text-blue-600 shadow-sm' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 hover:shadow-md' }}">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 transition-colors duration-200 
                                {{ $this->isActiveRouteGroup(['crear-competencia', 'revisar-competencia','catalogo-competencia']) ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                                    </svg>
                                    <span class="text-sm font-medium">Competencia</span>
                                </div>
                                <svg class="w-4 h-4 transition-all duration-300 ease-in-out 
                            {{ $this->isActiveRouteGroup(['crear-competencia', 'revisar-competencia', 'catalogo-competencia']) ? 'text-blue-400' : 'text-gray-400' }} 
                            {{ $this->isMenuOpen('competencias') ? 'rotate-180' : 'rotate-0' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div class="overflow-hidden transition-all duration-300 ease-in-out 
                        {{ $this->isMenuOpen('competencias') ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0' }} mt-1 ml-4 space-y-1">
                                <a href="{{ route('crear-competencia') }}"
                                    wire:click="closeMenus"
                                    class="flex items-center px-3 py-2.5 rounded-lg group transition-all duration-200 ease-in-out 
                            {{ $this->isActiveRoute('crear-competencia', 'revisar-competencia', 'catalogo-competencia') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600 shadow-sm' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 hover:shadow-md' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 transition-colors duration-200 
                                {{ $this->isActiveRoute('crear-usuario') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    <span class="text-sm">Crear Competencia</span>
                                </a>
                                <a href="{{ route('revisar-competencia') }}"
                                    {{-- FIN DE LA CORRECCIÓN --}}
                                    wire:click="closeMenus"
                                    class="flex items-center px-3 py-2.5 rounded-lg group transition-all duration-200 ease-in-out 
    {{-- Ajusta también la comprobación de la ruta activa si es necesario --}}
    {{ $this->isActiveRoute('revisar-competencia') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600 shadow-sm' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 hover:shadow-md' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 transition-colors duration-200 
        {{ $this->isActiveRoute('mostrar-usuario' ) ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        {{-- He cambiado el ícono para que sea diferente al de "Crear" --}}
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m15.75 15.75-2.489-2.489m0 0a3.375 3.375 0 1 0-4.773-4.773 3.375 3.375 0 0 0 4.774 4.774ZM21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    <span class="text-sm">Revisar Competencia</span>
                                </a>
                                <a href="{{ route('catalogo-competencia') }}"
                                    {{-- FIN DE LA CORRECCIÓN --}}
                                    wire:click="closeMenus"
                                    class="flex items-center px-3 py-2.5 rounded-lg group transition-all duration-200 ease-in-out 
    {{-- Ajusta también la comprobación de la ruta activa si es necesario --}}
    {{ $this->isActiveRoute('catalogo-competencia') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600 shadow-sm' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 hover:shadow-md' }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 transition-colors duration-200 
        {{ $this->isActiveRoute('catalogo-competencia' ) ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        {{-- He cambiado el ícono para que sea diferente al de "Crear" --}}
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 6.878V6a2.25 2.25 0 0 1 2.25-2.25h7.5A2.25 2.25 0 0 1 18 6v.878m-12 0c.235-.083.487-.128.75-.128h10.5c.263 0 .515.045.75.128m-12 0A2.25 2.25 0 0 0 4.5 9v.878m13.5-3A2.25 2.25 0 0 1 19.5 9v.878m0 0a2.246 2.246 0 0 0-.75-.128H5.25c-.263 0-.515.045-.75.128m15 0A2.25 2.25 0 0 1 21 12v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6c0-.98.626-1.813 1.5-2.122" />
                                    </svg>
                                    <span class="text-sm">Catalogo Competencia</span>
                                </a>
                            </div>

                            <!-- Navegación de competencias de mostrar y crear final-->


                            <!-- Navegación de preguntas de mostrar y crear -->
                            <div class="mt-3">
                                <button wire:click="toggleMenu('preguntas')" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg group transition-all duration-200 ease-in-out 
                        {{ $this->isActiveRouteGroup(['gestionar-pregunta']) ? 'bg-blue-50 text-blue-600 shadow-sm' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 hover:shadow-md' }}">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 transition-colors duration-200 
                                {{ $this->isActiveRouteGroup(['gestionar-pregunta']) ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                                        </svg>
                                        <span class="text-sm font-medium">Pregunta</span>
                                    </div>
                                    <svg class="w-4 h-4 transition-all duration-300 ease-in-out 
                            {{ $this->isActiveRouteGroup(['gestionar-pregunta']) ? 'text-blue-400' : 'text-gray-400' }} 
                            {{ $this->isMenuOpen('preguntas') ? 'rotate-180' : 'rotate-0' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div class="overflow-hidden transition-all duration-300 ease-in-out 
                        {{ $this->isMenuOpen('preguntas') ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0' }} mt-1 ml-4 space-y-1">
                                    <a href="{{ route('gestionar-pregunta') }}"
                                        wire:click="closeMenus"
                                        class="flex items-center px-3 py-2.5 rounded-lg group transition-all duration-200 ease-in-out 
                            {{ $this->isActiveRoute('gestionar-pregunta') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600 shadow-sm' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 hover:shadow-md' }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 transition-colors duration-200 
                                {{ $this->isActiveRoute('gestionar-pregunta') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                        </svg>
                                        <span class="text-sm">Gestionar Pregunta</span>
                                    </a>
                                </div>

                                <!-- Navegación de preguntas de mostrar y crear final-->

                                <!-- Navegación de evaluacion de mostrar y crear -->
                                <div class="mt-3">
                                    <button wire:click="toggleMenu('evaluaciones')" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg group transition-all duration-200 ease-in-out 
                        {{ $this->isActiveRouteGroup(['crear-evaluacion', 'mostrar-evaluaciones']) ? 'bg-blue-50 text-blue-600 shadow-sm' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 hover:shadow-md' }}">
                                        <div class="flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 transition-colors duration-200 
                                {{ $this->isActiveRouteGroup(['crear-evaluacion', 'mostrar-evaluaciones']) ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" />
                                            </svg>
                                            <span class="text-sm font-medium">Evaluación</span>
                                        </div>
                                        <svg class="w-4 h-4 transition-all duration-300 ease-in-out 
                            {{ $this->isActiveRouteGroup(['crear-evaluacion', 'mostrar-evaluaciones']) ? 'text-blue-400' : 'text-gray-400' }} 
                            {{ $this->isMenuOpen('evaluaciones') ? 'rotate-180' : 'rotate-0' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                    <div class="overflow-hidden transition-all duration-300 ease-in-out 
                        {{ $this->isMenuOpen('evaluaciones') ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0' }} mt-1 ml-4 space-y-1">
                                        <a href="{{ route('crear-evaluacion') }}"
                                            wire:click="closeMenus"
                                            class="flex items-center px-3 py-2.5 rounded-lg group transition-all duration-200 ease-in-out 
                            {{ $this->isActiveRoute('crear-evaluacion') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600 shadow-sm' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 hover:shadow-md' }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 transition-colors duration-200 
                                {{ $this->isActiveRoute('crear-evaluacion') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                            <span class="text-sm">Configurar Evaluación</span>
                                        </a>
                                        <a href="{{ route('mostrar-evaluaciones') }}"
                                            wire:click="closeMenus"
                                            class="flex items-center px-3 py-2.5 rounded-lg group transition-all duration-200 ease-in-out 
                            {{ $this->isActiveRoute('mostrar-evaluaciones') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600 shadow-sm' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 hover:shadow-md' }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 transition-colors duration-200 
                                {{ $this->isActiveRoute('mostrar-evaluaciones') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 3v11.25A2.25 2.25 0 0 0 6 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5m.75-9 3-3 2.148 2.148A12.061 12.061 0 0 1 16.5 7.605" />
                                            </svg>
                                            <span class="text-sm">Visualizar Detalles</span>
                                        </a>
                                    </div>

                                    <!-- Navegación de evaluacion de mostrar y crear final -->




                                    <!-- Navegación de relizar evaluacion 360  -->
                                    <div class="mt-3">
                                        <button wire:click="toggleMenu('realizarevaluaciones')" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg group transition-all duration-200 ease-in-out 
                        {{ $this->isActiveRouteGroup(['mis-evaluaciones']) ? 'bg-blue-50 text-blue-600 shadow-sm' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 hover:shadow-md' }}">
                                            <div class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 transition-colors duration-200 
                                {{ $this->isActiveRouteGroup(['mis-evaluaciones']) ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                                                </svg>
                                                <span class="text-sm font-medium">Evaluaciones</span>
                                            </div>
                                            <svg class="w-4 h-4 transition-all duration-300 ease-in-out 
                            {{ $this->isActiveRouteGroup(['mis-evaluaciones']) ? 'text-blue-400' : 'text-gray-400' }} 
                            {{ $this->isMenuOpen('realizarevaluaciones') ? 'rotate-180' : 'rotate-0' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </button>
                                        <div class="overflow-hidden transition-all duration-300 ease-in-out 
                        {{ $this->isMenuOpen('realizarevaluaciones') ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0' }} mt-1 ml-4 space-y-1">
                                            <a href="{{ route('mis-evaluaciones') }}"
                                                wire:click="closeMenus"
                                                class="flex items-center px-3 py-2.5 rounded-lg group transition-all duration-200 ease-in-out 
                            {{ $this->isActiveRoute('mis-evaluaciones') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600 shadow-sm' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 hover:shadow-md' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 transition-colors duration-200 
                                {{ $this->isActiveRoute('mis-evaluaciones') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                                <span class="text-sm">Realizar Evaluación</span>
                                            </a>
                                        </div>

                                        <!-- Navegación de relizar evaluacion 360  final -->


                                        <!-- Navegación de reporte de mostrar -->
                                        <div class="mt-3">
                                            <button wire:click="toggleMenu('reporteevaluaciones')" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg group transition-all duration-200 ease-in-out 
                        {{ $this->isActiveRouteGroup(['reporte-evaluacion']) ? 'bg-blue-50 text-blue-600 shadow-sm' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 hover:shadow-md' }}">
                                                <div class="flex items-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 transition-colors duration-200 
                                {{ $this->isActiveRouteGroup(['reporte-evaluacion']) ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                                                    </svg>
                                                    <span class="text-sm font-medium">Reporte</span>
                                                </div>
                                                <svg class="w-4 h-4 transition-all duration-300 ease-in-out 
                            {{ $this->isActiveRouteGroup(['reporte-evaluacion']) ? 'text-blue-400' : 'text-gray-400' }} 
                            {{ $this->isMenuOpen('reporteevaluaciones') ? 'rotate-180' : 'rotate-0' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </button>
                                            <div class="overflow-hidden transition-all duration-300 ease-in-out 
                        {{ $this->isMenuOpen('reporteevaluaciones') ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0' }} mt-1 ml-4 space-y-1">
                                                <a href="{{ route('reporte-evaluacion') }}"
                                                    wire:click="closeMenus"
                                                    class="flex items-center px-3 py-2.5 rounded-lg group transition-all duration-200 ease-in-out 
                            {{ $this->isActiveRoute('reporte-evaluacion') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600 shadow-sm' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 hover:shadow-md' }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 transition-colors duration-200 
                                {{ $this->isActiveRoute('reporte-evaluacion') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25M9 16.5v.75m3-3v3M15 12v5.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                                    </svg>
                                                    <span class="text-sm">Reporte General</span>
                                                </a>
                                            </div>

                                            <!-- Navegación de reporte de mostrar final -->

                                            <!-- Navegación de reanking  de excelencia mostrar  -->
                                            <div class="mt-3">
                                                <button wire:click="toggleMenu('rakingexcelencias')" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg group transition-all duration-200 ease-in-out 
                        {{ $this->isActiveRouteGroup(['reaking-excelencia']) ? 'bg-blue-50 text-blue-600 shadow-sm' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 hover:shadow-md' }}">
                                                    <div class="flex items-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 transition-colors duration-200 
                                {{ $this->isActiveRouteGroup(['reaking-excelencia']) ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941" />
                                                        </svg>
                                                        <span class="text-sm font-medium">Reaking</span>
                                                    </div>
                                                    <svg class="w-4 h-4 transition-all duration-300 ease-in-out 
                            {{ $this->isActiveRouteGroup(['reaking-excelencia']) ? 'text-blue-400' : 'text-gray-400' }} 
                            {{ $this->isMenuOpen('rakingexcelencias') ? 'rotate-180' : 'rotate-0' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                    </svg>
                                                </button>
                                                <div class="overflow-hidden transition-all duration-300 ease-in-out 
                        {{ $this->isMenuOpen('rakingexcelencias') ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0' }} mt-1 ml-4 space-y-1">
                                                    <a href="{{ route('reaking-excelencia') }}"
                                                        wire:click="closeMenus"
                                                        class="flex items-center px-3 py-2.5 rounded-lg group transition-all duration-200 ease-in-out 
                            {{ $this->isActiveRoute('reaking-excelencia') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600 shadow-sm' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 hover:shadow-md' }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 transition-colors duration-200 
                                {{ $this->isActiveRoute('reporte-evaluacion') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 0 1-.982-3.172M9.497 14.25a7.454 7.454 0 0 0 .981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 0 0 7.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 0 0 2.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 0 1 2.916.52 6.003 6.003 0 0 1-5.395 4.972m0 0a6.726 6.726 0 0 1-2.749 1.35m0 0a6.772 6.772 0 0 1-3.044 0" />
                                                        </svg>
                                                        <span class="text-sm">Ranking de Excelencia</span>
                                                    </a>
                                                </div>

                                                <!-- Navegación de reanking de excelencia final -->



                                                <!-- Navegación de Roles y Permisos   -->
                                                <div class="mt-3">
                                                    <button wire:click="toggleMenu('rolespermisos')" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg group transition-all duration-200 ease-in-out 
                        {{ $this->isActiveRouteGroup(['asignar-roles', 'gestion-roles']) ? 'bg-blue-50 text-blue-600 shadow-sm' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 hover:shadow-md' }}">
                                                        <div class="flex items-center">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 transition-colors duration-200 
                                {{ $this->isActiveRouteGroup(['asignar-roles', 'gestion-roles']) ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                                                            </svg>
                                                            <span class="text-sm font-medium">Roles y Permisos</span>
                                                        </div>
                                                        <svg class="w-4 h-4 transition-all duration-300 ease-in-out 
                            {{ $this->isActiveRouteGroup(['asignar-roles', 'gestion-roles']) ? 'text-blue-400' : 'text-gray-400' }} 
                            {{ $this->isMenuOpen('rolespermisos') ? 'rotate-180' : 'rotate-0' }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                        </svg>
                                                    </button>
                                                    <div class="overflow-hidden transition-all duration-300 ease-in-out 
                        {{ $this->isMenuOpen('rolespermisos') ? 'max-h-96 opacity-100' : 'max-h-0 opacity-0' }} mt-1 ml-4 space-y-1">
                                                        <a href="{{ route('asignar-roles') }}"
                                                            wire:click="closeMenus"
                                                            class="flex items-center px-3 py-2.5 rounded-lg group transition-all duration-200 ease-in-out 
                            {{ $this->isActiveRoute('asignar-roles') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600 shadow-sm' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 hover:shadow-md' }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 transition-colors duration-200 
                                {{ $this->isActiveRoute('asignar-roles') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z" />
                                                            </svg>
                                                            <span class="text-sm">Roles</span>
                                                        </a>

                                                        <a href="{{ route('gestion-roles') }}"
                                                            wire:click="closeMenus"
                                                            class="flex items-center px-3 py-2.5 rounded-lg group transition-all duration-200 ease-in-out 
                            {{ $this->isActiveRoute('gestion-roles') ? 'bg-blue-50 text-blue-600 border-r-4 border-blue-600 shadow-sm' : 'text-gray-600 hover:text-blue-600 hover:bg-blue-50 hover:shadow-md' }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-3 transition-colors duration-200 
                                {{ $this->isActiveRoute('gestion-roles') ? 'text-blue-500' : 'text-gray-400 group-hover:text-blue-500' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                                            </svg>
                                                            <span class="text-sm">Permisos</span>
                                                        </a>



                                                    </div>
                                                </div>
                                            </div> <!-- Resto del código del sidebar (agrega secciones similares con las mismas mejoras) -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</div>