<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerCheck;
use App\Models\Customer\CustomerWallet;
use App\Notifications\Customer\NewCheckoutCheckNotification;
use App\Notifications\Customer\UpdateCheckoutCheckNotification;
use Illuminate\Http\Request;

class CheckController extends ApiController
{
    public function store($customer_id, $number_account, Request $request)
    {
        $wallet = CustomerWallet::where('number_account', $number_account)->first();

        if(!$wallet->customer->fcc) {
            $start = random_numeric(7);
            $check = $wallet->checks()->create([
                'reference' => generateReference(),
                'tranche_start' => $start,
                'tranche_end' => $start += 40,
                'customer_wallet_id' => $wallet->id
            ]);

            $wallet->customer->info->notify(new NewCheckoutCheckNotification($wallet->customer, $check, "Comptes & Moyens de paiement"));

            return $this->sendSuccess();
        } else {
            return $this->sendDanger("Vous êtes actuellement enregistré dans le fichier des incident de chèque", null, 203);
        }
    }

    public function update($customer_id, $number_account, $check_id, Request $request)
    {
        $check = CustomerCheck::find($check_id);

        return match ($request->get('action')) {
            "with" => $this->customerWithCheck($check)
        };
    }

    private function customerWithCheck(CustomerCheck $check)
    {
        $check->update([
            'status' => 'outstanding'
        ]);

        $check->wallet->customer->info->notify(new UpdateCheckoutCheckNotification($check->wallet->customer, $check));
        return $this->sendSuccess();
    }
}
