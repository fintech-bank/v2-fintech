<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Jobs\Customer\AcceptSepaJob;
use App\Models\Core\Agency;
use App\Models\Customer\CustomerSepa;
use App\Services\Fintech\Payment\Sepa;
use Illuminate\Http\Request;

class SepaController extends Controller
{
    private $sepa;
    public function __construct()
    {
        $this->sepa = new Sepa();
    }

    public function info($customer_id, $number_account, $sepa_uuid)
    {
        $sepa = CustomerSepa::with('creditor', 'wallet')->where('uuid', $sepa_uuid)->first();
        $agency = Agency::find($sepa->wallet->customer->agency->id);

        return response()->json(['sepa' => $sepa, "agency" => $agency]);
    }

    public function update($customer_id, $number_account, $sepa_uuid, Request $request)
    {
        $sepa = CustomerSepa::where('uuid', $sepa_uuid)->first();
        return match ($request->get('action')) {
            "accept" => "",
            "reject" => "",
            "refunded" => "",
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
}
