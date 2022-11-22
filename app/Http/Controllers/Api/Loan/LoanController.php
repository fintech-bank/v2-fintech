<?php

namespace App\Http\Controllers\Api\Loan;

use App\Helper\CustomerLoanHelper;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerPret;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoanController extends ApiController
{
    /**
     * @param int $limit
     * @param Carbon|null $start
     * @param Carbon|null $end
     * @return JsonResponse
     */
    public function list(int $limit = 10,Carbon $start = null, Carbon $end = null)
    {
        $data = collect([
            'limit' => $limit,
            'start' => $start == null ? now()->startOfYear() : $start,
            'end' => $end == null ? now()->endOfYear() : $end,
        ])->toArray();

        $call = CustomerPret::with('plan', 'customer', 'wallet', 'payment', 'card', 'facelia', 'insurance', 'cautions')
            ->whereBetween('created_at', [$data['start'], $data['end']])
            ->limit($data['limit'])
            ->get();

        return $this->sendSuccess(null, [$call]);
    }

    public function retrieve($loan_reference)
    {
        try {
            $call = CustomerPret::with('plan', 'customer', 'wallet', 'payment', 'card', 'facelia', 'insurance', 'cautions')
                ->where('reference', $loan_reference)
                ->first();

            return $this->sendSuccess(null, [$call]);
        }catch (\Exception $exception) {
            return $this->sendError($exception);
        }
    }

    public function update($loan_reference, Request $request)
    {
        $credit = CustomerPret::where('reference', $loan_reference)->first();

        return match ($request->get('action')) {
            "up_prlv_date" =>
                CustomerLoanHelper::update($credit, ["prlv_day" => $request->get('prlv_day')]) ? $this->sendSuccess() : $this->sendError(),
        };
    }
}
