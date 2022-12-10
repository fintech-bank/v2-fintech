<?php

namespace App\Http\Controllers\Agent\Credit;

use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerPret;

class CreditController extends Controller
{
    public function index()
    {
        return view('agent.credit.index', [
            'credits' => CustomerPret::all()
        ]);
    }
}
