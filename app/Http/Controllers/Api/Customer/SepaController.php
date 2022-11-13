<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Core\Agency;
use App\Models\Customer\CustomerSepa;
use Illuminate\Http\Request;

class SepaController extends Controller
{
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

    }
}
