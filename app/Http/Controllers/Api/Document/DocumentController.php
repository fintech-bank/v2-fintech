<?php

namespace App\Http\Controllers\Api\Document;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerDocument;
use App\Models\Customer\CustomerPretCaution;
use App\Notifications\Customer\SendCodeSignApiNotification;
use Illuminate\Http\Request;

class DocumentController extends ApiController
{
    /**
     * Dans la requète donnée encrypt ref_doc/num_phone/sector ex: caution/client/transaction/transfer/auth
     * @param Request $request
     * @return void
     */
    public function request(Request $request)
    {
        $string = base64_decode($request->get('token'));
        $tab = explode('/', $string);

        return match ($tab[2]) {
            "caution" => $this->codeCaution($tab[1]),
            "client" => ''
        };
    }

    /**
     * Dans la requète donnée encrypt ref_doc/num_phone/sector/code ex: caution/client/transaction/transfer/auth
     * @param Request $request
     * @return mixed
     */
    public function verify(Request $request)
    {
        $string = base64_decode($request->get('token'));
        $tab = explode('/', $string);

        return match ($tab[2]) {
            "caution" => $this->verifyCaution($tab[1], $tab[3])
        };
    }

    private function codeCaution($num_phone)
    {
        $code = base64_encode(random_numeric(6));
        $caution = CustomerPretCaution::where('phone', $num_phone)->first();
        if(isset($caution)) {
            $caution->update([
                'code_sign' => base64_encode($code)
            ]);

            $caution->notify(new SendCodeSignApiNotification(base64_decode($code)));

            return $this->sendSuccess();
        }else {
            return $this->sendWarning("Caution inconnu");
        }
    }

    private function verifyCaution($num_phone, $code)
    {
        $caution = CustomerPretCaution::where('phone', $num_phone)->first();
        dd($caution->code_sign, base64_encode($code));

        if(base64_decode($caution->code_sign) == $code) {
            $caution->update([
                'code_sign' => null,
                'status' => 'process',
                'sign_caution' => true,
                'signed_at' => now(),
            ]);

            return $this->sendSuccess();
        } else {
            return $this->sendWarning("Code Invalide");
        }
    }
}
