<div
    x-data="{ show: <?php if ((object) ('mostrarModal') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('mostrarModal'->value()); ?>')<?php echo e('mostrarModal'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('mostrarModal'); ?>')<?php endif; ?> }"
    x-show="show"
    x-on:keydown.escape.window="show = false"
    x-transition:enter="ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75"
    style="display: none;" >
    <!-- Contenedor del Modal -->
    <div
        @click.away="show = false"
        x-show="show"       
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        class="bg-white rounded-xl shadow-3xl w-full max-w-3xl mx-4">
        <!-- Cabecera del Modal -->
        <div class="flex items-center justify-between p-5 border-b border-gray-200">
            <div class="flex items-center">
                <div class="flex-shrink-0 bg-blue-100 text-blue-600 rounded-full p-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253z"></path>
                    </svg>
                </div>
                <h3 class="ml-4 text-xl font-semibold text-gray-800" id="modal-title"><?php echo e($titulo); ?></h3>
            </div>
            <button wire:click="cerrarModal" class="text-gray-400 hover:text-gray-600">
                <span class="sr-only">Cerrar</span>
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Contenido del Modal -->
        <div class="p-6 prose max-w-none">
            <?php echo $contenido; ?>

        </div>

        <!-- Pie del Modal -->
        <div class="bg-gray-50 px-6 py-4 text-right rounded-b-xl">
            <button wire:click="cerrarModal" type="button" class="px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Entendido
            </button>
        </div>
    </div>
</div><?php /**PATH D:\laragon\www\encuesta-pro360\resources\views/livewire/encuesta/departamento/manual-usuario-dep-modal.blade.php ENDPATH**/ ?>