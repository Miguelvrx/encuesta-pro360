<div>
    <div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <form wire:submit.prevent="update" class="space-y-8">

            {{-- Bloque de Información Principal --}}
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4">
                    {{-- Título cambiado --}}
                    <h1 class="text-2xl font-bold text-white">Editar Competencia</h1>
                    <p class="text-sm text-indigo-200 mt-1">Modifica los detalles de la competencia y sus niveles.</p>
                </div>

                <div class="p-6 space-y-6">
                    {{-- El resto del formulario es idéntico --}}
                    <div>
                        <label for="nombre_competencia" class="block text-sm font-medium text-gray-700">Nombre de la Competencia</label>
                        <input type="text" wire:model="nombre_competencia" id="nombre_competencia" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('nombre_competencia') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="definicion_competencia" class="block text-sm font-medium text-gray-700">Definición de la Competencia</label>
                        <textarea wire:model="definicion_competencia" id="definicion_competencia" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        @error('definicion_competencia') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="categoria" class="block text-sm font-medium text-gray-700">Categoría</label>
                        <select wire:model="categoria_id_competencia" id="categoria" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Selecciona una categoría</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id_categoria_competencia }}">{{ $categoria->categoria }}</option>
                            @endforeach
                        </select>
                        @error('categoria_id_competencia') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            {{-- Bloque Dinámico de Niveles --}}
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-6 py-4">
                    <h2 class="text-lg font-semibold text-white">Niveles de Comportamiento</h2>
                </div>

                <div class="p-6 space-y-6">
                    @foreach ($niveles as $index => $nivel)
                        <div wire:key="nivel-{{ $index }}" class="p-4 border border-gray-200 rounded-lg relative">
                            <button type="button" wire:click="eliminarNivel({{ $index }})" class="absolute top-2 right-2 text-gray-400 hover:text-red-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                            <div class="grid grid-cols-1 gap-6">
                                <div>
                                    <label for="nivel_nombre_{{ $index }}" class="block text-sm font-medium text-gray-700">Nombre del Nivel {{ $index + 1 }}</label>
                                    <input type="text" wire:model="niveles.{{ $index }}.nombre_nivel" id="nivel_nombre_{{ $index }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    @error('niveles.'.$index.'.nombre_nivel') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label for="nivel_descripcion_{{ $index }}" class="block text-sm font-medium text-gray-700">Descripción del Comportamiento</label>
                                    <textarea wire:model="niveles.{{ $index }}.descripcion_nivel" id="nivel_descripcion_{{ $index }}" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
                                    @error('niveles.'.$index.'.descripcion_nivel') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="flex justify-start">
                        <button type="button" wire:click="añadirNivel" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700">
                            Añadir Nivel
                        </button>
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="flex justify-center space-x-4 pt-4">
                <a href="{{ route('revisar-competencia') }}" wire:navigate class="px-8 py-3 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300">
                    Cancelar
                </a>
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-medium rounded-lg hover:from-indigo-700 hover:to-indigo-800">
                    {{-- Texto del botón cambiado --}}
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>
