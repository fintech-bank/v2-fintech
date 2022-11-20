<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Core\LoanPlan;
use App\Models\Customer\Customer;
use App\Models\Customer\CustomerPret;
use App\Notifications\Customer\UpdateStatusPretNotification;
use App\Scope\CalcLoanTrait;
use App\Scope\VerifCompatibilityBeforeLoanTrait;
use Illuminate\Http\Request;

class PretController extends ApiController
{
    public function update($customer_id, $number_account, $pret_reference, Request $request)
    {
        $pret = CustomerPret::where('reference', $pret_reference)->first();

        return match ($request->get('action')) {
            "state" => $this->updateState($pret, $request->get('state'))
        };
    }

    public function verify($customer_id, Request $request)
    {
        $customer = Customer::find($customer_id);
        try {
            $match = match ($request->get('verify')) {
                "prerequest" => VerifCompatibilityBeforeLoanTrait::prerequestLoan($customer),
                "loan" => VerifCompatibilityBeforeLoanTrait::verify($customer),
                default => $this->result($customer, $request)
            };
        } catch (\Exception $exception) {
            return $this->sendError($exception);
        }

        return $this->sendSuccess(null, [$match]);
    }

    public function deleteCaution($customer_id, $pret_reference, $caution_id)
    {
        $credit = CustomerPret::where('reference', $pret_reference)->first();
        $caution = collect(json_decode($credit->caution))->reject(function ($value, $key) {
            dd($value, $key);
            return $value == $caution_id;
        });

        $credit->update([
            'caution' => $caution->all()
        ]);

        return $this->sendSuccess();
    }

    private function updateState(CustomerPret $pret, $state)
    {
        $pret->update([
            'status' => $state
        ]);

        $pret->customer->info->notify(new UpdateStatusPretNotification($pret->customer, $pret));

        return $this->sendSuccess();
    }

    private function result(Customer $customer, Request $request)
    {
        $request->validate([
            'loan_plan_id' => "required",
            'amount_loan' => "required",
            'duration' => "required|int|min_digits:1|max_digits:30",
            'wallet_payment_id' => "required"
        ]);

        $plan = LoanPlan::find($request->get('wallet_payment_id'));

        try {
            $mensuality = eur($request->get('amount_loan') / ($request->get('duration') * 12));
            $taux = $plan->tarif->type_taux == 'fixe' ? $plan->tarif->interest : $this->CalcTauxVariable($request->get('amount_loan'), $plan);
            $interest = $request->get('amount_loan') * $taux / 100;
            $amount_du = eur($request->get('amount_loan') + $interest);
            $taxe_assurance = 'Non Renseignable';

            return [
                'mensuality' => $mensuality,
                'taux' => $taux." %",
                'amount_du' => $amount_du,
                'taxe_assurance' => $taxe_assurance
            ];
        }catch (\Exception $exception) {
            return [];
        }
    }

    private function CalcTauxVariable($amount,LoanPlan $plan)
    {
        $min = $plan->tarif->min_interest;
        $max = $plan->tarif->max_interest;

        if($amount <= 100) {
            return $min;
        } elseif($amount > 101 && $amount <= 500) {
            return $min/1.3;
        } elseif($amount > 501 && $amount <= 3000) {
            return $min/2.6;
        } elseif($amount > 3001 && $amount <= 5000) {
            return ceil($min/3.1);
        } else {
            return $max;
        }
    }
}
