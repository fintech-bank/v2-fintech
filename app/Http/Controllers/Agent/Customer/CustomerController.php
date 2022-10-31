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
        session()->put('finish', true);
        $session = (object) session()->all();
        $help = new CustomerHelper();

        if(!$session->finish) {
            $customer = $help->createCustomer($session);
            session()->flush();
            session()->put('customer_id', $customer->id);
        } else {
            $customer = Customer::find(session()->get('customer_id'));
        }

        return view('agent.customer.create.finish', compact('customer'));
    }
}
