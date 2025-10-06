<div>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-white py-8 px-4 sm:px-6 lg:px-8">

        {{-- El formulario ahora llama al método 'update' --}}
        <form wire:submit.prevent="update" class="space-y-8 max-w-5xl mx-auto">

            <!-- Mensajes de sesión -->
            @if (session()->has('message'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg" role="alert">
                <p>{{ session('message') }}</p>
            </div>
            @endif
            @if (session()->has('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg" role="alert">
                <p>{{ session('error') }}</p>
            </div>
            @endif

            <!-- Información Básica -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4">
                    <h1 class="text-2xl font-bold text-white">Editar Información de la Empresa</h1>
                    <p class="text-sm text-indigo-200 mt-1">Ajusta los detalles básicos de la empresa.</p>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <!-- Nombre Comercial -->
                        <div>
                            <label for="nombre_comercial" class="block text-sm font-medium text-gray-700">Nombre Comercial</label>
                            <input type="text" wire:model="nombre_comercial" id="nombre_comercial" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('nombre_comercial') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <!-- Razón Social -->
                        <div>
                            <label for="razon_social" class="block text-sm font-medium text-gray-700">Razón Social</label>
                            <input type="text" wire:model="razon_social" id="razon_social" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('razon_social') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <!-- Sector/Industria -->
                        <div>
                            <label for="sector" class="block text-sm font-medium text-gray-700">Sector/Industria</label>
                            <select wire:model="sector" id="sector" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
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
                            @error('sector') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <!-- Estado Inicial -->
                        <div>
                            <label for="estado_inicial" class="block text-sm font-medium text-gray-700">Estado Inicial</label>
                            <select wire:model="estado_inicial" id="estado_inicial" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Selecciona el estado inicial</option>
                                <option value="Activo">Activo</option>
                                <option value="Inactivo">Inactivo</option>
                                <option value="En Proceso">En Proceso</option>
                                <option value="Suspendido">Suspendido</option>
                            </select>
                            @error('estado_inicial') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <!-- Número de Empleados -->
                        <div>
                            <label for="numero_empleados" class="block text-sm font-medium text-gray-700">Número de Empleados</label>
                            <select wire:model="numero_empleados" id="numero_empleados" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Selecciona un rango</option>
                                <option value="1-10">1-10 empleados</option>
                                <option value="11-50">11-50 empleados</option>
                                <option value="51-100">51-100 empleados</option>
                                <option value="101-500">101-500 empleados</option>
                                <option value="500+">Más de 500 empleados</option>
                            </select>
                            @error('numero_empleados') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <!-- Fecha de Registro -->
                        <div>
                            <label for="fecha_registro" class="block text-sm font-medium text-gray-700">Fecha de Registro</label>
                            <input type="date" wire:model="fecha_registro" id="fecha_registro" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('fecha_registro') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <!-- Año en el mercado -->
                        <div>
                            <label for="ano_mercado" class="block text-sm font-medium text-gray-700">Año en el mercado</label>
                            <input type="number" wire:model="ano_mercado" id="ano_mercado" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('ano_mercado') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <!-- Tipo de Organización -->
                        <div>
                            <label for="tipo_organizacion" class="block text-sm font-medium text-gray-700">Tipo de Organización</label>
                            <select wire:model="tipo_organizacion" id="tipo_organizacion" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Selecciona el tipo</option>
                                <option value="S.A. de C.V.">S.A. de C.V.</option>
                                <option value="S.R.L.">S.R.L.</option>
                                <option value="S.C.">S.C.</option>
                                <option value="Persona Física">Persona Física</option>
                                <option value="Asociación Civil">Asociación Civil</option>
                                <option value="Cooperativa">Cooperativa</option>
                            </select>
                            @error('tipo_organizacion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Logo de la Empresa -->
                    <div class="mt-6">
                        <label for="logo" class="block text-sm font-medium text-gray-700">Logo de la Empresa (Opcional)</label>
                        <input type="file" wire:model="logo" id="logo" class="mt-1">
                        @error('logo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                        <div class="mt-4 flex flex-wrap items-start gap-6">
                            @if ($logo instanceof \Livewire\TemporaryUploadedFile)
                            <div class="transition-opacity duration-500 ease-in-out opacity-0 animate-fade-in">
                                <p class="text-sm font-medium text-gray-700 mb-2">Previsualización Nuevo Logo:</p>
                                <img id="preview-logo" src="{{ $logo->temporaryUrl() }}" alt="Nuevo Logo" class="w-24 h-24 object-cover rounded-lg shadow-md">
                                <div id="color-preview" class="flex gap-2 mt-2"></div>
                            </div>
                            @endif

                            @if ($logoExistente)
                            <div class="transition-opacity duration-500 ease-in-out opacity-0 animate-fade-in">
                                <p class="text-sm font-medium text-gray-700 mb-2">Logo Actual:</p>
                                <img src="{{ asset('storage/' . $logoExistente) }}" alt="Logo Actual" class="w-24 h-24 object-cover rounded-lg shadow-md">
                            </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

            <!-- Información Fiscal y Ubicación -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-4">
                    <h2 class="text-lg font-semibold text-white">Información Fiscal y Ubicación</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 mb-6">
                        <div>
                            <label for="rfc" class="block text-sm font-medium text-gray-700">RFC</label>
                            <input type="text" wire:model="rfc" id="rfc" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('rfc') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="pais" class="block text-sm font-medium text-gray-700">País</label>
                            <select wire:model.live="paisSeleccionado" id="pais" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Selecciona un país</option>
                                @foreach ($paises as $pais)
                                <option value="{{ $pais['name'] }}">{{ $pais['name'] }}</option>
                                @endforeach
                            </select>
                            @error('paisSeleccionado') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-3 mb-6">
                        <div>
                            <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
                            <select wire:model.live="estadoSeleccionado" id="estado" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" @if(empty($estados)) disabled @endif>
                                <option value="">Selecciona un estado</option>
                                @foreach ($estados as $estado)
                                <option value="{{ $estado['name'] }}">{{ $estado['name'] }}</option>
                                @endforeach
                            </select>
                            @error('estadoSeleccionado') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="ciudad" class="block text-sm font-medium text-gray-700">Ciudad</label>
                            <select wire:model.live="ciudadSeleccionada" id="ciudad" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" @if(empty($ciudades)) disabled @endif>
                                <option value="">Selecciona una ciudad</option>
                                @foreach ($ciudades as $ciudad)
                                <option value="{{ $ciudad }}">{{ $ciudad }}</option>
                                @endforeach
                            </select>
                            @error('ciudadSeleccionada') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="municipio" class="block text-sm font-medium text-gray-700">Municipio</label>
                            <select wire:model="municipioSeleccionado" id="municipio" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" @if(empty($municipios)) disabled @endif>
                                <option value="">Selecciona un municipio</option>
                                @foreach ($municipios as $municipio)
                                <option value="{{ $municipio }}">{{ $municipio }}</option>
                                @endforeach
                            </select>
                            @error('municipioSeleccionado') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <label for="direccion" class="block text-sm font-medium text-gray-700">Dirección</label>
                            <input type="text" wire:model="direccion" id="direccion" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('direccion') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="codigo_postal" class="block text-sm font-medium text-gray-700">Código Postal</label>
                            <input type="text" wire:model="codigo_postal" id="codigo_postal" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('codigo_postal') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contacto Principal -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="bg-gradient-to-r from-green-600 to-green-700 px-6 py-4">
                    <h2 class="text-lg font-semibold text-white">Contacto Principal (Opcional)</h2>
                </div>
                <div class="p-6 grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="contacto_nombre" class="block text-sm font-medium text-gray-700">Nombre completo</label>
                        <input type="text" wire:model="contacto_nombre" id="contacto_nombre" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label for="contacto_puesto" class="block text-sm font-medium text-gray-700">Puesto</label>
                        <input type="text" wire:model="contacto_puesto" id="contacto_puesto" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label for="contacto_telefono" class="block text-sm font-medium text-gray-700">Teléfono</label>
                        <input type="tel" wire:model="contacto_telefono" id="contacto_telefono" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label for="contacto_correo" class="block text-sm font-medium text-gray-700">Correo electrónico</label>
                        <input type="email" wire:model="contacto_correo" id="contacto_correo" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="flex justify-center space-x-4 pt-6">
                <a href="{{ route('mostrar-empresa') }}" wire:navigate class="px-8 py-3 bg-gray-200 text-gray-700 font-medium rounded-lg hover:bg-gray-300">
                    Cancelar
                </a>
                <button type="submit" class="px-8 py-3 bg-gradient-to-r from-indigo-600 to-indigo-700 text-white font-medium rounded-lg hover:from-indigo-700 hover:to-indigo-800">
                    Guardar Cambios
                </button>
            </div>

        </form>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/color-thief/2.3.2/color-thief.umd.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const img = document.getElementById('preview-logo');
        const colorContainer = document.getElementById('color-preview');

        if (img && colorContainer) {
            img.addEventListener('load', () => {
                const colorThief = new ColorThief();
                const palette = colorThief.getPalette(img, 5);

                colorContainer.innerHTML = ''; // Limpia antes de pintar
                palette.forEach(color => {
                    const colorBox = document.createElement('div');
                    colorBox.style.width = '24px';
                    colorBox.style.height = '24px';
                    colorBox.style.borderRadius = '50%';
                    colorBox.style.backgroundColor = `rgb(${color[0]}, ${color[1]}, ${color[2]})`;
                    colorBox.title = `rgb(${color[0]}, ${color[1]}, ${color[2]})`;
                    colorBox.style.boxShadow = '0 0 2px rgba(0,0,0,0.3)';
                    colorContainer.appendChild(colorBox);
                });
            });
        }
    });
</script>
