
<div class="bg-white rounded-lg shadow-md border border-gray-200/80 overflow-hidden">
    <div class="space-y-6">
        
        <div>
            <div class="bg-blue-700 px-6 py-3">
                <h2 class="text-base font-bold text-white uppercase tracking-wider">Nombre de la competencia</h2>
            </div>
            <div class="px-6 py-4">
                <p class="text-gray-800 text-lg"><?php echo e($competencia->nombre_competencia); ?></p>
            </div>
        </div>

        
        <div>
            <div class="bg-blue-700 px-6 py-3">
                <h2 class="text-base font-bold text-white uppercase tracking-wider">Definición de competencia</h2>
            </div>
            <div class="px-6 py-4">
                <p class="text-gray-600 leading-relaxed"><?php echo e($competencia->definicion_competencia); ?></p>
            </div>
        </div>

        
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
                        <?php
                        $escalaDeNiveles = [
                        'Excepcional' => 5, 'Supera las Expectativas' => 4, 'Competente' => 3,
                        'En Desarrollo' => 2, 'Requiere Apoyo' => 1
                        ];
                        ?>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $competencia->niveles->sortByDesc(fn($nivel) => $escalaDeNiveles[$nivel->nombre_nivel] ?? 0); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $nivel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-lg font-bold text-blue-600">
                                <?php echo e($escalaDeNiveles[$nivel->nombre_nivel] ?? 'N/A'); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800"><?php echo e($nivel->nombre_nivel); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-600"><?php echo e($nivel->descripcion_nivel); ?></td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div><?php /**PATH D:\laragon\www\encuesta-pro360\resources\views/livewire/encuesta/competencia/competencia-detalle.blade.php ENDPATH**/ ?>