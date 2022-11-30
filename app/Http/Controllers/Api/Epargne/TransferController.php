<?php

namespace App\Http\Controllers\Api\Epargne;

use App\Helper\CustomerTransactionHelper;
use App\Helper\DocumentFile;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerEpargne;
use App\Models\Customer\CustomerTransfer;
use App\Notifications\Customer\NewTransferAssocDonNotification;
use App\Notifications\Customer\NotifyTransferAssocNotification;
use App\Scope\CustomerEpargneTrait;
use Illuminate\Http\Request;

class TransferController extends ApiController
{
    public function store($reference, Request $request)
    {
        $epargne = CustomerEpargne::where('reference', $reference)->first();

        if(CustomerEpargneTrait::verifyInfoTransfer($epargne, $request)) {
            return match($request->get('type_transfer')) {
                "courant" => $this->transfCourantVerify($epargne, $request),
                "orga" => $this->transfOrgaVerify($epargne, $request),
                "assoc" => $this->transfAssocVerify($epargne, $request),
            };
        } else {
            return match($request->get('type_transfer')) {
                "courant" => $this->transfCourantUnverify($epargne, $request),
                "orga" => $this->transfOrgaUnverify($request),
                "assoc" => $this->transfAssocUnverify($request),
            };
        }
    }

    public function update($epargne_reference, $transfer_reference, Request $request)
    {
        $transfer = CustomerTransfer::where('reference', $transfer_reference)->first();

        return match ($request->get('action')) {
            "accept" => $this->acceptTransfer($transfer, $request),
            "refuse" => $this->refuseTransfer($transfer, $request),
        };
    }

    private function acceptTransfer(CustomerTransfer $transfer, Request $request)
    {
        if($transfer->amount > $transfer->wallet->balance_actual) {
            return $this->sendWarning("Le montant du transfers ne permet pas sont envoie");
        } else {
            $transfer->update([
                'status' => 'in_transit'
            ]);

            $transaction_ep = CustomerTransactionHelper::createDebit(
                $transfer->wallet->id,
                'virement',
                'Virement ' . $transfer->wallet->name_account_generic,
                'REFERENCE ' . $transfer->reference . ' | ' . $transfer->wallet->epargne->plan->name . ' ~ ' . $transfer->wallet->number_account,
                $transfer->amount,
            );

            CustomerTransactionHelper::createCredit(
                $transfer->wallet->epargne->payment->id,
                'virement',
                'Virement ' . $transfer->wallet->name_account_generic,
                'REFERENCE ' . $transfer->reference . ' | ' . $transfer->wallet->epargne->plan->name . ' ~ ' . $transfer->wallet->number_account,
                $transfer->amount,
            );

            $transfer->update([
                'transaction_id' => $transaction_ep->id
            ]);

            return $this->sendSuccess();
        }
    }
    private function refuseTransfer(CustomerTransfer $transfer, Request $request)
    {
        $transfer->update([
            'status' => 'in_transit'
        ]);

        CustomerTransactionHelper::createDebit(
            $transfer->wallet->id,
            'frais',
            'Frais Bancaire',
            'Rejet virement | REF.'.$transfer->reference.' | '.$transfer->amount_format,
            2.5,
            true,
            now()
        );

        return $this->sendSuccess();
    }

    private function transfCourantVerify(CustomerEpargne $epargne, Request $request)
    {
        $transfer = CustomerTransfer::create([
            'uuid' => \Str::uuid(),
            'amount' => $request->get('amount'),
            'reference' => generateReference(),
            'reason' => 'Virement vers '.$epargne->payment->name_account_generic,
            'type' => $request->get('type'),
            'transfer_date' => $request->get('type') == 'immediat' || $request->get('type') == 'differed' ? $request->get('transfer_date') : null,
            'recurring_start' => $request->get('type') == 'permanent' ? $request->get('recurring_start') : null,
            'recurring_end' => $request->get('type') == 'permanent' ? $request->get('recurring_end') : null,
            'customer_wallet_id' => $request->get('customer_wallet_id'),
            'status' => 'in_transit'
        ]);

        $transaction_ep = CustomerTransactionHelper::createDebit(
            $epargne->wallet->id,
            'virement',
            'Virement ' . $epargne->wallet->name_account_generic,
            'REFERENCE ' . $transfer->reference . ' | ' . $epargne->plan->name . ' ~ ' . $epargne->wallet->number_account,
            $transfer->amount,
        );

        CustomerTransactionHelper::createCredit(
            $epargne->payment->id,
            'virement',
            'Virement ' . $epargne->wallet->name_account_generic,
            'REFERENCE ' . $transfer->reference . ' | ' . $epargne->plan->name . ' ~ ' . $epargne->wallet->number_account,
            $transfer->amount,
        );

        $transfer->update([
            'transaction_id' => $transaction_ep->id
        ]);

        return $this->sendSuccess(null, [$transfer]);
    }
    private function transfCourantUnverify(CustomerEpargne $epargne, Request $request)
    {
        $transfer = CustomerTransfer::create([
            'uuid' => \Str::uuid(),
            'amount' => $request->get('amount'),
            'reference' => generateReference(),
            'reason' => 'Virement vers '.$epargne->payment->name_account_generic,
            'type' => $request->get('type'),
            'transfer_date' => $request->get('type') == 'immediat' || $request->get('type') == 'differed' ? $request->get('transfer_date') : null,
            'recurring_start' => $request->get('type') == 'permanent' ? $request->get('recurring_start') : null,
            'recurring_end' => $request->get('type') == 'permanent' ? $request->get('recurring_end') : null,
            'customer_wallet_id' => $request->get('customer_wallet_id'),
            'customer_beneficiaire_id' => $request->get('customer_beneficiaire_id'),
            'status' => 'pending'
        ]);

        return $this->sendWarning("Certaines vérification sont invalide mais le virement à été enregistré", [$transfer]);
    }

    private function transfOrgaVerify(CustomerEpargne $epargne, Request $request)
    {
        $transfer = CustomerTransfer::create([
            'uuid' => \Str::uuid(),
            'amount' => $request->get('amount'),
            'reference' => generateReference(),
            'reason' => 'Virement vers '.$request->get('name_organisme'),
            'type' => 'immediat',
            'transfer_date' => now()->format('H:i') >= "18:00" ? now()->addDay() : now(),
            'customer_wallet_id' => $request->get('customer_wallet_id'),
            'status' => 'in_transit'
        ]);

        $transaction_ep = CustomerTransactionHelper::createDebit(
            $epargne->wallet->id,
            'virement',
            'Virement vers ' . $request->get('name_organisme'),
            'REFERENCE ' . $transfer->reference . ' | ' . $epargne->plan->name . ' ~ ' . $epargne->wallet->number_account." - IBAN ".$request->get('iban_organisme'),
            $transfer->amount,
        );

        $transfer->update([
            'transaction_id' => $transaction_ep->id
        ]);

        return $this->sendSuccess(null, [$transfer]);
    }
    private function transfOrgaUnverify(Request $request)
    {
        $transfer = CustomerTransfer::create([
            'uuid' => \Str::uuid(),
            'amount' => $request->get('amount'),
            'reference' => generateReference(),
            'reason' => 'Virement vers '.$request->get('name_organisme'),
            'type' => 'immediat',
            'transfer_date' => now()->format("H:i") > "18:00" ? now()->addDay() : now(),
            'customer_wallet_id' => $request->get('customer_wallet_id'),
            'status' => 'pending'
        ]);

        return $this->sendWarning("Certaines vérification sont invalide mais le virement à été enregistré", [$transfer]);
    }

    private function transfAssocVerify(CustomerEpargne $epargne, Request $request)
    {
        $transfer = CustomerTransfer::create([
            'uuid' => \Str::uuid(),
            'amount' => $request->get('amount'),
            'reference' => generateReference(),
            'reason' => 'Virement vers '.$request->get('name_assoc'),
            'type' => 'immediat',
            'transfer_date' => now()->format('H:i') >= "18:00" ? now()->addDay() : now(),
            'customer_wallet_id' => $request->get('customer_wallet_id'),
            'status' => 'in_transit'
        ]);

        $transaction_ep = CustomerTransactionHelper::createDebit(
            $epargne->wallet->id,
            'virement',
            'Virement vers ' . $request->get('name_assoc'),
            'REFERENCE ' . $transfer->reference . ' | ' . $epargne->plan->name . ' ~ ' . $epargne->wallet->number_account." - IBAN ".$request->get('iban_assoc'),
            $transfer->amount,
        );

        $association = [
            'name' => $request->get('name_assoc'),
            'iban' => $request->get('iban_assoc'),
            'email' => $request->get('email_assoc')
        ];

        $doc_formulaire_don = DocumentFile::createDoc(
            $epargne->customer,
            'wallet.formulaire_don',
            $transfer->reference." - Formulaire Don - ".$transfer->id,
            5,
            $epargne->reference,
            false,
            false,
            false,
            true,
            ['transfer' => $transfer, 'association' => $association]
        );

        $transfer->update([
            'transaction_id' => $transaction_ep->id
        ]);

        $docs = [];
        $docs[] = ['url' => $doc_formulaire_don->url_folder];

        $epargne->customer->info->notify(new NewTransferAssocDonNotification($epargne->customer, $transfer, $association, $docs, "Epargne"));
        \Notification::route('mail', $association['email'])
            ->notify(new NotifyTransferAssocNotification($epargne->customer, $transfer, $association, $docs));

        return $this->sendSuccess(null, [$transfer]);
    }
    private function transfAssocUnverify(Request $request)
    {
        $transfer = CustomerTransfer::create([
            'uuid' => \Str::uuid(),
            'amount' => $request->get('amount'),
            'reference' => generateReference(),
            'reason' => 'Virement vers '.$request->get('name_assoc'),
            'type' => 'immediat',
            'transfer_date' => now()->format("H:i") > "18:00" ? now()->addDay() : now(),
            'customer_wallet_id' => $request->get('customer_wallet_id'),
            'status' => 'pending'
        ]);

        return $this->sendWarning("Certaines vérification sont invalide mais le virement à été enregistré", [$transfer]);
    }
}
