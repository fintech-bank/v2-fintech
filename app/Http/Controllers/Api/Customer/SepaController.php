<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerSepa;
use Illuminate\Http\Request;

class SepaController extends Controller
{
    public function info($customer_id, $number_account, $sepa_uuid)
    {
        $sepa = CustomerSepa::with('creditor', 'wallet')->where('uuid', $sepa_uuid)->first();

        return response()->json($sepa);
    }
}
