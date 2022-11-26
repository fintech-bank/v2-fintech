<?php

namespace App\Http\Controllers\Api\Epargne;

use App\Helper\CustomerTransactionHelper;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerCheckDeposit;
use App\Models\Customer\CustomerEpargne;
use App\Models\Customer\CustomerMoneyDeposit;
use Illuminate\Http\Request;

class DepositController extends ApiController
{
    public function store($reference_epargne, Request $request)
    {
        $epargne = CustomerEpargne::where('reference', $reference_epargne)->first();

        return match ($request->get('type_deposit')) {
            "money" => $this->depositMoney($epargne, $request),
            "check" => $this->depositCheck($epargne, $request)
        };
    }

    private function depositMoney(CustomerEpargne $epargne, Request $request)
    {
        $deposit = CustomerMoneyDeposit::create([
            'reference' => generateReference(),
            'amount' => $request->get('amount_money'),
            'status' => 'terminated',
            'code' => base64_encode(0000),
            'customer_wallet_id' => $epargne->wallet->id,
            'customer_withdraw_dab_id' => 1
        ]);

        $transaction = CustomerTransactionHelper::createCredit(
            $epargne->wallet->id,
            'depot',
            "Dépot d'espèce en Agence",
            "Dépot {$deposit->reference} | {$deposit->created_at->format('d/m H:i')}",
            $deposit->amount,
            true,
            now()
        );

        $deposit->update(['customer_transaction_id' => $transaction->id]);

        return $this->sendSuccess(null, [$deposit]);
    }

    private function depositCheck(CustomerEpargne $epargne, Request $request)
    {
        $lists = collect();

        for ($i=0; $i <= 10; $i++) {
            if($request->get('number')[$i] != null) {
                $lists->push([
                    'number' => $request->get('number')[$i],
                    'amount' => $request->get('amount')[$i],
                    'date_deposit' => $request->get('date_deposit')[$i],
                    'name_deposit' => $request->get('name_deposit')[$i],
                    'bank_deposit' => $request->get('bank_deposit')[$i],
                    'verified' => $request->has('verified'),
                ]);
            }
        }

        $deposit = CustomerCheckDeposit::create([
            'reference' => generateReference(),
            'amount' => $request->get('amount_check'),
            'state' => 'terminated',
            'customer_wallet_id' => $epargne->wallet->id,
        ]);

        foreach ((object) $lists as $list) {
            $deposit->lists()->create([
                'number' => $list['number'],
                'amount' => $list['amount'],
                'date_deposit' => $list['date_deposit'],
                'name_deposit' => $list['name_deposit'],
                'bank_deposit' => $list['bank_deposit'],
                'verified' => $list['verified'],
                'customer_check_deposit_id' => $deposit->id,

            ]);
        }

        $transaction = CustomerTransactionHelper::createCredit(
            $epargne->wallet->id,
            'depot',
            "Dépot de {$lists->count()} chèques en Agence",
            "Dépot {$deposit->reference} | {$deposit->created_at->format('d/m H:i')}",
            $deposit->amount,
            true,
            now()
        );

        $deposit->update(['customer_transaction_id' => $transaction->id]);

        return $this->sendSuccess(null, [$deposit]);
    }
}
