<?php

namespace App\Http\Controllers\Api\User;

use App\Helper\DocumentFile;
use App\Http\Controllers\Api\ApiController;
use App\Jobs\Customer\Mobility\BankStartJob;
use App\Models\Core\MobilityType;
use App\Models\Customer\CustomerMobility;
use App\Models\Customer\CustomerWallet;
use App\Notifications\Customer\NewMobilityNotification;
use Illuminate\Http\Request;
use Intervention\Validation\Rules\Bic;
use Intervention\Validation\Rules\Iban;

class MobilityController extends ApiController
{
    public function store($user_id, Request $request)
    {
        $typeMob = MobilityType::find($request->get('mobility_type_id'));

        $validator = \Validator::make($request->all(), [
            'iban' => new Iban(),
            'bic' => new Bic()
        ]);

        if($validator->fails()) {
            return $this->sendWarning("Certains Champs sont invalide", [$validator]);
        }

        $mobility = CustomerMobility::create([
            'name_mandate' => $request->get('name_mandate'),
            'ref_mandate' => "MDT-TRS-".now()->format('Ymd')."-".generateReference(),
            'name_account' => $request->get('name_account'),
            'iban' => $request->get('iban'),
            'bic' => $request->get('bic'),
            'address' => $request->get('address'),
            'addressbis' => $request->get('addressbis'),
            'postal' => $request->get('postal'),
            'ville' => $request->get('ville'),
            'country' => $request->get('country'),
            'date_transfer' => $request->get('date_transfer'),
            'customer_wallet_id' => $request->get('customer_wallet_id'),
            'customer_id' => $request->get('customer_id'),
            'cloture' => false,
            'mobility_type_id' => $typeMob->id
        ]);

        $wallet = CustomerWallet::find($request->get('customer_wallet_id'));

        if($typeMob->cloture) {
            $mobility->update(['cloture' => $request->has('cloture')]);
        }

        $document = DocumentFile::createDoc(
            $wallet->customer,
            'general.mandate_mobility',
            $mobility->ref_mandate." - Mandat Mobilité Bancaire",
            2,
            $mobility->ref_mandate,
            true,
            true,
            true,
            true,
            ["mobility" => $mobility],
        );

        dispatch(new BankStartJob($mobility))->delay(now()->addMinutes(rand(1,5)));
        $mobility->wallet->customer->info->notify(new NewMobilityNotification($mobility->customer, $mobility, "Contact avec ma banque"));

        return $this->sendSuccess("Mandat de mobilité bancaire créer avec succès", [$mobility]);

    }
}
