<div wire:ignore class="w-full h-96">
    <canvas 
        id="{{ $chartId }}" 
        data-chart-data='@json($data)'
        data-chart-options='@json($options)'
    ></canvas>
</div>

@script
<script>
    let chartInstance = null;

    // Función para inicializar el gráfico
    function initChart() {
        const canvas = document.getElementById('{{ $chartId }}');
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
@endscript