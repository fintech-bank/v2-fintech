<?php

namespace App\Http\Controllers\Api\Loan;

use App\Helper\CustomerLoanHelper;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerDocument;
use App\Models\Customer\CustomerPret;
use App\Notifications\Customer\Loan\ChangePrlvDayNotification;
use App\Notifications\Customer\Loan\ReportEcheanceNotification;
use App\Notifications\Customer\UpdateStatusPretNotification;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoanController extends ApiController
{
    /**
     * @param int $limit
     * @param Carbon|null $start
     * @param Carbon|null $end
     * @return JsonResponse
     */
    public function list(int $limit = 10,Carbon $start = null, Carbon $end = null)
    {
        $data = collect([
            'limit' => $limit,
            'start' => $start == null ? now()->startOfYear() : $start,
            'end' => $end == null ? now()->endOfYear() : $end,
        ])->toArray();

        $call = CustomerPret::with('plan', 'customer', 'wallet', 'payment', 'card', 'facelia', 'insurance', 'cautions')
            ->whereBetween('created_at', [$data['start'], $data['end']])
            ->limit($data['limit'])
            ->get();

        return $this->sendSuccess(null, [$call]);
    }

    public function retrieve($loan_reference)
    {
        try {
            $call = CustomerPret::with('plan', 'customer', 'wallet', 'payment', 'card', 'facelia', 'insurance', 'cautions')
                ->where('reference', $loan_reference)
                ->first();

            return $this->sendSuccess(null, [$call]);
        }catch (\Exception $exception) {
            return $this->sendError($exception);
        }
    }

    public function update($loan_reference, Request $request)
    {
        $credit = CustomerPret::where('reference', $loan_reference)->first();

        return match ($request->get('action')) {
            "up_prlv_date" => $this->prlv_day($credit, $request->get('prlv_day')),
            "accept" => $this->acceptCredit($credit),
            "reject" => $this->rejectCredit($credit),
            'report_echeance' => $this->report_echeance($credit)

        };
    }

    private function prlv_day(CustomerPret $credit, $prlv_day)
    {
        if($credit->plan->avantage->adapt_mensuality) {
            if($credit->nb_adapt_mensuality <= $credit->plan->condition->adapt_mensuality_month) {
                $credit->update([
                    'prlv_day' => $prlv_day,
                    'nb_adapat_mensuality' => $credit->nb_adapt_mensuality++,
                    'first_payment_at' => Carbon::create($credit->first_payment_at->year, $credit->first_payment_at->month, $prlv_day)
                ]);

                $credit->customer->info->notify(new ChangePrlvDayNotification($credit->customer, $credit));

                return $this->sendSuccess();
            } else {
                return $this->sendWarning("Le nombre de changement de mensualité à été dépassé pour ce crédit");
            }
        } else {
            return $this->sendDanger("Le changement de date de mensualité n'est pas disponible pour ce crédit");
        }
    }

    private function acceptCredit(CustomerPret $credit)
    {
        if(CustomerDocument::where('reference', $credit->reference)->where('signable', 1)->where('signed_by_client', 0)->count() == 0) {
            if($credit->required_caution != 0) {
                if($credit->cautions()->where('sign_caution', 1)->count() != 0) {
                    $credit->update([
                        'status' => "accepted",
                        'confirmed_at' => now()
                    ]);

                    $credit->customer->info->notify(new UpdateStatusPretNotification($credit->customer, $credit));

                    return $this->sendSuccess();
                } else {
                    return $this->sendWarning("Une ou plusieurs cautions ne sont pas recevable");
                }
            } else {
                $credit->update([
                    'status' => "accepted",
                    'confirmed_at' => now()
                ]);

                $credit->customer->info->notify(new UpdateStatusPretNotification($credit->customer, $credit));

                return $this->sendSuccess();
            }
        } else {
            return $this->sendWarning("Tous les documents relatifs au crédit ne sont pas signée");
        }
    }

    private function rejectCredit(CustomerPret $credit)
    {
        $credit->update([
            'status' => 'refused'
        ]);

        $credit->customer->info->notify(new UpdateStatusPretNotification($credit->customer, $credit));

        return $this->sendSuccess();
    }

    private function report_echeance(CustomerPret $credit)
    {
        if($credit->plan->avantage->report_echeance) {
            if($credit->nb_report_echeance <= $credit->plan->condition->report_echeance_max) {
                $credit->update([
                    'nb_echeance_max' => $credit->nb_echeance_max++,
                    'first_payment_at' => $credit->first_payment_at->addMonth()
                ]);

                $credit->wallet->customer->info->notify(new ReportEcheanceNotification($credit->wallet->customer, $credit));

                return $this->sendSuccess();
            } else {
                return $this->sendWarning("Ce crédit ne peut plus faire l'objet d'un report d'échéance");
            }
        } else {
            return $this->sendDanger("Ce crédit ne peut pas faire l'objet d'un report d'échéance");
        }
    }
}
