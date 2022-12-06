<?php

namespace App\Charts\Customer;

use App\Models\Customer\CustomerTransaction;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class WalletExpenseChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($customer_wallet_id): \ArielMejiaDev\LarapexCharts\DonutChart
    {
        $data = collect();
        $depot = CustomerTransaction::where('customer_wallet_id', $customer_wallet_id)
            ->where('type', 'depot')
            ->whereBetween('confirmed_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('amount');

        dd($depot);

        return $this->chart->donutChart()
            ->setTitle('Dépense')
            ->setSubtitle('Depuis le '.now()->startOfMonth()->format('d.m.Y'))
            ->addData([80.30, 89.63, 96.30])
            ->setLabels(['Vie quotidienne', 'Emprunts', 'Loisirs'])
            ->setColors(['#D32F2F', '#03A9F4', '#04D6F9']);
    }
}
