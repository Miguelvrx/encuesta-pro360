<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        <!-- Cabecera del Reporte -->
        <header class="mb-8">
            <div class="flex flex-col md:flex-row justify-between items-center bg-white p-6 rounded-xl shadow-md">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Reporte de Evaluación</h1>
                    <p class="mt-1 text-sm text-gray-500">Análisis detallado de los resultados de las evaluaciones 360°.</p>
                </div>
            </div>
        </header>

        <!-- Controles de Filtro y Visualización -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <!-- Filtro por Evaluación -->
                <div>
                    <label for="select-evaluacion" class="block text-sm font-medium text-gray-700">Seleccionar Evaluación</label>
                    <select wire:model.live="evaluacionIdSeleccionada" id="select-evaluacion" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="">-- Selecciona una Evaluación --</option>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $evaluaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $eval): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($eval->id_evaluacion); ?>"><?php echo e($eval->tipo_evaluacion); ?> (<?php echo e($eval->fecha_inicio->format('d/m/Y')); ?>)</option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </select>
                </div>

                <!-- Filtro por Empresa -->
                <div>
                    <label for="select-empresa" class="block text-sm font-medium text-gray-700">Filtrar por Empresa</label>
                    <select wire:model.live="empresaSeleccionada" id="select-empresa" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="">-- Todas las Empresas --</option>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $empresas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empresa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($empresa->id_empresa); ?>"><?php echo e($empresa->nombre_comercial); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </select>
                </div>

                <!-- Filtro por Departamento -->
                <div>
                    <label for="select-departamento" class="block text-sm font-medium text-gray-700">Filtrar por Departamento</label>
                    <select wire:model.live="departamentoSeleccionado" id="select-departamento" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" <?php if(!$departamentos->count()): ?> disabled <?php endif; ?>>
                        <option value="">-- Todos los Departamentos --</option>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $departamentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $departamento): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($departamento->id_departamento); ?>"><?php echo e($departamento->nombre_departamento); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </select>
                </div>

                <!-- Filtro por Usuario Evaluado -->
                <div>
                    <label for="select-evaluado" class="block text-sm font-medium text-gray-700">Seleccionar Evaluado</label>
                    <select wire:model.live="usuarioEvaluadoSeleccionado" id="select-evaluado" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md" <?php if(!$usuariosEvaluados->count()): ?> disabled <?php endif; ?>>
                        <option value="">-- Todos los Evaluados --</option>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $usuariosEvaluados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $usuario): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($usuario->id); ?>"><?php echo e($usuario->name); ?> <?php echo e($usuario->primer_apellido); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </select>
                </div>
            </div>

            <!-- Selección de Tipo de Reporte -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Reporte:</label>
                <div class="flex space-x-4">
                    <button wire:click="$set('tipoReporte', 'general')" class="px-4 py-2 rounded-md text-sm font-medium <?php echo e($tipoReporte === 'general' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'); ?>">
                        General
                    </button>
                    <button wire:click="$set('tipoReporte', 'por_competencia')" class="px-4 py-2 rounded-md text-sm font-medium <?php echo e($tipoReporte === 'por_competencia' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'); ?>">
                        Por Competencia
                    </button>
                    <button wire:click="$set('tipoReporte', 'por_evaluado')" class="px-4 py-2 rounded-md text-sm font-medium <?php echo e($tipoReporte === 'por_evaluado' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'); ?>">
                        Por Evaluado
                    </button>
                </div>
            </div>

            <!-- Selección de Tipo de Visualización -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Visualización:</label>
                <div class="flex space-x-4">
                    <button wire:click="$set('tipoVisualizacion', 'tabla')" class="px-4 py-2 rounded-md text-sm font-medium <?php echo e($tipoVisualizacion === 'tabla' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'); ?>">
                        Tabla
                    </button>
                    <button wire:click="$set('tipoVisualizacion', 'grafico')" class="px-4 py-2 rounded-md text-sm font-medium <?php echo e($tipoVisualizacion === 'grafico' ? 'bg-indigo-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'); ?>">
                        Gráfico
                    </button>
                </div>
            </div>
        </div>

        <!-- Contenido del Reporte -->
        <!--[if BLOCK]><![endif]--><?php if(empty($resultados)): ?>
            <div class="bg-white rounded-xl shadow-lg p-6 text-center text-gray-500">
                <p>Selecciona una evaluación para ver los resultados.</p>
            </div>
        <?php else: ?>
            <!--[if BLOCK]><![endif]--><?php if($tipoVisualizacion === 'tabla'): ?>
                <!-- Vista de Tabla -->
                <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Evaluado</th>
                                    <!--[if BLOCK]><![endif]--><?php if($tipoReporte === 'general' || $tipoReporte === 'por_evaluado'): ?>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Promedio General</th>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <!--[if BLOCK]><![endif]--><?php if($tipoReporte === 'por_competencia' || $tipoReporte === 'por_evaluado'): ?>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = head($resultados)['competencias'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $competencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo e($competencia['nombre']); ?></th>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $resultados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $evaluado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo e($evaluado['nombre']); ?></td>
                                        <!--[if BLOCK]><![endif]--><?php if($tipoReporte === 'general' || $tipoReporte === 'por_evaluado'): ?>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo e($evaluado['promedio_general']); ?></td>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                        <!--[if BLOCK]><![endif]--><?php if($tipoReporte === 'por_competencia' || $tipoReporte === 'por_evaluado'): ?>
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $evaluado['competencias']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $competencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo e($competencia['promedio']); ?></td>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!--[if BLOCK]><![endif]--><?php if($usuarioEvaluadoSeleccionado && $tipoReporte === 'por_evaluado'): ?>
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden mt-8 p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Detalle por Rol para <?php echo e($resultados[$usuarioEvaluadoSeleccionado]['nombre']); ?></h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Competencia</th>
                                        <?php
                                            $rolesUnicos = [];
                                            foreach ($resultados[$usuarioEvaluadoSeleccionado]['competencias'] as $comp) {
                                                foreach ($comp['promedios_por_rol'] as $rol => $prom) {
                                                    if (!in_array($rol, $rolesUnicos)) $rolesUnicos[] = $rol;
                                                }
                                            }
                                        ?>
                                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $rolesUnicos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"><?php echo e($rol); ?></th>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $resultados[$usuarioEvaluadoSeleccionado]['competencias']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $competencia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?php echo e($competencia['nombre']); ?></td>
                                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $rolesUnicos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo e($competencia['promedios_por_rol'][$rol] ?? 'N/A'); ?></td>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <?php elseif($tipoVisualizacion === 'grafico'): ?>
                <!-- Vista de Gráfico -->
                <div class="bg-white rounded-xl shadow-lg p-6">
                    <!--[if BLOCK]><![endif]--><?php if($usuarioEvaluadoSeleccionado && isset($graficos['radar'])): ?>
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Promedio por Competencia para <?php echo e($resultados[$usuarioEvaluadoSeleccionado]['nombre']); ?></h3>
                        <div style="width: 100%; max-width: 700px; margin: auto;">
                            <canvas id="radarChart"></canvas>
                        </div>
                        <!--[if BLOCK]><![endif]--><?php if(isset($graficos['barras_roles'])): ?>
                            <h3 class="text-lg font-bold text-gray-800 mt-8 mb-4">Promedio por Rol y Competencia para <?php echo e($resultados[$usuarioEvaluadoSeleccionado]['nombre']); ?></h3>
                            <div style="width: 100%; max-width: 900px; margin: auto;">
                                <canvas id="barrasRolesChart"></canvas>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    <?php elseif($tipoReporte === 'general' && isset($graficos['barras_generales'])): ?>
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Promedio General por Evaluado</h3>
                        <div style="width: 100%; max-width: 900px; margin: auto;">
                            <canvas id="barrasGeneralesChart"></canvas>
                        </div>
                    <?php elseif($tipoReporte === 'por_competencia' && isset($graficos['barras_competencias'])): ?>
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Promedio por Competencia Agrupado por Evaluado</h3>
                        <div style="width: 100%; max-width: 900px; margin: auto;">
                            <canvas id="barrasCompetenciasChart"></canvas>
                        </div>
                    <?php else: ?>
                        <p class="text-center text-gray-500">No hay datos de gráficos disponibles para la selección actual.</p>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    </div>

    <!-- Incluir Chart.js y script para renderizar gráficos -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    <script>
        document.addEventListener('livewire:navigated', () => {
            renderCharts();
        });
        document.addEventListener('livewire:updated', () => {
            renderCharts();
        });

        function renderCharts() {
            const graficos = <?php echo json_encode($graficos, 15, 512) ?>;

            // Destruir gráficos existentes para evitar duplicados
            Chart.getChart('radarChart')?.destroy();
            Chart.getChart('barrasRolesChart')?.destroy();
            Chart.getChart('barrasGeneralesChart')?.destroy();
            Chart.getChart('barrasCompetenciasChart')?.destroy();

            if (graficos.radar) {
                const ctxRadar = document.getElementById('radarChart');
                if (ctxRadar) {
                    new Chart(ctxRadar, {
                        type: 'radar',
                        data: graficos.radar,
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                r: {
                                    angleLines: { display: false },
                                    suggestedMin: 0,
                                    suggestedMax: 5,
                                    ticks: { stepSize: 1 }
                                }
                            },
                            plugins: {
                                legend: { display: true, position: 'top' },
                                title: { display: false }
                            }
                        }
                    });
                }
            }

            if (graficos.barras_roles) {
                const ctxBarrasRoles = document.getElementById('barrasRolesChart');
                if (ctxBarrasRoles) {
                    new Chart(ctxBarrasRoles, {
                        type: 'bar',
                        data: graficos.barras_roles,
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    suggestedMax: 5,
                                    ticks: { stepSize: 1 }
                                }
                            },
                            plugins: {
                                legend: { display: true, position: 'top' },
                                title: { display: false }
                            }
                        }
                    });
                }
            }

            if (graficos.barras_generales) {
                const ctxBarrasGenerales = document.getElementById('barrasGeneralesChart');
                if (ctxBarrasGenerales) {
                    new Chart(ctxBarrasGenerales, {
                        type: 'bar',
                        data: graficos.barras_generales,
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    suggestedMax: 5,
                                    ticks: { stepSize: 1 }
                                }
                            },
                            plugins: {
                                legend: { display: true, position: 'top' },
                                title: { display: false }
                            }
                        }
                    });
                }
            }

            if (graficos.barras_competencias) {
                const ctxBarrasCompetencias = document.getElementById('barrasCompetenciasChart');
                if (ctxBarrasCompetencias) {
                    new Chart(ctxBarrasCompetencias, {
                        type: 'bar',
                        data: graficos.barras_competencias,
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            scales: {
                                x: { stacked: false },
                                y: {
                                    stacked: false,
                                    beginAtZero: true,
                                    suggestedMax: 5,
                                    ticks: { stepSize: 1 }
                                }
                            },
                            plugins: {
                                legend: { display: true, position: 'top' },
                                title: { display: false }
                            }
                        }
                    });
                }
            }
        }
    </script>
</div>

<?php /**PATH D:\laragon\www\encuesta-pro360\resources\views/livewire/encuesta/resultado/reporte-evaluacion.blade.php ENDPATH**/ ?>