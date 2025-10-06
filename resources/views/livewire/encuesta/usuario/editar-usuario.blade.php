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
                            <h1 class="text-2xl font-bold text-white">Editar Usuario</h1>
                            <p class="text-sm text-indigo-200 mt-1">Modifica la información del miembro del sistema.</p>
                        </div>
                    </div>
                </div>

                <!-- Sección: Información Personal -->
                <div class="p-6">
                    <h2 class="text-lg font-semibold text-gray-800 border-b pb-4">Información Personal</h2>
                    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nombre(s)</label>
                            <input type="text" wire:model="name" id="name" class="mt-1 w-full input-style @error('name') input-error @enderror">
                            @error('name') <span class="error-message">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="primer_apellido" class="block text-sm font-medium text-gray-700">Primer Apellido</label>
                            <input type="text" wire:model="primer_apellido" id="primer_apellido" class="mt-1 w-full input-style @error('primer_apellido') input-error @enderror">
                            @error('primer_apellido') <span class="error-message">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="segundo_apellido" class="block text-sm font-medium text-gray-700">Segundo Apellido <span class="text-gray-400">(Opcional)</span></label>
                            <input type="text" wire:model="segundo_apellido" id="segundo_apellido" class="mt-1 w-full input-style">
                        </div>
                        <div>
                            <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                            <input type="tel" wire:model="telefono" id="telefono" class="mt-1 w-full input-style @error('telefono') input-error @enderror">
                            @error('telefono') <span class="error-message">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Sección: Seguridad de Acceso -->
                <div class="p-6 border-t">
                    <h2 class="text-lg font-semibold text-gray-800 border-b pb-4">Seguridad de Acceso</h2>
                    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="sm:col-span-2">
                            <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico / Usuario</label>
                            <input type="email" wire:model="email" id="email" class="mt-1 w-full input-style @error('email') input-error @enderror">
                            @error('email') <span class="error-message">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">Nueva Contraseña <span class="text-gray-400">(Opcional)</span></label>
                            <input type="password" wire:model="password" id="password" placeholder="Dejar en blanco para no cambiar" class="mt-1 w-full input-style @error('password') input-error @enderror">
                            @error('password') <span class="error-message">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Nueva Contraseña</label>
                            <input type="password" wire:model="password_confirmation" id="password_confirmation" class="mt-1 w-full input-style">
                        </div>
                    </div>
                </div>

                <!-- Sección: Asignación Organizacional -->
                <div class="p-6 border-t">
                    <h2 class="text-lg font-semibold text-gray-800 border-b pb-4">Asignación Organizacional</h2>
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
                            <input type="text" wire:model="puesto" id="puesto" class="mt-1 w-full input-style @error('puesto') input-error @enderror">
                            @error('puesto') <span class="error-message">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <!-- Sección: Información Adicional -->
                <div class="p-6 border-t">
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
                            <select wire:model="escolaridad" id="escolaridad" class="mt-1 w-full input-style">
                                <option value="">Selecciona nivel de escolaridad</option>

                                <optgroup label="Educación Básica">
                                    <option value="Preescolar">Preescolar</option>
                                    <option value="Primaria">Primaria</option>
                                    <option value="Secundaria">Secundaria</option>
                                </optgroup>

                                <optgroup label="Educación Media">
                                    <option value="Bachillerato">Bachillerato</option>
                                    <option value="Preparatoria">Preparatoria</option>
                                </optgroup>

                                <optgroup label="Educación Superior">
                                    <option value="Licenciatura">Licenciatura</option>
                                    <option value="Ingeniería">Ingeniería</option>
                                    <option value="Maestría">Maestría</option>
                                    <option value="Doctorado">Doctorado</option>
                                </optgroup>
                            </select>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="flex justify-center space-x-4 pt-6">
                <a href="{{ route('mostrar-usuario') }}" wire:navigate class="px-8 py-3 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300">
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