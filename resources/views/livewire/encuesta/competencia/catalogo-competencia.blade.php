<div>
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50/30 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">

            {{-- 1. Encabezado Principal Mejorado --}}
            <header class="mb-8">
                <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100/50 backdrop-blur-sm">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                        <div class="space-y-3">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl shadow-md">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                                    </svg>
                                </div>
                                <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent">Catálogo de Competencias</h1>
                            </div>
                            <p class="text-gray-600 max-w-2xl">
                                Explora y gestiona todas las competencias organizacionales disponibles en el sistema
                            </p>
                            <div class="flex items-center gap-4">
                                <span class="inline-flex items-center px-3 py-1.5 rounded-full bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-700 font-medium text-sm shadow-sm border border-indigo-200/50">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    {{ $competenciasTotales ?? 0 }} Competencias Disponibles
                                </span>
                            </div>
                        </div>

                        {{-- Botones de acción mejorados --}}
                        <div class="flex items-center gap-3 flex-wrap">
                            <!-- Botón Manual de Usuario -->
                            <!-- <a href="#"
                                class="group relative inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold text-sm rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <div class="absolute inset-0 bg-white/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z" />
                                </svg>
                                Manual de Usuario
                            </a> -->

                            <!-- Botón Crear Nueva Competencia -->
                            <a href="{{ route('crear-competencia') }}" wire:navigate
                                class="group relative inline-flex items-center px-4 py-2.5 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold text-sm rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <div class="absolute inset-0 bg-white/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Nueva Competencia
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            {{-- 2. Panel de Filtros Mejorado --}}
            <div class="mb-8 bg-white rounded-2xl shadow-lg border border-gray-100/50">
                <div class="bg-gradient-to-r from-gray-50 to-gray-100/80 px-6 py-5 border-b border-gray-200/50">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-indigo-100 rounded-lg">
                            <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                        </div>
                        <h2 class="text-lg font-semibold text-gray-800">Filtros de Búsqueda</h2>
                    </div>
                </div>
                
                <div class="p-6 grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    {{-- Filtro Categoría --}}
                    <div class="group">
                        <label for="categoria" class="block text-sm font-semibold text-gray-700 mb-3">
                            <span class="flex items-center gap-2">
                                <span class="inline-flex w-2 h-2 bg-indigo-500 rounded-full"></span>
                                Categoría
                            </span>
                        </label>
                        <select
                            wire:model.live="categoriaSeleccionada"
                            id="categoria"
                            class="w-full pl-4 pr-10 py-3 border border-gray-200 rounded-xl leading-5 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200 group-hover:border-gray-300">
                            <option value="" class="text-gray-400">Todas las categorías</option>
                            @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id_categoria_competencia }}">{{ $categoria->categoria }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Filtro Competencia --}}
                    <div class="group">
                        <label for="competencia" class="block text-sm font-semibold text-gray-700 mb-3">
                            <span class="flex items-center gap-2">
                                <span class="inline-flex w-2 h-2 bg-indigo-500 rounded-full"></span>
                                Competencia
                            </span>
                        </label>
                        <select
                            wire:model.live="competenciaSeleccionada"
                            id="competencia"
                            class="w-full pl-4 pr-10 py-3 border border-gray-200 rounded-xl leading-5 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all duration-200 disabled:bg-gray-50 disabled:cursor-not-allowed group-hover:border-gray-300"
                            @if($competenciasFiltradas->isEmpty()) disabled @endif>
                            <option value="" class="text-gray-400">
                                @if($categoriaSeleccionada && $competenciasFiltradas->isNotEmpty())
                                Selecciona una competencia
                                @else
                                Primero selecciona una categoría
                                @endif
                            </option>
                            @foreach($competenciasFiltradas as $comp)
                            <option value="{{ $comp->id_competencia }}">{{ $comp->nombre_competencia }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Botón Ver Catálogo Completo --}}
                    <button
                        wire:click="verCatalogoCompleto"
                        class="group relative inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:scale-100"
                        @if(!$categoriaSeleccionada || $competenciasFiltradas->isEmpty()) disabled @endif>
                        <div class="absolute inset-0 bg-white/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                        </svg>
                        Ver Catálogo Completo
                    </button>

                    {{-- Botón Limpiar Filtros --}}
                    <button
                        wire:click="resetFiltros"
                        class="group relative inline-flex items-center justify-center px-4 py-3 bg-gradient-to-r from-gray-200 to-gray-300 text-gray-700 font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-105 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <div class="absolute inset-0 bg-white/20 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Limpiar Filtros
                    </button>
                </div>
            </div>

            {{-- 3. Área de Detalles de la Competencia --}}
            <div class="mt-8">
                {{-- Vista de competencia individual --}}
                @if ($competenciaActual && !$vistaCatalogo)
                @php
                $escalaDeNiveles = [
                    'Excepcional' => ['numero' => 5, 'tagline' => 'Modelo a seguir con impacto sostenido', 'color' => 'from-emerald-500 to-green-600', 'bg' => 'bg-gradient-to-r from-emerald-50 to-green-50', 'border' => 'border-emerald-200'],
                    'Supera las Expectativas' => ['numero' => 4, 'tagline' => 'Desempeño consistentemente superior', 'color' => 'from-blue-500 to-indigo-600', 'bg' => 'bg-gradient-to-r from-blue-50 to-indigo-50', 'border' => 'border-blue-200'],
                    'Competente' => ['numero' => 3, 'tagline' => 'Cumple de forma confiable lo esperado', 'color' => 'from-indigo-500 to-purple-600', 'bg' => 'bg-gradient-to-r from-indigo-50 to-purple-50', 'border' => 'border-indigo-200'],
                    'En Desarrollo' => ['numero' => 2, 'tagline' => 'Avanza con áreas por fortalecer', 'color' => 'from-amber-500 to-orange-600', 'bg' => 'bg-gradient-to-r from-amber-50 to-orange-50', 'border' => 'border-amber-200'],
                    'Requiere Apoyo' => ['numero' => 1, 'tagline' => 'Necesita acompañamiento para el estándar', 'color' => 'from-red-500 to-rose-600', 'bg' => 'bg-gradient-to-r from-red-50 to-rose-50', 'border' => 'border-red-200'],
                ];
                @endphp

                {{-- Tarjeta de competencia individual mejorada --}}
                <div class="group bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100/50 hover:shadow-xl transition-all duration-500">
                    <div class="bg-gradient-to-r from-gray-50 to-gray-100/80 p-6 border-b border-gray-200/50">
                        <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-3">
                                    <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-700 border border-indigo-200/50 shadow-sm">
                                        {{ $competenciaActual->categoria->categoria ?? 'Sin categoría' }}
                                    </span>
                                    <div class="h-2 w-2 rounded-full bg-indigo-300"></div>
                                    <span class="text-xs text-gray-500 font-medium">
                                        {{ $competenciaActual->niveles->count() }} Niveles
                                    </span>
                                </div>
                                <h2 class="text-2xl font-bold text-gray-900 group-hover:text-indigo-700 transition-colors duration-300">
                                    {{ $competenciaActual->nombre_competencia }}
                                </h2>
                                <p class="mt-3 text-gray-600 leading-relaxed max-w-3xl">
                                    {{ $competenciaActual->definicion_competencia }}
                                </p>
                            </div>
                            <a
                                href="{{ route('editar-competencia', ['competencia' => $competenciaActual->id_competencia]) }}"
                              class="group/edit relative flex-shrink-0 inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-semibold rounded-xl text-white bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-300 hover:scale-105 hover:shadow-lg overflow-hidden">
                                <div class="absolute inset-0 bg-white/20 rounded-xl opacity-0 group-hover/edit:opacity-100 transition-opacity duration-300"></div>
                                <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                </svg>
                                Editar Competencia
                            </a>
                        </div>
                    </div>

                    {{-- Contenido de niveles --}}
                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-6">
                            <div class="p-1.5 bg-indigo-100 rounded-lg">
                                <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                            </div>
                            <h4 class="text-sm font-bold text-gray-700 uppercase tracking-widest">Niveles de Comportamiento</h4>
                        </div>

                        {{-- Listado de niveles mejorado --}}
                        <div class="space-y-4">
                            @forelse ($competenciaActual->niveles as $nivel)
                            @php
                            $datosNivel = $escalaDeNiveles[$nivel->nombre_nivel] ?? null;
                            @endphp

                            <div class="group/nivel {{ $datosNivel['bg'] ?? 'bg-gray-50' }} rounded-xl border {{ $datosNivel['border'] ?? 'border-gray-200' }} p-5 transition-all duration-300 hover:shadow-md hover:scale-[1.02]">
                                <div class="grid grid-cols-12 gap-6 items-start">
                                    {{-- Columna Izquierda: Información del nivel --}}
                                    <div class="col-span-12 md:col-span-5">
                                        @if ($datosNivel)
                                        <div class="flex items-center gap-4">
                                            <div class="flex-shrink-0">
                                                <div class="h-14 w-14 rounded-xl bg-gradient-to-r {{ $datosNivel['color'] }} flex items-center justify-center text-white font-bold text-lg shadow-md">
                                                    {{ $datosNivel['numero'] }}
                                                </div>
                                            </div>
                                            <div class="flex-1">
                                                <p class="text-lg font-bold text-gray-800 group-hover/nivel:text-gray-900 transition-colors">
                                                    {{ $nivel->nombre_nivel }}
                                                </p>
                                                <p class="text-sm text-gray-500 italic mt-1 leading-tight">"{{ $datosNivel['tagline'] }}"</p>
                                            </div>
                                        </div>
                                        @else
                                        <div class="flex items-center gap-4">
                                            <div class="h-14 w-14 rounded-xl bg-gradient-to-r from-gray-400 to-gray-600 flex items-center justify-center text-white font-bold text-lg shadow-md">
                                                ?
                                            </div>
                                            <p class="text-lg font-bold text-gray-800">{{ $nivel->nombre_nivel }}</p>
                                        </div>
                                        @endif
                                    </div>

                                    {{-- Columna Derecha: Descripción del comportamiento --}}
                                    <div class="col-span-12 md:col-span-7">
                                        <p class="text-gray-600 leading-relaxed group-hover/nivel:text-gray-700 transition-colors">
                                            {{ $nivel->descripcion_nivel }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-12 bg-gradient-to-br from-gray-50 to-gray-100/50 rounded-xl border-2 border-dashed border-gray-300/50">
                                <div class="mx-auto h-16 w-16 bg-gradient-to-r from-gray-200 to-gray-300 rounded-full flex items-center justify-center mb-4">
                                    <svg class="h-8 w-8 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">Sin niveles definidos</h3>
                                <p class="text-gray-500 max-w-md mx-auto">Esta competencia aún no tiene niveles de comportamiento configurados.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Vista de catálogo completo --}}
                @elseif ($vistaCatalogo && $competenciasCatalogo->isNotEmpty())
                @php
                $escalaDeNiveles = [
                    'Excepcional' => ['numero' => 5, 'tagline' => 'Modelo a seguir con impacto sostenido', 'color' => 'from-emerald-500 to-green-600', 'bg' => 'bg-gradient-to-r from-emerald-50 to-green-50', 'border' => 'border-emerald-200'],
                    'Supera las Expectativas' => ['numero' => 4, 'tagline' => 'Desempeño consistentemente superior', 'color' => 'from-blue-500 to-indigo-600', 'bg' => 'bg-gradient-to-r from-blue-50 to-indigo-50', 'border' => 'border-blue-200'],
                    'Competente' => ['numero' => 3, 'tagline' => 'Cumple de forma confiable lo esperado', 'color' => 'from-indigo-500 to-purple-600', 'bg' => 'bg-gradient-to-r from-indigo-50 to-purple-50', 'border' => 'border-indigo-200'],
                    'En Desarrollo' => ['numero' => 2, 'tagline' => 'Avanza con áreas por fortalecer', 'color' => 'from-amber-500 to-orange-600', 'bg' => 'bg-gradient-to-r from-amber-50 to-orange-50', 'border' => 'border-amber-200'],
                    'Requiere Apoyo' => ['numero' => 1, 'tagline' => 'Necesita acompañamiento para el estándar', 'color' => 'from-red-500 to-rose-600', 'bg' => 'bg-gradient-to-r from-red-50 to-rose-50', 'border' => 'border-red-200'],
                ];
                @endphp

                <div class="space-y-6">
                    {{-- Contador de competencias mejorado --}}
                    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-indigo-500 p-4 rounded-xl shadow-sm">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-indigo-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-indigo-700 font-medium">
                                    Mostrando <span class="font-bold">{{ $competenciasCatalogo->count() }}</span> competencia(s) de esta categoría
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Listado de todas las competencias --}}
                    @foreach ($competenciasCatalogo as $competencia)
                    <div wire:key="competencia-{{ $competencia->id_competencia }}" 
                         class="group bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100/50 hover:shadow-xl transition-all duration-500">
                        
                        {{-- Mismo diseño de tarjeta que la vista individual --}}
                        <div class="bg-gradient-to-r from-gray-50 to-gray-100/80 p-6 border-b border-gray-200/50">
                            <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-3">
                                        <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-gradient-to-r from-indigo-100 to-purple-100 text-indigo-700 border border-indigo-200/50 shadow-sm">
                                            {{ $competencia->categoria->categoria ?? 'Sin categoría' }}
                                        </span>
                                        <div class="h-2 w-2 rounded-full bg-indigo-300"></div>
                                        <span class="text-xs text-gray-500 font-medium">
                                            {{ $competencia->niveles->count() }} Niveles
                                        </span>
                                    </div>
                                    <h2 class="text-2xl font-bold text-gray-900 group-hover:text-indigo-700 transition-colors duration-300">
                                        {{ $competencia->nombre_competencia }}
                                    </h2>
                                    <p class="mt-3 text-gray-600 leading-relaxed max-w-3xl">
                                        {{ $competencia->definicion_competencia }}
                                    </p>
                                </div>
                                <a
                                    href="{{ route('editar-competencia', ['competencia' => $competencia->id_competencia]) }}"
                                     class="group/edit relative flex-shrink-0 inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-semibold rounded-xl text-white bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-300 hover:scale-105 hover:shadow-lg overflow-hidden">
                                    <div class="absolute inset-0 bg-white/20 rounded-xl opacity-0 group-hover/edit:opacity-100 transition-opacity duration-300"></div>
                                    <svg class="w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                    Editar
                                </a>
                            </div>
                        </div>

                        {{-- Contenido de niveles (igual que en vista individual) --}}
                        <div class="p-6">
                            <div class="flex items-center gap-2 mb-6">
                                <div class="p-1.5 bg-indigo-100 rounded-lg">
                                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                </div>
                                <h4 class="text-sm font-bold text-gray-700 uppercase tracking-widest">Niveles de Comportamiento</h4>
                            </div>

                            <div class="space-y-4">
                                @forelse ($competencia->niveles as $nivel)
                                @php
                                $datosNivel = $escalaDeNiveles[$nivel->nombre_nivel] ?? null;
                                @endphp

                                <div class="group/nivel {{ $datosNivel['bg'] ?? 'bg-gray-50' }} rounded-xl border {{ $datosNivel['border'] ?? 'border-gray-200' }} p-5 transition-all duration-300 hover:shadow-md hover:scale-[1.02]">
                                    <div class="grid grid-cols-12 gap-6 items-start">
                                        <div class="col-span-12 md:col-span-5">
                                            @if ($datosNivel)
                                            <div class="flex items-center gap-4">
                                                <div class="flex-shrink-0">
                                                    <div class="h-14 w-14 rounded-xl bg-gradient-to-r {{ $datosNivel['color'] }} flex items-center justify-center text-white font-bold text-lg shadow-md">
                                                        {{ $datosNivel['numero'] }}
                                                    </div>
                                                </div>
                                                <div class="flex-1">
                                                    <p class="text-lg font-bold text-gray-800 group-hover/nivel:text-gray-900 transition-colors">
                                                        {{ $nivel->nombre_nivel }}
                                                    </p>
                                                    <p class="text-sm text-gray-500 italic mt-1 leading-tight">"{{ $datosNivel['tagline'] }}"</p>
                                                </div>
                                            </div>
                                            @else
                                            <div class="flex items-center gap-4">
                                                <div class="h-14 w-14 rounded-xl bg-gradient-to-r from-gray-400 to-gray-600 flex items-center justify-center text-white font-bold text-lg shadow-md">
                                                    ?
                                                </div>
                                                <p class="text-lg font-bold text-gray-800">{{ $nivel->nombre_nivel }}</p>
                                            </div>
                                            @endif
                                        </div>

                                        <div class="col-span-12 md:col-span-7">
                                            <p class="text-gray-600 leading-relaxed group-hover/nivel:text-gray-700 transition-colors">
                                                {{ $nivel->descripcion_nivel }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-12 bg-gradient-to-br from-gray-50 to-gray-100/50 rounded-xl border-2 border-dashed border-gray-300/50">
                                    <div class="mx-auto h-16 w-16 bg-gradient-to-r from-gray-200 to-gray-300 rounded-full flex items-center justify-center mb-4">
                                        <svg class="h-8 w-8 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">Sin niveles definidos</h3>
                                    <p class="text-gray-500 max-w-md mx-auto">Esta competencia aún no tiene niveles de comportamiento configurados.</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Vista inicial --}}
                @else
                <div class="text-center bg-white p-16 rounded-2xl shadow-lg border border-gray-100/50">
                    <div class="mx-auto h-20 w-20 bg-gradient-to-r from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-6">
                        <svg class="h-10 w-10 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Catálogo de Competencias</h3>
                    <p class="text-gray-600 mb-6 max-w-md mx-auto">Selecciona una categoría y una competencia para ver sus detalles, o usa "Ver Catálogo Completo" para explorar todas las competencias de una categoría.</p>
                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Selecciona una categoría para comenzar
                        </span>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>