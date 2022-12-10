<?php

namespace App\Http\Controllers\Api\Customer;

use App\Helper\CustomerTransactionHelper;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerWallet;
use App\Notifications\Agent\NewCheckDepositNotification;
use App\Notifications\Customer\UpdateStatusWalletNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CustomerWalletController extends ApiController
{
    public function info($customer_id, $number_account)
    {
        $wallet = CustomerWallet::where('number_account', $number_account)->first();

        return response()->json($wallet);
    }

    public function update($customer_id, $number_account, Request $request)
    {
        return match ($request->get('action')) {
            "state" => $this->updateStateWallet($number_account, $request)
        };
    }

    public function chartSummary($customer_id, $number_account)
    {
        $wallet = CustomerWallet::with('transactions')->where('number_account', $number_account)->first();
        $debit[] = [
            $wallet->transactions()->where('amount', '<=', 0)->whereBetween('created_at', [now()->year.'-01-01 00:00:00', now()->year.'-01-31 00:00:00'])->sum('amount'),
            $wallet->transactions()->where('amount', '<=', 0)->whereBetween('created_at', [now()->year.'-02-01 00:00:00', now()->year.'-02-28 00:00:00'])->sum('amount'),
            $wallet->transactions()->where('amount', '<=', 0)->whereBetween('created_at', [now()->year.'-03-01 00:00:00', now()->year.'-03-31 00:00:00'])->sum('amount'),
            $wallet->transactions()->where('amount', '<=', 0)->whereBetween('created_at', [now()->year.'-04-01 00:00:00', now()->year.'-04-31 00:00:00'])->sum('amount'),
            $wallet->transactions()->where('amount', '<=', 0)->whereBetween('created_at', [now()->year.'-05-01 00:00:00', now()->year.'-05-31 00:00:00'])->sum('amount'),
            $wallet->transactions()->where('amount', '<=', 0)->whereBetween('created_at', [now()->year.'-06-01 00:00:00', now()->year.'-06-31 00:00:00'])->sum('amount'),
            $wallet->transactions()->where('amount', '<=', 0)->whereBetween('created_at', [now()->year.'-07-01 00:00:00', now()->year.'-07-31 00:00:00'])->sum('amount'),
            $wallet->transactions()->where('amount', '<=', 0)->whereBetween('created_at', [now()->year.'-08-01 00:00:00', now()->year.'-08-31 00:00:00'])->sum('amount'),
            $wallet->transactions()->where('amount', '<=', 0)->whereBetween('created_at', [now()->year.'-09-01 00:00:00', now()->year.'-09-31 00:00:00'])->sum('amount'),
            $wallet->transactions()->where('amount', '<=', 0)->whereBetween('created_at', [now()->year.'-10-01 00:00:00', now()->year.'-10-31 00:00:00'])->sum('amount'),
            $wallet->transactions()->where('amount', '<=', 0)->whereBetween('created_at', [now()->year.'-11-01 00:00:00', now()->year.'-11-31 00:00:00'])->sum('amount'),
            $wallet->transactions()->where('amount', '<=', 0)->whereBetween('created_at', [now()->year.'-12-01 00:00:00', now()->year.'-12-31 00:00:00'])->sum('amount'),
        ];

        $credit[] = [
            $wallet->transactions()->where('amount', '>', 0)->whereBetween('created_at', [now()->year.'-01-01 00:00:00', now()->year.'-01-31 00:00:00'])->sum('amount'),
            $wallet->transactions()->where('amount', '>', 0)->whereBetween('created_at', [now()->year.'-02-01 00:00:00', now()->year.'-02-28 00:00:00'])->sum('amount'),
            $wallet->transactions()->where('amount', '>', 0)->whereBetween('created_at', [now()->year.'-03-01 00:00:00', now()->year.'-03-31 00:00:00'])->sum('amount'),
            $wallet->transactions()->where('amount', '>', 0)->whereBetween('created_at', [now()->year.'-04-01 00:00:00', now()->year.'-04-31 00:00:00'])->sum('amount'),
            $wallet->transactions()->where('amount', '>', 0)->whereBetween('created_at', [now()->year.'-05-01 00:00:00', now()->year.'-05-31 00:00:00'])->sum('amount'),
            $wallet->transactions()->where('amount', '>', 0)->whereBetween('created_at', [now()->year.'-06-01 00:00:00', now()->year.'-06-31 00:00:00'])->sum('amount'),
            $wallet->transactions()->where('amount', '>', 0)->whereBetween('created_at', [now()->year.'-07-01 00:00:00', now()->year.'-07-31 00:00:00'])->sum('amount'),
            $wallet->transactions()->where('amount', '>', 0)->whereBetween('created_at', [now()->year.'-08-01 00:00:00', now()->year.'-08-31 00:00:00'])->sum('amount'),
            $wallet->transactions()->where('amount', '>', 0)->whereBetween('created_at', [now()->year.'-09-01 00:00:00', now()->year.'-09-31 00:00:00'])->sum('amount'),
            $wallet->transactions()->where('amount', '>', 0)->whereBetween('created_at', [now()->year.'-10-01 00:00:00', now()->year.'-10-31 00:00:00'])->sum('amount'),
            $wallet->transactions()->where('amount', '>', 0)->whereBetween('created_at', [now()->year.'-11-01 00:00:00', now()->year.'-11-31 00:00:00'])->sum('amount'),
            $wallet->transactions()->where('amount', '>', 0)->whereBetween('created_at', [now()->year.'-12-01 00:00:00', now()->year.'-12-31 00:00:00'])->sum('amount'),
        ];

        $decouvert[] = [
            '-'.$wallet->balance_decouvert,
            '-'.$wallet->balance_decouvert,
            '-'.$wallet->balance_decouvert,
            '-'.$wallet->balance_decouvert,
            '-'.$wallet->balance_decouvert,
            '-'.$wallet->balance_decouvert,
            '-'.$wallet->balance_decouvert,
            '-'.$wallet->balance_decouvert,
            '-'.$wallet->balance_decouvert,
            '-'.$wallet->balance_decouvert,
            '-'.$wallet->balance_decouvert,
            '-'.$wallet->balance_decouvert,
        ];

        return response()->json([
            'debit' => $debit,
            'credit' => $credit,
            'decouvert' => $decouvert,
        ]);
    }

    public function requestOverdraft($customer_id, $number_account, Request $request)
    {
        $wallet = CustomerWallet::where('number_account', $number_account)->first();

        $result = $wallet->requestOverdraft();
        return response()->json($result);
    }

    public function storeWallet($customer_id, $number_account, Request $request)
    {
        $wallet = CustomerWallet::where('number_account', $number_account)->first();

        return match ($request->get('action')) {
            "check_deposit" => $this->checkDeposit($wallet, $request),
        };
    }

    private function updateStateWallet($number_account, Request $request)
    {
        $wallet = CustomerWallet::where('number_account', $number_account)->first();

        $wallet->update([
            'status' => $request->get('status')
        ]);

        $wallet->customer->info->notify(new UpdateStatusWalletNotification($wallet->customer, $wallet, "Comptes & Moyens de paiement"));

        return $this->sendSuccess();
    }

    private function checkDeposit(CustomerWallet $wallet, Request $request)
    {
        $deposit = $wallet->deposits()->create([
            'reference' => generateReference(),
            'amount' => 0,
            'state' => 'pending',
            'customer_wallet_id' => $wallet->id,
        ]);

        foreach ($request->get('chq_repeat') as $chq) {
            $deposit->lists()->create([
                'number' => $chq['number'],
                'amount' => $chq['amount'],
                'name_deposit' => $chq['name_deposit'],
                'bank_deposit' => $chq['bank_deposit'],
                'date_deposit' => Carbon::createFromTimestamp(strtotime($chq['date_deposit'])),
                'customer_check_deposit_id' => $deposit->id
            ]);

            $deposit->update([
                'amount' => $deposit->amount + $chq['amount']
            ]);
        }

        $transaction = CustomerTransactionHelper::createCredit(
            $deposit->wallet->id,
            'depot',
            'Remise de chèque',
            "Remise de {$deposit->lists()->count()} Chèques | Ref: {$deposit->reference}",
            $deposit->amount,
        );

        $deposit->update(["customer_transaction_id" => $transaction->id]);

        $deposit->wallet->customer->agent->agents->user->notify(new NewCheckDepositNotification($deposit));

        return redirect()->back()->with('success', "Votre remise de chèque N°{$deposit->reference} à été enregistré avec succès");
    }
}
