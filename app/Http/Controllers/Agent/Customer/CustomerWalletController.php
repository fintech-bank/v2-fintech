<?php

namespace App\Http\Controllers\Agent\Customer;

use App\Helper\CustomerEpargneHelper;
use App\Helper\CustomerLoanHelper;
use App\Helper\CustomerTransactionHelper;
use App\Helper\CustomerWalletHelper;
use App\Helper\DocumentFile;
use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerEpargne;
use App\Models\Customer\CustomerWallet;
use App\Notifications\Customer\NewEpargneNotification;
use App\Notifications\Customer\NewPretNotification;
use App\Notifications\Customer\NewPretNotificationP;
use App\Notifications\Customer\NewWalletNotification;
use App\Notifications\Customer\SendLinkForContractNotification;
use Illuminate\Http\Request;

class CustomerWalletController extends Controller
{

    public function store(Request $request, $customer_id)
    {
        $customer = Customer::find($customer_id);

        match ($request->get('action')) {
            'compte' => $this->createCompte($customer),
            'epargne' => $this->createEpargne($customer, $request),
            'pret' => $this->createPret($customer, $request)
        };

        return response()->json([
            'customer' => $customer
        ]);
    }

    public function show($number_account)
    {
        $wallet = CustomerWallet::where('number_account', $number_account)->first();
        //dd($wallet->cards->count(), $wallet->customer->package->nb_carte_physique);

        if($wallet->type == 'compte') {
            return view('agent.customer.wallet.compte.show', [
                'wallet' => $wallet
            ]);
        } elseif ($wallet->type == 'epargne') {
            return view('agent.customer.wallet.epargne.show', [
                'wallet' => $wallet
            ]);
        } else {
            return view('agent.customer.wallet.pret.show', [
                'wallet' => $wallet
            ]);
        }
    }

    private function createCompte(Customer $customer)
    {
        CustomerWalletHelper::createWallet(
            $customer,
            'compte',
            0,
            0,
            0,
            0,
            'active'
        );

        return response()->json();
    }

    private function createEpargne(Customer $customer, Request $request)
    {
        CustomerEpargneHelper::create(
            $customer,
            $request->get('initial_payment'),
            $request->get('monthly_payment'),
            $request->get('monthly_days'),
            $request->get('wallet_payment_id'),
            $request->get('epargne_plan_id')
        );

        return response()->json();
    }

    private function createPret(Customer $customer, Request $request)
    {
        dd($request->all());
        $pret = CustomerLoanHelper::create(

        );

        $docs = [];

        $docs[] = DocumentFile::createDoc(
            $customer,
            'fiche_dialogue',
            $pret->reference . " - Fiche de dialogue",
            3,
            $pret->reference,
            false,
            false,
            false,
            true,
            []
        );

        $docs[] = DocumentFile::createDoc(
            $customer,
            'information_precontractuel_normaliser',
            $pret->reference . " - Information Precontractuel Normaliser",
            3,
            $pret->reference,
            false,
            false,
            false,
            true,
            ['pret' => $pret]
        );

        $docs[] = DocumentFile::createDoc(
            $customer,
            'assurance_emprunteur',
            $pret->reference . " - Assurance Emprunteur",
            3,
            $pret->reference,
            false,
            false,
            false,
            true,
        );

        $docs[] = DocumentFile::createDoc(
            $customer,
            'contrat_de_credit_personnel',
            $pret->reference . " - Contrat de crédit: Pret Personnel",
            3,
            $pret->reference,
            true,
            true,
            false,
            true,
            ['pret' => $pret]
        );

        $docs[] = DocumentFile::createDoc(
            $customer,
            'mandat_prelevement_sepa',
            $pret->reference . " - Mandat de Prélèvement Sepa",
            3,
            $pret->reference,
            true,
            true,
            false,
            true,
            ["pret" => $pret]
        );

        $docs[] = DocumentFile::createDoc(
            $customer,
            'plan_amortiseement',
            $pret->reference . " - Plan d'amortissement",
            3,
            $pret->reference,
            true,
            true,
            false,
            true,
            ["pret" => $pret]
        );

        $arr = [];
        foreach ($docs as $doc) {
            $arr[] = ["url" => public_path("/storage/gdd/{$customer->user->id}/documents/{$doc->category->name}/$doc->name.pdf")];
        }

        $customer->user->notify(new NewPretNotification($customer, $pret, $arr));
    }
}
