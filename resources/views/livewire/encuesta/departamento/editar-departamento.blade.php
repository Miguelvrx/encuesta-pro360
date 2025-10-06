<div>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-white py-8 px-4 sm:px-6 lg:px-8">

        {{-- 1. El formulario ahora llama al método 'update' --}}
        <form wire:submit.prevent="update" class="space-y-8 max-w-5xl mx-auto">

            <!-- Cabecera del Formulario -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                {{-- 2. Títulos y colores ajustados para la edición --}}
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-2xl font-bold text-white">Editar Departamento</h1>
                            <p class="text-sm text-indigo-200 mt-1">Modifica la información del departamento.</p>
                        </div>
                        {{-- Puedes mantener el botón del manual si quieres --}}
                    </div>
                </div>

                <!-- Cuerpo del Formulario (idéntico al de creación) -->
                <div class="p-6 space-y-6">

                    <!-- Selector de Empresa -->
                    <div>
                        <label for="empresa" class="block text-sm font-medium text-gray-700 mb-2">Empresa a la que pertenece <span class="text-red-500">*</span></label>
                        <select wire:model="empresa_id_empresa" id="empresa" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('empresa_id_empresa') border-red-500 @enderror">
                            <option value="">Selecciona una empresa</option>
                            @foreach ($empresas as $empresa)
                            <option value="{{ $empresa->id_empresa }}">{{ $empresa->nombre_comercial }}</option>
                            @endforeach
                        </select>
                        @error('empresa_id_empresa') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Nombre del Departamento -->
                    <div>
                        <label for="nombre_departamento" class="block text-sm font-medium text-gray-700 mb-2">Nombre del Departamento <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="nombre_departamento" id="nombre_departamento" placeholder="Ej. Recursos Humanos, Finanzas, TI" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('nombre_departamento') border-red-500 @enderror">
                        @error('nombre_departamento') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Descripción -->
                    <div>
                        <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-2">Descripción <span class="text-red-500">*</span></label>
                        <textarea wire:model="descripcion" id="descripcion" rows="4" placeholder="Describe las funciones y responsabilidades principales del departamento..." class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('descripcion') border-red-500 @enderror"></textarea>
                        @error('descripcion') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Puesto Principal -->
                        <div>
                            <label for="puesto" class="block text-sm font-medium text-gray-700 mb-2">Puesto Principal del Departamento <span class="text-red-500">*</span></label>
                            <input type="text" wire:model="puesto" id="puesto" placeholder="Ej. Gerente de RRHH, Director Financiero" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('puesto') border-red-500 @enderror">
                            @error('puesto') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- Estado -->
                        <div>
                            <label for="estado" class="block text-sm font-medium text-gray-700 mb-2">Estado <span class="text-red-500">*</span></label>
                            <select wire:model="estado" id="estado" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors @error('estado') border-red-500 @enderror">
                                <option value="activo">Activo</option>
                                <option value="inactivo">Inactivo</option>
                            </select>
                            @error('estado') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="flex justify-center space-x-4 pt-6">
                <a href="{{ route('mostrar-departamento') }}" wire:navigate class="px-8 py-3 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300">
                    Cancelar
                </a>
                {{-- 3. Texto del botón ajustado para la edición --}}
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-medium rounded-lg hover:from-indigo-700 hover:to-indigo-800">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>