{{-- INICIO: Bloque para mostrar mensajes de sesión --}}
@if (session()->has('message'))
<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6" role="alert">
    <p class="font-bold">¡Éxito!</p>
    <p>{{ session('message') }}</p>
</div>
@endif

@if (session()->has('error'))
<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6" role="alert">
    <p class="font-bold">¡Error!</p>
    <p>{{ session('error') }}</p>
</div>
@endif
<div>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-white py-8 px-4 sm:px-6 lg:px-8">
        {{-- El elemento raíz ahora es el FORMULARIO. Los estilos de los divs exteriores se han movido aquí. --}}
        <form wire:submit.prevent="save"  class="space-y-8 max-w-5xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

            <!-- Header (sin cambios, solo está dentro del nuevo form raíz) -->
            <div class="mb-8 text-center">
                {{-- Aquí puedes reactivar tu título o manual de usuario si lo necesitas --}}
            </div>

            <!-- Información Básica -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                    <h1 class="text-2xl font-bold text-white mb-2">Complete el formulario para agregar una nueva empresa</h1>
                    <div class="flex items-center">
                        <h2 class="text-lg font-semibold text-white">Información Básica</h2>
                        <span class="ml-2 text-blue-200">/ Campos Obligatorios</span>
                    </div>
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <!-- Nombre Comercial -->
                        <div>
                            <label for="nombre_comercial" class="block text-sm font-medium text-gray-700 mb-2">Nombre Comercial</label>
                            <input type="text" wire:model="nombre_comercial" id="nombre_comercial" placeholder="Ej. TechCorp Solutions" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('nombre_comercial') border-red-500 ring-red-500 @enderror">
                            @error('nombre_comercial') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- Razón Social -->
                        <div>
                            <label for="razon_social" class="block text-sm font-medium text-gray-700 mb-2">Razón Social</label>
                            <input type="text" wire:model="razon_social" id="razon_social" placeholder="Ej. TechCorp Solutions S.A. de C.V." class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('razon_social') border-red-500 ring-red-500 @enderror">
                            @error('razon_social') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- Sector/Industria -->
                        <div>
                            <label for="sector" class="block text-sm font-medium text-gray-700 mb-2">Sector/Industria</label>
                            <select wire:model="sector" id="sector" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('sector') border-red-500 ring-red-500 @enderror">
                                <option value="">Selecciona el sector</option>
                                <option value="Tecnología">Tecnología</option>
                                <option value="Manufactura">Manufactura</option>
                                <option value="Servicios">Servicios</option>
                                <option value="Comercio">Comercio</option>
                                <option value="Construcción">Construcción</option>
                                <option value="Salud">Salud</option>
                                <option value="Educación">Educación</option>
                                <option value="Turismo">Turismo</option>
                                <option value="Otros">Otros</option>
                            </select>
                            @error('sector') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- Estado Inicial -->
                        <div>
                            <label for="estado_inicial" class="block text-sm font-medium text-gray-700 mb-2">Estado Inicial</label>
                            <select wire:model="estado_inicial" id="estado_inicial" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('estado_inicial') border-red-500 ring-red-500 @enderror">
                                <option value="">Selecciona el estado inicial</option>
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                                <option value="En Proceso">En Proceso</option>
                                <option value="Suspendido">Suspendido</option>
                            </select>
                            @error('estado_inicial') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- Número de Empleados -->
                        <div>
                            <label for="numero_empleados" class="block text-sm font-medium text-gray-700 mb-2">Número de Empleados</label>
                            <select wire:model="numero_empleados" id="numero_empleados" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('numero_empleados') border-red-500 ring-red-500 @enderror">
                                <option value="">Selecciona un rango</option>
                                <option value="1-10">1-10 empleados</option>
                                <option value="11-50">11-50 empleados</option>
                                <option value="51-100">51-100 empleados</option>
                                <option value="101-500">101-500 empleados</option>
                                <option value="500+">Más de 500 empleados</option>
                            </select>
                            @error('numero_empleados') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- Fecha de Registro -->
                        <div>
                            <label for="fecha_registro" class="block text-sm font-medium text-gray-700 mb-2">Fecha de Registro</label>
                            <div class="relative">
                                <input type="date" wire:model="fecha_registro" id="fecha_registro" placeholder="dd/mm/aaaa" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('fecha_registro') border-red-500 ring-red-500 @enderror">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            @error('fecha_registro') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- Año en el mercado -->
                        <div>
                            <label for="ano_mercado" class="block text-sm font-medium text-gray-700 mb-2">Año en el mercado</label>
                            <input type="number" wire:model="ano_mercado" id="ano_mercado" placeholder="Ej. 15" min="0" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('ano_mercado') border-red-500 ring-red-500 @enderror">
                            @error('ano_mercado') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>

                        <!-- Tipo de Organización -->
                        <div>
                            <label for="tipo_organizacion" class="block text-sm font-medium text-gray-700 mb-2">Tipo de Organización</label>
                            <select wire:model="tipo_organizacion" id="tipo_organizacion" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('tipo_organizacion') border-red-500 ring-red-500 @enderror">
                                <option value="">Selecciona el tipo</option>
                                <option value="S.A. de C.V.">S.A. de C.V.</option>
                                <option value="S.R.L.">S.R.L.</option>
                                <option value="S.C.">S.C.</option>
                                <option value="Persona Física">Persona Física</option>
                                <option value="Asociación Civil">Asociación Civil</option>
                                <option value="Cooperativa">Cooperativa</option>
                            </select>
                            @error('tipo_organizacion') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Logo de la Empresa -->
                    <div class="mt-6">
                        <div class="flex items-center mb-2">
                            <label for="image" class="block text-sm font-medium text-gray-700">Logo de la Empresa</label>
                            <span class="ml-2 px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">Opcional</span>
                        </div>
                        <div>
                            <div class="relative border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-400 transition-colors">
                                <input type="file" wire:model="image" id="image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                <div wire:loading wire:target="image" class="absolute inset-0 flex items-center justify-center bg-white bg-opacity-75">
                                    <div class="text-blue-600">
                                        <svg class="animate-spin h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        <span class="ml-2">Subiendo...</span>
                                    </div>
                                </div>
                                <div wire:loading.remove wire:target="image" class="flex flex-col items-center pointer-events-auto">

                                    <svg class="h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    <p class="text-sm font-medium text-gray-900 mb-1">Haz click para subir el logo</p>
                                    <p class="text-sm text-gray-500 mb-2">o arrastra y suelta aquí</p>
                                    <p class="text-xs text-gray-400">PNG, JPG hasta 5 MB</p>
                                </div>
                            </div>
                            @if ($image)
                            <div class="mt-4" wire:loading.remove wire:target="image">
                                <p class="text-sm font-medium text-gray-700 mb-2">Previsualización:</p>
                                <img src="{{ is_string($image) ? Storage::url($image) : $image->temporaryUrl() }}" class="w-32 h-32 object-cover rounded-lg mx-auto shadow-md">
                            </div>
                            @endif
                            @error('image') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- En resources/views/livewire/encuesta/empresa/crear-empresa.blade.php --}}

            <!-- Información Fiscal -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4">
                    <div class="flex items-center">
                        <h2 class="text-lg font-semibold text-white">Información Fiscal</h2>
                        <span class="ml-2 text-indigo-200">/ Campos obligatorios</span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                        {{-- RFC --}}
                        <div>
                            <label for="rfc" class="block text-sm font-medium text-gray-700 mb-2">RFC</label>
                            <input type="text" wire:model="rfc" id="rfc" placeholder="Ej. ABC123456XYZ" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('rfc') border-red-500 ring-red-500 @enderror">
                            @error('rfc') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>

                        {{-- SELECT DE PAÍS --}}
                        <div>
                            <label for="pais" class="block text-sm font-medium text-gray-700 mb-2">País</label>
                            <select wire:model.live="paisSeleccionado" id="pais" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('paisSeleccionado') border-red-500 @enderror">
                                <option value="">Selecciona un país</option>
                                @foreach ($paises as $pais)
                                <option value="{{ $pais['name'] }}">{{ $pais['name'] }}</option>
                                @endforeach
                            </select>
                            @error('paisSeleccionado') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>

                        {{-- SELECT DE ESTADO --}}
                        <div>
                            <label for="estado" class="block text-sm font-medium text-gray-700 mb-2">Estado</label>
                            <select wire:model.live="estadoSeleccionado" id="estado" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('estadoSeleccionado') border-red-500 @enderror" @if(empty($estados)) disabled @endif>
                                <option value="">Selecciona un estado</option>
                                @foreach ($estados as $estado)
                                <option value="{{ $estado['name'] }}">{{ $estado['name'] }}</option>
                                @endforeach
                            </select>
                            <div wire:loading wire:target="paisSeleccionado" class="text-sm text-gray-500 mt-1">Cargando estados...</div>
                            @error('estadoSeleccionado') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>

                        {{-- SELECT DE CIUDAD/MUNICIPIO --}}
                        <div>
                            <label for="ciudad" class="block text-sm font-medium text-gray-700 mb-2">Ciudad / Municipio</label>
                            <select wire:model="ciudadSeleccionada" id="ciudad" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('ciudadSeleccionada') border-red-500 @enderror" @if(empty($municipios)) disabled @endif>
                                <option value="">Selecciona una ciudad</option>
                                @foreach ($municipios as $municipio)
                                <option value="{{ $municipio }}">{{ $municipio }}</option>
                                @endforeach
                            </select>
                            <div wire:loading wire:target="estadoSeleccionado" class="text-sm text-gray-500 mt-1">Cargando ciudades...</div>
                            @error('ciudadSeleccionada') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 mt-6">
                        {{-- DIRECCIÓN --}}
                        <div>
                            <label for="direccion" class="block text-sm font-medium text-gray-700 mb-2">Dirección</label>
                            <input type="text" wire:model="direccion" id="direccion" placeholder="Ej. Av. Siempre Viva 123" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('direccion') border-red-500 ring-red-500 @enderror">
                            @error('direccion') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                        {{-- CÓDIGO POSTAL --}}
                        <div>
                            <label for="codigo_postal" class="block text-sm font-medium text-gray-700 mb-2">Código Postal</label>
                            <input type="text" wire:model="codigo_postal" id="codigo_postal" placeholder="Ej. 42227" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors @error('codigo_postal') border-red-500 ring-red-500 @enderror">
                            @error('codigo_postal') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contacto Principal -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                    <div class="flex items-center">
                        <h2 class="text-lg font-semibold text-white">Contacto Principal</h2>
                        <span class="ml-2 text-green-200">/ Opcional</span>
                    </div>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="contacto_nombre" class="block text-sm font-medium text-gray-700 mb-2">Nombre completo</label>
                            <input type="text" wire:model="contacto_nombre" id="contacto_nombre" placeholder="Ej. Miguel Ángel Potrero" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        </div>
                        <div>
                            <label for="contacto_puesto" class="block text-sm font-medium text-gray-700 mb-2">Puesto</label>
                            <input type="text" wire:model="contacto_puesto" id="contacto_puesto" placeholder="Ej. Gerente" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        </div>
                        <div>
                            <label for="contacto_telefono" class="block text-sm font-medium text-gray-700 mb-2">Teléfono</label>
                            <input type="tel" wire:model="contacto_telefono" id="contacto_telefono" placeholder="+52 2255414234" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        </div>
                        <div>
                            <label for="contacto_correo" class="block text-sm font-medium text-gray-700 mb-2">Correo electrónico</label>
                            <input type="email" wire:model="contacto_correo" id="contacto_correo" placeholder="migueldevpro@gmail.com" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="flex justify-center space-x-4 pt-6">
                <!-- <button type="button" wire:click="resetForm" class="px-8 py-3 bg-white border-2 border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-all duration-200">
                    Cancelar
                </button> -->
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-medium rounded-lg hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-lg hover:shadow-xl transition-all duration-200">
                    Guardar
                </button>
            </div>

        </form>
    </div>

</div>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    window.addEventListener('mostrar-empresa', event => {
        toastr.success(event.detail.message);
    });

    // window.addEventListener('empresa-error', event => {
    //     toastr.error(event.detail.message);
    // });
</script> -->