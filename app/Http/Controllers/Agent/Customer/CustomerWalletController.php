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
        CustomerLoanHelper::create(
            $request->get('wallet_payment_id'),
            $customer,
            $request->get('amount_loan'),
            $request->get('loan_plan_id'),
            $request->get('duration'),
            $request->get('prlv_day')
        );
    }
}
