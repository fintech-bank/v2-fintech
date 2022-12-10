<?php

namespace App\Http\Controllers\Api\Insurance;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InsuranceController extends ApiController
{
    public function index()
    {

    }

    public function info(Request $request)
    {
        return $this->sendSuccess(null, ["request" => $request->all()]);
    }
}
