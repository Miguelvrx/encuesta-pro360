<div>
    <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

        <!-- 1. Cabecera: Título y Botón de Creación -->
        <header class="mb-8">
            <div class="flex justify-between items-center bg-white p-6 rounded-xl shadow-md">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Listado de Departamentos</h1>
                    <p class="mt-1 text-sm text-gray-500">Gestiona los departamentos de todas las empresas.</p>
                </div>
                <a href="{{ route('crear-departamento') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold text-sm rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Nuevo Departamento
                </a>
            </div>
        </header>

        <!-- 2. Barra de Filtros y Búsqueda -->
        <div class="mb-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="col-span-1 sm:col-span-2">
                <input type="search" wire:model.live.debounce.300ms="busqueda" placeholder="Buscar por nombre o puesto..." class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
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
                <select wire:model.live="filtroEstado" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Todos los Estados</option>
                    @foreach ($estadosFiltro as $estado)
                    <option value="{{ $estado }}">{{ ucfirst($estado) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- 3. Tabla de Departamentos -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" wire:click="ordenar('nombre_departamento')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">Departamento @if ($ordenarPor === 'nombre_departamento')<span>{{ $direccionOrden === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Empresa</th>
                            <th scope="col" wire:click="ordenar('puesto')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">Puesto Principal @if ($ordenarPor === 'puesto')<span>{{ $direccionOrden === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                            <th scope="col" wire:click="ordenar('estado')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">Estado @if ($ordenarPor === 'estado')<span>{{ $direccionOrden === 'asc' ? '▲' : '▼' }}</span>@endif</th>
                            <th scope="col" class="relative px-6 py-3"><span class="sr-only">Acciones</span></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($departamentos as $departamento)
                        <tr wire:key="{{ $departamento->id_departamento }}" class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $departamento->nombre_departamento }}</div>
                                <div class="text-sm text-gray-500 truncate max-w-xs">{{ $departamento->descripcion }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $departamento->empresa->nombre_comercial ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $departamento->puesto }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $departamento->estado == 'activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($departamento->estado) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                {{-- NOTA: Las rutas 'ver-departamento' y 'editar-departamento' aún no existen. Las crearemos después. --}}
                                <a href="{{ route('ver-departamento', $departamento) }}" wire:navigate class="text-blue-600 hover:text-blue-900">Ver</a>
                                <a href="{{ route('editar-departamento', $departamento) }}" wire:navigate class="ml-4 text-indigo-600 hover:text-indigo-900">Editar</a>
                                <button x-data @click="$dispatch('confirm-delete', { id: {{ $departamento->id_departamento }} })" class="ml-4 text-red-600 hover:text-red-900 font-medium">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No se encontraron departamentos</h3>
                                    <p class="mt-1 text-sm text-gray-500">Intenta ajustar tu búsqueda o crea un nuevo departamento.</p>
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
            {{ $departamentos->links() }}
        </div>
    </div>
</div>

{{-- Al final de resources/views/livewire/encuesta/departamento/mostrar-departamento.blade.php --}}

{{-- ... (código de la tabla y paginación) ... --}}

@push('scripts')
<script>
    // Usamos document.addEventListener para asegurarnos de que el DOM esté listo.
    document.addEventListener('livewire:init', () => {
        
        // Listener para el modal de confirmación
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
                    Livewire.dispatch('delete-confirmed', { id: data.id });
                }
            });
        });

        // (Opcional) Listener para toasts de éxito/error si los usas en esta página
        Livewire.on('swal-toast', (event) => {
            const data = event[0];
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
            });
            Toast.fire({
                icon: data.icon,
                title: data.title
            });
        });
    });
</script>
@endpush
