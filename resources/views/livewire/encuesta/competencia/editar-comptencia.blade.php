{{-- resources/views/livewire/encuesta/competencia/editar-competencia.blade.php --}}
<div>
    <div class="max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <form wire:submit.prevent="update" class="space-y-8">

            {{-- Bloque de Información Principal --}}
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4">
                    <h1 class="text-2xl font-bold text-white">Editar Competencia</h1>
                    <p class="text-sm text-indigo-200 mt-1">Modifica la categoría, competencia y sus niveles de comportamiento.</p>
                </div>
                <div class="p-6 space-y-6">
                    
                    {{-- 1. Categoría (Primero) --}}
                    <div>
                        <label for="categoria" class="block text-sm font-medium text-gray-700">
                            Categoría <span class="text-red-500">*</span>
                        </label>
                        <select 
                            wire:model.live="categoria_id_competencia" 
                            id="categoria" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Selecciona una categoría</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id_categoria_competencia }}">{{ $categoria->categoria }}</option>
                            @endforeach
                        </select>
                        @error('categoria_id_competencia') 
                            <span class="text-red-500 text-sm">{{ $message }}</span> 
                        @enderror
                    </div>

                    {{-- 2. Nombre de la Competencia (Select dinámico) --}}
                    <div>
                        <label for="nombre_competencia" class="block text-sm font-medium text-gray-700">
                            Nombre de la Competencia <span class="text-red-500">*</span>
                        </label>
                        <select 
                            wire:model.live="nombre_competencia" 
                            id="nombre_competencia"
                            @if(!$categoria_id_competencia) disabled @endif
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 disabled:bg-gray-100 disabled:cursor-not-allowed">
                            <option value="">
                                @if($categoria_id_competencia)
                                    Selecciona una competencia
                                @else
                                    Primero selecciona una categoría
                                @endif
                            </option>
                            @foreach($competenciasDisponibles as $competencia)
                                <option value="{{ $competencia }}">{{ $competencia }}</option>
                            @endforeach
                        </select>
                        @error('nombre_competencia') 
                            <span class="text-red-500 text-sm">{{ $message }}</span> 
                        @enderror
                    </div>

                    {{-- 3. Definición (Autocompletada, editable) --}}
                    <div>
                        <label for="definicion_competencia" class="block text-sm font-medium text-gray-700">
                            Definición de la Competencia <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            wire:model="definicion_competencia" 
                            id="definicion_competencia" 
                            rows="3" 
                            placeholder="Selecciona una competencia para ver su definición..."
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        @error('definicion_competencia') 
                            <span class="text-red-500 text-sm">{{ $message }}</span> 
                        @enderror
                        @if($nombre_competencia)
                            <p class="text-xs text-gray-500 mt-1">
                                💡 Puedes editar la definición si lo necesitas
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Bloque Fijo de 5 Niveles --}}
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-gray-700 to-gray-800 px-6 py-4">
                    <h2 class="text-lg font-semibold text-white">Niveles de Comportamiento</h2>
                    <p class="text-sm text-gray-300 mt-1">Describe el comportamiento observable para cada nivel estándar.</p>
                </div>
                <div class="p-6 space-y-6">
                    @foreach ($niveles as $index => $nivel)
                    <div wire:key="nivel-{{ $index }}" class="p-4 border border-gray-200 rounded-lg hover:border-gray-300 transition-colors">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-4 items-start">
                            
                            {{-- Columna Izquierda: Nombre y Descripción del Nivel --}}
                            <div class="md:col-span-1">
                                <label class="block text-sm font-medium text-gray-700">Nivel</label>
                                <div class="mt-2 flex items-baseline gap-3">
                                    <span class="text-3xl font-bold text-indigo-600">{{ $nivel['numero'] }}</span>
                                    <div>
                                        <p class="text-lg font-semibold text-gray-800">{{ $nivel['nombre_nivel'] }}</p>
                                        <p class="text-xs text-gray-500 italic">"{{ $nivel['tagline'] }}"</p>
                                    </div>
                                </div>
                                <input type="hidden" wire:model="niveles.{{ $index }}.nombre_nivel">
                                <input type="hidden" wire:model="niveles.{{ $index }}.id_nivel">
                            </div>

                            {{-- Columna Derecha: Textarea para el Comportamiento Observable --}}
                            <div class="md:col-span-2">
                                <label for="nivel_descripcion_{{ $index }}" class="block text-sm font-medium text-gray-700">
                                    Descripción del Comportamiento Observable <span class="text-red-500">*</span>
                                </label>
                                <textarea
                                    wire:model="niveles.{{ $index }}.descripcion_nivel"
                                    id="nivel_descripcion_{{ $index }}"
                                    rows="4"
                                    placeholder="Describe qué hace una persona en el nivel '{{ $nivel['nombre_nivel'] }}'..."
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                                @error('niveles.'.$index.'.descripcion_nivel') 
                                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                                @enderror
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Botones de Acción --}}
            <div class="flex justify-center space-x-4 pt-4">
                <a 
                    href="{{ route('revisar-competencia') }}" 
                    wire:navigate 
                    class="px-8 py-3 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 transition-colors">
                    Cancelar
                </a>
                <button 
                    type="submit" 
                    class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-medium rounded-lg hover:from-indigo-700 hover:to-indigo-800 transition-all">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>