<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BeneficiaireController extends Controller
{
    public function store($customer_id, Request $request)
    {
        dd($request->all());
    }
}
