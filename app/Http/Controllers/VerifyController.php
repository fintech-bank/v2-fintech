<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\ApiController;
use App\Models\Customer\Customer;
use App\Models\User;
use Illuminate\Http\Request;

class VerifyController extends ApiController
{
    public function mail(Request $request)
    {
        $email = decrypt($request->get('token'));
        $user = User::where('email', $email)->first();

        if(isset($user)) {
            return redirect()->route('verify-success')
                ->with('sector', 'email');
        } else {
            return redirect()->route('verify-error')
                ->with('sector', 'email');
        }
    }

    public function identity(Request $request)
    {
        $email = decrypt($request->get('token'));
        $user = User::where('email', $email)->first();

        if(isset($user)) {
            return view('front.verify.identity', [
                'customer' => $user->customers
            ]);
        } else {
            return redirect()->route('verify-error')
                ->with('sector', 'identity');
        }
    }

    public function address(Request $request)
    {
        $email = decrypt($request->get('token'));
        $user = User::where('email', $email)->first();

        if(isset($user)) {
            return view('front.verify.address', [
                'customer' => $user->customers
            ]);
        } else {
            return redirect()->route('verify-error')
                ->with('sector', 'address');
        }
    }

    public function income(Request $request)
    {
        $email = decrypt($request->get('token'));
        $user = User::where('email', $email)->first();

        if(isset($user)) {
            return view('front.verify.income', [
                'customer' => $user->customers
            ]);
        } else {
            return redirect()->route('verify-error')
                ->with('sector', 'income');
        }
    }

    public function other(Request $request)
    {
        $email = base64_decode($request->get('token'));
        $user = User::where('email', $email)->first();

        if(isset($user)) {
            return view('front.verify.other', [
                'customer' => $user->customer,
                'action' => $request->get('action')
            ]);
        } else {
            return redirect()->route('verify-error')
                ->with('sector', 'other')
                ->with('action', $request->get('action'));
        }
    }

    public function success(Request $request)
    {
        $sector = $request->get('sector');
        $customer = Customer::find($request->get('customer_id'));

        if($sector == 'identity') {
            $customer->info->update([
                'isVerified' => true
            ]);
        } elseif ($sector == 'address') {
            $customer->info->update([
                'addressVerified' => true
            ]);
        } else {
            $customer->info->update([
                'incomeVerified' => true
            ]);
        }

        return view('front.verify.success', compact('sector'));
    }
}
