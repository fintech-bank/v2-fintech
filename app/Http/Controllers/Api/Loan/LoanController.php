<?php

namespace App\Http\Controllers\Api\Loan;

use App\Helper\CustomerLoanHelper;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerPret;
use Illuminate\Http\Request;

class LoanController extends ApiController
{
    public function list(Request $request)
    {
        $data = collect([
            'limit' => $request->get('limit'),
            'start' => $request->get('start'),
            'end' => $request->get('end')
        ])->first();

        $call = CustomerPret::whereBetween('created_at', [$data->start, $data->end])->limit($data->limit)->get();

        return $this->sendSuccess(null, [$call]);
    }
}
