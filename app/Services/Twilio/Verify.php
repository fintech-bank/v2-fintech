<?php


namespace App\Services\Twilio;


use App\Helper\LogHelper;
use App\Models\Customer\CustomerInfo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Twilio\Exceptions\TwilioException;

class Verify extends Twilio
{

    public function create($phone)
    {
        try {
            $this->client->verify->v2->services($this->verify_sid)
                ->verifications
                ->create($phone, config('app.env') == 'local' ? 'whatsapp' : 'sms');
        } catch (TwilioException $e) {
            LogHelper::notify('critical', $e);
        }
    }

    public function verify(Request $request)
    {
        $request->validate([
            'verification_code' => ['required', 'numeric'],
            'phone' => ['required', 'string']
        ]);

        try {
            $verification = $this->client->verify->v2->services($this->verify_sid)
                ->verificationChecks
                ->create([
                    'to' => $request->get('phone'),
                    'code' => $request->get('verification_code')
                ]);
        } catch (TwilioException $e) {
            if($e->getCode() == '20404') {
                return redirect()->back()->with(['error' => "Session Expiré !"]);
            } else {
                LogHelper::notify('critical', $e);
                return redirect()->back()->with(['error' => "Erreur lors de la vérification !"]);
            }
        }

        dd($verification);

        if($verification->status == 'approved') {
            $user = CustomerInfo::where('mobile', $request->get('phone'));
            $user->first()->update([
                'isVerified' => true
            ]);
            Auth::login($user->first()->customer->user);

            return redirect()->route('part.home')->with(['success' => "Le numéro de téléphone à été vérifié"]);
        }

        return redirect()->back()->with(['error' => "Le code de vérification entré est invalide !"]);
    }

}
