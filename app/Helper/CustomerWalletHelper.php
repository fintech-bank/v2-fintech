<?php

namespace App\Helper;

use App\Models\Customer\CustomerWallet;
use IbanGenerator\Generator;
use Illuminate\Support\Str;

class CustomerWalletHelper
{
    /**
     * Création d'un compte
     *
     * @param  \Illuminate\Database\Eloquent\Model  $customer
     * @param  string  $type
     * @param  int  $balance_actual
     * @param  int  $balance_coming
     * @param  int  $decouvert
     * @param  int  $bal_decouvert
     * @param  string  $status
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public static function createWallet($customer, $type, $balance_actual = 0, $balance_coming = 0, $decouvert = 0, $bal_decouvert = 0, $status = 'pending')
    {
        $number_account = random_numeric(9);
        $ibanG = new Generator($customer->user->agency->code_banque, $number_account);

        $wallet = CustomerWallet::query()->create([
            'uuid' => \Str::uuid(),
            'number_account' => $number_account,
            'iban' => $ibanG->generate($customer->user->agency->code_banque, $number_account, 'FR'),
            'rib_key' => $ibanG->getBban($customer->user->agency->code_banque, $number_account),
            'type' => $type,
            'status' => $status,
            'balance_actual' => $balance_actual,
            'balance_coming' => $balance_coming,
            'decouvert' => $decouvert,
            'balance_decouvert' => $bal_decouvert,
            'customer_id' => $customer->id,
        ]);

        $docs = [];
        $docs[] = DocumentFile::createDoc(
            $customer,
            'convention compte',
            'Convention de compte',
            3,
            Str::upper(Str::random(6)),
            true,
            true,
            true,
            true,
            ["wallet" => $wallet]
        );

        return $wallet;
    }


}
