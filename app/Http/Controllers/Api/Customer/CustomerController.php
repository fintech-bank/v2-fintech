<?php

namespace App\Http\Controllers\Api\Customer;

use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Jobs\Customer\AlertCustomerJob;
use App\Mail\Customer\SendSignateDocumentRequestMail;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerDocument;
use App\Notifications\Customer\Sending\SendVerifyAddressCustomerLinkNotification;
use App\Notifications\Customer\Sending\SendVerifyIdentityCustomerLinkNotification;
use App\Notifications\Customer\Sending\SendVerifyIncomeCustomerLinkNotification;
use App\Scope\VerifCNITrait;
use App\Services\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class CustomerController extends Controller
{
    public function search(Request $request)
    {
        dd($request->all());
    }

    public function subscribe(Request $request)
    {
        return match ($request->get('action')) {
            'alerta' => $this->subscribeAlerta(),
            'dailyInsurance' => $this->subscribeDailyInsurance(),
            'dab' => $this->subscribeDab(),
            'overdraft' => $this->subscribeOverdraft($request->get('overdraft_amount')),
            'card_code' => $this->subscribeCardCode(),
            'offert' => $this->subscribeOffert(),
            default => null,
        };
    }

    public function signateDocument(Request $request)
    {
        $document = CustomerDocument::find($request->get('document_id'));
        $customer = $document->customer;

        Mail::to($customer->user)->send(new SendSignateDocumentRequestMail($customer, base64_encode($request->get('document_id'))));

        return response()->json($document);
    }

    public function verifySign(Request $request)
    {
        $document = CustomerDocument::find($request->get('document_id'));
        $document->update([
            'signed_by_client' => true
        ]);

        return response()->json();
    }

    public function verifSecure(Request $request, $code)
    {
        $customer = Customer::find($request->get('customer_id'));
        $code_customer = base64_decode($customer->auth_code);

        if ($code == $code_customer) {
            return response()->json();
        } else {
            return response()->json(['errors' => ['Le code SECURPASS est invalide']], 401);
        }
    }

    public function reinitPass($customer_id)
    {
        $password = \Str::random(8);
        $customer = Customer::find($customer_id);

        try {
            $customer->user->update([
                'password' => \Hash::make($password)
            ]);

            $customer->user->notify(new SendPasswordNotification($customer, $password));
        } catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage(), $exception);
            return response()->json($exception->getMessage(), 500);
        }

        return response()->json();
    }

    public function reinitCode($customer_id)
    {
        $code = random_numeric(4);
        $customer = Customer::find($customer_id);

        try {
            $customer->update([
                'auth_code' => base64_encode($code),
            ]);

            $customer->user->notify(new SendSecurePassCodeNotification($code));
        } catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage(), $exception);
            return response()->json($exception->getMessage(), 500);
        }
        return response()->json();
    }

    public function verifAllSolde($customer_id)
    {
        $customer = Customer::find($customer_id);
        $wallets = [];

        foreach ($customer->wallets as $wallet) {
            if ($wallet->balance_actual < 0 && $wallet->decouvert == 0) {
                $wallets[] = [
                    'compte' => $wallet->number_account,
                    'status' => 'outdated',
                ];
            } else {
                $wallets[] = [
                    'compte' => $wallet->number_account,
                    'status' => 'ok',
                ];
            }
        }

        return $wallets;
    }

    public function updateBusiness($customer_id, Request $request)
    {
        $customer = Customer::find($customer_id);
        if ($request->has('ca')) {
            $customer->business->result -= $customer->business->ca;
            $customer->business->result += $request->get('ca');

            $customer->business->result_finance -= $customer->business->apport_personnel;
            $customer->business->result_finance += $request->get('apport_personnel');
        } elseif ($request->has('achat')) {
            $customer->business->result += $customer->business->achat;
            $customer->business->result -= $request->get('achat');
        } elseif ($request->has('frais')) {
            $customer->business->result += $customer->business->frais;
            $customer->business->result -= $request->get('frais');
        }elseif ($request->has('salaire')) {
            $customer->business->result += $customer->business->salaire;
            $customer->business->result -= $request->get('salaire');
        }elseif ($request->has('impot')) {
            $customer->business->result += $customer->business->impot;
            $customer->business->result -= $request->get('impot');
        }elseif ($request->has('other_charge')) {
            $customer->business->result += $customer->business->other_charge;
            $customer->business->result -= $request->get('other_charge');
        }elseif ($request->has('other_product')) {
            $customer->business->result -= $customer->business->other_product;
            $customer->business->result += $request->get('other_product');

            $customer->business->result_finance -= $customer->business->apport_personnel;
            $customer->business->result_finance += $request->get('apport_personnel');
        }elseif ($request->has('apport_personnel')) {
            $customer->business->result_finance -= $customer->business->apport_personnel;
            $customer->business->result_finance += $request->get('apport_personnel');
        }elseif ($request->has('finance')) {
            $customer->business->result_finance -= $customer->business->finance;
            $customer->business->result_finance += $request->get('finance');
        }

        $customer->business->update($request->except('_token'));

        $calc = intval($customer->business->result_finance / ($customer->business->result + $customer->business->result_finance) * 100);
        if($calc <= 20) {
            $customer->business->update(['indicator' => false]);
        } else {
            $customer->business->update(['indicator' => true]);
        }

        return response()->json($customer);
    }

    public function alert($customer_id, Request $request)
    {
        match ($request->get('action')) {
            $request->get('action') => dispatch(new AlertCustomerJob($customer_id, $request->get('action'), now()->addMinute()))
        };

        return response()->json();
    }

    public function verify($customer_id, Request $request)
    {
        $customer = Customer::find($customer_id);
        switch ($request->get('verify')) {
            case 'identity':
                $customer->info->notify(new SendVerifyIdentityCustomerLinkNotification($customer));
                break;

            case 'address':
                $customer->info->notify(new SendVerifyAddressCustomerLinkNotification($customer));
                break;

            case 'income':
                $customer->info->notify(new SendVerifyIncomeCustomerLinkNotification($customer));
                break;

            case 'cni':
                $cn = $this->verifyCni(
                    $request->get('cni_number'),
                    $request->get('cni_version')
                );

                return response()->json($cn);

        }

        return response()->json();
    }

    public function endettement($customer_id)
    {
        $customer = Customer::find($customer_id);
        $income = $customer->income->pro_incoming;
        $charge = $customer->charge->rent + $customer->charge->credit + $customer->charge->divers + $customer->prets()->where('status', 'progress')->sum('mensuality');

        $reste_vivre = $customer->income->pro_incoming - $charge;
        $end = $charge / $income * 100;

        return response()->json([
            'reste' => $reste_vivre,
            'percent' => round($end,2),
            'income' => $income,
            'charge' => $charge
        ]);
    }

    public function gauge($customer_id)
    {
        $customer = Customer::find($customer_id);
        $setting = $customer->setting;

        return response()->json([

        ]);
    }

    private function subscribeAlerta()
    {
        session()->put('subscribe.alerta', true);
        return response()->json(['offer' => 'Alerta']);
    }

    private function subscribeDailyInsurance()
    {
        session()->put('subscribe.daily_insurance', true);
        return response()->json(['offer' => 'Mon Assurance au quotidien']);
    }

    private function subscribeDab()
    {
        session()->put('subscribe.dab', true);
        return response()->json(['offer' => 'Retrait DAB Illimité']);
    }

    private function subscribeOverdraft($amount)
    {
        session()->put('subscribe.overdraft', true);
        session()->put('subscribe.overdraft_amount', $amount);

        return response()->json(['offer' => 'Facilité de caisse']);
    }

    private function subscribeCardCode()
    {
        session()->put('subscribe.card_code', true);

        return response()->json(['offer' => 'Choisir son code secret']);
    }

    private function subscribeOffert()
    {
        session()->put('subscribe.offert', true);

        return response()->json(['offer' => "Offre de bienvenue"]);
    }

    private function verifyCni(string $cni, string $versionCNI = '1995')
    {
        $cni_array = explode(',', $cni);
        if($versionCNI == '1995') {
            return VerifCNITrait::version1992($cni_array[0], $cni_array[1]);
        } else {
            return VerifCNITrait::version2021($cni_array[0], $cni_array[1]);
        }

    }
}
