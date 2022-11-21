<?php

namespace App\Http\Controllers\Api\Loan;

use App\Helper\CustomerLoanHelper;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerPret;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoanController extends ApiController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function list($limit = 10, $start = null, $end = null)
    {
        $data = collect([
            'limit' => $limit,
            'start' => $start == null ? now()->startOfYear() : $start,
            'end' => $end == null ? now()->endOfYear() : $end,
        ])->first();

        $call = CustomerPret::whereBetween('created_at', [$data->start, $data->end])->limit($data->limit)->get();

        return $this->sendSuccess(null, [$call]);
    }
}
