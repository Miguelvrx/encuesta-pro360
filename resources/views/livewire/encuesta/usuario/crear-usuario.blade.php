<div>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-white py-8 px-4 sm:px-6 lg:px-8">
        <form wire:submit.prevent="save" class="space-y-8 max-w-5xl mx-auto">

            <!-- Cabecera del Formulario -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-2xl font-bold text-white">Crear Nuevo Usuario</h1>
                            <p class="text-sm text-blue-200 mt-1">Complete la información para registrar un nuevo miembro en el sistema</p>
                        </div>
                        <button
                            type="button"
                            wire:click=""
                            class="hidden sm:inline-flex items-center px-4 py-2 bg-white/20 text-white font-semibold text-sm rounded-lg shadow-sm hover:bg-white/30 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z"></path>
                            </svg>
                            Manual de Usuario
                        </button>
                    </div>
                </div>

                <!-- Sección: Información Personal -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-gray-800 border-b pb-4">Información Personal <span class="text-sm font-normal text-gray-500">/ Obligatorio</span></h2>
                        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Nombre(s)</label>
                                <input type="text" wire:model="name" id="name" placeholder="Ej. Juan Carlos" class="mt-1 w-full input-style @error('name') input-error @enderror">
                                @error('name') <span class="error-message">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="primer_apellido" class="block text-sm font-medium text-gray-700">Primer Apellido</label>
                                <input type="text" wire:model="primer_apellido" id="primer_apellido" placeholder="Ej. López" class="mt-1 w-full input-style @error('primer_apellido') input-error @enderror">
                                @error('primer_apellido') <span class="error-message">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="segundo_apellido" class="block text-sm font-medium text-gray-700">Segundo Apellido <span class="text-gray-400">(Opcional)</span></label>
                                <input type="text" wire:model="segundo_apellido" id="segundo_apellido" placeholder="Ej. García" class="mt-1 w-full input-style">
                            </div>
                            <div>
                                <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                                <input type="tel" wire:model="telefono" id="telefono" placeholder="+52 222 123 4567" class="mt-1 w-full input-style @error('telefono') input-error @enderror">
                                @error('telefono') <span class="error-message">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sección: Seguridad de Acceso -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-gray-800 border-b pb-4">Seguridad de Acceso <span class="text-sm font-normal text-gray-500">/ Obligatorio</span></h2>
                        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="sm:col-span-2">
                                <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico / Usuario</label>
                                <input type="email" wire:model="email" id="email" placeholder="usuario@empresa.com" class="mt-1 w-full input-style @error('email') input-error @enderror">
                                @error('email') <span class="error-message">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                                <input type="password" wire:model="password" id="password" placeholder="Mínimo 8 caracteres" class="mt-1 w-full input-style @error('password') input-error @enderror">
                                @error('password') <span class="error-message">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Contraseña</label>
                                <input type="password" wire:model="password_confirmation" id="password_confirmation" placeholder="Repite la contraseña" class="mt-1 w-full input-style">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sección: Asignación Organizacional -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-gray-800 border-b pb-4">Asignación Organizacional <span class="text-sm font-normal text-gray-500">/ Obligatorio</span></h2>
                        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="departamento_id" class="block text-sm font-medium text-gray-700">Departamento</label>
                                <select wire:model="departamento_id" id="departamento_id" class="mt-1 w-full input-style @error('departamento_id') input-error @enderror">
                                    <option value="">Selecciona un departamento</option>
                                    @foreach ($departamentos as $departamento)
                                    <option value="{{ $departamento->id_departamento }}">{{ $departamento->nombre_departamento }}</option>
                                    @endforeach
                                </select>
                                @error('departamento_id') <span class="error-message">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label for="puesto" class="block text-sm font-medium text-gray-700">Puesto</label>
                                <input type="text" wire:model="puesto" id="puesto" placeholder="Ej. Analista de Datos" class="mt-1 w-full input-style @error('puesto') input-error @enderror">
                                @error('puesto') <span class="error-message">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sección: Información Adicional -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-gray-800 border-b pb-4">Información Adicional <span class="text-sm font-normal text-gray-500">/ Opcional</span></h2>
                        <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="genero" class="block text-sm font-medium text-gray-700">Género</label>
                                <select wire:model="genero" id="genero" class="mt-1 w-full input-style">
                                    <option value="">Selecciona un género</option>
                                    <option value="masculino">Masculino</option>
                                    <option value="femenino">Femenino</option>
                                    <option value="no definido">Prefiero no decirlo</option>
                                </select>
                            </div>
                            <div>
                                <label for="escolaridad" class="block text-sm font-medium text-gray-700">Nivel de Escolaridad</label>
                                <input type="text" wire:model="escolaridad" id="escolaridad" placeholder="Ej. Licenciatura, Maestría" class="mt-1 w-full input-style">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Botones de Acción -->
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