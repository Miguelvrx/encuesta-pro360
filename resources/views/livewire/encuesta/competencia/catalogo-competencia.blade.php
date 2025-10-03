<div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

    {{-- 1. Panel de Gestión --}}
    <div class="bg-white rounded-lg shadow-md border border-gray-200/80">
        <div class="bg-blue-700 rounded-t-lg p-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-white">Gestión de Competencia</h1>
            <a href="#" class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md text-blue-700 bg-white hover:bg-blue-50">
                Manual de Usuario
            </a>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            {{-- Filtro Categoría --}}
            <div>
                <label for="categoria" class="block text-sm font-medium text-gray-700">Categoría</label>
                <select wire:model.live="categoriaSeleccionada" id="categoria" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                    <option value="">Selecciona una categoría</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id_categoria_competencia }}">{{ $categoria->categoria }}</option>
                    @endforeach
                </select>
            </div>
            {{-- Filtro Competencia --}}
            <div>
                <label for="competencia" class="block text-sm font-medium text-gray-700">Competencia</label>
                <select wire:model.live="competenciaSeleccionada" id="competencia" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md" @if($competenciasFiltradas->isEmpty()) disabled @endif>
                    <option value="">Selecciona una competencia</option>
                    @foreach($competenciasFiltradas as $comp)
                        <option value="{{ $comp->id_competencia }}">{{ $comp->nombre_competencia }}</option>
                    @endforeach
                </select>
            </div>
            {{-- Botón Ver Competencia (enlace a la otra vista) --}}
            <a href="{{ route('revisar-competencia') }}" wire:navigate class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                <svg class="w-5 h-5 mr-2 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>
                Banco de Competencia
            </a>
            {{-- Botón Crear Nueva --}}
            <a href="{{ route('crear-competencia' ) }}" wire:navigate class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" /></svg>
                Crear Nueva Competencia
            </a>
        </div>
    </div>

    {{-- 2. Área de Detalles de la Competencia --}}
    <div class="mt-8">
        @if ($competenciaActual )
            <div class="bg-white rounded-lg shadow-md border border-gray-200/80 overflow-hidden">
                {{-- Nombre --}}
                <div class="bg-blue-700 p-4">
                    <h2 class="text-lg font-bold text-white">Nombre de la competencia</h2>
                </div>
                <div class="p-4 text-gray-800">
                    {{ $competenciaActual->nombre_competencia }}
                </div>

                {{-- Definición --}}
                <div class="bg-blue-700 p-4 mt-4">
                    <h2 class="text-lg font-bold text-white">Definición de competencia</h2>
                </div>
                <div class="p-4 text-gray-600">
                    {{ $competenciaActual->definicion_competencia }}
                </div>

                {{-- Niveles --}}
                <div class="bg-blue-700 p-4 mt-4">
                    <h2 class="text-lg font-bold text-white">Niveles de Comportamientos</h2>
                </div>
                <div class="p-4">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">ID</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-3/12">Nivel de Comportamiento</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-8/12">Descripción</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($competenciaActual->niveles as $index => $nivel)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $nivel->nombre_nivel }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $nivel->descripcion_nivel }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="text-center bg-white p-12 rounded-lg shadow-md border">
                <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">Catálogo de Competencias</h3>
                <p class="mt-1 text-sm text-gray-500">Selecciona una categoría y una competencia para ver sus detalles.</p>
            </div>
        @endif
    </div>
</div>
