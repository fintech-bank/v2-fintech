<?php

namespace App\Http\Controllers\Api\User;

use App\Helper\CustomerSepaHelper;
use App\Helper\DocumentFile;
use App\Http\Controllers\Api\ApiController;
use App\Jobs\Customer\Mobility\BankStartJob;
use App\Jobs\Customer\Mobility\CreditorStartJob;
use App\Jobs\Customer\Mobility\TerminatedJob;
use App\Models\Core\MobilityType;
use App\Models\Customer\CustomerMobility;
use App\Models\Customer\CustomerMobilityMvm;
use App\Models\Customer\CustomerTransfer;
use App\Models\Customer\CustomerWallet;
use App\Notifications\Customer\NewMobilityNotification;
use App\Notifications\Customer\UpdateMobilityNotification;
use Carbon\Carbon;
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

    public function update($user_id, $ref_mandate, Request $request)
    {
        $mobility = CustomerMobility::where('ref_mandate', $ref_mandate)->first();

        if($request->get('action') == 'select_mvm_bank') {
            if($request->has('mvm_id')) {
                foreach ($request->get('mvm_id') as  $mvm) {
                    $mouvement = $mobility->mouvements()->find($mvm);

                    match ($mouvement->type_mvm) {
                        "virement" => $this->postVirement($mouvement),
                        "prlv" => $this->postPrlv($mouvement)
                    };

                    $mouvement->update(['valid' => true]);
                }

                $mobility->customer->info->notify(new UpdateMobilityNotification($mobility->customer, $mobility, 'Contact avec votre banque'));
                dispatch(new CreditorStartJob($mobility));

                return $this->sendSuccess("Selection effectuée avec succès");

            }
        } else {
            if($request->has('mvm_id')) {
                foreach ($request->get('mvm_id') as  $mvm) {
                    $mouvement = $mobility->creditors()->find($mvm);

                    if($mouvement->creditor == 'SECU' || $mouvement->creditor == 'CAF') {
                        for ($i=1; $i <= 12; $i++) {
                            CustomerTransfer::create([
                                'uuid' => \Str::uuid(),
                                'amount' => $mouvement->amount,
                                'reference' => $mouvement->reference,
                                'reason' => "Virement {$mouvement->creditor}",
                                'type_transfer' => 'courant',
                                'transfer_date' => $mouvement->date->addMonths($i),
                                'customer_wallet_id' => $mobility->wallet->id,
                            ]);
                        }
                    } else {
                        CustomerSepaHelper::createPrlv(
                            $mouvement->amount,
                            $mobility->wallet,
                            $mouvement->creditor,
                            $mouvement->date
                        );
                    }

                    $mouvement->update(['valid' => true]);
                }

                $mobility->update(['status' => 'creditor_end']);
                $mobility->customer->info->notify(new UpdateMobilityNotification($mobility->customer, $mobility, 'Contact avec votre banque'));
                dispatch(new TerminatedJob($mobility));

                return $this->sendSuccess("Selection effectuée avec succès");

            }
        }
    }

    private function postVirement(CustomerMobilityMvm $mvm)
    {
        $rec_start = $mvm->mobility->date_transfer->addMonth();
        $mvm->mobility->wallet->transfers()->create([
            'uuid' => $mvm->uuid,
            "amount" => $mvm->amount,
            "reference" => $mvm->reference,
            "reason" => "Virement vers ".$mvm->creditor,
            "type_transfer" => 'courant',
            'type' => 'permanent',
            'recurring_start' => $rec_start,
            'recurring_end' => $rec_start->addYear(),
            'customer_wallet_id' => $mvm->mobility->wallet->id
        ]);
    }

    private function postPrlv(CustomerMobilityMvm $mvm)
    {
        CustomerSepaHelper::createPrlv(
            $mvm->amount,
            $mvm->mobility->wallet,
            $mvm->creditor,
            $mvm->date_transfer
        );

    }
}
