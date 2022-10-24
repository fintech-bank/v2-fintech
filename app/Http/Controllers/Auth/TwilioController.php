<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Twilio\Verify;
use Illuminate\Http\Request;

class TwilioController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }


    public function verifyView()
    {
        return view('auths.auth.verify');
    }

    public function verify(Request $request)
    {
        $twilio = new Verify();

        return $twilio->verify($request);
    }


}
