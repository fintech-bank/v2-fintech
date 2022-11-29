<?php

namespace App\Charts\Customer;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class GaugeChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\DonutChart
    {
        return $this->chart->donutChart()
            ->setTitle('')
            ->setSubtitle('')
            ->addData([20])
            ->setLabels(['']);
    }
}
