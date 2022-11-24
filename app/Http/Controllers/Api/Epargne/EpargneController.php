<?php

namespace App\Http\Controllers\Api\Epargne;

use App\Helper\CustomerTransactionHelper;
use App\Helper\CustomerWalletHelper;
use App\Helper\DocumentFile;
use App\Http\Controllers\Api\ApiController;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerEpargne;
use App\Models\Customer\CustomerWallet;
use App\Notifications\Customer\NewEpargneNotification;
use App\Notifications\Customer\SendRequestNotification;
use App\Scope\VerifyEpargneFromPlanTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EpargneController extends ApiController
{
    /**
     * Liste des contrats d'épargne
     * @param int $limit
     * @param Carbon|null $start
     * @param Carbon|null $end
     * @return JsonResponse
     */
    public function list(int $limit = 10, Carbon $start = null, Carbon $end = null)
    {
        $call = CustomerEpargne::with('plan', 'wallet', 'payment');
        $start != null ? $call->whereBetween('start', [$start, $end]) : $call;
        $call->limit($limit)->get();

        return $this->sendSuccess(null, [$call]);
    }

    /**
     * Création d'un contrat d'épargne
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {

        $request->validate([
            'initial_payment' => 'required',
            'monthly_payment' => 'required',
            'monthly_days' => 'required|integer',
            'wallet_payment_id' => 'required|integer',
            'epargne_plan_id' => 'required|integer',
            'customer_id' => 'required|integer'
        ]);
        $customer = Customer::find($request->get('customer_id'));
        if(VerifyEpargneFromPlanTrait::verifRequest($request, $customer)->state) {
            try {
                $wallet = CustomerWalletHelper::createWallet(
                    $customer,
                    'epargne'
                );
            }catch (\Exception $exception) {
                return $this->sendError($exception);
            }

            try {
                $epargne = CustomerEpargne::create([
                    'uuid' => \Str::uuid(),
                    'reference' => generateReference(),
                    'initial_payment' => $request->get('initial_payment'),
                    'monthly_payment' => $request->get('monthly_payment'),
                    'monthly_days' => $request->get('monthly_days'),
                    'wallet_id' => $wallet->id,
                    'next_prlv' => Carbon::create(now()->year, now()->addMonth()->month, $request->get('monthly_days')),
                    "start" => now(),
                    'wallet_payment_id' => $request->get('wallet_payment_id'),
                    'epargne_plan_id' => $request->get('epargne_plan_id')
                ]);
            }catch (\Exception $exception) {
                return $this->sendError($exception);
            }

            $wallet_payment = $customer->wallets->find($request->get('wallet_payment_id'));

            try {
                $customer->beneficiaires()->create([
                    "type" => $customer->info->type == 'part' ? 'retail' : 'corporate',
                    "bankname" => $customer->agency->name,
                    "iban" => $wallet_payment->iban,
                    "bic" => $customer->agency->bic,
                    "company" => $customer->info->type != 'part' ? $customer->info->full_name : '',
                    "civility" => $customer->info->type == 'part' ? $customer->info->civility : '',
                    "firstname" => $customer->info->type == 'part' ? $customer->info->firstname : '',
                    "lastname" => $customer->info->type == 'part' ? $customer->info->lastname : '',
                    "titulaire" => 1,
                    "customer_id" => $customer->id,
                    "bank_id" => 176,
                    "uuid" => \Str::uuid()
                ]);

                $wallet_payment->customer->beneficiaires()->create([
                    "type" => $customer->info->type == 'part' ? 'retail' : 'corporate',
                    "bankname" => $customer->agency->name,
                    "iban" => $wallet->iban,
                    "bic" => $customer->agency->bic,
                    "company" => $customer->info->type != 'part' ? $customer->info->full_name : '',
                    "civility" => $customer->info->type == 'part' ? $customer->info->civility : '',
                    "firstname" => $customer->info->type == 'part' ? $customer->info->firstname : '',
                    "lastname" => $customer->info->type == 'part' ? $customer->info->lastname : '',
                    "titulaire" => 1,
                    "customer_id" => $customer->id,
                    "bank_id" => 176,
                    "uuid" => \Str::uuid()
                ]);
            }catch (\Exception $exception) {
                return $this->sendError($exception);
            }

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

            $req = $customer->requests()->create([
                "reference" => generateReference(),
                "sujet" => "Signature d'un document",
                "commentaire" => "<p>Veuillez effectuer la signature du document suivant : ".$doc_epargne->name."</p><br><a href='".route('signate.show', base64_encode($doc_epargne->id))."' class='btn btn-circle btn-primary'>Signer le document</a>",
                "link_model" => CustomerEpargne::class,
                "link_id" => $epargne->id,
                "customer_id" => $customer->id
            ]);

            $customer->info->notify(new SendRequestNotification($customer, $req));

            try {
                CustomerTransactionHelper::createDebit(
                    $wallet_payment->id,
                    'virement',
                    'Virement Compte Epargne '.$wallet->number_account,
                    "REFERENCE " . $epargne->reference . " | Livret " . $wallet->epargne->plan->name . " ~ " . $wallet->number_account,
                    $request->get('initial_payment'),
                    true,
                    now()
                );

                CustomerTransactionHelper::create(
                    'credit',
                    'virement',
                    'Virement Compte Epargne '.$wallet->number_account,
                    $request->get('initial_payment'),
                    $wallet->id,
                    true,
                    "REFERENCE " . $epargne->reference . " | Livret " . $wallet->epargne->plan->name . " ~ " . $wallet->number_account,
                    now(),
                );
            }catch (\Exception $exception) {
                return $this->sendError($exception);
            }

            $customer->info->notify(new NewEpargneNotification($customer, $wallet));

            return $this->sendSuccess(null, ["epargne" => $epargne]);
        } else {
            return $this->sendWarning("Prérequis non remplie", [VerifyEpargneFromPlanTrait::verifRequest($request, $customer)]);
        }
    }

    public function retrieve($reference)
    {
        $epargne = CustomerEpargne::with('plan', 'wallet', 'payment')->where('reference', $reference)->first();

        return $this->sendSuccess(null, $epargne);
    }
}
