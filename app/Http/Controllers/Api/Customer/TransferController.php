<?php

namespace App\Http\Controllers\Api\Customer;

use App\Helper\CustomerTransactionHelper;
use App\Helper\CustomerTransferHelper;
use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerBeneficiaire;
use App\Models\Customer\CustomerWallet;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function store($customer_id, $number_account, Request $request)
    {
        $request->validate([
            'customer_beneficiaire_id' => "required",
            'amount' => "required|numeric",
            'type' => "required",
        ]);

        $date_perm = $request->get('type') == 'permanent' ? explode(',', $request->get('permanent_date')) : null;
        $wallet = CustomerWallet::where('number_account', $number_account)->first();
        $beneficiaire = CustomerBeneficiaire::find($request->get('customer_beneficiaire_id'));

        if($wallet->status != 'active') {
            return response()->json(null, 401);
        } else {
            return match ($request->get('type')) {
                "immediat" => $this->immediatTransfer($wallet, $beneficiaire, $request),
                "differed" => $this->differedTransfer($wallet, $beneficiaire, $request),
                "permanent" => $this->permanentTransfer($wallet, $beneficiaire, $request, $date_perm),
            };
        }
    }

    private function immediatTransfer(CustomerWallet $wallet,CustomerBeneficiaire $beneficiaire, Request $request)
    {
        if($wallet->solde_remaining <= 0) {
            $transfer = $wallet->transfers()->create([
                'uuid' => \Str::uuid(),
                'amount' => $request->get('amount'),
                'reference' => $request->get('reference') != null ? $request->get('reference') : generateReference(),
                'reason' => $request->get('reason') != null ? $request->get('reason') : "Virement vers le compte ".CustomerTransferHelper::getNameBeneficiaire($beneficiaire),
                'type' => 'immediat',
                'transfer_date' => now(),
                'status' => 'pending',
                'customer_wallet_id' => $wallet->id,
                'customer_beneficiaire_id' => $beneficiaire->id
            ]);
        } else {
            if($request->get('access') == 'classic') {
                $transfer = $wallet->transfers()->create([
                    'uuid' => \Str::uuid(),
                    'amount' => $request->get('amount'),
                    'reference' => $request->get('reference') != null ? $request->get('reference') : generateReference(),
                    'reason' => $request->get('reason') != null ? $request->get('reason') : "Virement vers le compte ".CustomerTransferHelper::getNameBeneficiaire($beneficiaire),
                    'type' => 'immediat',
                    'transfer_date' => now(),
                    'status' => 'in_transit',
                    'customer_wallet_id' => $wallet->id,
                    'customer_beneficiaire_id' => $beneficiaire->id
                ]);
            } else {
                $transfer = $wallet->transfers()->create([
                    'uuid' => \Str::uuid(),
                    'amount' => $request->get('amount'),
                    'reference' => $request->get('reference') != null ? $request->get('reference') : generateReference(),
                    'reason' => $request->get('reason') != null ? $request->get('reason') : "Virement vers le compte ".CustomerTransferHelper::getNameBeneficiaire($beneficiaire),
                    'type' => 'immediat',
                    'transfer_date' => now(),
                    'status' => 'paid',
                    'customer_wallet_id' => $wallet->id,
                    'customer_beneficiaire_id' => $beneficiaire->id
                ]);

                CustomerTransactionHelper::create(
                    'debit',
                    'frais',
                    'Frais virement instantané',
                    0.80,
                    $wallet->id,
                    true,
                    $transfer->reason,
                    now()
                );
            }
        }

        $transaction = CustomerTransactionHelper::create(
            'debit',
            'virement',
            $transfer->reason,
            $transfer->amount,
            $wallet->id,
            false,
            'Virement emis pour: '.CustomerTransferHelper::getNameBeneficiaire($beneficiaire)." chez: ".$transfer->beneficiaire->bic,
            null,
            now()
        );

        $transfer->update([
            'transaction_id' => $transaction->id
        ]);

        return response()->json();
    }

    private function differedTransfer(CustomerWallet $wallet,CustomerBeneficiaire $beneficiaire, Request $request)
    {
        if($wallet->solde_remaining <= 0) {
            $transfer = $wallet->transfers()->create([
                'uuid' => \Str::uuid(),
                'amount' => $request->get('amount'),
                'reference' => $request->get('reference') != null ? $request->get('reference') : generateReference(),
                'reason' => $request->get('reason') != null ? $request->get('reason') : "Virement vers le compte ".CustomerTransferHelper::getNameBeneficiaire($beneficiaire),
                'type' => 'differed',
                'transfer_date' => Carbon::parse($request->get('transfer_date')),
                'status' => 'pending',
                'customer_wallet_id' => $wallet->id,
                'customer_beneficiaire_id' => $beneficiaire->id
            ]);
        } else {
            $transfer = $wallet->transfers()->create([
                'uuid' => \Str::uuid(),
                'amount' => $request->get('amount'),
                'reference' => $request->get('reference') != null ? $request->get('reference') : generateReference(),
                'reason' => $request->get('reason') != null ? $request->get('reason') : "Virement vers le compte ".CustomerTransferHelper::getNameBeneficiaire($beneficiaire),
                'type' => 'differed',
                'transfer_date' => Carbon::parse($request->get('transfer_date')),
                'status' => 'in_transit',
                'customer_wallet_id' => $wallet->id,
                'customer_beneficiaire_id' => $beneficiaire->id
            ]);
        }

        $transaction = CustomerTransactionHelper::create(
            'debit',
            'virement',
            $transfer->reason,
            $transfer->amount,
            $wallet->id,
            false,
            'Virement emis pour: '.CustomerTransferHelper::getNameBeneficiaire($beneficiaire)." chez: ".$transfer->beneficiaire->bic,
            null,
            $transfer->transfer_date
        );

        $transfer->update([
            'transaction_id' => $transaction->id
        ]);

        return response()->json();
    }

    private function permanentTransfer(CustomerWallet $wallet,CustomerBeneficiaire $beneficiaire, Request $request, $date)
    {
        $transfer = $wallet->transfers()->create([
            'uuid' => \Str::uuid(),
            'amount' => $request->get('amount'),
            'reference' => $request->get('reference') != null ? $request->get('reference') : generateReference(),
            'reason' => $request->get('reason') != null ? $request->get('reason') : "Virement vers le compte ".CustomerTransferHelper::getNameBeneficiaire($beneficiaire),
            'type' => 'permanent',
            'recurring_start' => Carbon::parse($date[0]),
            'recurring_end' => Carbon::parse($date[1]),
            'status' => 'pending',
            'customer_wallet_id' => $wallet->id,
            'customer_beneficiaire_id' => $beneficiaire->id
        ]);

        return response()->json();
    }
}
