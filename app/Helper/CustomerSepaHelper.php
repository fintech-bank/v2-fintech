<?php

namespace App\Helper;

use App\Models\Customer\CustomerSepa;
use Illuminate\Support\Str;

class CustomerSepaHelper
{
    public static function getStatus($status, $labeled = true)
    {
        if ($labeled == false) {
            switch ($status) {
                case 'waiting': return 'En Attente';
                    break;
                case 'processed': return 'Traité';
                    break;
                case 'rejected': return 'Rejeté';
                    break;
                case 'return': return 'Retourné';
                    break;
                case 'refunded': return 'Remboursé';
                    break;
                default: return null;
            }
        } else {
            switch ($status) {
                case 'waiting': return '<span class="badge badge-pill rounded badge-warning">En Attente</span>';
                    break;
                case 'processed': return '<span class="badge badge-pill rounded badge-success">Traité</span>';
                    break;
                case 'rejected': return '<span class="badge badge-pill rounded badge-info">Rejeté</span>';
                    break;
                case 'return': return '<span class="badge badge-pill rounded badge-danger">Retourné</span>';
                    break;
                case 'refunded': return '<span class="badge badge-pill rounded badge-primary">Remboursé</span>';
                    break;
                default: return null;
            }
        }
    }

    public static function generateMandate()
    {
        return "00000/".now()->format('dmY')."/".random_numeric(6);
    }

    public static function createPrlv($amount, $wallet, $designation, $date_prlv)
    {
        $mandate = self::generateMandate();

        $transaction = CustomerTransactionHelper::create(
            'debit',
            'sepa',
            'PRLV EUROPE '.$mandate,
            $amount,
            $wallet->id,
            false,
            $designation,
            null,
            $date_prlv,
        );

        CustomerSepa::create([
            'uuid' => Str::uuid(),
            'creditor' => "FINTECH ASSURANCE",
            'number_mandate' => self::generateMandate(),
            'amount' => $amount,
            'status' => 'waiting',
            'transaction_id' => $transaction->id,
            'customer_wallet_id' => $wallet->id
        ]);
    }
}
