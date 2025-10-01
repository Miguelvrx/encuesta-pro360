<div>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-white py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">

            <!-- 1. Cabecera: Título y Botón Manual de Usuario -->
            <header class="mb-8">
                <div class="flex justify-between items-center bg-white p-6 rounded-xl shadow-md">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">Listado de Empresas</h1>
                        <p class="mt-1 text-sm text-gray-500">Busca, filtra y gestiona las empresas registradas.</p>
                    </div>
                    <a href="#" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold text-sm rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z"></path>
                        </svg>
                        Manual de Usuario
                    </a>
                </div>
            </header>

            <!-- 2. Barra de Filtros y Búsqueda -->
            <div class="mb-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="col-span-1 sm:col-span-2 lg:col-span-2">
                    <label for="busqueda" class="sr-only">Buscar</label>
                    <input type="search" id="busqueda" wire:model.live.debounce.300ms="busqueda" placeholder="Buscar por nombre, razón social o RFC..." class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label for="filtroSector" class="sr-only">Filtrar por Sector</label>
                    <select id="filtroSector" wire:model.live="filtroSector" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Todos los Sectores</option>
                        @foreach ($sectores as $sector )
                        <option value="{{ $sector }}">{{ $sector }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="filtroEstado" class="sr-only">Filtrar por Estado</label>
                    <select id="filtroEstado" wire:model.live="filtroEstado" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Todos los Estados</option>
                        @foreach ($estados as $estado)
                        <option value="{{ $estado }}">{{ $estado }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- 3. Tabla de Empresas -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                {{-- Cabecera de la tabla con ordenación --}}
                                <th scope="col" wire:click="ordenar('nombre_comercial')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                    Nombre Comercial
                                    @if ($ordenarPor === 'nombre_comercial')
                                    <span>{{ $direccionOrden === 'asc' ? '▲' : '▼' }}</span>
                                    @endif
                                </th>
                                <th scope="col" wire:click="ordenar('sector')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                    Sector
                                    @if ($ordenarPor === 'sector')
                                    <span>{{ $direccionOrden === 'asc' ? '▲' : '▼' }}</span>
                                    @endif
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Ubicación
                                </th>
                                <th scope="col" wire:click="ordenar('estado_inicial')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                    Estado
                                    @if ($ordenarPor === 'estado_inicial')
                                    <span>{{ $direccionOrden === 'asc' ? '▲' : '▼' }}</span>
                                    @endif
                                </th>
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Acciones</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($empresas as $empresa)
                            <tr wire:key="{{ $empresa->id_empresa }}" class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if ($empresa->logo)
                                        <img class="h-10 w-10 rounded-full object-cover" src="{{ asset('storage/' . $empresa->logo) }}" alt="Logo de {{ $empresa->nombre_comercial }}">
                                        @else
                                        <span class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold">
                                            {{ strtoupper(substr($empresa->nombre_comercial, 0, 2)) }}
                                        </span>
                                        @endif
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $empresa->nombre_comercial }}</div>
                                            <div class="text-sm text-gray-500">{{ $empresa->rfc }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $empresa->sector }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $empresa->ciudad }}, {{ $empresa->pais }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($empresa->estado_inicial == 'Activo') bg-green-100 text-green-800 @endif
                                        @if($empresa->estado_inicial == 'Inactivo') bg-red-100 text-red-800 @endif
                                        @if($empresa->estado_inicial == 'En Proceso') bg-yellow-100 text-yellow-800 @endif
                                        @if($empresa->estado_inicial == 'Suspendido') bg-gray-100 text-gray-800 @endif
                                    ">
                                        {{ $empresa->estado_inicial }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('ver-empresa', $empresa) }}" wire:navigate class="text-blue-600 hover:text-blue-900">Ver</a>
                                    <a href="{{ route('editar-empresa', $empresa) }}" wire:navigate class="ml-4 text-indigo-600 hover:text-indigo-900">Editar</a>

                                    {{-- INICIO DE LA RESTAURACIÓN --}}
                                    <button
                                        wire:click="deleteEmpresa({{ $empresa->id_empresa }})"
                                        wire:confirm="¿Estás seguro de que deseas eliminar esta empresa? Esta acción no se puede deshacer."
                                        class="ml-4 text-red-600 hover:text-red-900 font-medium">
                                        Eliminar
                                    </button>
                                    {{-- FIN DE LA RESTAURACIÓN --}}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <div class="text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                        </svg>
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

            <!-- 4. Paginación -->
            <div class="mt-6">
                {{ $empresas->links() }}
            </div>

        </div>
    </div>
</div>