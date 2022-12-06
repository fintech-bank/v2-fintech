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

        $retrait = CustomerTransaction::where('customer_wallet_id', $customer_wallet_id)
            ->where('type', 'retrait')
            ->whereBetween('confirmed_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('amount');

        $payment = CustomerTransaction::where('customer_wallet_id', $customer_wallet_id)
            ->where('type', 'payment')
            ->whereBetween('confirmed_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('amount');

        $virement = CustomerTransaction::where('customer_wallet_id', $customer_wallet_id)
            ->where('type', 'virement')
            ->whereBetween('confirmed_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('amount');

        $sepa = CustomerTransaction::where('customer_wallet_id', $customer_wallet_id)
            ->where('type', 'sepa')
            ->whereBetween('confirmed_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('amount');

        $frais = CustomerTransaction::where('customer_wallet_id', $customer_wallet_id)
            ->where('type', 'frais')
            ->whereBetween('confirmed_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('amount');

        $souscription = CustomerTransaction::where('customer_wallet_id', $customer_wallet_id)
            ->where('type', 'souscription')
            ->whereBetween('confirmed_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('amount');

        $autre = CustomerTransaction::where('customer_wallet_id', $customer_wallet_id)
            ->where('type', 'autre')
            ->whereBetween('confirmed_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('amount');

        $credit = CustomerTransaction::where('customer_wallet_id', $customer_wallet_id)
            ->where('type', 'facelia')
            ->whereBetween('confirmed_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('amount');



        return $this->chart->donutChart()
            ->setTitle('Dépense')
            ->setSubtitle('Depuis le '.now()->startOfMonth()->format('d.m.Y'))
            ->addData([$retrait, $payment, $virement, $sepa, $frais, $souscription, $autre, $credit])
            ->setLabels(['Retrait bancaire', 'CB, Paiement, Loisir', 'Virement Bancaire', 'Prélèvement', 'Frais Bancaire', 'Souscription', 'Autre', 'Emprunts, Crédit'])
            ->setColors(['#E57373', '#F06292', '#BA68C8', '#9575CD', '#7986CB', '#64B5F6', '#4DB6AC', '#FFD54F']);
    }
}
