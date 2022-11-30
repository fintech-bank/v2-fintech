<?php

namespace App\Http\Controllers\Customer\Account;

use App\Http\Controllers\Controller;

class AgendaController extends Controller
{
    public function index()
    {
        return view('customer.account.agenda.index');
    }
}
