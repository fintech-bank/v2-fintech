<?php

namespace App\Http\Controllers\Api\Customer;

use App\Helper\CustomerCreditCard;
use App\Helper\CustomerFaceliaHelper;
use App\Helper\CustomerLoanHelper;
use App\Helper\CustomerTransactionHelper;
use App\Helper\CustomerWalletHelper;
use App\Helper\DocumentFile;
use App\Helper\LogHelper;
use App\Http\Controllers\Api\ApiController;
use App\Models\Core\CreditCardOpposit;
use App\Models\Core\LoanPlan;
use App\Models\Customer\CustomerFacelia;
use App\Models\Customer\CustomerPret;
use App\Models\Customer\CustomerWallet;
use App\Notifications\Customer\CancelCreditCardNotification;
use App\Notifications\Customer\NewPretNotification;
use App\Notifications\Customer\SendCreditCardCodeNotification;
use App\Notifications\Customer\SendRequestNotification;
use App\Scope\CalcLoanInsuranceTrait;
use App\Scope\CalcLoanTrait;
use App\Scope\VerifCompatibilityBeforeLoanTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CreditCardController extends ApiController
{
    use CalcLoanTrait, CalcLoanInsuranceTrait;
    public function store($customer_id, $number_account, Request $request)
    {
        $wallet = CustomerWallet::where('number_account', $number_account)->first();

        $card = CustomerCreditCard::createCard(
            $wallet->customer,
            $wallet,
            $request->get('type'),
            $request->get('support'),
            $request->get('debit'),
        );

        if ($wallet->Numberofphysicalbankcardsexceeded()) {
            CustomerTransactionHelper::create(
                'debit',
                'frais',
                'Cotisation Carte Bancaire Physique',
                25,
                $wallet->id,
                true,
                'Carte Bancaire Supplémentaire N°' . $card->number_card_oscure,
                now(),
            );
        }

        if ($wallet->Numberofvirtualbankcardsexceeded()) {
            CustomerTransactionHelper::create(
                'debit',
                'frais',
                'Cotisation Carte Bancaire Virtuel',
                10,
                $wallet->id,
                true,
                'Carte Bancaire virtuel Supplémentaire N°' . $card->number_card_oscure,
                now(),
            );
        }

        return response()->json();
    }

    public function update($customer_id, $number_account, $card_id, Request $request)
    {
        $card = \App\Models\Customer\CustomerCreditCard::find($card_id);

        return match ($request->get('action')) {
            "edit" => $this->editCreditCard($card, $request),
            "send_code" => $this->sendCode($card),
            "facelia" => $this->facelia($card, $request),
            "cancel_card" => $this->cancelCard($card),
            "opposit_card" => $this->oppositCard($card, $request)
        };
    }

    private function editCreditCard(\App\Models\Customer\CustomerCreditCard $card, Request $request)
    {
        try {
            $card->update($request->except('_token', 'action'));
        } catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage(), $exception);
            return response()->json(null, 500);
        }

        return response()->json();
    }

    private function sendCode(\App\Models\Customer\CustomerCreditCard $card)
    {
        if ($card->wallet->customer->package->name != 'Platine' || $card->wallet->customer->package->name != 'Pro Gold') {
            CustomerTransactionHelper::create(
                'debit',
                'frais',
                'Frais Bancaire',
                0.15,
                $card->wallet->id,
                true,
                'Renvoie du code carte bancaire ' . $card->number_card_oscure,
                now()
            );
        }

        $card->wallet->customer->info->notify(new SendCreditCardCodeNotification($card->wallet->customer, base64_decode($card->code), $card));

        return response()->json();
    }

    private function facelia(\App\Models\Customer\CustomerCreditCard $card, Request $request)
    {
        if($card->facelia == 0) {
            if (VerifCompatibilityBeforeLoanTrait::prerequestLoan($card->wallet->customer)->count() == 0) {
                if(VerifCompatibilityBeforeLoanTrait::verify($card->wallet->customer)) {
                    // Création du compte de pret
                    $wallet_pret = CustomerWalletHelper::createWallet(
                        $card->wallet->customer,
                        'pret'
                    );

                    // Création du pret
                    $pret = CustomerPret::create([
                        'uuid' => Str::uuid(),
                        'reference' => generateReference(10),
                        'amount_loan' => $request->get('amount_available'),
                        'amount_interest' => 0,
                        'amount_du' => 0,
                        'mensuality' => 0,
                        'prlv_day' => 20,
                        'duration' => 36,
                        'signed_bank' => true,
                        'customer_wallet_id' => $wallet_pret->id,
                        'wallet_payment_id' => $card->wallet->id,
                        'loan_plan_id' => 6,
                        'customer_id' => $card->wallet->id
                    ]);

                    // Création Facelia
                    $facelia = CustomerFacelia::create([
                        'reference' => $pret->reference,
                        'amount_available' => $pret->amount_loan,
                        'amount_interest' => 0,
                        'amount_du' => 0,
                        'mensuality' => 0,
                        'wallet_payment_id' => $card->wallet->id,
                        'customer_pret_id' => $pret->id,
                        'customer_credit_card_id' => $card->id,
                        'customer_wallet_id' => $wallet_pret->id,
                    ]);
                    $plan = LoanPlan::find(6);
                    $amount_interest =  self::getLoanInterest($request->get('amount_available'), $plan->tarif->type_taux == 'fixe' ? $plan->tarif->interest : self::calcLoanIntestVariableTaxe($pret));
                    $amount_du = $request->get('amount_available') + $amount_interest;
                    $mensuality = $amount_du / 36;

                    $pret->update([
                        'amount_interest' => $amount_interest,
                        'amount_du' => $amount_du,
                        'mensuality' => $mensuality
                    ]);

                    $doc_pret = DocumentFile::createDoc(
                        $card->wallet->customer,
                        'loan.contrat_de_credit_facelia',
                        $pret->reference.' - Information Contractuel Facelia',
                        3,
                        $pret->reference,
                        true,
                        true,
                        true,
                        true,
                        [
                            'loan' => $pret,
                            'facelia' => $facelia,
                        ]
                    );

                    DocumentFile::createDoc(
                        $card->wallet->customer,
                        'general.fiche_de_dialogue',
                        $pret->reference.' - Fiche de Dialogue',
                        3,
                        $pret->reference,
                        false,
                        false,
                        false,
                        true,
                        []
                    );

                    DocumentFile::createDoc(
                        $card->wallet->customer,
                        'loan.information_precontractuel_normalise',
                        $pret->reference.' - Information Precontractuel Normalise',
                        3,
                        $pret->reference,
                        true,
                        true,
                        true,
                        true,
                        [
                            'loan' => $pret,
                        ]
                    );

                    DocumentFile::createDoc(
                        $card->wallet->customer,
                        'loan.assurance_emprunteur',
                        $pret->reference.' - Assurance Emprunteur',
                        3,
                        $pret->reference,
                        false,
                        false,
                        false,
                        true,
                        []
                    );

                    DocumentFile::createDoc(
                        $card->wallet->customer,
                        'insurance.avis_de_conseil_relatif_assurance',
                        $pret->reference.' - Avis de conseil relatif à un produit d\'assurance',
                        3,
                        $pret->reference,
                        false,
                        false,
                        false,
                        true,
                        []
                    );
                    DocumentFile::createDoc(
                        $card->wallet->customer,
                        'general.mandat_prelevement_sepa',
                        $pret->reference.' - Mandat Prelevement Sepa',
                        3,
                        $pret->reference,
                        false,
                        false,
                        false,
                        true,
                        [
                            'loan' => $pret,
                        ]
                    );
                    DocumentFile::createDoc(
                        $card->wallet->customer,
                        'loan.plan_damortissement',
                        $pret->reference.' - Plan d\'amortissement',
                        3,
                        $pret->reference,
                        false,
                        false,
                        false,
                        true,
                        [
                            'loan' => $pret,
                        ]
                    );

                    $documents = $card->wallet->customer->documents()->where('reference', $pret->reference)->get();
                    $docs = [];

                    $request = $card->wallet->customer->requests()->create([
                        "reference" => generateReference(),
                        "sujet" => "Signature d'un document",
                        "commentaire" => "<p>Veuillez effectuer la signature du document suivant : ".$pret->reference." - Offre de contrat de credit Pret Personnel</p><br><a href='".route('signate.show', base64_encode($doc_pret->id))."' class='btn btn-circle btn-primary'>Signer le document</a>",
                        "link_model" => CustomerPret::class,
                        "link_id" => $pret->id,
                        "customer_id" => $card->wallet->customer->id
                    ]);
                    $card->wallet->customer->info->notify(new SendRequestNotification($card->wallet->customer, $request));

                    foreach ($documents as $document) {
                        $docs[] = [
                            'url' => public_path($document->url_folder)
                        ];
                    }

                    $card->wallet->customer->info->notify(new NewPretNotification($card->wallet->customer, $pret, $docs));

                    return $this->sendSuccess();
                } else {
                    return $this->sendWarning("Certains pré-requis ne sont pas remplie pour acceder au crédit renouvelable FACELIA.");
                }
            } else {
                return $this->sendError(["errors" => VerifCompatibilityBeforeLoanTrait::prerequestLoan($card->wallet->customer)]);
            }
        } else {
            return $this->sendWarning("Cette carte bancaire est déjà affilier à un contrat FACELIA");
        }
    }

    private function cancelCard(\App\Models\Customer\CustomerCreditCard $card)
    {
        $card->update([
            'status' => 'canceled'
        ]);

        $card->wallet->customer->info->notify(new CancelCreditCardNotification($card->wallet->customer, $card));

        return $this->sendSuccess();

    }

    private function oppositCard(\App\Models\Customer\CustomerCreditCard $card, Request $request)
    {
        $opposit = $card->setOpposit($request->get('raison_select'), $request->get('description'));
        $requete = $card->wallet->customer->requests()->create([
            "reference" => generateReference(14),
            "sujet" => "Opposition sur la carte bancaire",
            "commentaire" => "Veuillez nous transmettre les documents relatives à la requete d'opposition.",
            "link_model" => CreditCardOpposit::class,
            "link_id" => $opposit->id,
            "customer_id" => $card->wallet->customer->id,
        ]);

        $card->wallet->customer->info->notify(new SendRequestNotification($card->wallet->customer, $requete));

        return response()->json();
    }
}
