<?php

namespace App\Http\Controllers\Agent\Customer;

use App\Helper\CustomerHelper;
use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('agent.customer.index', [
            "customers" => Customer::all()
        ]);
    }

    public function start()
    {
        return view('agent.customer.create.start');
    }

    public function finish()
    {
        $session = (object) session()->all();
        $customer = CustomerHelper::createCustomer($session);

        return view('agent.customer.create.finish', compact('customer'));
    }
}
