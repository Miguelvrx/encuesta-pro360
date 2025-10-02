<div>
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

        <!-- Cabecera -->
        <header class="mb-8">
            <div class="flex justify-between items-center bg-white p-6 rounded-xl shadow-md">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Listado de Usuarios</h1>
                    <p class="mt-1 text-sm text-gray-500">Gestiona los usuarios del sistema.</p>
                </div>
                <a href="{{ route('crear-usuario') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold text-sm rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.5a2.25 2.25 0 0 1 2.25-2.25H18.75a2.25 2.25 0 0 1 2.25 2.25V21" />
                    </svg>
                    Nuevo Usuario
                </a>
            </div>
        </header>

        <!-- Barra de Filtros -->
        <div class="mb-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="col-span-1 sm:col-span-2">
                <input type="search" wire:model.live.debounce.300ms="busqueda" placeholder="Buscar por nombre, apellido o email..." class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div>
                <select wire:model.live="filtroEmpresa" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Todas las Empresas</option>
                    @foreach ($empresasFiltro as $empresa )
                    <option value="{{ $empresa->id_empresa }}">{{ $empresa->nombre_comercial }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select wire:model.live="filtroRol" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Todos los Roles</option>
                    @foreach ($rolesFiltro as $id => $nombre)
                    <option value="{{ $id }}">{{ $nombre }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Tabla de Usuarios -->
        {{-- En resources/views/livewire/encuesta/usuario/mostrar-usuario.blade.php --}}

        <!-- Tabla de Usuarios -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            {{-- --- INICIO DE LA MODIFICACIÓN (CABECERA) --- --}}

                            {{-- 1. Columna para Nombre --}}
                            <th scope="col" wire:click="ordenar('name')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                Nombre @if ($ordenarPor === 'name')<span>{{ $direccionOrden === 'asc' ? '▲' : '▼' }}</span>@endif
                            </th>

                            {{-- 2. Nueva Columna para Email --}}
                            <th scope="col" wire:click="ordenar('email')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                Email @if ($ordenarPor === 'email')<span>{{ $direccionOrden === 'asc' ? '▲' : '▼' }}</span>@endif
                            </th>

                            {{-- 3. Nueva Columna para Empresa --}}
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Empresa
                            </th>

                            {{-- 4. Nueva Columna para Departamento --}}
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Departamento
                            </th>

                            {{-- 5. Nueva Columna para Puesto --}}
                            <th scope="col" wire:click="ordenar('puesto')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                Puesto @if ($ordenarPor === 'puesto')<span>{{ $direccionOrden === 'asc' ? '▲' : '▼' }}</span>@endif
                            </th>

                            {{-- 6. Columna para Rol (sin cambios) --}}
                            <th scope="col" wire:click="ordenar('rol')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                Rol @if ($ordenarPor === 'rol')<span>{{ $direccionOrden === 'asc' ? '▲' : '▼' }}</span>@endif
                            </th>

                            {{-- 7. Columna para Estado (sin cambios) --}}
                            <th scope="col" wire:click="ordenar('estado')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                Estado @if ($ordenarPor === 'estado')<span>{{ $direccionOrden === 'asc' ? '▲' : '▼' }}</span>@endif
                            </th>

                            {{-- 8. Columna para Acciones (sin cambios) --}}
                            <th scope="col" class="relative px-6 py-3"><span class="sr-only">Acciones</span></th>

                            {{-- --- FIN DE LA MODIFICACIÓN (CABECERA) --- --}}
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($usuarios as $usuario)
                        <tr wire:key="{{ $usuario->id }}" class="hover:bg-gray-50">

                            {{-- --- INICIO DE LA MODIFICACIÓN (CUERPO) --- --}}

                            {{-- 1. Celda para Nombre (con foto) --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <img class="h-10 w-10 rounded-full object-cover" src="{{ $usuario->profile_photo_url }}" alt="{{ $usuario->name }}">
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $usuario->name }} {{ $usuario->primer_apellido }}</div>
                                        <div class="text-sm text-gray-500">{{ $usuario->puesto }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- 2. Nueva Celda para Email --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $usuario->email }}
                            </td>

                            {{-- 3. Nueva Celda para Empresa --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $usuario->departamento->empresa->nombre_comercial ?? 'N/A' }}
                            </td>

                            {{-- 4. Nueva Celda para Departamento --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $usuario->departamento->nombre_departamento ?? 'N/A' }}
                            </td>

                            {{-- 5. Nueva Celda para Puesto --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $usuario->puesto }}
                            </td>

                            {{-- 6. Celda para Rol --}}
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $rolesFiltro[$usuario->rol] ?? 'Rol Desconocido' }}
                            </td>

                            {{-- 7. Celda para Estado --}}
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $usuario->estado == 'activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($usuario->estado) }}
                                </span>
                            </td>

                            {{-- 8. Celda para Acciones --}}
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('ver-usuario', $usuario) }}" wire:navigate class="text-blue-600 hover:text-blue-900">Ver</a>
                                <a href="{{ route('editar-usuario', $usuario) }}" wire:navigate class="ml-4 text-indigo-600 hover:text-indigo-900">Editar</a>
                                <button
                                    x-data
                                    @click="$dispatch('confirm-delete', { id: {{ $usuario->id }} })"
                                    class="ml-4 text-red-600 hover:text-red-900 font-medium">
                                    Eliminar
                                </button>
                            </td>

                            {{-- --- FIN DE LA MODIFICACIÓN (CUERPO) --- --}}
                        </tr>
                        @empty
                        <tr>
                            {{-- 9. Ajustamos el colspan para que ocupe todas las nuevas columnas --}}
                            <td colspan="8" class="px-6 py-12 text-center">
                                <h3 class="text-sm font-medium text-gray-900">No se encontraron usuarios</h3>
                                <p class="mt-1 text-sm text-gray-500">Intenta ajustar tu búsqueda o crea un nuevo usuario.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>


        <!-- Paginación -->
        <div class="mt-6">
            {{ $usuarios->links() }}
        </div>
    </div>
</div>


@push('scripts')
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
@endpush