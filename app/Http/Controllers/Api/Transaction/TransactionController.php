<?php

namespace App\Http\Controllers\Api\Transaction;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerTransaction;
use Illuminate\Http\Request;

class TransactionController extends ApiController
{
    public function search(Request $request)
    {
        $data = collect();

        $duration = match ($request->get('duration')) {
            "mensuel" => collect(['start' => now()->startOfMonth(), 'end' => now()->endOfMonth()])->toArray(),
            'trimestriel' => collect(['start' => now()->subMonths(3)->startOfMonth(), "end" => now()->endOfMonth()])->toArray(),
            'semestriel' => collect(['start' => now()->subMonths(6)->startOfMonth(), 'end' => now()->endOfMonth()])->toArray()
        };

        $search = CustomerTransaction::where('customer_wallet_id', $request->get('wallet_id'))
            ->whereBetween('confirmed_at', [$duration['start'], $duration['end']])
            ->where('designation', 'LIKE', '%'.$request->get('search').'%')
            ->orWhere('description', 'LIKE', '%'.$request->get('search').'%');

        $data->push([
            'count' => $search->count(),
            'data' => $search->get()
        ])->toArray();

        return $this->sendSuccess(null, [$data]);
    }
}
