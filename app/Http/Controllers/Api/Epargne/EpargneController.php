<?php

namespace App\Http\Controllers\Api\Epargne;

use App\Http\Controllers\Api\ApiController;
use App\Models\Customer\CustomerEpargne;
use Carbon\Carbon;

class EpargneController extends ApiController
{
    /**
     * @param int $limit
     * @param Carbon|null $start
     * @param Carbon|null $end
     * @return void
     */
    public function list(int $limit = 10, Carbon $start = null, Carbon $end = null)
    {
        $call = CustomerEpargne::with('plan', 'wallet', 'payment');
        $start != null ? $call->whereBetween('start', [$start, $end]) : $call;
        $call->limit($limit)->get();
    }
}
