<div>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-white py-8 px-4 sm:px-6 lg:px-8">
        {{-- El elemento raíz es el FORMULARIO --}}
        <form wire:submit.prevent="save" class="space-y-8 max-w-5xl mx-auto">

            <!-- Cabecera del Formulario -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-2xl font-bold text-white">Agregar un Nuevo Departamento</h1>
                            <p class="text-sm text-blue-200 mt-1">Complete la información para registrar un departamento.</p>
                        </div>
                        <a href="#" class="hidden sm:inline-flex items-center px-4 py-2 bg-white/20 text-white font-semibold text-sm rounded-lg shadow-sm hover:bg-white/30 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z"></path>
                            </svg>
                            Manual de Usuario
                        </a>
                    </div>
                </div>

                <!-- Cuerpo del Formulario -->
                <div class="p-6 space-y-6">

                    <!-- Selector de Empresa -->
                    <div>
                        <label for="empresa" class="block text-sm font-medium text-gray-700 mb-2">Empresa a la que pertenece <span class="text-red-500">*</span></label>
                        <select wire:model="empresa_id_empresa" id="empresa" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('empresa_id_empresa') border-red-500 @enderror">
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
                        <input type="text" wire:model="nombre_departamento" id="nombre_departamento" placeholder="Ej. Recursos Humanos, Finanzas, TI" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('nombre_departamento') border-red-500 @enderror">
                        @error('nombre_departamento') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    <!-- Descripción -->
                    <div>
                        <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-2">Descripción <span class="text-red-500">*</span></label>
                        <textarea wire:model="descripcion" id="descripcion" rows="4" placeholder="Describe las funciones y responsabilidades principales del departamento..." class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('descripcion') border-red-500 @enderror"></textarea>
                        @error('descripcion') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Puesto Principal -->
                        <div>
                            <label for="puesto" class="block text-sm font-medium text-gray-700 mb-2">Puesto Principal del Departamento <span class="text-red-500">*</span></label>
                            <input type="text" wire:model="puesto" id="puesto" placeholder="Ej. Gerente de RRHH, Director Financiero" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('puesto') border-red-500 @enderror">
                            @error('puesto') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- Estado -->
                        <div>
                            <label for="estado" class="block text-sm font-medium text-gray-700 mb-2">Estado <span class="text-red-500">*</span></label>
                            <select wire:model="estado" id="estado" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('estado') border-red-500 @enderror">
                                <option value="activo">Activo</option>
                                <option value="inactivo">Inactivo</option>
                            </select>
                            @error('estado') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <!-- <div class="flex justify-end space-x-4"> -->
            <div class="flex justify-center space-x-4 pt-6">
                <button type="button" wire:click="reset" class="px-8 py-3 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 transition-colors">
                    Cancelar
                </button>
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-lg hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-lg hover:shadow-xl transition-all duration-200">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>