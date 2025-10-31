<div>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">

            <!-- Cabecera del Reporte -->
            <header class="mb-8">
                <div class="flex flex-col md:flex-row justify-between items-center bg-white p-6 rounded-xl shadow-md">
                    <div>
                        <div class="flex items-center space-x-3">
                            <div class="bg-indigo-600 text-white rounded-full w-12 h-12 flex items-center justify-center font-bold text-xl">
                                E360
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold text-gray-800">E360 Pro</h1>
                                <p class="text-sm text-indigo-600 font-semibold">Reporte de Evaluación 360°</p>
                            </div>
                        </div>
                        <p class="mt-3 text-sm text-gray-500">Análisis detallado de resultados basado en retroalimentación multifuente</p>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <button onclick="window.print()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-medium shadow-md transition-colors">
                            📄 Descargar PDF
                        </button>
                    </div>
                </div>
            </header>

            <!-- Controles de Filtro Mejorados -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Filtros de Búsqueda</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                    <!-- Evaluación con información adicional -->
                    <div>
                        <label for="select-evaluacion" class="block text-sm font-medium text-gray-700 mb-1">
                            Evaluación
                            <!--[if BLOCK]><![endif]--><?php if($evaluacionIdSeleccionada): ?>
                            <span class="text-green-600 text-xs">(<?php echo e($totalEvaluados); ?> eval.)</span>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </label>
                        <select wire:model.live="evaluacionIdSeleccionada" id="select-evaluacion"
                            class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg">
                            <option value="">-- Todas las Evaluaciones --</option>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $evaluaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $eval): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                            $totalEval = $this->getEvaluacionesAgrupadas($eval->tipo_evaluacion, $eval->fecha_inicio->format('Y-m-d'))->sum(function($e) {
                            return $e->encuestados_data ? count($e->encuestados_data) : 0;
                            });
                            ?>
                            <option value="<?php echo e($eval->id_evaluacion); ?>">
                                <?php echo e($eval->tipo_evaluacion); ?> (<?php echo e($eval->fecha_inicio->format('d/m/Y')); ?>)
                                <!--[if BLOCK]><![endif]--><?php if($totalEval > 0): ?>
                                <span class="text-gray-500">- <?php echo e($totalEval); ?> evaluados</span>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </select>
                        <!--[if BLOCK]><![endif]--><?php if($evaluacionIdSeleccionada): ?>
                        <p class="text-xs text-gray-500 mt-1">
                            <?php echo e($empresaActual); ?><?php echo e($departamentoActual ? ' • ' . $departamentoActual : ''); ?>

                        </p>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                    <!-- Empresa con departamentos disponibles -->
                    <div>
                        <label for="select-empresa" class="block text-sm font-medium text-gray-700 mb-1">
                            Empresa
                            <!--[if BLOCK]><![endif]--><?php if($empresaSeleccionada && $departamentos->count()): ?>
                            <span class="text-blue-600 text-xs">(<?php echo e($departamentos->count()); ?> dept.)</span>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </label>
                        <select wire:model.live="empresaSeleccionada" id="select-empresa"
                            class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg"
                            <?php echo e(!$evaluacionIdSeleccionada ? 'disabled' : ''); ?>>
                            <option value="">-- Todas las Empresas --</option>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $empresasDisponibles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empresa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($empresa->id_empresa); ?>"><?php echo e($empresa->nombre_comercial); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </select>
                    </div>

                    <!-- Departamento con evaluados disponibles -->
                    <div>
                        <label for="select-departamento" class="block text-sm font-medium text-gray-700 mb-1">
                            Departamento
                            <!--[if BLOCK]><![endif]--><?php if($departamentoSeleccionado && $usuariosEvaluados->count()): ?>
                            <span class="text-purple-600 text-xs">(<?php echo e($usuariosEvaluados->count()); ?> pers.)</span>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </label>
                        <select wire:model.live="departamentoSeleccionado" id="select-departamento"
                            class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg"
                            <?php echo e(!$empresaSeleccionada ? 'disabled' : ''); ?>>
                            <option value="">-- Todos los Departamentos --</option>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $departamentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $departamento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($departamento->id_departamento); ?>"><?php echo e($departamento->nombre_departamento); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </select>
                    </div>

                    <!-- Evaluado con información de puesto -->
                    <div>
                        <label for="select-evaluado" class="block text-sm font-medium text-gray-700 mb-1">
                            Evaluado
                            <!--[if BLOCK]><![endif]--><?php if($usuarioEvaluadoSeleccionado): ?>
                            <span class="text-green-600 text-xs">(Individual)</span>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </label>
                        <select wire:model.live="usuarioEvaluadoSeleccionado" id="select-evaluado"
                            class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 rounded-lg"
                            <?php echo e(!$departamentoSeleccionado ? 'disabled' : ''); ?>>
                            <option value="">-- Todos los Evaluados --</option>
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $usuariosEvaluados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                            $puesto = $this->getPuestoFromEvaluacion($usuario->id, $evaluacionIdSeleccionada);
                            ?>
                            <option value="<?php echo e($usuario->id); ?>">
                                <?php echo e($usuario->name); ?>

                                <!--[if BLOCK]><![endif]--><?php if($puesto): ?>
                                <span class="text-gray-500">- <?php echo e($puesto); ?></span>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </select>
                    </div>
                </div>
            </div>

            <!-- Contenido del Reporte -->
            <!--[if BLOCK]><![endif]--><?php if(empty($resultados)): ?>
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                <div class="text-gray-400 mb-4">
                    <svg class="mx-auto h-24 w-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <p class="text-lg text-gray-500">Selecciona una evaluación para ver los resultados</p>
            </div>
            <?php else: ?>
            <!--[if BLOCK]><![endif]--><?php if($tipoReporte === 'por_evaluado' && $usuarioEvaluadoSeleccionado): ?>
            <?php
            $evaluado = $resultados[$usuarioEvaluadoSeleccionado];
            $evaluacionActual = $evaluaciones->firstWhere('id_evaluacion', $evaluacionIdSeleccionada);
            ?>

            <!-- Reporte Individual Detallado -->
            <div class="space-y-6">
                <!-- Encabezado del Evaluado -->
                <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl shadow-lg p-8 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <h2 class="text-2xl font-bold mb-2"><?php echo e($evaluado['nombre']); ?></h2>
                            <div class="space-y-1 text-indigo-100">
                                <p><span class="font-semibold">Empresa:</span> <?php echo e($evaluado['empresa']); ?></p>
                                <p><span class="font-semibold">Departamento:</span> <?php echo e($evaluado['departamento']); ?></p>
                                <p><span class="font-semibold">Puesto:</span> <?php echo e($evaluado['puesto']); ?></p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-indigo-200">Reporte Generado</p>
                            <p class="text-lg font-semibold"><?php echo e(now()->format('d/m/Y')); ?></p>
                            <p class="text-xs text-indigo-200 mt-2">ID: E360-<?php echo e(date('Y-m-d')); ?>-<?php echo e(str_pad($usuarioEvaluadoSeleccionado, 3, '0', STR_PAD_LEFT)); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Guía de Interpretación -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">📋 Evaluación 360° – Guía de Interpretación</h3>
                    <p class="text-gray-600 mb-4">
                        La Evaluación 360° ofrece una visión integral de su desempeño, recopilando retroalimentación desde diferentes perspectivas.
                        Este enfoque permite identificar fortalezas y áreas de mejora con el fin de impulsar su crecimiento profesional.
                    </p>

                    <div class="bg-gray-50 rounded-lg p-4">
                        <h4 class="font-semibold text-gray-800 mb-3">Niveles de Comportamiento</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $nivelesEvaluacion; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nivel => $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center space-x-3">
                                <div class="w-4 h-4 rounded-full" style="background-color: <?php echo e($info['color']); ?>"></div>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">Nivel <?php echo e($nivel); ?>: <?php echo e($info['nombre']); ?></p>
                                    <p class="text-xs text-gray-500"><?php echo e($info['descripcion']); ?></p>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>
                </div>

                <!-- KPIs Resumen -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Promedio General</p>
                                <p class="text-4xl font-bold text-indigo-600 mt-2"><?php echo e($evaluado['promedio_general'] ?? '0.00'); ?></p>
                            </div>
                            <div class="w-16 h-16 rounded-full flex items-center justify-center"
                                style="background-color: <?php echo e(($nivelesEvaluacion[$evaluado['nivel_general']]['color'] ?? '#EF4444')); ?>20">
                                <span class="text-2xl">📊</span>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium text-white"
                                style="background-color: <?php echo e($nivelesEvaluacion[$evaluado['nivel_general']]['color'] ?? '#EF4444'); ?>">
                                <?php echo e($nivelesEvaluacion[$evaluado['nivel_general']]['nombre'] ?? 'Sin datos'); ?>

                            </span>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Participantes</p>
                                <p class="text-4xl font-bold text-purple-600 mt-2"><?php echo e($evaluado['total_calificadores']); ?></p>
                            </div>
                            <div class="w-16 h-16 rounded-full bg-purple-100 flex items-center justify-center">
                                <span class="text-2xl">👥</span>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <p class="text-xs text-gray-500">Evaluadores en esta retroalimentación</p>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 font-medium">Competencias</p>
                                <p class="text-4xl font-bold text-green-600 mt-2"><?php echo e(count($evaluado['competencias'])); ?></p>
                            </div>
                            <div class="w-16 h-16 rounded-full bg-green-100 flex items-center justify-center">
                                <span class="text-2xl">🎯</span>
                            </div>
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <p class="text-xs text-gray-500">Evaluadas en este proceso</p>
                        </div>
                    </div>
                </div>

                <!-- Participación en esta evaluación -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">👥 Participación en esta Evaluación</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $evaluado['calificadores']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $calificador): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-gradient-to-br from-indigo-50 to-purple-50 rounded-lg p-4 border border-indigo-100">
                            <div class="flex items-center space-x-2 mb-2">
                                <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center text-sm font-bold">
                                    <?php echo e(substr($calificador['nombre'], 0, 1)); ?>

                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-800"><?php echo e(explode(' ', $calificador['nombre'])[0]); ?></p>
                                </div>
                            </div>
                            <span class="inline-block px-2 py-1 bg-indigo-600 text-white text-xs rounded-full">
                                <?php echo e($calificador['tipo_rol']); ?>

                            </span>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>

                <!-- Gráfica de Radar -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">📊 Visión General de Competencias</h3>
                    <p class="text-sm text-gray-600 mb-6">Distribución del desempeño en todas las competencias evaluadas</p>
                    <div class="flex justify-center">
                        <img src="<?php echo e($this->generarUrlGraficaRadar($evaluado['id'])); ?>"
                            alt="Gráfica de competencias"
                            class="max-w-full h-auto rounded-lg shadow-sm">
                    </div>
                </div>

                <!-- Detalle de Competencias -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-6">🎯 Análisis Detallado por Competencia</h3>
                    <div class="space-y-8">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $evaluado['competencias']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idComp => $competencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="border-l-4 pl-6 py-4" style="border-color: <?php echo e($nivelesEvaluacion[$competencia['nivel']]['color']); ?>">
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <h4 class="text-lg font-semibold text-gray-800"><?php echo e($competencia['nombre']); ?></h4>
                                    <div class="mt-2 flex items-center space-x-3">
                                        <span class="text-3xl font-bold text-gray-800"><?php echo e($competencia['promedio']); ?></span>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium text-white"
                                            style="background-color: <?php echo e($nivelesEvaluacion[$competencia['nivel']]['color']); ?>">
                                            <?php echo e($nivelesEvaluacion[$competencia['nivel']]['nombre']); ?>

                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Barra de progreso visual -->
                            <div class="mb-4">
                                <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                                    <div class="h-3 rounded-full transition-all duration-500"
                                        style="width: <?php echo e(($competencia['promedio'] / 5) * 100); ?>%; background-color: <?php echo e($nivelesEvaluacion[$competencia['nivel']]['color']); ?>">
                                    </div>
                                </div>
                                <div class="flex justify-between text-xs text-gray-500 mt-1">
                                    <span>0</span>
                                    <span>2.5</span>
                                    <span>5.0</span>
                                </div>
                            </div>

                            <!-- Evaluación por Relaciones -->
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm font-semibold text-gray-700 mb-3">Evaluación por Relaciones:</p>
                                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $competencia['promedios_por_rol']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rol => $promedio): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="bg-white rounded-lg p-3 border border-gray-200">
                                        <p class="text-xs text-gray-500 mb-1"><?php echo e($rol); ?></p>
                                        <p class="text-2xl font-bold text-indigo-600"><?php echo e($promedio); ?></p>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>

                            <!-- Mini gráfica comparativa -->
                            <div class="mt-4">
                                <img src="<?php echo e($this->generarUrlGraficaComparativaRoles($evaluado['id'], $idComp)); ?>"
                                    alt="Comparativa por roles"
                                    class="max-w-full h-auto rounded-lg">
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>

                <!-- Gráfica de Barras Horizontales -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">📈 Ranking de Competencias</h3>
                    <p class="text-sm text-gray-600 mb-6">Comparación visual del desempeño en cada competencia</p>
                    <div class="flex justify-center">
                        <img src="<?php echo e($this->generarUrlGraficaBarrasHorizontal($evaluado['id'])); ?>&t=<?php echo e(now()->timestamp); ?>"
                            alt="Ranking de competencias"
                            class="max-w-full h-auto rounded-lg shadow-sm">
                    </div>
                </div>

                <!-- Tabla Detalle por Rol -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">📋 Competencia Comparativa</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-indigo-50 to-purple-50">
                                <tr>
                                    <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Competencia
                                    </th>
                                    <?php
                                    // Definir todos los roles posibles en el orden deseado
                                    $rolesPosibles = ['Autoevaluación', 'Jefe', 'Par', 'Colaborador', 'Cliente'];
                                    $rolesPresentes = [];

                                    foreach ($evaluado['competencias'] as $comp) {
                                    foreach ($comp['promedios_por_rol'] as $rol => $prom) {
                                    if (!in_array($rol, $rolesPresentes)) $rolesPresentes[] = $rol;
                                    }
                                    }

                                    // Ordenar los roles según el orden definido
                                    $rolesUnicos = array_intersect($rolesPosibles, $rolesPresentes);
                                    ?>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $rolesUnicos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        <?php echo e($rol); ?>

                                    </th>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Promedio
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Diferencia
                                    </th>
                                    <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">
                                        Tendencia
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $evaluado['competencias']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $competencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                // Calcular diferencia entre autoevaluación y promedio de otros roles
                                $autoevaluacion = $competencia['promedios_por_rol']['Autoevaluación'] ?? null;

                                // Calcular promedio de todos los roles excepto autoevaluación
                                $otrosRoles = array_filter($competencia['promedios_por_rol'], function($rol) {
                                return $rol !== 'Autoevaluación';
                                }, ARRAY_FILTER_USE_KEY);

                                $promedioOtrosRoles = null;
                                $diferencia = null;
                                $tendencia = null;
                                $colorTendencia = 'gray';

                                if ($autoevaluacion !== null && count($otrosRoles) > 0) {
                                $promedioOtrosRoles = round(array_sum($otrosRoles) / count($otrosRoles), 2);
                                $diferencia = round($autoevaluacion - $promedioOtrosRoles, 2);

                                // Determinar tendencia basada en la diferencia
                                if ($diferencia > 0.5) {
                                $tendencia = 'Sobrevalorado';
                                $colorTendencia = 'yellow';
                                } elseif ($diferencia < -0.5) {
                                    $tendencia='Subvalorado' ;
                                    $colorTendencia='blue' ;
                                    } else {
                                    $tendencia='Alineado' ;
                                    $colorTendencia='green' ;
                                    }
                                    }

                                    // También calcular diferencia específica con Jefe si existe
                                    $diferenciaJefe=null;
                                    $jefeEvaluacion=$competencia['promedios_por_rol']['Jefe'] ?? null;
                                    if ($autoevaluacion !==null && $jefeEvaluacion !==null) {
                                    $diferenciaJefe=round($autoevaluacion - $jefeEvaluacion, 2);
                                    }
                                    ?>
                                    <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                        <?php echo e($competencia['nombre']); ?>

                                    </td>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $rolesUnicos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <!--[if BLOCK]><![endif]--><?php if(isset($competencia['promedios_por_rol'][$rol])): ?>
                                        <?php
                                        $promedioRol = $competencia['promedios_por_rol'][$rol];
                                        $nivelRol = $promedioRol >= 4.5 ? 5 : ($promedioRol >= 3.5 ? 4 : ($promedioRol >= 2.5 ? 3 : ($promedioRol >= 1.5 ? 2 : 1)));
                                        ?>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold text-white"
                                            style="background-color: <?php echo e($nivelesEvaluacion[$nivelRol]['color']); ?>">
                                            <?php echo e($promedioRol); ?>

                                        </span>
                                        <?php else: ?>
                                        <span class="text-gray-400 text-sm">N/A</span>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="inline-flex items-center px-4 py-1.5 rounded-full text-sm font-bold text-white"
                                            style="background-color: <?php echo e($nivelesEvaluacion[$competencia['nivel']]['color']); ?>">
                                            <?php echo e($competencia['promedio']); ?>

                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <!--[if BLOCK]><![endif]--><?php if($diferencia !== null): ?>
                                        <div class="flex flex-col items-center space-y-1">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold 
                                <?php echo e($diferencia > 0 ? 'bg-yellow-100 text-yellow-800' : ($diferencia < 0 ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800')); ?>">
                                                <?php echo e($diferencia > 0 ? '+' : ''); ?><?php echo e($diferencia); ?>

                                            </span>
                                            <!--[if BLOCK]><![endif]--><?php if($diferenciaJefe !== null): ?>
                                            <span class="text-xs text-gray-500">
                                                Jefe: <?php echo e($diferenciaJefe > 0 ? '+' : ''); ?><?php echo e($diferenciaJefe); ?>

                                            </span>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                        <?php else: ?>
                                        <span class="text-gray-400 text-sm">N/A</span>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <!--[if BLOCK]><![endif]--><?php if($tendencia): ?>
                                        <div class="flex flex-col items-center space-y-1">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                                <?php echo e($colorTendencia === 'yellow' ? 'bg-yellow-100 text-yellow-800' : 
                                   ($colorTendencia === 'blue' ? 'bg-blue-100 text-blue-800' : 
                                   ($colorTendencia === 'green' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'))); ?>">
                                                <!--[if BLOCK]><![endif]--><?php if($tendencia === 'Sobrevalorado'): ?>
                                                ⬆️ <?php echo e($tendencia); ?>

                                                <?php elseif($tendencia === 'Subvalorado'): ?>
                                                ⬇️ <?php echo e($tendencia); ?>

                                                <?php else: ?>
                                                ✅ <?php echo e($tendencia); ?>

                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </span>
                                            <!--[if BLOCK]><![endif]--><?php if($promedioOtrosRoles !== null): ?>
                                            <span class="text-xs text-gray-500">
                                                vs otros: <?php echo e($promedioOtrosRoles); ?>

                                            </span>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        </div>
                                        <?php else: ?>
                                        <span class="text-gray-400 text-sm">N/A</span>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </tbody>
                        </table>

                        <!-- Leyenda de la tabla -->
                        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
                            <div class="flex flex-wrap items-center justify-center gap-4 text-xs text-gray-600">
                                <div class="flex items-center space-x-1">
                                    <span class="w-3 h-3 bg-yellow-100 border border-yellow-300 rounded"></span>
                                    <span>Sobrevalorado: Autoevaluación > Otros por +0.5</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <span class="w-3 h-3 bg-blue-100 border border-blue-300 rounded"></span>
                                    <span>Subvalorado: Autoevaluación < Otros por -0.5</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    <span class="w-3 h-3 bg-green-100 border border-green-300 rounded"></span>
                                    <span>Alineado: Diferencia dentro de ±0.5</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php else: ?>
                <!-- Vista de Tabla Resumen para múltiples evaluados -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="p-6 bg-gradient-to-r from-indigo-50 to-purple-50 border-b border-gray-200">
                        <h3 class="text-xl font-bold text-gray-800">
                            <!--[if BLOCK]><![endif]--><?php if($tipoReporte === 'general'): ?>
                            📊 Resumen General
                            <?php elseif($tipoReporte === 'por_competencia'): ?>
                            🎯 Resultados por Competencia
                            <?php else: ?>
                            👥 Resultados por Evaluado
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </h3>
                        <p class="text-sm text-gray-600 mt-1">
                            Mostrando <?php echo e(count($resultados)); ?> evaluado(s)
                        </p>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-10">
                                        Evaluado
                                    </th>
                                    <!--[if BLOCK]><![endif]--><?php if($tipoReporte === 'general' || $tipoReporte === 'por_evaluado'): ?>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Promedio General
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Nivel
                                    </th>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <!--[if BLOCK]><![endif]--><?php if($tipoReporte === 'por_competencia' || $tipoReporte === 'por_evaluado'): ?>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = head($resultados)['competencias'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $competencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <?php echo e($competencia['nombre']); ?>

                                    </th>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Acción
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $resultados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $evaluado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 sticky left-0 bg-white">
                                        <div>
                                            <p class="font-semibold"><?php echo e($evaluado['nombre']); ?></p>
                                            <p class="text-xs text-gray-500"><?php echo e($evaluado['puesto']); ?></p>
                                        </div>
                                    </td>
                                    <!--[if BLOCK]><![endif]--><?php if($tipoReporte === 'general' || $tipoReporte === 'por_evaluado'): ?>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="text-2xl font-bold text-indigo-600"><?php echo e($evaluado['promedio_general'] ?? '0.00'); ?></span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <!--[if BLOCK]><![endif]--><?php if(isset($evaluado['nivel_general']) && isset($nivelesEvaluacion[$evaluado['nivel_general']])): ?>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium text-white"
                                            style="background-color: <?php echo e($nivelesEvaluacion[$evaluado['nivel_general']]['color']); ?>">
                                            Nivel <?php echo e($evaluado['nivel_general']); ?>

                                        </span>
                                        <?php else: ?>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-500 text-white">
                                            Sin datos
                                        </span>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </td>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <!--[if BLOCK]><![endif]--><?php if($tipoReporte === 'por_competencia' || $tipoReporte === 'por_evaluado'): ?>
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $evaluado['competencias']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $competencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold text-white"
                                            style="background-color: <?php echo e($nivelesEvaluacion[$competencia['nivel']]['color']); ?>">
                                            <?php echo e($competencia['promedio']); ?>

                                        </span>
                                    </td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <button
                                            wire:click="verDetalle(<?php echo e($evaluado['id']); ?>)"
                                            class="text-indigo-600 hover:text-indigo-900 font-medium text-sm transition-colors duration-200 hover:scale-105">
                                            Ver Detalle →
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </tbody>
                        </table>
                    </div>
                </div>


                <!-- Gráfica comparativa general (solo para múltiples evaluados) -->
                <!--[if BLOCK]><![endif]--><?php if(count($resultados) > 1 && $tipoReporte === 'general'): ?>
                <div class="bg-white rounded-xl shadow-lg p-6 mt-6">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">📊 Comparativa General</h3>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-gray-600 mb-4">Distribución de Niveles de Desempeño</p>
                            <?php
                            $distribucionNiveles = array_count_values(
                            array_map(function($evaluado) {
                            return $evaluado['nivel_general'] ?? 1; // Valor por defecto 1 si no existe
                            }, $resultados)
                            );
                            ?>
                            <div class="space-y-3">
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $nivelesEvaluacion; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nivel => $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                $cantidad = $distribucionNiveles[$nivel] ?? 0;
                                $porcentaje = count($resultados) > 0 ? ($cantidad / count($resultados)) * 100 : 0;
                                ?>
                                <div>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="font-medium">Nivel <?php echo e($nivel); ?>: <?php echo e($info['nombre']); ?></span>
                                        <span class="text-gray-600"><?php echo e($cantidad); ?> (<?php echo e(number_format($porcentaje, 1)); ?>%)</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="h-2.5 rounded-full"
                                            style="width: <?php echo e($porcentaje); ?>%; background-color: <?php echo e($info['color']); ?>">
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 mb-4">Estadísticas Generales</p>
                            <?php
                            $promedios = array_map(function($evaluado) {
                            return $evaluado['promedio_general'] ?? 0; // Valor por defecto 0 si no existe
                            }, $resultados);
                            $promedioGlobal = count($promedios) > 0 ? array_sum($promedios) / count($promedios) : 0;
                            $maximo = count($promedios) > 0 ? max($promedios) : 0;
                            $minimo = count($promedios) > 0 ? min($promedios) : 0;
                            ?>
                            <div class="grid grid-cols-3 gap-4">
                                <div class="bg-indigo-50 rounded-lg p-4 text-center">
                                    <p class="text-xs text-gray-600 mb-1">Promedio</p>
                                    <p class="text-2xl font-bold text-indigo-600"><?php echo e(number_format($promedioGlobal, 2)); ?></p>
                                </div>
                                <div class="bg-green-50 rounded-lg p-4 text-center">
                                    <p class="text-xs text-gray-600 mb-1">Máximo</p>
                                    <p class="text-2xl font-bold text-green-600"><?php echo e(number_format($maximo, 2)); ?></p>
                                </div>
                                <div class="bg-red-50 rounded-lg p-4 text-center">
                                    <p class="text-xs text-gray-600 mb-1">Mínimo</p>
                                    <p class="text-2xl font-bold text-red-600"><?php echo e(number_format($minimo, 2)); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->


                <!-- Sección de Compromisos de Mejora -->
                <!-- Agregar después de la tabla comparativa y antes del footer -->
                <!--[if BLOCK]><![endif]--><?php if($tipoReporte === 'por_evaluado' && $usuarioEvaluadoSeleccionado): ?>
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">🎯 Plan de Acción y Compromisos</h3>
                            <p class="text-sm text-gray-600 mt-1">Compromisos establecidos para el desarrollo de competencias</p>
                        </div>
                        <button
                            wire:click="abrirFormularioCompromiso"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg font-medium shadow-md transition-colors flex items-center space-x-2">
                            <span>➕</span>
                            <span>Nuevo Compromiso</span>
                        </button>
                    </div>

                    <?php
                    $compromisos = $this->cargarCompromisos($usuarioEvaluadoSeleccionado);
                    ?>

                    <!--[if BLOCK]><![endif]--><?php if($compromisos->isEmpty()): ?>
                    <div class="text-center py-12 bg-gray-50 rounded-lg">
                        <div class="text-gray-400 mb-4">
                            <svg class="mx-auto h-16 w-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </div>
                        <p class="text-gray-600 mb-2">No hay compromisos registrados</p>
                        <p class="text-sm text-gray-500">Crea el primer compromiso para iniciar el plan de acción</p>
                    </div>
                    <?php else: ?>
                    <!-- Resumen de Compromisos -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                        <?php
                        $stats = [
                        'total' => $compromisos->count(),
                        'pendiente' => $compromisos->where('estado', 'pendiente')->count(),
                        'en_progreso' => $compromisos->where('estado', 'en_progreso')->count(),
                        'completado' => $compromisos->where('estado', 'completado')->count(),
                        ];
                        ?>
                        <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                            <p class="text-sm text-blue-600 font-medium">Total</p>
                            <p class="text-2xl font-bold text-blue-700"><?php echo e($stats['total']); ?></p>
                        </div>
                        <div class="bg-yellow-50 rounded-lg p-4 border border-yellow-200">
                            <p class="text-sm text-yellow-600 font-medium">Pendientes</p>
                            <p class="text-2xl font-bold text-yellow-700"><?php echo e($stats['pendiente']); ?></p>
                        </div>
                        <div class="bg-purple-50 rounded-lg p-4 border border-purple-200">
                            <p class="text-sm text-purple-600 font-medium">En Progreso</p>
                            <p class="text-2xl font-bold text-purple-700"><?php echo e($stats['en_progreso']); ?></p>
                        </div>
                        <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                            <p class="text-sm text-green-600 font-medium">Completados</p>
                            <p class="text-2xl font-bold text-green-700"><?php echo e($stats['completado']); ?></p>
                        </div>
                    </div>

                    <!-- Lista de Compromisos -->
                    <div class="space-y-4">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $compromisos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $compromiso): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="border border-gray-200 rounded-lg p-5 hover:shadow-md transition-shadow">
                            <div class="flex justify-between items-start mb-3">
                                <div class="flex-1">
                                    <div class="flex items-center space-x-3 mb-2">
                                        <h4 class="text-lg font-semibold text-gray-800"><?php echo e($compromiso->titulo); ?></h4>
                                        <?php
                                        $estadoConfig = [
                                        'pendiente' => ['color' => 'yellow', 'icono' => '⏳', 'texto' => 'Pendiente'],
                                        'en_progreso' => ['color' => 'blue', 'icono' => '🚀', 'texto' => 'En Progreso'],
                                        'completado' => ['color' => 'green', 'icono' => '✅', 'texto' => 'Completado'],
                                        'vencido' => ['color' => 'red', 'icono' => '⚠️', 'texto' => 'Vencido'],
                                        ];
                                        $config = $estadoConfig[$compromiso->estado] ?? $estadoConfig['pendiente'];
                                        ?>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-<?php echo e($config['color']); ?>-100 text-<?php echo e($config['color']); ?>-800">
                                            <?php echo e($config['icono']); ?> <?php echo e($config['texto']); ?>

                                        </span>
                                    </div>

                                    <!-- Competencia vinculada -->
                                    <!--[if BLOCK]><![endif]--><?php if($compromiso->competencia): ?>
                                    <?php
                                    $competenciaData = $evaluado['competencias'][$compromiso->competencia] ?? null;
                                    ?>
                                    <!--[if BLOCK]><![endif]--><?php if($competenciaData): ?>
                                    <div class="flex items-center space-x-2 mb-3">
                                        <span class="text-sm text-gray-600">Competencia:</span>
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium text-white"
                                            style="background-color: <?php echo e($nivelesEvaluacion[$competenciaData['nivel']]['color']); ?>">
                                            <?php echo e($competenciaData['nombre']); ?>

                                        </span>
                                    </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                    <p class="text-gray-700 mb-3"><?php echo e($compromiso->descripcion_compromiso); ?></p>

                                    <!-- Niveles -->
                                    <!--[if BLOCK]><![endif]--><?php if($compromiso->nivel_actual && $compromiso->nivel_objetivo): ?>
                                    <div class="flex items-center space-x-4 mb-3 text-sm">
                                        <div class="flex items-center space-x-2">
                                            <span class="text-gray-600">Nivel Actual:</span>
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                Nivel <?php echo e($compromiso->nivel_actual); ?>

                                            </span>
                                        </div>
                                        <span class="text-gray-400">→</span>
                                        <div class="flex items-center space-x-2">
                                            <span class="text-gray-600">Objetivo:</span>
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Nivel <?php echo e($compromiso->nivel_objetivo); ?>

                                            </span>
                                        </div>
                                    </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                    <!-- Fechas -->
                                    <div class="flex items-center space-x-4 text-sm text-gray-600 mb-3">
                                        <div class="flex items-center space-x-1">
                                            <span>📅</span>
                                            <span>Creado: <?php echo e($compromiso->fecha_alta->format('d/m/Y')); ?></span>
                                        </div>
                                        <div class="flex items-center space-x-1">
                                            <span>⏰</span>
                                            <span>Vencimiento: <?php echo e($compromiso->fecha_vencimiento->format('d/m/Y')); ?></span>
                                        </div>
                                    </div>

                                    <!-- Acciones específicas -->
                                    <!--[if BLOCK]><![endif]--><?php if($compromiso->acciones_especificas): ?>
                                    <div class="bg-indigo-50 rounded-lg p-3 mb-3">
                                        <p class="text-xs font-semibold text-indigo-800 mb-1">Acciones Específicas:</p>
                                        <p class="text-sm text-indigo-700"><?php echo e($compromiso->acciones_especificas); ?></p>
                                    </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                                    <!-- Recursos de apoyo -->
                                    <!--[if BLOCK]><![endif]--><?php if($compromiso->recursos_apoyo): ?>
                                    <div class="bg-purple-50 rounded-lg p-3">
                                        <p class="text-xs font-semibold text-purple-800 mb-1">Recursos de Apoyo:</p>
                                        <p class="text-sm text-purple-700"><?php echo e($compromiso->recursos_apoyo); ?></p>
                                    </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>

                                <!-- Acciones -->
                                <div class="flex space-x-2 ml-4">
                                    <!--[if BLOCK]><![endif]--><?php if($compromiso->estado !== 'completado'): ?>
                                    <div class="relative group">
                                        <button class="p-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                            </svg>
                                        </button>
                                        <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 hidden group-hover:block z-10">
                                            <!--[if BLOCK]><![endif]--><?php if($compromiso->estado === 'pendiente'): ?>
                                            <button wire:click="cambiarEstadoCompromiso(<?php echo e($compromiso->id_compromiso); ?>, 'en_progreso')"
                                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                🚀 Iniciar
                                            </button>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            <!--[if BLOCK]><![endif]--><?php if($compromiso->estado === 'en_progreso'): ?>
                                            <button wire:click="cambiarEstadoCompromiso(<?php echo e($compromiso->id_compromiso); ?>, 'completado')"
                                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                ✅ Completar
                                            </button>
                                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            <button wire:click="editarCompromiso(<?php echo e($compromiso->id_compromiso); ?>)"
                                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                ✏️ Editar
                                            </button>
                                            <button wire:click="eliminarCompromiso(<?php echo e($compromiso->id_compromiso); ?>)"
                                                class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                                🗑️ Eliminar
                                            </button>
                                        </div>
                                    </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>

                            <!-- Seguimientos -->
                            <!--[if BLOCK]><![endif]--><?php if($compromiso->seguimientos->count() > 0): ?>
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <p class="text-sm font-semibold text-gray-700 mb-3">Seguimientos (<?php echo e($compromiso->seguimientos->count()); ?>):</p>
                                <div class="space-y-2">
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $compromiso->seguimientos->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seguimiento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="bg-gray-50 rounded-lg p-3 text-sm">
                                        <div class="flex justify-between items-start mb-1">
                                            <span class="font-medium text-gray-800"><?php echo e($seguimiento->fecha_seguimiento->format('d/m/Y')); ?></span>
                                            <span class="text-xs px-2 py-1 rounded bg-blue-100 text-blue-800"><?php echo e($seguimiento->avance); ?>% avance</span>
                                        </div>
                                        <p class="text-gray-600"><?php echo e($seguimiento->comentarios); ?></p>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>

                <!-- Modal para Crear/Editar Compromiso -->
                <!--[if BLOCK]><![endif]--><?php if($mostrarFormularioCompromiso): ?>
                <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click="cerrarFormularioCompromiso">
                    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-lg bg-white" wire:click.stop>
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-bold text-gray-800">
                                <?php echo e($compromisoEditando ? 'Editar Compromiso' : 'Nuevo Compromiso de Mejora'); ?>

                            </h3>
                            <button wire:click="cerrarFormularioCompromiso" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <form wire:submit.prevent="guardarCompromiso" class="space-y-4">
                            <!-- Título -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Título del Compromiso*</label>
                                <input type="text" wire:model="compromiso_titulo"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="Ej: Mejorar habilidades de comunicación">
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['compromiso_titulo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>

                            <!-- Descripción -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Descripción*</label>
                                <textarea wire:model="compromiso_descripcion" rows="3"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="Describe el compromiso de mejora"></textarea>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['compromiso_descripcion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>

                            <!-- Grid de 2 columnas -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Competencia -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Competencia Relacionada</label>
                                    <select wire:model.live="compromiso_competencia"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="">Seleccionar competencia</option>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $evaluado['competencias']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $idComp => $comp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($idComp); ?>"><?php echo e($comp['nombre']); ?> (Nivel <?php echo e($comp['nivel']); ?>)</option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </select>
                                </div>

                                <!-- Fecha de Vencimiento -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Fecha de Vencimiento*</label>
                                    <input type="date" wire:model="compromiso_fecha_vencimiento"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['compromiso_fecha_vencimiento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>

                                <!-- Nivel Actual -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nivel Actual</label>
                                    <select wire:model="compromiso_nivel_actual"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="">Seleccionar</option>
                                        <!--[if BLOCK]><![endif]--><?php for($i = 1; $i <= 5; $i++): ?>
                                            <option value="<?php echo e($i); ?>">Nivel <?php echo e($i); ?> - <?php echo e($nivelesEvaluacion[$i]['nombre']); ?></option>
                                            <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                                    </select>
                                </div>

                                <!-- Nivel Objetivo -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nivel Objetivo*</label>
                                    <select wire:model="compromiso_nivel_objetivo"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                                        <option value="">Seleccionar</option>
                                        <!--[if BLOCK]><![endif]--><?php for($i = 1; $i <= 5; $i++): ?>
                                            <option value="<?php echo e($i); ?>">Nivel <?php echo e($i); ?> - <?php echo e($nivelesEvaluacion[$i]['nombre']); ?></option>
                                            <?php endfor; ?><!--[if ENDBLOCK]><![endif]-->
                                    </select>
                                    <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['compromiso_nivel_objetivo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                            </div>

                            <!-- Acciones Específicas -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Acciones Específicas*</label>
                                <textarea wire:model="compromiso_acciones" rows="3"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="¿Qué acciones concretas se realizarán?"></textarea>
                                <!--[if BLOCK]><![endif]--><?php $__errorArgs = ['compromiso_acciones'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>

                            <!-- Recursos de Apoyo -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Recursos de Apoyo</label>
                                <textarea wire:model="compromiso_recursos" rows="2"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                    placeholder="Capacitación, mentoring, herramientas, etc."></textarea>
                            </div>

                            <!-- Botones -->
                            <div class="flex justify-end space-x-3 pt-4">
                                <button type="button" wire:click="cerrarFormularioCompromiso"
                                    class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">
                                    Cancelar
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                                    <?php echo e($compromisoEditando ? 'Actualizar' : 'Crear Compromiso'); ?>

                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <!-- Footer del Reporte -->
                <footer class="mt-8 bg-white rounded-xl shadow-lg p-6 text-center text-gray-500 text-sm">
                    <p class="font-semibold text-gray-700">E360 Pro - Sistema de Evaluación 360°</p>
                    <p class="mt-2">© <?php echo e(date('Y')); ?> - Todos los derechos reservados</p>
                    <p class="mt-1 text-xs">Este reporte es confidencial y está destinado únicamente para uso interno</p>
                </footer>
            </div>
        </div>
    </div>
</div><?php /**PATH D:\laragon\www\encuesta-pro360\resources\views/livewire/encuesta/resultado/reporte-evaluacion.blade.php ENDPATH**/ ?>