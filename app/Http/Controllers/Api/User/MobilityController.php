<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;

class MobilityController extends ApiController
{
    public function store($user_id, Request $request)
    {
        dd($request->all());
    }
}
