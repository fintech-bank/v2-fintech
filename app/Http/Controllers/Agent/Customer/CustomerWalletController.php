<?php

namespace App\Http\Controllers\Agent\Customer;

use App\Helper\CustomerEpargneHelper;
use App\Helper\CustomerLoanHelper;
use App\Helper\CustomerTransactionHelper;
use App\Helper\CustomerWalletHelper;
use App\Helper\DocumentFile;
use App\Helper\LogHelper;
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

        try {
            return match ($request->get('action')) {
                'compte' => $this->createCompte($customer),
                'epargne' => $this->createEpargne($customer, $request),
                'pret' => $this->createPret($customer, $request)
            };
        }catch (\Exception $exception) {
            LogHelper::notify("critical", $exception->getMessage());
        }
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

    public function caution($number_account, Request $request)
    {
        $wallet = CustomerWallet::where('number_account', $number_account)->first();

        try {
            $cautions = collect(json_decode($wallet->loan->caution));

            $cautions->push([
                'name' => $request->get('name'),
                'lastname' => $request->get('lastname'),
                'birthdate' => $request->get('birthdate'),
                'cni' => \Str::limit(\Str::replace(',', '', $request->get('cni_number')), 15),
                'address' => $request->get('address'),
                'postal' => $request->get('postal'),
                'city' => $request->get('city'),
                'country' => $request->get('country'),
                'email' => $request->get('email'),
                'phone' => $request->get('phone'),
                'caution_type' => $request->get('caution_type'),
            ]);
        }catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }

        try {
            $file_recto = $request->file('cni_recto');
            $request->file('cni_recto')->storeAs(public_path("/storage/gdd/{$wallet->customer->user->id}/account/credit_{$wallet->loan->reference}/caution/".\Str::snake($request->get('name').$request->get('lastname'))), $file_recto->getClientOriginalName());
        }catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }

        try {
            $file_verso = $request->file('cni_verso');
            $request->file('cni_verso')->storeAs(public_path("/storage/gdd/{$wallet->customer->user->id}/account/credit_{$wallet->loan->reference}/caution/".\Str::snake($request->get('name').$request->get('lastname'))), $file_verso->getClientOriginalName());
        }catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }

        return redirect()->back()->with('success', "Le caution à été ajouter avec succès");
    }

    private function createCompte(Customer $customer)
    {
        return CustomerWalletHelper::createWallet(
            $customer,
            'compte',
            0,
            0,
            0,
            0,
            'active'
        );
    }

    private function createEpargne(Customer $customer, Request $request)
    {
        return CustomerEpargneHelper::create(
            $customer,
            $request->get('initial_payment'),
            $request->get('monthly_payment'),
            $request->get('monthly_days'),
            $request->get('wallet_payment_id'),
            $request->get('epargne_plan_id')
        );
    }

    private function createPret(Customer $customer, Request $request)
    {
        return CustomerLoanHelper::create(
            $request->get('wallet_payment_id'),
            $customer,
            $request->get('amount_loan'),
            $request->get('loan_plan_id'),
            $request->get('duration'),
            $request->get('prlv_day')
        );
    }
}
