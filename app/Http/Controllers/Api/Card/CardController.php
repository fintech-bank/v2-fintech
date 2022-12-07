<?php

namespace App\Http\Controllers\Api\Card;

use App\Helper\CustomerLoanHelper;
use App\Helper\CustomerWalletHelper;
use App\Helper\DocumentFile;
use App\Http\Controllers\Api\ApiController;
use App\Jobs\Customer\Card\LimitWithdrawJob;
use App\Models\Core\LoanPlan;
use App\Models\Customer\CustomerCreditCard;
use App\Models\Customer\CustomerFacelia;
use App\Models\Customer\CustomerPret;
use App\Models\Customer\CustomerWallet;
use App\Notifications\Customer\NewPretNotification;
use App\Notifications\Customer\SendRequestNotification;
use App\Scope\VerifCompatibilityBeforeLoanTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CardController extends ApiController
{
    public function index()
    {

    }

    public function update($card_id, Request $request)
    {
        $card = CustomerCreditCard::find($card_id);

        return match($request->get('action')) {
            "desactiveCard" => $this->desactiveCard($card),
            "activeCard" => $this->activeCard($card),
            "oppositCard" => $this->oppositCard($card, $request),
            'editLimitPayment' => $this->editLimitPayment($card, $request),
            'editLimitWithdraw' => $this->editLimitWithdraw($card, $request),
            'subscribeAlterna' => $this->subscribeAlterna($card, $request)
        };
    }

    private function desactiveCard(\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|array|\LaravelIdea\Helper\App\Models\Customer\_IH_CustomerCreditCard_C|CustomerCreditCard|null $card)
    {
        $card->update(['status' => 'inactive']);

        return $this->sendSuccess("Carte désactivé");
    }

    private function activeCard(\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|array|\LaravelIdea\Helper\App\Models\Customer\_IH_CustomerCreditCard_C|CustomerCreditCard|null $card)
    {
        $card->update(['status' => 'active']);

        return $this->sendSuccess("Carte activé");
    }

    private function oppositCard(\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|array|\LaravelIdea\Helper\App\Models\Customer\_IH_CustomerCreditCard_C|CustomerCreditCard|null $card, Request $request)
    {
        $opposit = $card->opposition()->create([
            'reference' => generateReference(),
            'type' => $request->get('type'),
            'description' => $request->get('description'),
            'verif_fraude' => $request->get('type') == 'fraude',
            'status' => 'submit',
            'customer_credit_card_id' => $card->id
        ]);

        $card->update(['status' => 'opposit']);

        return $this->sendSuccess("Dossier d'opposition transmis");
    }

    private function editLimitPayment(\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|array|\LaravelIdea\Helper\App\Models\Customer\_IH_CustomerCreditCard_C|CustomerCreditCard|null $card, Request $request)
    {
        $card->update(["limit_payment" => $request->get('limit_payment')]);

        return $this->sendSuccess("Plafond de paiement edité");
    }

    private function editLimitWithdraw(\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|array|\LaravelIdea\Helper\App\Models\Customer\_IH_CustomerCreditCard_C|CustomerCreditCard|null $card, Request $request)
    {
        dispatch(new LimitWithdrawJob($card, $card->limit_retrait))->delay(now()->addDays(2));
        $card->update(['limit_retrait' => $request->get('limit_retrait')]);

        return $this->sendSuccess("Limite de retrait edité");
    }

    private function subscribeAlterna(\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|array|\LaravelIdea\Helper\App\Models\Customer\_IH_CustomerCreditCard_C|CustomerCreditCard|null $card, Request $request)
    {
        if(VerifCompatibilityBeforeLoanTrait::prerequestLoan($card->wallet->customer)->count() == 0) {
            $plan = LoanPlan::find($request->get('loan_plan_id'));
            $wallet_pret = CustomerWalletHelper::createWallet($card->wallet->customer, 'pret');
            $amount = (float)\Str::replace('€ ', '', $request->get('amount_available'));

            $credit = CustomerPret::create([
                'uuid' => \Str::uuid(),
                'reference' => generateReference(),
                'amount_loan' => $amount,
                'amount_interest' => 0,
                'amount_du' => 0,
                'mensuality' => 0,
                'prlv_day' => '10',
                'duration' => $request->get('duration') * 12,
                'status' => 'open',
                'signed_customer' => 0,
                'signed_bank' => 1,
                'customer_wallet_id' => $wallet_pret->id,
                'wallet_payment_id' => $card->wallet->id,
                'first_payment_at' => Carbon::create(now()->year, now()->addMonth()->month, 10),
                'loan_plan_id' => $plan->id,
                'customer_id' => $card->wallet->customer,
            ]);

            $amount_interest = CustomerLoanHelper::getLoanInterest($amount, CustomerLoanHelper::calcLoanIntestVariableTaxe($credit));
            $amount_du = $amount + $amount_interest;
            $mensuality = $amount_du / ($request->get('duration') * 12);

            $credit->update([
                'amount_interest' => $amount_interest,
                'amount_du' => $amount_du,
                'mensuality' => $mensuality
            ]);

            $alterna = CustomerFacelia::create([
                'reference' => $credit->reference,
                'amount_available' => $amount,
                'amount_interest' => 0,
                'amount_du' => 0,
                'mensuality' => 0,
                'wallet_payment_id' => $card->wallet->id,
                'customer_pret_id' => $credit->id,
                'customer_credit_card_id' => $card->id,
                'customer_wallet_id' => $credit->wallet->id,
            ]);

            $doc_pret = DocumentFile::createDoc(
                $card->wallet->customer,
                'loan.contrat_de_credit_facelia',
                $credit->reference.' - Information Contractuel Facelia',
                3,
                $credit->reference,
                true,
                true,
                true,
                true,
                [
                    'loan' => $credit,
                    'facelia' => $alterna,
                ]
            );

            DocumentFile::createDoc(
                $card->wallet->customer,
                'loan.information_precontractuel_normalise',
                $credit->reference.' - Information Precontractuel Normalise',
                3,
                $credit->reference,
                true,
                true,
                true,
                true,
                [
                    'loan' => $credit,
                ]
            );

            DocumentFile::createDoc(
                $card->wallet->customer,
                'loan.assurance_emprunteur',
                $credit->reference.' - Assurance Emprunteur',
                3,
                $credit->reference,
                false,
                false,
                false,
                true,
                []
            );

            DocumentFile::createDoc(
                $card->wallet->customer,
                'insurance.avis_de_conseil_relatif_assurance',
                $credit->reference.' - Avis de conseil relatif à un produit d\'assurance',
                3,
                $credit->reference,
                false,
                false,
                false,
                true,
                []
            );
            DocumentFile::createDoc(
                $card->wallet->customer,
                'general.mandat_prelevement_sepa',
                $credit->reference.' - Mandat Prelevement Sepa',
                3,
                $credit->reference,
                false,
                false,
                false,
                true,
                [
                    'loan' => $credit,
                    'wallet' => $card->wallet
                ]
            );
            DocumentFile::createDoc(
                $card->wallet->customer,
                'loan.plan_damortissement',
                $credit->reference.' - Plan d\'amortissement',
                3,
                $credit->reference,
                false,
                false,
                false,
                true,
                [
                    'credit' => $credit,
                ]
            );

            $documents = $card->wallet->customer->documents()->where('reference', $credit->reference)->get();
            $docs = [];

            $request = $card->wallet->customer->requests()->create([
                "reference" => generateReference(),
                "sujet" => "Signature d'un document",
                "commentaire" => "<p>Veuillez effectuer la signature du document suivant : ".$credit->reference." - Offre de contrat de credit Pret Personnel</p><br><a href='".route('signate.show', base64_encode($doc_pret->id))."' class='btn btn-circle btn-primary'>Signer le document</a>",
                "link_model" => CustomerPret::class,
                "link_id" => $credit->id,
                "customer_id" => $card->wallet->customer->id
            ]);
            $card->wallet->customer->info->notify(new SendRequestNotification($card->wallet->customer, $request, 'Prêt'));

            foreach ($documents as $document) {
                $docs[] = [
                    'url' => public_path($document->url_folder)
                ];
            }

            $card->wallet->customer->info->notify(new NewPretNotification($card->wallet->customer, $credit, $docs, "Prêt"));

            return $this->sendSuccess("Souscription au crédit Alterna transmis");
        } else {
            return $this->sendWarning("Prérequis incomplé", ["errors" => VerifCompatibilityBeforeLoanTrait::prerequestLoan($card->wallet->customer)]);
        }
    }
}
