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
use App\Notifications\Customer\Customer\Customer\NewEpargneNotification;
use App\Notifications\Customer\Customer\Customer\NewPretNotification;
use App\Notifications\Customer\Customer\Customer\NewWalletNotification;
use Illuminate\Http\Request;

class CustomerWalletController extends Controller
{

    public function store(Request $request, $customer_id)
    {
        $customer = Customer::find($customer_id);

        $wallet = CustomerWalletHelper::createWallet(
            $customer,
            $request->get('action'),
        );

        match ($request->get('action')) {
            'compte' => $this->createCompte($customer, $wallet),
            'epargne' => $this->createEpargne($customer, $wallet, $request),
            'pret' => $this->createPret($customer, $wallet, $request)
        };

        return response()->json([
            'customer' => $customer,
            'wallet' => $wallet
        ]);
    }

    public function show($number_account)
    {
        $wallet = CustomerWallet::where('number_account', $number_account)->first();

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

    private function createCompte(Customer $customer, CustomerWallet $wallet)
    {
        $doc_compte = DocumentFile::createDoc(
            $customer,
            'convention_compte',
            'Convention de compte bancaire',
            3,
            generateReference(),
            true,
            true,
            false,
            true,
            ['wallet' => $wallet]
        );

        $docs = ["url" => public_path("/storage/gdd/{$customer->user->id}/documents/{$doc_compte->category->name}/{$doc_compte->name}.pdf")];

        //Notification de création de compte
        $customer->user->notify(new NewWalletNotification($customer, $docs));
    }

    private function createEpargne(Customer $customer, CustomerWallet $wallet, Request $request)
    {
        $epargne = CustomerEpargne::create([
            'uuid' => \Str::uuid(),
            'reference' => generateReference(),
            'initial_payment' => $request->get('initial_payment'),
            'monthly_payment' => $request->get('monthly_payment'),
            'monthly_days' => $request->get('monthly_days'),
            'wallet_id' => $wallet->id,
            'wallet_payment_id' => $request->get('wallet_payment_id'),
            'epargne_plan_id' => $request->get('epargne_plan_id'),
        ]);

        $doc_epargne = DocumentFile::createDoc(
            $customer,
            'contrat_epargne',
            "Contrat d'épargne",
            3,
            generateReference(),
            true,
            true,
            false,
            true,
            ['wallet' => $wallet, "epargne" => $epargne]
        );

        $wallet_retrait = CustomerWallet::find($epargne->wallet_payment_id);
        CustomerTransactionHelper::create(
            'debit',
            'sepa',
            'Prélèvement Contrat Epargne ' . $wallet->number_account,
            $request->get('initial_payment'),
            $wallet_retrait->id,
            true,
            "REFERENCE " . generateReference() . " | Livret " . $wallet->epargne->plan->name . " ~ " . $wallet->number_account,
            now()
        );
        CustomerTransactionHelper::create(
            'credit',
            'sepa',
            'Prélèvement Contrat Epargne ' . $wallet->number_account,
            $request->get('initial_payment'),
            $wallet->id,
            true,
            "REFERENCE " . generateReference() . " | Livret " . $wallet->epargne->plan->name . " ~ " . $wallet->number_account,
            now()
        );

        $customer->user->notify(new NewEpargneNotification($customer, $wallet, ['url' => public_path("/storage/gdd/{$customer->user->id}/documents/{$doc_epargne->category->name}/$doc_epargne->name.pdf")]));
    }

    private function createPret(Customer $customer, CustomerWallet $wallet, Request $request)
    {
        $pret = CustomerLoanHelper::createLoan(
            $wallet,
            $customer,
            $request->get('amount_load'),
            $request->get('loan_plan_id'),
            $request->get('duration'),
            $request->get('prlv_day'),
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
