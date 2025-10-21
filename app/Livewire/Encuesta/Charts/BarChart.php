<?php

namespace App\Livewire\Encuesta\Charts;

use Livewire\Component;

class BarChart extends Component
{

    public $chartId;
    public $data;
    public $options;

    public function mount($chartId, $data = [], $options = [])
    {
        $this->chartId = $chartId;
        $this->data = $data;
        $this->options = array_merge([
            'responsive' => true,
            'maintainAspectRatio' => false,
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'max' => 5,
                    'min' => 0,
                    'ticks' => [
                        'stepSize' => 1
                    ]
                ]
            ]
        ], $options);
    }




    public function render()
    {
        return view('livewire.encuesta.charts.bar-chart')->layout('layouts.app');
    }
}
