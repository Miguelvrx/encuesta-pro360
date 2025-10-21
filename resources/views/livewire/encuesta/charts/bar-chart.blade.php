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

    function initChart() {
        const canvas = document.getElementById('{{ $chartId }}');
        if (!canvas) return;

        const chartData = JSON.parse(canvas.getAttribute('data-chart-data'));
        const chartOptions = JSON.parse(canvas.getAttribute('data-chart-options'));

        if (chartInstance) {
            chartInstance.destroy();
        }

        chartInstance = new Chart(canvas, {
            type: 'bar',
            data: chartData,
            options: chartOptions
        });
    }

    $wire.on('rendered', () => {
        setTimeout(initChart, 100);
    });

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initChart);
    } else {
        initChart();
    }

    $wire.on('chart-updated', () => {
        setTimeout(initChart, 100);
    });
</script>
@endscript