<?php

namespace App\Http\Controllers\Api\Insurance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InsuranceController extends Controller
{
    public function index()
    {

    }

    public function info(Request $request)
    {
        dd($request->all());
    }
}
