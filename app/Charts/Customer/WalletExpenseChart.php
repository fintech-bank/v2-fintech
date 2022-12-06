<?php

namespace App\Charts\Customer;

use ArielMejiaDev\LarapexCharts\LarapexChart;

class WalletExpenseChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\RadialChart
    {
        return $this->chart->radialChart()
            ->setTitle('Dépense')
            ->setSubtitle('Depuis le '.now()->startOfMonth()->format('d.m.Y'))
            ->addData([-80.30, -89.63, -96.30])
            ->setLabels(['Vie quotidienne', 'Emprunts', 'Loisirs'])
            ->setColors(['#D32F2F', '#03A9F4', '#04D6F9']);
    }
}
