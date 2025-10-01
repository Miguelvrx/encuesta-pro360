<div>
    {{-- SELECT PARA PAÍS --}}
    <div class="mb-4">
        <label for="pais" class="block font-medium text-sm text-gray-700">País</label>
        <select id="pais" wire:model.live="paisSeleccionado" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
            <option value="">-- Seleccione un País --</option>
            @foreach ($paises as $pais)
                {{-- La API devuelve 'name' para el nombre y 'iso2' o 'iso3' como ID. Usaremos 'name'. --}}
                <option value="{{ $pais['name'] }}">{{ $pais['name'] }}</option>
            @endforeach
        </select>
    </div>

    {{-- SELECT PARA ESTADO --}}
    <div class="mb-4">
        <label for="estado" class="block font-medium text-sm text-gray-700">Estado / Provincia</label>
        <select id="estado" wire:model.live="estadoSeleccionado" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" @if(empty($estados)) disabled @endif>
            <option value="">-- Seleccione un Estado --</option>
            @foreach ($estados as $estado)
                <option value="{{ $estado['name'] }}">{{ $estado['name'] }}</option>
            @endforeach
        </select>
        {{-- Indicador de carga: se muestra mientras se actualiza la lista de estados --}}
        <div wire:loading wire:target="paisSeleccionado" class="text-sm text-gray-500 mt-1">
            Cargando estados...
        </div>
    </div>

    {{-- SELECT PARA MUNICIPIO --}}
    <div class="mb-4">
        <label for="municipio" class="block font-medium text-sm text-gray-700">Ciudad / Municipio</label>
        <select id="municipio" wire:model="municipioSeleccionado" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" @if(empty($municipios)) disabled @endif>
            <option value="">-- Seleccione un Municipio --</option>
            @foreach ($municipios as $municipio)
                <option value="{{ $municipio }}">{{ $municipio }}</option>
            @endforeach
        </select>
        {{-- Indicador de carga: se muestra mientras se actualiza la lista de municipios --}}
        <div wire:loading wire:target="estadoSeleccionado" class="text-sm text-gray-500 mt-1">
            Cargando municipios...
        </div>
    </div>
</div>
