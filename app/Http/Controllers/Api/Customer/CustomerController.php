<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function subscribe(Request $request)
    {
        switch ($request->get('action')) {
            case 'alerta':
                $this->subscribeAlerta();
                break;
            case 'daily_insurance':
                $this->subscribeDailyInsurance();
                break;
        }
    }

    private function subscribeAlerta()
    {
        session()->put('subscribe.alerta', true);
    }

    private function subscribeDailyInsurance()
    {
        session()->put('subscribe.daily_insurance', true);
    }
}
