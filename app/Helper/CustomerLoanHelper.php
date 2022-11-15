<?php

namespace App\Helper;

use App\Models\Core\LoanPlan;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerFacelia;
use App\Models\Customer\CustomerPret;
use App\Models\Customer\CustomerSepa;
use App\Models\Customer\CustomerWallet;
use App\Notifications\Customer\Customer\Agent\Customer\CreatePretNotification;
use App\Notifications\Customer\NewPretNotification;
use Carbon\Carbon;

class CustomerLoanHelper
{
    public static function getLoanInterest($amount_loan, $interest_percent)
    {
        return $amount_loan * $interest_percent / 100;
    }

    public static function getTypeLoan($type)
    {
    }

    public static function getStatusLoan($status, $labeled = true)
    {
        if ($labeled == true) {
            switch ($status) {
                case 'open':
                    return "<span class='badge badge-secondary badge-lg'><i class='fa-solid fa-pencil me-3'></i> Nouveau dossier</span>";
                    break;
                case 'study':
                    return "<span class='badge badge-warning badge-lg'><i class='fa-solid fa-file me-3'></i> Traitement de la demande</span>";
                    break;
                case 'accepted':
                    return "<span class='badge badge-success badge-lg'><i class='fa-solid fa-check-circle me-3'></i> Accepter</span>";
                    break;
                case 'refused':
                    return "<span class='badge badge-danger badge-lg'><i class='fa-solid fa-times-circle me-3'></i> Refuser</span>";
                    break;
                case 'progress':
                    return "<span class='badge badge-success badge-lg'><i class='fa-solid fa-spinner fa-spin me-3'></i> Utilisation en cours</span>";
                    break;
                case 'terminated':
                    return "<span class='badge badge-info badge-lg'><i class='fa-solid fa-check fa-spin me-3'></i> Pret rembourser</span>";
                    break;
                case 'error':
                    return "<span class='badge badge-danger badge-lg'><i class='fa-solid fa-exclamation-triangle fa-spin me-3'></i> Erreur</span>";
                    break;
            }
        } else {
            switch ($status) {
                case 'open':
                    return 'Nouveau dossier';
                    break;
                case 'study':
                    return 'Traitement de la demande';
                    break;
                case 'accepted':
                    return 'Accepter';
                    break;
                case 'refused':
                    return 'Refuser';
                    break;
                case 'progress':
                    return 'Utilisation en cours';
                    break;
                case 'terminated':
                    return 'Pret rembourser';
                    break;
                case 'error':
                    return 'Erreur';
                    break;
            }
        }
    }

    public static function calcRestantDu($loan, $euro = true)
    {
        if ($euro == true) {
            $prlv_effect = CustomerSepa::query()->where('status', 'processed')->where('creditor', config('app.name'))->sum('amount');
            $calc = $loan->amount_du - $prlv_effect;

            return eur($calc);
        } else {
            $prlv_effect = CustomerSepa::query()->where('status', 'processed')->where('creditor', config('app.name'))->sum('amount');

            return $loan->amount_du - $prlv_effect;
        }
    }

    public static function createLoan(CustomerWallet $wallet, Customer $customer, float $amount, int $loan_plan, int $duration, int $prlv_day = 20, string $status = 'open',\App\Models\Customer\CustomerCreditCard $card = null)
    {
        $plan = LoanPlan::find($loan_plan);

        $wallet_pret = CustomerWalletHelper::createWallet($customer, 'pret');

        $loan = CustomerPret::query()->create([
            'uuid' => \Str::uuid(),
            'reference' => generateReference(),
            'amount_loan' => $amount,
            'amount_interest' => self::getLoanInterest($amount, $plan->interests[0]->interest),
            'amount_du' => $amount + self::getLoanInterest($amount, $plan->interests[0]->interest),
            'mensuality' => ($amount + self::getLoanInterest($amount, $plan->interests[0]->interest)) / $duration,
            'prlv_day' => $prlv_day,
            'duration' => $duration,
            'status' => $status,
            'signed_customer' => 1,
            'signed_bank' => 1,
            'customer_wallet_id' => $wallet_pret->id,
            'wallet_payment_id' => $wallet->id,
            'first_payment_at' => Carbon::create(now()->year, now()->addMonth()->month, $prlv_day),
            'loan_plan_id' => $loan_plan,
            'customer_id' => $customer->id,
        ]);

        if ($plan->id == 6) {
            $facelia = CustomerFacelia::query()->create([
                'reference' => generateReference(),
                'amount_available' => $amount,
                'amount_interest' => 0,
                'amount_du' => 0,
                'mensuality' => 0,
                'wallet_payment_id' => $wallet->id,
                'customer_pret_id' => $loan->id,
                'customer_credit_card_id' => $card,
                'customer_wallet_id' => $loan->wallet->id,
            ]);

            $doc_pret = DocumentFile::createDoc(
                $customer,
                'loan.contrat_de_credit_facelia',
                $loan->reference.' - Information Contractuel Facelia',
                3,
                $loan->reference,
                true,
                true,
                true,
                true,
                [
                    'loan' => $loan,
                    'facelia' => $facelia,
                ]
            );
        } else {
            $doc_pret = DocumentFile::createDoc(
                $customer,
                'loan.contrat_de_credit_personnel',
                $loan->reference.' - Offre de contrat de credit Pret Personnel',
                3,
                $loan->reference,
                true,
                true,
                false,
                true,
                [
                    'loan' => $loan,
                ]
            );
        }

        DocumentFile::createDoc(
            $customer,
            'general.fiche_de_dialogue',
            $loan->reference.' - Fiche de Dialogue',
            3,
            $loan->reference,
            false,
            false,
            false,
            true,
            []
        );

        DocumentFile::createDoc(
            $customer,
            'loan.information_precontractuel_normalise',
            $loan->reference.' - Information Precontractuel Normalise',
            3,
            $loan->reference,
            true,
            true,
            true,
            true,
            [
                'loan' => $loan,
            ]
        );

        DocumentFile::createDoc(
            $customer,
            'loan.assurance_emprunteur',
            $loan->reference.' - Assurance Emprunteur',
            3,
            $loan->reference,
            false,
            false,
            false,
            true,
            []
        );

        DocumentFile::createDoc(
            $customer,
            'insurance.avis_de_conseil_relatif_assurance',
            $loan->reference.' - Avis de conseil relatif à un produit d\'assurance',
            3,
            $loan->reference,
            false,
            false,
            false,
            true,
            []
        );
        DocumentFile::createDoc(
            $customer,
            'general.mandat_prelevement_sepa',
            $loan->reference.' - Mandat Prelevement Sepa',
            3,
            $loan->reference,
            false,
            false,
            false,
            true,
            [
                'loan' => $loan,
            ]
        );
        DocumentFile::createDoc(
            $customer,
            'loan.plan_damortissement',
            $loan->reference.' - Plan d\'amortissement',
            3,
            $loan->reference,
            false,
            false,
            false,
            true,
            [
                'loan' => $loan,
            ]
        );

        $documents = $customer->documents()->where('reference', $loan->reference)->get();
        $docs = [];

        foreach ($documents as $document) {
            $docs[] = [
                'url' => $document->url_folder
            ];
        }

        $customer->info->notify(new NewPretNotification($customer, $loan, $docs));

        return $loan;
    }

    public static function calcMensuality($total_amount, $duration, $plan, $assurance = 'D')
    {
        $ass = self::getLoanInsurance($assurance);

        $subtotal = $total_amount + ($ass * $duration);
        $subInterest = self::getLoanInterest($total_amount, $plan->interests[0]->interest);
        $int_mensuality = $subInterest / $duration;

        return ($subtotal / $duration) + $int_mensuality;
    }

    public static function getLoanInsurance($insurance)
    {
        switch ($insurance) {
            case 'D': $ass = 3.50;
                break;
            case 'DIM': $ass = 4.90;
                break;
            default: $ass = 7.90;
                break;
        }

        return $ass;
    }

    public static function calcVariableTaxeInterest($vitesse = 'low')
    {
        return match ($vitesse) {
            'low' => 16.90,
            'middle' => 9.30,
            default => 4.39,
        };
    }

    public static function getPeriodicMensualityFromVitess($vitesse = 'low')
    {
        return match ($vitesse) {
            'low' => 36,
            'middle' => 24,
            default => 12,
        };
    }

}
