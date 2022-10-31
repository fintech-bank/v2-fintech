<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Notifications\Customer\SendVerificationLinkNotification;
use App\Services\Persona;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
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

    public function verifyCustomer(Request $request, Persona $persona)
    {
        $customer = Customer::find($request->get('customer_id'));
        $link = $persona->verificationLink($customer);

        $customer->info->notify(new SendVerificationLinkNotification($customer, $link));

        return response()->json();
    }

    public function verifyDomicile(Request $request, Persona $persona)
    {
        $customer = Customer::find($request->get('customer_id'));
        $link = $persona->verificationLink($customer,'domicile');

        $customer->info->notify(new SendVerificationLinkNotification($customer, $link));

        return response()->json();
    }

    public function verifyRevenue(Request $request, Persona $persona)
    {
        $customer = Customer::find($request->get('customer_id'));
        $link = $persona->verificationLink($customer, 'revenue');

        $customer->info->notify(new SendVerificationLinkNotification($customer, $link));

        return response()->json();
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
}
