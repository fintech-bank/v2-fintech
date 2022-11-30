<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PowensController extends Controller
{
    public function webview()
    {
        return redirect()->to("https://fintech-sandbox.biapi.pro/2.0/auth/webview/connect?client_id=14116510&redirect_uri=https://v2.fintech.ovh/powens/webview/success");
    }

    public function success(Request $request)
    {
        dd($request->all());
    }
}
