<div>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50/30 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">

            <!-- Cabecera Mejorada -->
            <header class="mb-8">
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100/50 backdrop-blur-sm">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                        <div class="space-y-3">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl shadow-md">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">Gestión de Empresas</h1>
                            </div>
                            <p class="text-gray-600 max-w-2xl">
                                Administra, busca y organiza las empresas registradas en el sistema
                            </p>
                            <div class="flex items-center gap-4">
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-700 font-medium text-sm shadow-sm border border-blue-200/50">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    {{ $empresas->total() }} {{ $empresas->total() == 1 ? 'Empresa' : 'Empresas' }}
                                </span>
                                @if($busqueda || $filtroSector || $filtroEstado)
                                <span class="text-sm text-gray-500 bg-gray-100 px-2 py-1 rounded-md">
                                    (Filtros aplicados)
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- Botones de acción mejorados -->
                        <div class="flex items-center gap-3 flex-wrap">
                            <!-- Botón Nueva Empresa -->
                            <a href="{{ route('crear-empresa') }}" wire:navigate
                                class="group relative inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold text-sm rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <div class="absolute inset-0 bg-white/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Nueva Empresa
                            </a>

                            <!-- Botón Papelera -->
                            <a href="{{ route('papelera-empresas') }}" wire:navigate
                                class="group relative inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-orange-500 to-amber-600 text-white font-semibold text-sm rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                                <div class="absolute inset-0 bg-white/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Papelera
                            </a>

                            <!-- Botón Manual de Usuario -->
                            <a href="#"
                                class="group relative inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold text-sm rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <div class="absolute inset-0 bg-white/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z" />
                                </svg>
                                Manual de Usuario
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Barra de Filtros y Búsqueda Mejorada -->
            <div class="mb-8 bg-white p-5 rounded-2xl shadow-lg border border-gray-100/50">
                <div class="flex flex-col sm:flex-row items-center gap-4">
                    <div class="relative flex-grow w-full">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="search" id="busqueda" wire:model.live.debounce.300ms="busqueda"
                            placeholder="Buscar por ID, nombre, razón social o RFC..."
                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl leading-5 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all duration-200">
                    </div>

                    <div class="flex items-center gap-4 w-full sm:w-auto">
                        <select id="filtroSector" wire:model.live="filtroSector"
                            class="w-full sm:w-48 rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500/50 py-3 transition-all duration-200">
                            <option value="">Todos los Sectores</option>
                            @foreach ($sectores as $sector)
                            <option value="{{ $sector }}">{{ $sector }}</option>
                            @endforeach
                        </select>

                        <select id="filtroEstado" wire:model.live="filtroEstado"
                            class="w-full sm:w-48 rounded-xl border-gray-200 shadow-sm focus:border-blue-500 focus:ring-blue-500/50 py-3 transition-all duration-200">
                            <option value="">Todos los Estados</option>
                            @foreach ($estados as $estado)
                            <option value="{{ $estado }}">{{ $estado }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Tabla de Empresas Mejorada -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100/50">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gradient-to-r from-gray-50 to-gray-100/80">
                            <tr>
                                <!-- Columna: ID Empresa -->
                                <th scope="col" wire:click="ordenar('id_empresa')"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider cursor-pointer group transition-colors duration-200 hover:bg-gray-100/50">
                                    <div class="flex items-center">
                                        <span>ID</span>
                                        @if ($ordenarPor === 'id_empresa')
                                        <span class="ml-1 transform transition-transform duration-200 {{ $direccionOrden === 'asc' ? 'rotate-0' : 'rotate-180' }}">
                                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                            </svg>
                                        </span>
                                        @else
                                        <svg class="w-4 h-4 ml-1 text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                        </svg>
                                        @endif
                                    </div>
                                </th>

                                <!-- Columna: Nombre Comercial -->
                                <th scope="col" wire:click="ordenar('nombre_comercial')"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider cursor-pointer group transition-colors duration-200 hover:bg-gray-100/50">
                                    <div class="flex items-center">
                                        <span>Nombre Comercial</span>
                                        @if ($ordenarPor === 'nombre_comercial')
                                        <span class="ml-1 transform transition-transform duration-200 {{ $direccionOrden === 'asc' ? 'rotate-0' : 'rotate-180' }}">
                                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                            </svg>
                                        </span>
                                        @else
                                        <svg class="w-4 h-4 ml-1 text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                        </svg>
                                        @endif
                                    </div>
                                </th>

                                <!-- Columna: RFC -->
                                <th scope="col" wire:click="ordenar('rfc')"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider cursor-pointer group transition-colors duration-200 hover:bg-gray-100/50">
                                    <div class="flex items-center">
                                        <span>RFC</span>
                                        @if ($ordenarPor === 'rfc')
                                        <span class="ml-1 transform transition-transform duration-200 {{ $direccionOrden === 'asc' ? 'rotate-0' : 'rotate-180' }}">
                                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                            </svg>
                                        </span>
                                        @else
                                        <svg class="w-4 h-4 ml-1 text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                        </svg>
                                        @endif
                                    </div>
                                </th>

                                <!-- Columna: Sector -->
                                <th scope="col" wire:click="ordenar('sector')"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider cursor-pointer group transition-colors duration-200 hover:bg-gray-100/50">
                                    <div class="flex items-center">
                                        <span>Sector</span>
                                        @if ($ordenarPor === 'sector')
                                        <span class="ml-1 transform transition-transform duration-200 {{ $direccionOrden === 'asc' ? 'rotate-0' : 'rotate-180' }}">
                                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                            </svg>
                                        </span>
                                        @else
                                        <svg class="w-4 h-4 ml-1 text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                        </svg>
                                        @endif
                                    </div>
                                </th>

                                <!-- Columna: País -->
                                <th scope="col" wire:click="ordenar('pais')"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider cursor-pointer group transition-colors duration-200 hover:bg-gray-100/50">
                                    <div class="flex items-center">
                                        <span>País</span>
                                        @if ($ordenarPor === 'pais')
                                        <span class="ml-1 transform transition-transform duration-200 {{ $direccionOrden === 'asc' ? 'rotate-0' : 'rotate-180' }}">
                                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                            </svg>
                                        </span>
                                        @else
                                        <svg class="w-4 h-4 ml-1 text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                        </svg>
                                        @endif
                                    </div>
                                </th>

                                <!-- Columna: Ubicación -->
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                    Ubicación
                                </th>

                                <!-- Columna: Fecha de Registro -->
                                <th scope="col" wire:click="ordenar('fecha_registro')"
                                    class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider cursor-pointer group transition-colors duration-200 hover:bg-gray-100/50">
                                    <div class="flex items-center">
                                        <span>Fecha de Registro</span>
                                        @if ($ordenarPor === 'fecha_registro')
                                        <span class="ml-1 transform transition-transform duration-200 {{ $direccionOrden === 'asc' ? 'rotate-0' : 'rotate-180' }}">
                                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                            </svg>
                                        </span>
                                        @else
                                        <svg class="w-4 h-4 ml-1 text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                        </svg>
                                        @endif
                                    </div>
                                </th>

                                <!-- Columna: Estado -->
                                <th scope="col" wire:click="ordenar('estado_inicial')"
                                    class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider cursor-pointer group transition-colors duration-200 hover:bg-gray-100/50">
                                    <div class="flex items-center justify-center">
                                        <span>Estado</span>
                                        @if ($ordenarPor === 'estado_inicial')
                                        <span class="ml-1 transform transition-transform duration-200 {{ $direccionOrden === 'asc' ? 'rotate-0' : 'rotate-180' }}">
                                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                            </svg>
                                        </span>
                                        @else
                                        <svg class="w-4 h-4 ml-1 text-gray-400 opacity-0 group-hover:opacity-100 transition-opacity duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                        </svg>
                                        @endif
                                    </div>
                                </th>

                                <!-- Columna: Acciones -->
                                <th scope="col" class="relative px-6 py-4">
                                    <span class="sr-only">Acciones</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($empresas as $empresa)
                            <tr wire:key="{{ $empresa->id_empresa }}"
                                class="hover:bg-gradient-to-r hover:from-blue-50/30 hover:to-indigo-50/20 transition-all duration-300 group">

                                <!-- Celda: ID Empresa -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900 group-hover:text-blue-700 transition-colors duration-200">
                                    {{ $empresa->id_empresa }}
                                </td>

                                <!-- Celda: Nombre Comercial -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if ($empresa->logo)
                                        <div class="h-12 w-12 rounded-xl bg-white border border-gray-200 flex items-center justify-center p-1.5 flex-shrink-0 shadow-sm group-hover:shadow-md transition-shadow duration-300">
                                            <img
                                                src="{{ asset('storage/' . $empresa->logo) }}"
                                                alt="Logo de {{ $empresa->nombre_comercial }}"
                                                class="max-h-full max-w-full object-contain rounded-lg">
                                        </div>
                                        @else
                                        <span class="h-12 w-12 rounded-xl bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center text-gray-600 font-bold flex-shrink-0 text-sm border border-gray-200 group-hover:shadow-md transition-shadow duration-300">
                                            {{ strtoupper(substr($empresa->nombre_comercial, 0, 2)) }}
                                        </span>
                                        @endif
                                        <div class="ml-4">
                                            <div class="text-sm font-semibold text-gray-900 group-hover:text-blue-700 transition-colors duration-200">
                                                {{ $empresa->nombre_comercial }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Celda: RFC -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono bg-gray-50/50 rounded-lg mx-2">
                                    {{ $empresa->rfc }}
                                </td>

                                <!-- Celda: Sector -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $empresa->sector }}
                                    </span>
                                </td>

                                <!-- Celda: País -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex items-center">
                                        <span class="mr-2 text-lg">🇲🇽</span>
                                        {{ $empresa->pais }}
                                    </div>
                                </td>

                                <!-- Celda: Ubicación -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $empresa->municipio ?? $empresa->ciudad }}, {{ $empresa->estado }}
                                </td>

                                <!-- Celda: Fecha de Registro -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $empresa->fecha_registro->format('d/m/Y') }}
                                    </div>
                                </td>

                                <!-- Celda: Estado -->
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-3 py-1.5 inline-flex text-xs leading-5 font-semibold rounded-full shadow-sm transition-all duration-200
                                        @if($empresa->estado_inicial == 'Activo') bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border border-green-200
                                        @elseif($empresa->estado_inicial == 'Inactivo') bg-gradient-to-r from-red-100 to-rose-100 text-red-800 border border-red-200
                                        @elseif($empresa->estado_inicial == 'En Proceso') bg-gradient-to-r from-yellow-100 to-amber-100 text-yellow-800 border border-yellow-200
                                        @elseif($empresa->estado_inicial == 'Suspendido') bg-gradient-to-r from-gray-100 to-slate-100 text-gray-800 border border-gray-200
                                        @endif">
                                        {{ $empresa->estado_inicial }}
                                    </span>
                                </td>

                                <!-- Celda: Acciones -->
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <!-- Botón Ver -->
                                        <a
                                            href="{{ route('ver-empresa', $empresa) }}"
                                            wire:navigate
                                            class="group relative inline-flex items-center p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-all duration-200 hover:scale-110 hover:shadow-md"
                                            title="Ver detalles">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-all duration-200 whitespace-nowrap shadow-lg">
                                                Ver detalles
                                                <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1 w-2 h-2 bg-gray-800 rotate-45"></span>
                                            </span>
                                        </a>

                                        <!-- Botón Editar -->
                                        <a
                                            href="{{ route('editar-empresa', $empresa) }}"
                                            wire:navigate
                                            class="group relative inline-flex items-center p-2 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-100 transition-all duration-200 hover:scale-110 hover:shadow-md"
                                            title="Editar empresa">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-all duration-200 whitespace-nowrap shadow-lg">
                                                Editar
                                                <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1 w-2 h-2 bg-gray-800 rotate-45"></span>
                                            </span>
                                        </a>

                                        <!-- Botón Eliminar -->
                                        <button
                                            x-data
                                            @click="$dispatch('confirm-delete', { id: {{ $empresa->id_empresa }} })"
                                            class="group relative inline-flex items-center p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-all duration-200 hover:scale-110 hover:shadow-md"
                                            title="Eliminar empresa">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-all duration-200 whitespace-nowrap shadow-lg">
                                                Eliminar
                                                <span class="absolute bottom-0 left-1/2 transform -translate-x-1/2 translate-y-1 w-2 h-2 bg-gray-800 rotate-45"></span>
                                            </span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="px-6 py-12 text-center">
                                    <div class="text-center">
                                        <div class="mx-auto h-16 w-16 bg-gradient-to-r from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-4">
                                            <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                            </svg>
                                        </div>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">No se encontraron empresas</h3>
                                        <p class="mt-1 text-sm text-gray-500">Intenta ajustar tu búsqueda o filtros.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Acciones Post-Tabla y Paginación Mejoradas -->
            <div class="mt-8 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="flex items-center gap-3 flex-wrap">
                    <span class="text-sm font-medium text-gray-600">Exportar vista actual:</span>
                    <button
                        wire:click="exportarZip"
                        wire:loading.attr="disabled"
                        wire:target="exportarZip"
                        title="Descargar todo en un archivo ZIP"
                        class="group relative inline-flex items-center justify-center px-4 py-2.5 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold text-sm rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">
                        <div class="absolute inset-0 bg-white/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <i class="fas fa-file-archive mr-2"></i>
                        <span wire:loading.remove wire:target="exportarZip">Descargar Todo (.zip)</span>
                        <span wire:loading wire:target="exportarZip">Generando...</span>
                    </button>

                    <button
                        wire:click="exportarExcel"
                        wire:loading.attr="disabled"
                        wire:target="exportarExcel"
                        title="Exportar a Excel"
                        class="group relative inline-flex items-center justify-center px-4 py-2.5 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold text-sm rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">
                        <div class="absolute inset-0 bg-white/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <i class="fas fa-file-excel mr-2"></i>
                        <span wire:loading.remove wire:target="exportarExcel">Exportar Excel</span>
                        <span wire:loading wire:target="exportarExcel">Exportando...</span>
                    </button>

                    <button
                        wire:click="exportarPdf"
                        wire:loading.attr="disabled"
                        wire:target="exportarPdf"
                        title="Exportar a PDF"
                        class="group relative inline-flex items-center justify-center px-4 py-2.5 bg-gradient-to-r from-red-500 to-rose-600 text-white font-semibold text-sm rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">
                        <div class="absolute inset-0 bg-white/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <i class="fas fa-file-pdf mr-2"></i>
                        <span wire:loading.remove wire:target="exportarPdf">Exportar PDF</span>
                        <span wire:loading wire:target="exportarPdf">Exportando...</span>
                    </button>
                </div>

                <div class="w-full sm:w-auto">
                    {{ $empresas->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Al final de resources/views/livewire/encuesta/mostrar-empresa.blade.php --}}

{{-- ... (código de la tabla y paginación) ... --}}

<!-- @push('scripts')
<script>
    // Nos aseguramos de que este script se ejecute después de que Livewire se haya inicializado.
    document.addEventListener('livewire:init', () => {

        // Listener para el modal de confirmación de eliminación
        Livewire.on('show-swal-delete', (event) => {
            const data = event[0];
            Swal.fire({
                title: data.title,
                text: data.text,
                icon: data.icon,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, ¡eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si se confirma, despachamos el evento final que el backend escuchará.
                    Livewire.dispatch('delete-confirmed', {
                        id: data.id
                    });
                }
            });
        });
    });
</script>
@endpush -->

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const img = document.getElementById('preview-logo');
        const colorContainer = document.getElementById('color-preview');

        if (img && colorContainer) {
            img.addEventListener('load', () => {
                const colorThief = new ColorThief();
                const palette = colorThief.getPalette(img, 5); // Extrae 5 colores

                palette.forEach(color => {
                    const colorBox = document.createElement('div');
                    colorBox.style.width = '30px';
                    colorBox.style.height = '30px';
                    colorBox.style.borderRadius = '50%';
                    colorBox.style.backgroundColor = `rgb(${color[0]}, ${color[1]}, ${color[2]})`;
                    colorBox.title = `rgb(${color[0]}, ${color[1]}, ${color[2]})`;
                    colorContainer.appendChild(colorBox);
                });
            });
        }
    });
</script>
@endpush