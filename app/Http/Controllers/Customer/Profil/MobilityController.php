<?php

namespace App\Http\Controllers\Customer\Profil;

use App\Http\Controllers\Controller;

class MobilityController extends Controller
{
    public function index()
    {
        return view('customer.account.profil.mobility.index');
    }
}
