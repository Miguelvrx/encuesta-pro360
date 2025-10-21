<div wire:ignore class="w-full h-96">
    <canvas 
        id="<?php echo e($chartId); ?>" 
        data-chart-data='<?php echo json_encode($data, 15, 512) ?>'
        data-chart-options='<?php echo json_encode($options, 15, 512) ?>'
    ></canvas>
</div>

    <?php
        $__scriptKey = '920764237-0';
        ob_start();
    ?>
<script>
    let chartInstance = null;

    // Función para inicializar el gráfico
    function initChart() {
        const canvas = document.getElementById('<?php echo e($chartId); ?>');
        if (!canvas) return;

        const chartData = JSON.parse(canvas.getAttribute('data-chart-data'));
        const chartOptions = JSON.parse(canvas.getAttribute('data-chart-options'));

        // Destruir gráfico anterior si existe
        if (chartInstance) {
            chartInstance.destroy();
        }

        // Crear nuevo gráfico
        chartInstance = new Chart(canvas, {
            type: 'radar',
            data: chartData,
            options: chartOptions
        });
    }

    // Inicializar cuando el componente se monta
    $wire.on('rendered', () => {
        setTimeout(initChart, 100);
    });

    // También inicializar cuando el DOM esté listo
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initChart);
    } else {
        initChart();
    }

    // Escuchar eventos de Livewire para actualizaciones
    $wire.on('chart-updated', () => {
        setTimeout(initChart, 100);
    });
</script>
    <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?><?php /**PATH D:\laragon\www\encuesta-pro360\resources\views/livewire/encuesta/charts/radar-chart.blade.php ENDPATH**/ ?>