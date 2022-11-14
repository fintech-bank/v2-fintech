<?php

namespace App\Http\Controllers\Api\Customer;

use App\Helper\CustomerTransactionHelper;
use App\Http\Controllers\Controller;
use App\Jobs\Customer\AcceptSepaJob;
use App\Jobs\Customer\RefundSepaJob;
use App\Models\Core\Agency;
use App\Models\Customer\CustomerSepa;
use App\Notifications\Customer\RejectSepaNotification;
use App\Services\Fintech\Payment\Sepa;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SepaController extends Controller
{
    private $sepa;
    public function __construct()
    {
        $this->sepa = new Sepa();
    }

    public function info($customer_id, $number_account, $sepa_uuid)
    {
        $sepa = CustomerSepa::with('creditors', 'wallet')->where('uuid', $sepa_uuid)->first();
        $agency = Agency::find($sepa->wallet->customer->agency->id);

        return response()->json(['sepa' => $sepa, "agency" => $agency]);
    }

    public function update($customer_id, $number_account, $sepa_uuid, Request $request)
    {
        $sepa = CustomerSepa::where('uuid', $sepa_uuid)->first();
        return match ($request->get('action')) {
            "accept" => $this->acceptSepa($sepa),
            "reject" => $this->rejectSepa($sepa),
            "refunded" => $this->rembSepa($sepa),
        };
    }

    private function acceptSepa(CustomerSepa $sepa)
    {
        $call = $this->sepa->acceptSepa();

        if($call == 1) {
            dispatch(new AcceptSepaJob($sepa))->delay(now()->addMinutes(rand(2,5)));
            return response()->json();
        } else {
            return response()->json(null, 522);
        }
    }

    private function rejectSepa(CustomerSepa $sepa)
    {
        $sepa->update([
            'status' => 'rejected'
        ]);

        $sepa->wallet->customer->info->notify(new RejectSepaNotification($sepa->wallet->customer, $sepa));

        return response()->json();
    }

    private function rembSepa(CustomerSepa $sepa)
    {
        $call = $this->sepa->rembSepaRequest($sepa);
        if($call) {
            dispatch(new RefundSepaJob($sepa))->delay(now()->addMinutes(rand(2,5)));
            return response()->json();
        } else {
            return response()->json(null, 522);
        }
    }
}
