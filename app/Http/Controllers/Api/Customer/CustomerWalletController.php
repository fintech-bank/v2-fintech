<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerWallet;
use App\Notifications\Customer\UpdateStatusWalletNotification;
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
            "check_deposit" => "",
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
}
