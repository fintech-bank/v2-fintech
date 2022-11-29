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
            ->setTitle('Top 3 scorers of the team.')
            ->setSubtitle('Season 2021.')
            ->setOptions([
                'plotOptions' => [
                    'pie' => [
                        'startAngle' => "-90",
                        'endAngle' => "90",
                        'offsetY' => 10
                    ]
                ]
            ])
            ->addData([20])
            ->setLabels(['Player 7']);
    }
}
