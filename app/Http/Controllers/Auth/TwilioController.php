<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use App\Models\User;
use App\Services\Authy\AuthyService;
use App\Services\Twilio\Verify;
use Illuminate\Http\Request;

class TwilioController extends Controller
{
    private AuthyService $authy;

    /**
     * @param AuthyService $authy
     */
    public function __construct(AuthyService $authy)
    {
        $this->middleware('guest');
        $this->authy = $authy;
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

    public function register()
    {
        $customer = Customer::find(\request()->get('customer_id'));
        $authy_id = $this->authy->register($customer->user->email, $customer->info->mobile, $customer->info->country);
        $customer->user->updateAuthyId($authy_id);

        if($this->authy->verifyUserStatus($authy_id)->registered) {
            $message = "Ouvrez l'application Authy sur votre téléphone pour voir le code de vérification";
        } else {
            $this->authy->sendToken($authy_id);
            $message = "Vous recevrez un SMS avec le code de vérification";
        }

        return response()->json([
            'url' => route('auth.verify.view'),
            'message' => $message
        ]);
    }


}
