<div>
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        {{-- Mensajes Flash --}}
        @if (session()->has('message'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-lg">
            <div class="flex">
                <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                </svg>
                <p class="ml-3 text-sm text-green-700">{{ session('message') }}</p>
            </div>
        </div>
        @endif

        {{-- Panel de Gestión --}}
        <div class="bg-white rounded-lg shadow-md border border-gray-200/80">
            <div class="bg-indigo-700 rounded-t-lg p-4 flex justify-between items-center">
                <h1 class="text-xl font-bold text-white">Gestión de Preguntas por Competencia</h1>
                <a href="{{ route('catalogo-competencia') }}" wire:navigate class="inline-flex items-center px-3 py-1.5 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-white hover:bg-indigo-50 transition-colors">
                    <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                    </svg>
                    Ver Catálogo
                </a>
            </div>

            <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- Filtro Categoría --}}
                <div>
                    <label for="categoria" class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
                    <select wire:model.live="categoriaSeleccionada" id="categoria" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="">Selecciona una categoría</option>
                        @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id_categoria_competencia }}">{{ $categoria->categoria }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Filtro Competencia --}}
                <div>
                    <label for="competencia" class="block text-sm font-medium text-gray-700 mb-1">Competencia</label>
                    <select wire:model.live="competenciaSeleccionada" id="competencia" class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md disabled:bg-gray-100 disabled:cursor-not-allowed" @if($competenciasFiltradas->isEmpty()) disabled @endif>
                        <option value="">
                            @if($categoriaSeleccionada && $competenciasFiltradas->isNotEmpty())
                            Selecciona una competencia
                            @else
                            Primero selecciona una categoría
                            @endif
                        </option>
                        @foreach($competenciasFiltradas as $comp)
                        <option value="{{ $comp->id_competencia }}">{{ $comp->nombre_competencia }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Botón Agregar Pregunta --}}
                <div class="flex items-end">
                    <button wire:click="abrirModal" type="button" class="w-full inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed" @if(!$competenciaActual) disabled @endif>
                        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Nueva Pregunta
                    </button>
                </div>
            </div>
        </div>

        {{-- Área de Contenido --}}
        <div class="mt-8">
            @if ($competenciaActual)
            {{-- Info de la Competencia --}}
            <div class="bg-gradient-to-r from-indigo-50 to-blue-50 rounded-lg p-6 mb-6 border border-indigo-200">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" />
                        </svg>
                    </div>
                    <div class="ml-4 flex-1">
                        <span class="inline-block px-2.5 py-0.5 text-xs font-semibold rounded-full bg-indigo-100 text-indigo-800 mb-2">
                            {{ $competenciaActual->categoria->categoria ?? 'Sin categoría' }}
                        </span>
                        <h3 class="text-lg font-bold text-gray-900">{{ $competenciaActual->nombre_competencia }}</h3>
                        <p class="mt-1 text-sm text-gray-600">{{ $competenciaActual->definicion_competencia }}</p>
                        <div class="mt-2 text-xs text-gray-500">
                            <strong>Niveles definidos:</strong> {{ $competenciaActual->niveles->count() }} |
                            <strong>Preguntas creadas:</strong> {{ $competenciaActual->preguntas->count() }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Listado de Preguntas --}}
            @if($competenciaActual->preguntas->isNotEmpty())
            <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-900">Preguntas Asociadas</h3>
                </div>
                <ul class="divide-y divide-gray-200">
                    @foreach($competenciaActual->preguntas as $pregunta)
                    <li class="px-6 py-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start justify-between">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="flex-shrink-0 inline-flex items-center justify-center w-8 h-8 rounded-full bg-indigo-100 text-indigo-700 font-bold text-sm">
                                        {{ $pregunta->orden }}
                                    </span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $pregunta->activa ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $pregunta->activa ? 'Activa' : 'Inactiva' }}
                                    </span>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Max: {{ $pregunta->puntuacion_maxima }} pts
                                    </span>
                                </div>
                                <h4 class="text-base font-semibold text-gray-900">{{ $pregunta->texto_pregunta }}</h4>
                                <p class="mt-1 text-sm text-gray-600">{{ $pregunta->descripcion_pregunta }}</p>
                            </div>

                            <div class="ml-4 flex-shrink-0 flex items-center gap-2">
                                <button wire:click="editarPregunta({{ $pregunta->id_pregunta }})" type="button" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                                    <svg class="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                    Editar
                                </button>
                                <button wire:click="cambiarEstado({{ $pregunta->id_pregunta }})" type="button" class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded-md {{ $pregunta->activa ? 'text-red-700 bg-white hover:bg-red-50' : 'text-green-700 bg-white hover:bg-green-50' }} transition-colors">
                                    {{ $pregunta->activa ? 'Desactivar' : 'Activar' }}
                                </button>
                                <button wire:click="eliminarPregunta({{ $pregunta->id_pregunta }})" wire:confirm="¿Estás seguro de eliminar esta pregunta?" type="button" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-red-600 hover:bg-red-700 transition-colors">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            @else
            <div class="text-center bg-white p-12 rounded-lg shadow-md border border-dashed border-gray-300">
                <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">No hay preguntas</h3>
                <p class="mt-1 text-sm text-gray-500">Comienza agregando la primera pregunta para esta competencia.</p>
                <button wire:click="abrirModal" type="button" class="mt-4 inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                    <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Agregar Primera Pregunta
                </button>
            </div>
            @endif

            @else
            {{-- Vista inicial --}}
            <div class="text-center bg-white p-12 rounded-lg shadow-md border">
                <svg class="mx-auto h-12 w-12 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                </svg>
                <h3 class="mt-2 text-lg font-medium text-gray-900">Gestión de Preguntas</h3>
                <p class="mt-1 text-sm text-gray-500">Selecciona una categoría y una competencia para comenzar a gestionar sus preguntas.</p>
            </div>
            @endif
        </div>

        {{-- Modal para Crear/Editar Pregunta --}}
        @if($modalAbierto)
        <div class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="cerrarModal"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                    <form wire:submit="guardarPregunta">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-indigo-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <svg class="h-6 w-6 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                                    </svg>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                        {{ $preguntaEditando ? 'Editar Pregunta' : 'Nueva Pregunta' }}
                                    </h3>
                                    <div class="mt-4 space-y-4">
                                        {{-- Texto de la Pregunta --}}
                                        <div>
                                            <label for="texto_pregunta" class="block text-sm font-medium text-gray-700">Texto de la Pregunta *</label>
                                            <textarea wire:model="texto_pregunta" id="texto_pregunta" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Ejemplo: ¿Cómo te organizas para cumplir tus metas laborales?"></textarea>
                                            @error('texto_pregunta') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                        </div>

                                        {{-- Descripción de la Pregunta --}}
                                        <div>
                                            <label for="descripcion_pregunta" class="block text-sm font-medium text-gray-700">Descripción / Instrucciones *</label>
                                            <textarea wire:model="descripcion_pregunta" id="descripcion_pregunta" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" placeholder="Proporciona contexto o instrucciones adicionales para responder esta pregunta..."></textarea>
                                            @error('descripcion_pregunta') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            {{-- Puntuación Máxima --}}
                                            <div>
                                                <label for="puntuacion_maxima" class="block text-sm font-medium text-gray-700">Puntuación Máxima *</label>
                                                <input wire:model="puntuacion_maxima" type="number" id="puntuacion_maxima" min="1" max="10" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                @error('puntuacion_maxima') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                            </div>

                                            {{-- Orden --}}
                                            <div>
                                                <label for="orden" class="block text-sm font-medium text-gray-700">Orden *</label>
                                                <input wire:model="orden" type="number" id="orden" min="1" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                @error('orden') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                                            </div>

                                            {{-- Estado Activa --}}
                                            <div>
                                                <label for="activa" class="block text-sm font-medium text-gray-700">Estado</label>
                                                <div class="mt-2">
                                                    <label class="inline-flex items-center">
                                                        <input wire:model="activa" type="checkbox" id="activa" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                                        <span class="ml-2 text-sm text-gray-700">Pregunta activa</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                                {{ $preguntaEditando ? 'Actualizar' : 'Guardar' }}
                            </button>
                            <button wire:click="cerrarModal" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>