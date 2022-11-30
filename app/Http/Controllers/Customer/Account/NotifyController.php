<?php

namespace App\Http\Controllers\Customer\Account;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;

class NotifyController extends Controller
{
    public function index()
    {
        return view('customer.account.notify.index', [
            'notifications' => Customer::find(auth()->user()->customers->id)->info->notifications
        ]);
    }
}
