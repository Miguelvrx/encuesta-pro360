<div>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-white py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">

            <!-- Cabecera -->
            <header class="mb-8">
                <div class="bg-white p-5 rounded-xl shadow-md">
                    <!-- Título y estadísticas -->
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800">Gestión de Departamentos</h1>
                            <p class="mt-2 text-sm text-gray-600">
                                Administra, busca y organiza los departamentos registrados en el sistema
                            </p>
                            <div class="mt-3 flex items-center gap-4 text-sm">
                                <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-50 text-blue-700 font-medium">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    {{ $departamentos->total() }} {{ $departamentos->total() == 1 ? 'Departamento' : 'Departamentos' }}
                                </span>
                                @if($busqueda || $filtroEmpresa || $filtroEstado)
                                <span class="text-gray-500">
                                    (Filtrado)
                                </span>
                                @endif
                            </div>
                        </div>

                        <!-- Botones de acción -->
                        <div class="flex items-center gap-3 flex-wrap">
                            <!-- Botón Nuevo Departamento -->
                            <a href="{{ route('crear-departamento') }}" wire:navigate
                                class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-semibold text-sm rounded-lg shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Nuevo Departamento
                            </a>

                            <!-- Botón Manual de Usuario -->
                            <a href="#"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold text-sm rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z" />
                                </svg>
                                Manual de Usuario
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Barra de Filtros y Búsqueda -->
            <div class="mb-6 flex flex-col sm:flex-row items-center gap-4">
                <div class="relative flex-grow w-full sm:w-auto">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="search" id="busqueda" wire:model.live.debounce.300ms="busqueda" placeholder="Buscar por nombre o puesto..." class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                <div class="flex items-center gap-4 w-full sm:w-auto">
                    <select id="filtroEmpresa" wire:model.live="filtroEmpresa" class="w-full sm:w-56 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Todas las Empresas</option>
                        @foreach ($empresasFiltro as $empresa)
                        <option value="{{ $empresa->id_empresa }}">{{ $empresa->nombre_comercial }}</option>
                        @endforeach
                    </select>

                    <select id="filtroEstado" wire:model.live="filtroEstado" class="w-full sm:w-48 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Todos los Estados</option>
                        @foreach ($estadosFiltro as $estado)
                        <option value="{{ $estado }}">{{ ucfirst($estado) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Tabla de Departamentos -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <!-- Columna: ID Departamento -->
                                <th scope="col" wire:click="ordenar('id_departamento')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                    ID
                                    @if ($ordenarPor === 'id_departamento')
                                    <span>{{ $direccionOrden === 'asc' ? '▲' : '▼' }}</span>
                                    @endif
                                </th>

                                <!-- Columna: Nombre Departamento -->
                                <th scope="col" wire:click="ordenar('nombre_departamento')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                    Departamento
                                    @if ($ordenarPor === 'nombre_departamento')
                                    <span>{{ $direccionOrden === 'asc' ? '▲' : '▼' }}</span>
                                    @endif
                                </th>

                                <!-- Columna: Descripción -->
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Descripción
                                </th>

                                <!-- Columna: Empresa -->
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Empresa
                                </th>

                                <!-- Columna: Puesto -->
                                <th scope="col" wire:click="ordenar('puesto')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                    Puesto Principal
                                    @if ($ordenarPor === 'puesto')
                                    <span>{{ $direccionOrden === 'asc' ? '▲' : '▼' }}</span>
                                    @endif
                                </th>

                                <!-- Columna: Fecha de Registro -->
                                <th scope="col" wire:click="ordenar('fecha_registro_departamento')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                    Fecha de Registro
                                    @if ($ordenarPor === 'fecha_registro_departamento')
                                    <span>{{ $direccionOrden === 'asc' ? '▲' : '▼' }}</span>
                                    @endif
                                </th>

                                <!-- Columna: Estado -->
                                <th scope="col" wire:click="ordenar('estado')" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                    Estado
                                    @if ($ordenarPor === 'estado')
                                    <span>{{ $direccionOrden === 'asc' ? '▲' : '▼' }}</span>
                                    @endif
                                </th>

                                <!-- Columna: Acciones -->
                                <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Acciones</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($departamentos as $departamento)
                            <tr wire:key="{{ $departamento->id_departamento }}" class="hover:bg-gray-50 transition-colors duration-150">

                                <!-- Celda: ID Departamento -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $departamento->id_departamento }}
                                </td>

                                <!-- Celda: Nombre Departamento -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="h-12 w-12 rounded-lg bg-gradient-to-br from-blue-100 to-indigo-200 flex items-center justify-center text-indigo-700 font-bold flex-shrink-0 text-sm border border-indigo-200">
                                            {{ strtoupper(substr($departamento->nombre_departamento, 0, 2)) }}
                                        </span>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $departamento->nombre_departamento }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Celda: Descripción -->
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    <div class="max-w-xs truncate" title="{{ $departamento->descripcion }}">
                                        {{ $departamento->descripcion }}
                                    </div>
                                </td>

                                <!-- Celda: Empresa -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if ($departamento->empresa && $departamento->empresa->logo)
                                        <div class="h-10 w-10 rounded-lg bg-white border border-gray-200 flex items-center justify-center p-1 flex-shrink-0 shadow-sm">
                                            <img
                                                src="{{ asset('storage/' . $departamento->empresa->logo) }}"
                                                alt="Logo de {{ $departamento->empresa->nombre_comercial }}"
                                                class="max-h-full max-w-full object-contain">
                                        </div>
                                        @else
                                        <span class="h-10 w-10 rounded-lg bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center text-gray-600 font-bold flex-shrink-0 text-xs border border-gray-200">
                                            {{ $departamento->empresa ? strtoupper(substr($departamento->empresa->nombre_comercial, 0, 2)) : 'N/A' }}
                                        </span>
                                        @endif
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $departamento->empresa->nombre_comercial ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Celda: Puesto -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $departamento->puesto }}
                                </td>

                                <!-- Celda: Fecha de Registro -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $departamento->fecha_registro_departamento ? $departamento->fecha_registro_departamento->format('d/m/Y') : 'N/A' }}
                                </td>

                                <!-- Celda: Estado -->
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @if($departamento->estado == 'activo') bg-green-100 text-green-800 
                                        @else bg-red-100 text-red-800 
                                        @endif">
                                        {{ ucfirst($departamento->estado) }}
                                    </span>
                                </td>

                                <!-- Celda: Acciones -->
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <!-- Botón Ver -->
                                        <a
                                            href="{{ route('ver-departamento', $departamento) }}"
                                            wire:navigate
                                            class="inline-flex items-center p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors duration-200 group relative"
                                            title="Ver detalles">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">
                                                Ver detalles
                                            </span>
                                        </a>

                                        <!-- Botón Editar -->
                                        <a
                                            href="{{ route('editar-departamento', $departamento) }}"
                                            wire:navigate
                                            class="inline-flex items-center p-2 bg-indigo-50 text-indigo-600 rounded-lg hover:bg-indigo-100 transition-colors duration-200 group relative"
                                            title="Editar departamento">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">
                                                Editar
                                            </span>
                                        </a>

                                        <!-- Botón Eliminar -->
                                        <button
                                            x-data
                                            @click="$dispatch('confirm-delete', { id: {{ $departamento->id_departamento }} })"
                                            class="inline-flex items-center p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors duration-200 group relative"
                                            title="Eliminar departamento">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            <span class="absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">
                                                Eliminar
                                            </span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-6 py-12 text-center">
                                    <div class="text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                            <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">No se encontraron departamentos</h3>
                                        <p class="mt-1 text-sm text-gray-500">Intenta ajustar tu búsqueda o filtros.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Paginación -->
            <div class="mt-6 flex justify-end">
                {{ $departamentos->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:init', () => {
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
                    Livewire.dispatch('delete-confirmed', {
                        id: data.id
                    });
                }
            });
        });
    });
</script>
@endpush