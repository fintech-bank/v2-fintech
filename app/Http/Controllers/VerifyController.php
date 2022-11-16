<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\ApiController;
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
        }
    }
}
