<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        <!-- Header -->
        <header class="mb-8">
            <div class="flex flex-col md:flex-row justify-between items-center bg-white p-6 rounded-xl shadow-md">
                <div>
                    <div class="flex items-center space-x-3">
                        <div class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white rounded-full w-14 h-14 flex items-center justify-center font-bold text-2xl shadow-lg">
                            🏆
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold text-gray-800">Ranking de Excelencia</h1>
                            <p class="text-sm text-indigo-600 font-semibold">Evaluación 360° - Clasificación por Desempeño</p>
                        </div>
                    </div>
                </div>
                <div class="mt-4 md:mt-0 flex gap-2">
                    <button wire:click="exportarExcel"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium shadow-md transition-colors flex items-center gap-2">
                        <span>📊</span> Excel
                    </button>
                    <button wire:click="exportarPDF"
                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium shadow-md transition-colors flex items-center gap-2">
                        <span>📄</span> PDF
                    </button>
                </div>
            </div>
        </header>

        <!-- Filtros -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">🔍 Filtros y Búsqueda</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                <!-- Evaluación -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Evaluación</label>
                    <select wire:model.live="evaluacionSeleccionada"
                        class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg">
                        <option value="">-- Selecciona una Evaluación --</option>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $evaluaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $eval): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($eval->id_evaluacion); ?>">
                            <?php echo e($eval->tipo_evaluacion); ?> (<?php echo e($eval->fecha_inicio->format('d/m/Y')); ?>)
                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </select>
                </div>

                <!-- Empresa -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Empresa</label>
                    <select wire:model.live="empresaSeleccionada"
                        class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg">
                        <option value="">-- Todas --</option>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $empresas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empresa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($empresa->id_empresa); ?>"><?php echo e($empresa->nombre_comercial); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </select>
                </div>

                <!-- Departamento -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Departamento</label>
                    <select wire:model.live="departamentoSeleccionado"
                        class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg"
                        <?php if(!$departamentos->count()): ?> disabled <?php endif; ?>>
                        <option value="">-- Todos --</option>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $departamentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $depto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($depto->id_departamento); ?>"><?php echo e($depto->nombre_departamento); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </select>
                </div>

                <!-- Búsqueda -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                    <input type="text" wire:model.live.debounce.300ms="busqueda"
                        placeholder="Nombre del evaluado..."
                        class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg">
                </div>
            </div>

            <!-- Ordenamiento -->
            <div class="flex flex-wrap gap-3 items-center">
                <span class="text-sm font-medium text-gray-700">Ordenar por:</span>
                <select wire:model.live="ordenarPor"
                    class="px-3 py-2 text-sm border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg">
                    <option value="promedio_general">Promedio General</option>
                    <option value="diferencia">Diferencia</option>
                    <option value="autoevaluacion">Autoevaluación</option>
                    <option value="evaluadores">Evaluación de Otros</option>
                </select>

                <button wire:click="$toggle('orden')"
                    class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium transition-colors">
                    <?php echo e($orden === 'desc' ? '↓ Mayor a Menor' : '↑ Menor a Mayor'); ?>

                </button>

                <div class="ml-auto text-sm text-gray-600">
                    <strong><?php echo e(count($rankingData)); ?></strong> evaluados encontrados
                </div>
            </div>
        </div>

        <!-- Estadísticas Rápidas -->
        <!--[if BLOCK]><![endif]--><?php if(count($rankingData) > 0): ?>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <?php
            $promedios = array_column($rankingData, 'promedio_general');
            $promedioGlobal = array_sum($promedios) / count($promedios);
            $maximo = max($promedios);
            $minimo = min($promedios);
            $alineados = count(array_filter($rankingData, fn($r) => $r['tendencia'] === 'Alineado'));
            ?>

            <div class="bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-xl p-6 shadow-lg">
                <div class="text-sm opacity-90 mb-1">Promedio Global</div>
                <div class="text-3xl font-bold"><?php echo e(number_format($promedioGlobal, 2)); ?></div>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-green-600 text-white rounded-xl p-6 shadow-lg">
                <div class="text-sm opacity-90 mb-1">Mejor Desempeño</div>
                <div class="text-3xl font-bold"><?php echo e(number_format($maximo, 2)); ?></div>
            </div>

            <div class="bg-gradient-to-br from-orange-500 to-orange-600 text-white rounded-xl p-6 shadow-lg">
                <div class="text-sm opacity-90 mb-1">Menor Desempeño</div>
                <div class="text-3xl font-bold"><?php echo e(number_format($minimo, 2)); ?></div>
            </div>

            <div class="bg-gradient-to-br from-purple-500 to-purple-600 text-white rounded-xl p-6 shadow-lg">
                <div class="text-sm opacity-90 mb-1">Alineados</div>
                <div class="text-3xl font-bold"><?php echo e($alineados); ?> / <?php echo e(count($rankingData)); ?></div>
            </div>
        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <!-- Tabla de Ranking -->
        <!--[if BLOCK]><![endif]--><?php if(empty($rankingData)): ?>
        <div class="bg-white rounded-xl shadow-lg p-12 text-center">
            <div class="text-gray-400 mb-4">
                <svg class="mx-auto h-24 w-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <p class="text-lg text-gray-500">Selecciona una evaluación para ver el ranking</p>
        </div>
        <?php else: ?>
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-indigo-50 to-purple-50">
                        <tr>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider w-20">
                                Ranking
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Nombre
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Perfil
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Autoevaluación
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Evaluadores
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Diferencia
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Tendencia
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Promedio
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $rankingData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $evaluado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-gray-50 transition-colors <?php echo e($index < 3 ? 'bg-yellow-50' : ''); ?>">
                            <!-- Ranking -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <!--[if BLOCK]><![endif]--><?php if($evaluado['ranking'] === 1): ?>
                                <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-br from-yellow-400 to-yellow-500 rounded-full text-white font-bold text-lg shadow-lg">
                                    🥇
                                </div>
                                <?php elseif($evaluado['ranking'] === 2): ?>
                                <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-br from-gray-300 to-gray-400 rounded-full text-white font-bold text-lg shadow-lg">
                                    🥈
                                </div>
                                <?php elseif($evaluado['ranking'] === 3): ?>
                                <div class="inline-flex items-center justify-center w-12 h-12 bg-gradient-to-br from-orange-400 to-orange-500 rounded-full text-white font-bold text-lg shadow-lg">
                                    🥉
                                </div>
                                <?php else: ?>
                                <div class="inline-flex items-center justify-center w-10 h-10 bg-gray-100 rounded-full text-gray-700 font-bold">
                                    <?php echo e($evaluado['ranking']); ?>

                                </div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </td>

                            <!-- Nombre -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold">
                                            <?php echo e(substr($evaluado['nombre'], 0, 1)); ?>

                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900"><?php echo e($evaluado['nombre']); ?></div>
                                        <div class="text-xs text-gray-500"><?php echo e($evaluado['puesto']); ?></div>
                                    </div>
                                </div>
                            </td>

                            <!-- Perfil -->
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900"><?php echo e($evaluado['empresa']); ?></div>
                                <div class="text-xs text-gray-500"><?php echo e($evaluado['departamento']); ?></div>
                            </td>

                            <!-- Autoevaluación -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <!--[if BLOCK]><![endif]--><?php if($evaluado['autoevaluacion'] !== null): ?>
                                <span class="inline-flex items-center justify-center w-16 h-10 rounded-lg text-lg font-bold text-white"
                                    style="background-color: <?php echo e($nivelesEvaluacion[$this->obtenerNivel($evaluado['autoevaluacion'])]['color']); ?>">
                                    <?php echo e($evaluado['autoevaluacion']); ?>

                                </span>
                                <?php else: ?>
                                <span class="text-gray-400 text-sm">N/A</span>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </td>

                            <!-- Evaluadores -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <!--[if BLOCK]><![endif]--><?php if($evaluado['evaluadores'] !== null): ?>
                                <span class="inline-flex items-center justify-center w-16 h-10 rounded-lg text-lg font-bold text-white"
                                    style="background-color: <?php echo e($nivelesEvaluacion[$this->obtenerNivel($evaluado['evaluadores'])]['color']); ?>">
                                    <?php echo e($evaluado['evaluadores']); ?>

                                </span>
                                <?php else: ?>
                                <span class="text-gray-400 text-sm">N/A</span>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </td>

                            <!-- Diferencia -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <!--[if BLOCK]><![endif]--><?php if($evaluado['diferencia'] !== null): ?>
                                <span class="inline-flex items-center px-4 py-2 rounded-lg text-base font-bold
                                    <?php echo e($evaluado['diferencia'] > 0 ? 'bg-green-100 text-green-800' : 
                                       ($evaluado['diferencia'] < 0 ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')); ?>">
                                    <?php echo e($evaluado['diferencia'] > 0 ? '+' : ''); ?><?php echo e($evaluado['diferencia']); ?>

                                    <!--[if BLOCK]><![endif]--><?php if($evaluado['diferencia'] > 0): ?> ↑ <?php elseif($evaluado['diferencia'] < 0): ?> ↓ <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </span>
                                        <?php else: ?>
                                        <span class="text-gray-400 text-sm">N/A</span>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </td>

                            <!-- Tendencia -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <!--[if BLOCK]><![endif]--><?php if($evaluado['tendencia'] === 'Alineado'): ?>
                                    <div class="text-3xl">📈</div>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                        <?php echo e($evaluado['tendencia']); ?>

                                    </span>
                                    <?php elseif($evaluado['tendencia'] === 'Sobrevalorado'): ?>
                                    <div class="text-3xl">📊</div>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                        <?php echo e($evaluado['tendencia']); ?>

                                    </span>
                                    <?php elseif($evaluado['tendencia'] === 'Subvalorado'): ?>
                                    <div class="text-3xl">📉</div>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                        <?php echo e($evaluado['tendencia']); ?>

                                    </span>
                                    <?php else: ?>
                                    <span class="text-gray-400 text-sm"><?php echo e($evaluado['tendencia']); ?></span>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </td>

                            <!-- Promedio General -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex flex-col items-center gap-1">
                                    <span class="inline-flex items-center justify-center w-20 h-12 rounded-lg text-2xl font-bold text-white shadow-lg"
                                        style="background-color: <?php echo e($nivelesEvaluacion[$evaluado['nivel']]['color']); ?>">
                                        <?php echo e($evaluado['promedio_general']); ?>

                                    </span>
                                    <span class="text-xs text-gray-500">
                                        Nivel <?php echo e($evaluado['nivel']); ?>

                                    </span>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Leyenda -->
        <div class="mt-6 bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">📖 Leyenda de Interpretación</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Niveles de Desempeño -->
                <div>
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Niveles de Desempeño:</h4>
                    <div class="space-y-2">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $nivelesEvaluacion; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nivel => $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white font-bold text-sm"
                                style="background-color: <?php echo e($info['color']); ?>">
                                <?php echo e($nivel); ?>

                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800"><?php echo e($info['nombre']); ?></p>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>

                <!-- Tendencias -->
                <div>
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Interpretación de Tendencias:</h4>
                    <div class="space-y-3">
                        <div class="flex items-start space-x-3">
                            <div class="text-2xl">📈</div>
                            <div>
                                <p class="text-sm font-semibold text-green-700">Alineado</p>
                                <p class="text-xs text-gray-600">La autoevaluación coincide con la percepción de otros (diferencia ±0.5)</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="text-2xl">📊</div>
                            <div>
                                <p class="text-sm font-semibold text-yellow-700">Sobrevalorado</p>
                                <p class="text-xs text-gray-600">La autoevaluación es mayor que la percepción de otros (+0.5 o más)</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <div class="text-2xl">📉</div>
                            <div>
                                <p class="text-sm font-semibold text-blue-700">Subvalorado</p>
                                <p class="text-xs text-gray-600">La autoevaluación es menor que la percepción de otros (-0.5 o menos)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Diferencia -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <h4 class="text-sm font-semibold text-gray-700 mb-3">Cálculo de Diferencia:</h4>
                <div class="bg-gray-50 rounded-lg p-4">
                    <p class="text-sm text-gray-700 mb-2">
                        <strong>Diferencia = Autoevaluación - Promedio de Evaluadores</strong>
                    </p>
                    <ul class="text-xs text-gray-600 space-y-1 ml-4">
                        <li>• <span class="text-green-700 font-semibold">Positiva (+):</span> El evaluado se califica más alto que otros</li>
                        <li>• <span class="text-red-700 font-semibold">Negativa (-):</span> El evaluado se califica más bajo que otros</li>
                        <li>• <span class="text-gray-700 font-semibold">Cercana a 0:</span> Percepción alineada entre autoevaluación y evaluadores</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Análisis de Distribución -->
        <!--[if BLOCK]><![endif]--><?php if(count($rankingData) > 0): ?>
        <div class="mt-6 bg-white rounded-xl shadow-lg p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">📊 Análisis de Distribución</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Distribución por Nivel -->
                <div>
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Por Nivel de Desempeño:</h4>
                    <?php
                    $distribucionNiveles = array_count_values(array_column($rankingData, 'nivel'));
                    ?>
                    <div class="space-y-2">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $nivelesEvaluacion; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nivel => $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                        $cantidad = $distribucionNiveles[$nivel] ?? 0;
                        $porcentaje = count($rankingData) > 0 ? ($cantidad / count($rankingData)) * 100 : 0;
                        ?>
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="font-medium">Nivel <?php echo e($nivel); ?></span>
                                <span class="text-gray-600"><?php echo e($cantidad); ?> (<?php echo e(number_format($porcentaje, 1)); ?>%)</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="h-2.5 rounded-full transition-all duration-300"
                                    style="width: <?php echo e($porcentaje); ?>%; background-color: <?php echo e($info['color']); ?>">
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>

                <!-- Distribución por Tendencia -->
                <div>
                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Por Tendencia de Autopercepción:</h4>
                    <?php
                    $distribucionTendencias = array_count_values(array_column($rankingData, 'tendencia'));
                    $coloresTendencia = [
                    'Alineado' => '#10B981',
                    'Sobrevalorado' => '#F59E0B',
                    'Subvalorado' => '#3B82F6',
                    'Sin datos' => '#6B7280'
                    ];
                    ?>
                    <div class="space-y-2">
                        <?php $__currentLoopData = ['Alineado', 'Sobrevalorado', 'Subvalorado', 'Sin datos']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tendencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                        $cantidad = $distribucionTendencias[$tendencia] ?? 0;
                        $porcentaje = count($rankingData) > 0 ? ($cantidad / count($rankingData)) * 100 : 0;
                        ?>
                        <!--[if BLOCK]><![endif]--><?php if($cantidad > 0): ?>
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="font-medium"><?php echo e($tendencia); ?></span>
                                <span class="text-gray-600"><?php echo e($cantidad); ?> (<?php echo e(number_format($porcentaje, 1)); ?>%)</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="h-2.5 rounded-full transition-all duration-300"
                                    style="width: <?php echo e($porcentaje); ?>%; background-color: <?php echo e($coloresTendencia[$tendencia]); ?>">
                                </div>
                            </div>
                        </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
            </div>
        </div>

        <!-- Top 5 Mejores Desempeños -->
        <div class="mt-6 bg-gradient-to-r from-yellow-50 to-orange-50 rounded-xl shadow-lg p-6 border-2 border-yellow-200">
            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                <span class="text-2xl">🌟</span> Top 5 Mejores Desempeños
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = array_slice($rankingData, 0, 5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $top): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white rounded-lg p-4 shadow-md border-2 border-yellow-300">
                    <div class="text-center mb-2">
                        <!--[if BLOCK]><![endif]--><?php if($top['ranking'] === 1): ?>
                        <div class="text-4xl mb-1">🥇</div>
                        <?php elseif($top['ranking'] === 2): ?>
                        <div class="text-4xl mb-1">🥈</div>
                        <?php elseif($top['ranking'] === 3): ?>
                        <div class="text-4xl mb-1">🥉</div>
                        <?php else: ?>
                        <div class="text-3xl font-bold text-gray-600 mb-1">#<?php echo e($top['ranking']); ?></div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                    <div class="text-center">
                        <p class="font-semibold text-sm text-gray-800 mb-1"><?php echo e(explode(' ', $top['nombre'])[0]); ?></p>
                        <div class="inline-flex items-center justify-center px-3 py-1 rounded-lg text-white font-bold text-lg"
                            style="background-color: <?php echo e($nivelesEvaluacion[$top['nivel']]['color']); ?>">
                            <?php echo e($top['promedio_general']); ?>

                        </div>
                        <p class="text-xs text-gray-500 mt-1"><?php echo e($top['departamento']); ?></p>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        <!-- Footer -->
        <footer class="mt-8 bg-white rounded-xl shadow-lg p-6 text-center text-gray-500 text-sm">
            <p class="font-semibold text-gray-700">E360 Pro - Ranking de Excelencia</p>
            <p class="mt-2">© <?php echo e(date('Y')); ?> - Todos los derechos reservados</p>
            <p class="mt-1 text-xs">Generado el <?php echo e(now()->format('d/m/Y H:i:s')); ?></p>
        </footer>

    </div>
</div><?php /**PATH D:\laragon\www\encuesta-pro360\resources\views/livewire/encuesta/reaking/reaking-excelencia.blade.php ENDPATH**/ ?>