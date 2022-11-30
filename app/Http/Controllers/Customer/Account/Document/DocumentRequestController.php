<?php

namespace App\Http\Controllers\Customer\Account\Document;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;

class DocumentRequestController extends Controller
{
    public function index()
    {
        $customer = Customer::find(auth()->user()->customers->id);
        return view('customer.account.document.request.index', [
            'requests' => $customer->requests()
        ]);
    }
}
