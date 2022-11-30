<?php

namespace App\Http\Controllers;

use App\Models\Customer\Customer;
use App\Models\Customer\CustomerConnector;
use App\Services\Powens\Powens;
use Illuminate\Http\Request;

class PowensController extends Controller
{


    public function webview()
    {
        return redirect()->to("https://fintech-sandbox.biapi.pro/2.0/auth/webview/connect?client_id=14116510&redirect_uri=https://v2.fintech.ovh/powens/webview/success");
    }

    public function success(Request $request)
    {
        $powens = new Powens();
        $access_token = $powens->getClientAccessToken($request->get('code'));
        $connector = Customer::find(auth()->user()->customers->id)->connector()->create([
            'connection_id' => $request->get('connection_id'),
            'auth_code' => $request->get('code'),
            'auth_token' => $access_token->access_token
        ]);
    }
}
