<div>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-white py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">

            <!-- 1. Cabecera: Título y Botón Manual de Usuario -->
            <header class="mb-8">
                <div class="flex justify-between items-center bg-white p-6 rounded-xl shadow-md">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">Listado de Empresas</h1>
                        <p class="mt-1 text-sm text-gray-500">Busca, filtra y gestiona las empresas registradas.</p>
                    </div>
                    <a href="#" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-semibold text-sm rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z"></path>
                        </svg>
                        Manual de Usuario
                    </a>
                </div>
            </header>

            <!-- 2. Barra de Filtros, Búsqueda y Acciones -->
            <div class="mb-6 flex flex-col sm:flex-row items-center gap-4">

                
                <div class="relative flex-grow w-full sm:w-auto">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="search" id="busqueda" wire:model.live.debounce.300ms="busqueda" placeholder="Buscar por nombre, razón social o RFC..." class="w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>

                
                <div class="flex items-center gap-4 w-full sm:w-auto">

                    
                    <select id="filtroSector" wire:model.live="filtroSector" class="w-full sm:w-48 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Todos los Sectores</option>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $sectores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sector): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($sector); ?>"><?php echo e($sector); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </select>

                    
                    <select id="filtroEstado" wire:model.live="filtroEstado" class="w-full sm:w-48 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Todos los Estados</option>
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $estados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($estado); ?>"><?php echo e($estado); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </select>
                </div>
            </div>
        </div>

        <!-- 3. Tabla de Empresas (Diseño con Columnas Separadas + País) -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            
                            <th scope="col" wire:click="ordenar('nombre_comercial')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                Nombre Comercial
                                <!--[if BLOCK]><![endif]--><?php if($ordenarPor === 'nombre_comercial'): ?> <span><?php echo e($direccionOrden === 'asc' ? '▲' : '▼'); ?></span> <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </th>

                            
                            <th scope="col" wire:click="ordenar('rfc')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                RFC
                                <!--[if BLOCK]><![endif]--><?php if($ordenarPor === 'rfc'): ?> <span><?php echo e($direccionOrden === 'asc' ? '▲' : '▼'); ?></span> <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </th>

                            
                            <th scope="col" wire:click="ordenar('sector')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                Sector
                                <!--[if BLOCK]><![endif]--><?php if($ordenarPor === 'sector'): ?> <span><?php echo e($direccionOrden === 'asc' ? '▲' : '▼'); ?></span> <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </th>

                            
                            <th scope="col" wire:click="ordenar('pais')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                País
                                <!--[if BLOCK]><![endif]--><?php if($ordenarPor === 'pais'): ?> <span><?php echo e($direccionOrden === 'asc' ? '▲' : '▼'); ?></span> <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </th>

                            
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ubicación
                            </th>

                            
                            <th scope="col" wire:click="ordenar('fecha_registro')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                Fecha de Registro
                                <!--[if BLOCK]><![endif]--><?php if($ordenarPor === 'fecha_registro'): ?> <span><?php echo e($direccionOrden === 'asc' ? '▲' : '▼'); ?></span> <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </th>

                            
                            <th scope="col" wire:click="ordenar('estado_inicial')" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer">
                                Estado
                                <!--[if BLOCK]><![endif]--><?php if($ordenarPor === 'estado_inicial'): ?> <span><?php echo e($direccionOrden === 'asc' ? '▲' : '▼'); ?></span> <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </th>

                            
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Acciones</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $empresas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empresa): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr wire:key="<?php echo e($empresa->id_empresa); ?>" class="hover:bg-gray-50 transition-colors duration-150">

                            
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <!--[if BLOCK]><![endif]--><?php if($empresa->logo): ?>
                                    
                                    <div class="h-12 w-12 rounded-lg bg-white border border-gray-200 flex items-center justify-center p-1.5 flex-shrink-0 shadow-sm">
                                        <img
                                            src="<?php echo e(asset('storage/' . $empresa->logo)); ?>"
                                            alt="Logo de <?php echo e($empresa->nombre_comercial); ?>"
                                            class="max-h-full max-w-full object-contain">
                                    </div>
                                    <?php else: ?>
                                    
                                    <span class="h-12 w-12 rounded-lg bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center text-gray-600 font-bold flex-shrink-0 text-sm border border-gray-200">
                                        <?php echo e(strtoupper(substr($empresa->nombre_comercial, 0, 2))); ?>

                                    </span>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            <?php echo e($empresa->nombre_comercial); ?>

                                        </div>
                                    </div>
                                </div>
                            </td>


                            
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">
                                <?php echo e($empresa->rfc); ?>

                            </td>

                            
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e($empresa->sector); ?>

                            </td>

                            
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e($empresa->pais); ?>

                            </td>

                            
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e($empresa->municipio ?? $empresa->ciudad); ?>, <?php echo e($empresa->estado); ?>

                            </td>

                            
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e($empresa->fecha_registro->format('d/m/Y')); ?>

                            </td>

                            
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            <?php if($empresa->estado_inicial == 'Activo'): ?> bg-green-100 text-green-800 <?php endif; ?>
                            <?php if($empresa->estado_inicial == 'Inactivo'): ?> bg-red-100 text-red-800 <?php endif; ?>
                            <?php if($empresa->estado_inicial == 'En Proceso'): ?> bg-yellow-100 text-yellow-800 <?php endif; ?>
                            <?php if($empresa->estado_inicial == 'Suspendido'): ?> bg-gray-100 text-gray-800 <?php endif; ?>
                        ">
                                    <?php echo e($empresa->estado_inicial); ?>

                                </span>
                            </td>

                            
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="<?php echo e(route('ver-empresa', $empresa)); ?>" wire:navigate class="text-blue-600 hover:text-blue-900">Ver</a>
                                <a href="<?php echo e(route('editar-empresa', $empresa)); ?>" wire:navigate class="ml-4 text-indigo-600 hover:text-indigo-900">Editar</a>
                                <button
                                    x-data
                                    @click="$dispatch('confirm-delete', { id: <?php echo e($empresa->id_empresa); ?> })"
                                    class="ml-4 text-red-600 hover:text-red-900 font-medium">
                                    Eliminar
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            
                            <td colspan="8" class="px-6 py-12 text-center">
                                <div class="text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No se encontraron empresas</h3>
                                    <p class="mt-1 text-sm text-gray-500">Intenta ajustar tu búsqueda o filtros.</p>
                                </div>
                            </td>
                        </tr>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </tbody>
                </table>
            </div>
        </div>
        <!-- 4. Acciones Post-Tabla y Paginación -->
        <div class="mt-6 flex flex-col sm:flex-row justify-between items-center gap-4">

            
            <div class="flex items-center gap-3">
                <span class="text-sm font-medium text-gray-600">Exportar vista actual:</span>
                
                
                <button
                    wire:click="exportarZip"
                    wire:loading.attr="disabled"
                    wire:target="exportarZip"
                    title="Descargar todo en un archivo ZIP"
                    class="inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white font-semibold text-sm rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 ease-in-out transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">

                    <i class="fas fa-file-archive mr-2"></i>
                    <span wire:loading.remove wire:target="exportarZip">Descargar Todo (.zip)</span>
                    <span wire:loading wire:target="exportarZip">Generando...</span>
                </button>
                
                
                <button
                    wire:click="exportarExcel"
                    wire:loading.attr="disabled"
                    wire:target="exportarExcel"
                    title="Exportar a Excel"
                    class="inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white font-semibold text-sm rounded-lg shadow-sm hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 ease-in-out transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">

                    <i class="fas fa-file-excel mr-2"></i>
                    <span wire:loading.remove wire:target="exportarExcel">Exportar Excel</span>
                    <span wire:loading wire:target="exportarExcel">Exportando...</span>
                </button>

                
                <button
                    wire:click="exportarPdf"
                    wire:loading.attr="disabled"
                    wire:target="exportarPdf"
                    title="Exportar a PDF"
                    class="inline-flex items-center justify-center px-4 py-2 bg-red-600 text-white font-semibold text-sm rounded-lg shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200 ease-in-out transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed">

                    <i class="fas fa-file-pdf mr-2"></i>
                    <span wire:loading.remove wire:target="exportarPdf">Exportar PDF</span>
                    <span wire:loading wire:target="exportarPdf">Exportando...</span>
                </button>
            </div>

            
            <div class="w-full sm:w-auto">
                <?php echo e($empresas->links()); ?>

            </div>
        </div>

    </div>
</div>






<?php $__env->startPush('scripts'); ?>
<script>
    // Nos aseguramos de que este script se ejecute después de que Livewire se haya inicializado.
    document.addEventListener('livewire:init', () => {

        // Listener para el modal de confirmación de eliminación
        Livewire.on('show-swal-delete', (event) => {
            const data = event[0];
            Swal.fire({
                title: data.title,
                text: data.text,
                icon: data.icon,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, ¡eliminar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Si se confirma, despachamos el evento final que el backend escuchará.
                    Livewire.dispatch('delete-confirmed', {
                        id: data.id
                    });
                }
            });
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const img = document.getElementById('preview-logo');
        const colorContainer = document.getElementById('color-preview');

        if (img && colorContainer) {
            img.addEventListener('load', () => {
                const colorThief = new ColorThief();
                const palette = colorThief.getPalette(img, 5); // Extrae 5 colores

                palette.forEach(color => {
                    const colorBox = document.createElement('div');
                    colorBox.style.width = '30px';
                    colorBox.style.height = '30px';
                    colorBox.style.borderRadius = '50%';
                    colorBox.style.backgroundColor = `rgb(${color[0]}, ${color[1]}, ${color[2]})`;
                    colorBox.title = `rgb(${color[0]}, ${color[1]}, ${color[2]})`;
                    colorContainer.appendChild(colorBox);
                });
            });
        }
    });
</script>
<?php $__env->stopPush(); ?><?php /**PATH D:\laragon\www\encuesta-pro360\resources\views/livewire/encuesta/mostrar-empresa.blade.php ENDPATH**/ ?>