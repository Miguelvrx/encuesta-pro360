<div>
    <div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8">

        <!-- Cabecera con Título y Botón para Volver -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Detalles del Departamento</h1>
                <p class="mt-1 text-sm text-gray-500">Información completa del departamento y su empresa.</p>
            </div>
            <a href="{{ route('mostrar-departamento') }}" wire:navigate class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 font-semibold text-sm rounded-lg shadow-sm hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 15 3 9m0 0 6-6M3 9h12a6 6 0 0 1 0 12h-3" />
                </svg>
                Volver al Listado
            </a>
        </div>

        <!-- Tarjeta de Información -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">

            <!-- Encabezado de la Tarjeta -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-6">
                <h2 class="text-2xl font-bold text-white">{{ $departamento->nombre_departamento }}</h2>
                <p class="text-blue-200 mt-1">Puesto Principal: <span class="font-semibold">{{ $departamento->puesto }}</span></p>
            </div>

            <!-- Cuerpo de la Tarjeta -->
            <div class="p-6">
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-8">

                    <!-- Descripción -->
                    <div class="sm:col-span-2">
                        <dt class="text-sm font-medium text-gray-500">Descripción</dt>
                        <dd class="mt-1 text-base text-gray-900">{{ $departamento->descripcion }}</dd>
                    </div>

                    <!-- Estado -->
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Estado</dt>
                        <dd class="mt-1">
                            <span class="px-3 py-1 inline-flex text-sm leading-5 font-semibold rounded-full {{ $departamento->estado == 'activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($departamento->estado ) }}
                            </span>
                        </dd>
                    </div>

                    <!-- Fecha de Registro -->
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Fecha de Registro</dt>
                        <dd class="mt-1 text-base text-gray-900">{{ $departamento->fecha_registro_departamento->format('d/m/Y') }}</dd>
                    </div>

                    {{-- Separador --}}
                    <div class="sm:col-span-2 border-t border-gray-200 pt-8">
                        <h3 class="text-lg font-semibold text-gray-800">Empresa Asociada</h3>
                    </div>

                    <!-- Nombre de la Empresa -->
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Nombre Comercial</dt>
                        <dd class="mt-1 text-base text-gray-900">{{ $departamento->empresa->nombre_comercial ?? 'N/A' }}</dd>
                    </div>

                    <!-- RFC de la Empresa -->
                    <div>
                        <dt class="text-sm font-medium text-gray-500">RFC de la Empresa</dt>
                        <dd class="mt-1 text-base text-gray-900">{{ $departamento->empresa->rfc ?? 'N/A' }}</dd>
                    </div>

                </dl>
            </div>
        </div>
    </div>
</div>