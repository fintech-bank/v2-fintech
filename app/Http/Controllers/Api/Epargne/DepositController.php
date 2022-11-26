<?php

namespace App\Http\Controllers\Api\Epargne;

use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerEpargne;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    public function store($reference_epargne, Request $request)
    {
        dd($request->all());
        $epargne = CustomerEpargne::where('reference', $reference_epargne)->first();

    }
}
