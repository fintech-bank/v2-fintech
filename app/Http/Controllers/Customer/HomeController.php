<?php

namespace App\Http\Controllers\Customer;

use App\Charts\Customer\GaugeChart;
use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;

class HomeController extends Controller
{
    public function __invoke(GaugeChart $chart)
    {
        return view('customer.dashboard', [
            'customer' => Customer::find(auth()->user()->customers->id),
            'gauge' => $chart->build()
        ]);
    }
}
