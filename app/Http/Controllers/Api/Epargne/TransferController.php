<?php

namespace App\Http\Controllers\Api\Epargne;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function store($reference, Request $request)
    {
        dd($request->all());
    }
}
