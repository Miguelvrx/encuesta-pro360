<div>
    <div class="min-h-screen bg-gradient-to-b from-blue-50 to-white  max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8 ">

        {{-- 1. Encabezado Principal --}}
        <div class="bg-blue-700 rounded-lg shadow-lg p-4 mb-6 flex justify-between items-center">
            <h1 class="text-xl font-bold text-white">Banco de Competencias</h1>
            <a href="#" class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md text-blue-700 bg-white hover:bg-blue-50">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                </svg>
                Manual de Usuario
            </a>
        </div>

        {{-- 2. Barra de Filtros --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="md:col-span-2">
                <label for="busqueda" class="block text-sm font-medium text-gray-700">Buscar</label>
                <div class="relative mt-1">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="search" wire:model.live.debounce.300ms="busqueda" id="busqueda" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Buscar por nombre de competencia...">
                </div>
            </div>
            <div>
                <label for="categoria" class="block text-sm font-medium text-gray-700">Categoría</label>
                <select wire:model.live="categoriaFiltro" id="categoria" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                    <option value="">Todas</option>
                    @foreach($categorias as $categoria )
                    <option value="{{ $categoria->id_categoria_competencia }}">{{ $categoria->categoria }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- 3. Listado de Competencias --}}
        <div class="space-y-8">
            @forelse ($competencias as $competencia)
            <div wire:key="competencia-{{ $competencia->id_competencia }}" class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-200/80">
                <div class="p-6 sm:p-8">
                    {{-- Encabezado de la tarjeta --}}
                    <div class="flex justify-between items-start gap-4">
                        <div>
                            <span class="inline-block px-3 py-1 text-xs font-semibold leading-5 rounded-full bg-blue-100 text-blue-800">
                                {{ $competencia->categoria->categoria ?? 'Sin categoría' }}
                            </span>
                            <h2 class="mt-3 text-2xl font-bold text-gray-900">{{ $competencia->nombre_competencia }}</h2>
                            <p class="mt-2 text-base text-gray-600 max-w-3xl">{{ $competencia->definicion_competencia }}</p>
                        </div>
                        <a href="{{ route('editar-competencia', ['competencia' => $competencia->id_competencia]) }}" class="flex-shrink-0 ml-4 inline-flex items-center justify-center px-6 py-2 border border-transparent text-sm font-semibold rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-transform transform hover:scale-105">
                            Editar
                        </a>
                    </div>

                    {{-- Separador y título de niveles --}}
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h4 class="text-xs font-bold text-gray-500 uppercase tracking-widest">Niveles de Comportamiento</h4>

                        {{-- Listado de niveles --}}
                        <div class="mt-6 space-y-6">
                            @forelse ($competencia->niveles as $index => $nivel)
                            <div class="grid grid-cols-12 gap-x-4 sm:gap-x-6">
                                {{-- Columna 1: Número --}}
                                <div class="col-span-1 text-center">
                                    <span class="text-lg font-bold text-gray-400">{{ $index + 1 }}</span>
                                </div>

                                {{-- Columna 2: Nombre del Nivel --}}
                                <div class="col-span-11 sm:col-span-4 md:col-span-3">
                                    <p class="font-semibold text-gray-900">{{ $nivel->nombre_nivel }}</p>
                                </div>

                                {{-- Columna 3: Descripción --}}
                                <div class="col-span-12 sm:col-span-7 md:col-span-8 sm:col-start-6 md:col-start-5 mt-1 sm:mt-0">
                                    <p class="text-gray-600">{{ $nivel->descripcion_nivel }}</p>
                                </div>
                            </div>
                            @empty
                            <p class="text-gray-500 italic">Esta competencia aún no tiene niveles definidos.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center bg-white p-12 rounded-lg shadow-md border">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No se encontraron competencias</h3>
                <p class="mt-1 text-sm text-gray-500">Intenta ajustar los filtros o crea una nueva competencia.</p>
            </div>
            @endforelse
        </div>


        {{-- 4. Paginación --}}
        @if ($competencias->hasPages())
        <div class="mt-8">
            {{ $competencias->links() }}
        </div>
        @endif
    </div>
</div>