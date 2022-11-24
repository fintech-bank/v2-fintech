<?php

namespace App\Http\Controllers\Api\Transaction;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function search(Request $request)
    {
        dd($request->all());
    }
}
