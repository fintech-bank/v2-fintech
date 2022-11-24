<?php

namespace App\Helper;

use App\Models\Customer\CustomerWallet;
use App\Notifications\Customer\NewWalletNotification;
use App\Notifications\Customer\SendLinkForContractNotification;
use App\Notifications\Customer\SendRequestNotification;
use Faker\Factory;
use IbanGenerator\Generator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CustomerWalletHelper
{
    /**
     * Création d'un compte
     *
     * @param  Model  $customer
     * @param  string  $type
     * @param  int  $balance_actual
     * @param  int  $balance_coming
     * @param  int  $decouvert
     * @param  int  $bal_decouvert
     * @param  string  $status
     * @return Builder|Model
     */
    public static function createWallet($customer, $type, $balance_actual = 0, $balance_coming = 0, $decouvert = 0, $bal_decouvert = 0, $status = 'pending'): Model|Builder
    {
        $number_account = random_numeric(9);
        $ibanG = new Generator($customer->agency->code_banque, $number_account, 'FR');
        $faker = Factory::create('fr_FR');
        $iban = $faker->iban('FR');
        $number_account = Str::substr($iban, 4, 9);
        $key = Str::substr($iban, 14, 2);

        $wallet = CustomerWallet::create([
            'uuid' => \Str::uuid(),
            'number_account' => $number_account,
            'iban' => $iban,
            'rib_key' => $key,
            'type' => $type,
            'status' => $status,
            'balance_actual' => $balance_actual,
            'balance_coming' => $balance_coming,
            'decouvert' => $decouvert,
            'balance_decouvert' => $bal_decouvert,
            'customer_id' => $customer->id,
        ]);



        if($wallet->type == 'compte') {
            if ($customer->info->type != 'part') {
                $doc_compte = DocumentFile::createDoc(
                    $customer,
                    'customer.convention_compte_pro',
                    'Convention de compte bancaire Professionnel',
                    3,
                    generateReference(),
                    true,
                    true,
                    false,
                    true,
                    ['wallet' => $wallet]
                );
            } else {
                $doc_compte = DocumentFile::createDoc(
                    $customer,
                    'customer.convention_compte',
                    'Convention de compte bancaire',
                    3,
                    generateReference(),
                    true,
                    true,
                    false,
                    true,
                    ['wallet' => $wallet]
                );
            }

            $docs = ["url" => public_path("/storage/gdd/{$customer->user->id}/documents/{$doc_compte->category->name}/{$doc_compte->name}.pdf")];
            $request = $customer->requests()->create([
                "reference" => generateReference(),
                "sujet" => "Signature d'un document",
                "commentaire" => "<p>Veuillez effectuer la signature du document suivant : ".$doc_compte->name."</p><br><a href='".route('signate.show', base64_encode($doc_compte->id))."' class='btn btn-circle btn-primary'>Signer le document</a>",
                "link_model" => CustomerWallet::class,
                "link_id" => $wallet->id,
                "customer_id" => $customer->id
            ]);
            $customer->info->notify(new SendRequestNotification($customer, $request));
            //Notification de création de compte
            $customer->info->notify(new NewWalletNotification($customer, $wallet));
        }

        return $wallet;
    }


}
