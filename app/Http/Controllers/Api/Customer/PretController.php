<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerPret;
use App\Notifications\Customer\UpdateStatusPretNotification;
use Illuminate\Http\Request;

class PretController extends ApiController
{
    public function update($customer_id, $number_account, $pret_reference, Request $request)
    {
        $pret = CustomerPret::where('reference', $pret_reference)->first();

        return match ($request->get('action')) {
            "state" => $this->updateState($pret, $request->get('state'))
        };
    }

    private function updateState(CustomerPret $pret, $state)
    {
        $pret->update([
            'status' => $state
        ]);

        $pret->customer->info->notify(new UpdateStatusPretNotification($pret->customer, $pret));

        return $this->sendSuccess();
    }
}
