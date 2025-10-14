{{-- resources/views/livewire/encuesta/competencia/partials/competencia-detalle.blade.php --}}
{{-- Esta es una vista parcial NORMAL de Blade --}}

{{-- Contenedor principal con sombra y bordes redondeados --}}
<div class="bg-white rounded-lg shadow-md border border-gray-200/80 overflow-hidden">
    <div class="space-y-6">
        {{-- Sección: Nombre de la Competencia --}}
        <div>
            <div class="bg-blue-700 px-6 py-3">
                <h2 class="text-base font-bold text-white uppercase tracking-wider">Nombre de la competencia</h2>
            </div>
            <div class="px-6 py-4">
                <p class="text-gray-800 text-lg">{{ $competencia->nombre_competencia }}</p>
            </div>
        </div>

        {{-- Sección: Definición de la Competencia --}}
        <div>
            <div class="bg-blue-700 px-6 py-3">
                <h2 class="text-base font-bold text-white uppercase tracking-wider">Definición de competencia</h2>
            </div>
            <div class="px-6 py-4">
                <p class="text-gray-600 leading-relaxed">{{ $competencia->definicion_competencia }}</p>
            </div>
        </div>

        {{-- Sección: Niveles de Comportamiento --}}
        <div>
            <div class="bg-blue-700 px-6 py-3">
                <h2 class="text-base font-bold text-white uppercase tracking-wider">Niveles de Comportamientos</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/12">Nivel</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-3/12">Nombre</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-8/12">Descripción del Comportamiento</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php
                        $escalaDeNiveles = [
                            'Excepcional' => 5, 'Supera las Expectativas' => 4, 'Competente' => 3,
                            'En Desarrollo' => 2, 'Requiere Apoyo' => 1
                        ];
                        @endphp
                        @foreach ($competencia->niveles->sortByDesc(fn($nivel) => $escalaDeNiveles[$nivel->nombre_nivel] ?? 0) as $nivel)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-lg font-bold text-blue-600">
                                {{ $escalaDeNiveles[$nivel->nombre_nivel] ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">{{ $nivel->nombre_nivel }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $nivel->descripcion_nivel }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>