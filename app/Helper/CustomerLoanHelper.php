<?php

namespace App\Helper;

use App\Models\Core\LoanPlan;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerFacelia;
use App\Models\Customer\CustomerPret;
use App\Models\Customer\CustomerWallet;
use App\Notifications\Customer\NewPretNotification;
use App\Notifications\Customer\NewPretNotificationP;
use App\Notifications\Customer\SendRequestNotification;
use App\Scope\CalcLoanTrait;
use App\Scope\VerifCompatibilityBeforeLoanTrait;
use Carbon\Carbon;

class CustomerLoanHelper
{
    use CalcLoanTrait, VerifCompatibilityBeforeLoanTrait;

    public static function create(int $wallet_payment_id, Customer $customer, float $amount, int $loan_plan, int $duration, int $prlv_day = 20, string $status = 'open',\App\Models\Customer\CustomerCreditCard $card = null): array
    {
        if(VerifCompatibilityBeforeLoanTrait::prerequestLoan($customer)->count() == 0) {
            if(self::verify($customer)) {
                $plan = LoanPlan::find($loan_plan);

                $wallet_pret = CustomerWalletHelper::createWallet($customer, 'pret');

                $loan = CustomerPret::query()->create([
                    'uuid' => \Str::uuid(),
                    'reference' => generateReference(),
                    'amount_loan' => $amount,
                    'amount_interest' => 0,
                    'amount_du' => 0,
                    'mensuality' => 0,
                    'prlv_day' => $prlv_day,
                    'duration' => $duration * 12,
                    'status' => $status,
                    'signed_customer' => 1,
                    'signed_bank' => 1,
                    'customer_wallet_id' => $wallet_pret->id,
                    'wallet_payment_id' => $wallet_payment_id,
                    'first_payment_at' => Carbon::create(now()->year, now()->addMonth()->month, $prlv_day),
                    'loan_plan_id' => $loan_plan,
                    'customer_id' => $customer->id,
                ]);
                $amount_interest =  self::getLoanInterest($amount, $plan->tarif->type_taux == 'fixe' ? $plan->tarif->interest : self::calcLoanIntestVariableTaxe($loan));
                $amount_du = $amount + $amount_interest;
                $mensuality = $amount_du / $duration;

                $loan->update([
                    'amount_interest' => $amount_interest,
                    'amount_du' => $amount_du,
                    'mensuality' => $mensuality
                ]);

                if ($plan->id == 6) {
                    $facelia = CustomerFacelia::query()->create([
                        'reference' => generateReference(),
                        'amount_available' => $amount,
                        'amount_interest' => 0,
                        'amount_du' => 0,
                        'mensuality' => 0,
                        'wallet_payment_id' => $wallet_payment_id,
                        'customer_pret_id' => $loan->id,
                        'customer_credit_card_id' => $card->id,
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

                $request = $customer->requests()->create([
                    "reference" => generateReference(),
                    "sujet" => "Signature d'un document",
                    "commentaire" => "<p>Veuillez effectuer la signature du document suivant : ".$loan->reference." - Offre de contrat de credit Pret Personnel</p><br><a href='".route('signate.show', base64_encode($doc_pret->id))."' class='btn btn-circle btn-primary'>Signer le document</a>",
                    "link_model" => CustomerPret::class,
                    "link_id" => $loan->id,
                    "customer_id" => $customer->id
                ]);
                $customer->info->notify(new SendRequestNotification($customer, $request));

                foreach ($documents as $document) {
                    $docs[] = [
                        'url' => public_path($document->url_folder)
                    ];
                }

                $customer->info->notify(new NewPretNotification($customer, $loan, $docs));

                return [
                    "loan" => $loan,
                    "docs" => $docs
                ];
            } else {
                return [];
            }
        } else {
            return [];
        }
    }

}
