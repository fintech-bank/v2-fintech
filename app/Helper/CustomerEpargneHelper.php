<?php

namespace App\Helper;

use App\Models\Customer\Customer;
use App\Models\Customer\CustomerEpargne;
use App\Notifications\Customer\NewEpargneNotification;
use App\Notifications\Customer\SendRequestNotification;

class CustomerEpargneHelper
{
    public static function calcInterest($duration, $montant_actuel, $percent)
    {
        $first = $montant_actuel * $percent / 100;

        return $first / $duration;
    }

    public static function create(Customer $customer, $initial_payment, $monthly_payment, $monthly_days, $wallet_payment_id, $plan_id)
    {
        // Création du compte
        $wallet = CustomerWalletHelper::createWallet(
            $customer,
            'epargne',
            0,
            0,
            0,
            0,
            'active',
        );

        // Création de l'épargne
        $epargne = CustomerEpargne::create([
            'uuid' => \Str::uuid(),
            "reference" => generateReference(),
            "initial_payment" => $initial_payment,
            "monthly_payment" => $monthly_payment,
            "monthly_days" => $monthly_days,
            "wallet_id" => $wallet->id,
            "wallet_payment_id" => $wallet_payment_id,
            "epargne_plan_id" => $plan_id
        ]);

        $wallet_payment = $customer->wallets()->find($wallet_payment_id);

        $customer->beneficiaires->createBenef(
            $customer->info->type == 'part' ? 'retail' : 'corporate',
            $customer->agency->name,
            $wallet_payment->iban,
            $customer->agency->bic,
            $customer->info->type != 'part' ? $customer->info->full_name : '',
            $customer->info->type == 'part' ? $customer->info->civility : '',
            $customer->info->type == 'part' ? $customer->info->firstname : '',
            $customer->info->type == 'part' ? $customer->info->lastname : '',
            1
        );

        $doc_epargne = DocumentFile::createDoc(
            $customer,
            'wallet.contrat_epargne',
            "Contrat d'epargne",
            3,
            $epargne->reference,
            true,
            true,
            false,
            true,
            ["epargne" => $epargne, "wallet" => $wallet]
        );

        CustomerTransactionHelper::create(
            'debit',
            'virement',
            'Virement Compte Epargne '.$wallet->number_account,
            -$initial_payment,
            $wallet_payment_id,
            true,
            "REFERENCE " . $epargne->reference . " | Livret " . $wallet->epargne->plan->name . " ~ " . $wallet->number_account,
            now()
        );

        CustomerTransactionHelper::create(
            'credit',
            'virement',
            'Virement Compte Epargne '.$wallet->number_account,
            $initial_payment,
            $wallet->id,
            true,
            "REFERENCE " . $epargne->reference . " | Livret " . $wallet->epargne->plan->name . " ~ " . $wallet->number_account,
            now(),
        );

        $request = $customer->requests()->create([
            "reference" => generateReference(),
            "sujet" => "Signature d'un document",
            "commentaire" => "<p>Veuillez effectuer la signature du document suivant : ".$doc_epargne->name."</p><br><a href='".route('signate.show', base64_encode($doc_epargne->id))."' class='btn btn-circle btn-primary'>Signer le document</a>",
            "link_model" => CustomerEpargne::class,
            "link_id" => $epargne->id,
            "customer_id" => $customer->id
        ]);

        $customer->info->notify(new SendRequestNotification($customer, $request));
        $customer->info->notify(new NewEpargneNotification($customer, $wallet));

        return $epargne;
    }
}
