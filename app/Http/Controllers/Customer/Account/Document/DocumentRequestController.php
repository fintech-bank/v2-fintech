<?php

namespace App\Http\Controllers\Customer\Account\Document;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerRequest;

class DocumentRequestController extends Controller
{
    public function index()
    {
        $customer = Customer::find(auth()->user()->customers->id);
        return view('customer.account.document.request.index', [
            'requests' => $customer->requests()
        ]);
    }

    public function show($request_reference)
    {
        $request = CustomerRequest::where('reference', $request_reference)->first();

        return view('customer.account.document.request.show', [
            'request' => $request
        ]);
    }
}
