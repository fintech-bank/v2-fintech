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
use App\Models\Customer\CustomerPretCaution;
use App\Models\Customer\CustomerWallet;
use App\Notifications\Customer\Ficap\NewCautionFicapNotification;
use App\Notifications\Customer\NewCautionNotification;
use App\Notifications\Customer\NewEpargneNotification;
use App\Notifications\Customer\NewPretNotification;
use App\Notifications\Customer\NewPretNotificationP;
use App\Notifications\Customer\NewWalletNotification;
use App\Notifications\Customer\SendLinkForContractNotification;
use Carbon\Carbon;
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

    public function caution($number_account)
    {
        $wallet = CustomerWallet::where('number_account', $number_account)->first();

        return view('agent.customer.wallet.pret.caution', ["wallet" => $wallet]);
    }

    public function postCaution($number_account, Request $request)
    {
        //dd($request->all());
        $wallet = CustomerWallet::where('number_account', $number_account)->first();

        $caution = CustomerPretCaution::create([
            'type_caution' => $request->get('type_caution'),
            'type' => $request->get('type'),
            'civility' => $request->get('civility'),
            'firstname' => $request->get('firstname'),
            'lastname' => $request->get('lastname'),
            'company' => $request->get('company'),
            'ficap' => $request->has('ficap'),
            'address' => $request->get('address'),
            'postal' => $request->get('postal'),
            'city' => $request->get('city'),
            'country' => $request->get('country'),
            'phone' => $request->get('phone'),
            'email' => $request->get('email'),
            'password' => null,
            'num_cni' => $request->get('num_cni'),
            'date_naissance' => $request->get('date_naissance') != null ? $request->get('date_naissance') : null,
            'country_naissance' => $request->get('country_naissance'),
            'dep_naissance' => $request->get('dep_naissance'),
            'ville_naissance' => $request->get('city_naissance'),
            'persona_reference_id' => 'caution_'.$request->get('type').'_'.now()->format('dmY'),
            'type_structure' => $request->get('type_structure'),
            'siret' => $request->get('siret'),
            'customer_pret_id' => $wallet->loan->id
        ]);

        if($caution->ficap) {
            $password = \Str::random(8);

            $caution->update([
                'password' => \Hash::make($password)
            ]);

            try {
                \Notification::route('mail', $caution->email)
                    ->notify(new NewCautionFicapNotification($caution, $password));
            }catch (\Exception $exception) {
                LogHelper::notify('critical', $exception->getMessage());
            }
        }

        if($caution->type_caution == 'simple') {
            $doc_caution = DocumentFile::createDoc(
                $wallet->customer,
                'loan.caution_simple',
                $wallet->name_account_generic." - Caution Simple",
                3,
                $wallet->loan->reference,
                false,
                false,
                false,
                true,
                ['caution' => $caution],
                'simple'
            );
        } else {
            $doc_caution = DocumentFile::createDoc(
                $wallet->customer,
                'loan.caution_solidaire',
                $wallet->name_account_generic." - Caution Solidaire",
                3,
                $wallet->loan->reference,
                false,
                false,
                false,
                true,
                ['caution' => $caution],
                'simple'
            );
        }

        $wallet->customer->info->notify(new NewCautionNotification($wallet->customer, $caution));

        return redirect()->route('agent.customer.wallet.show', $wallet->number_account)->with('success', "Le cautionnaire à été ajouté avec succès");
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
