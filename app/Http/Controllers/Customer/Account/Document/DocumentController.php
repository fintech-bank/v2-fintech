<?php

namespace App\Http\Controllers\Customer\Account\Document;

use App\Http\Controllers\Controller;

class DocumentController extends Controller
{
    public function index()
    {
        return view('customer.account.document.index', [
            'customer' => auth()->user()->customers
        ]);
    }
}
