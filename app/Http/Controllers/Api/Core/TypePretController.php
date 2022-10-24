<?php

namespace App\Http\Controllers\Api\Core;

use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Core\LoanPlan;
use Illuminate\Http\Request;

class TypePretController extends Controller
{
    public function info($pret_id)
    {
        $type = LoanPlan::find($pret_id);

        return response()->json($type);
    }

    public function update(Request $request, $pret_id)
    {
        $type = LoanPlan::find($pret_id);

        $avantage = [
            'adapt_mensuality' => $request->has('adapt_mensuality'),
            'report_echeance' => $request->has('report_echeance'),
            'online_subscription' => $request->has('online_subscription'),
        ];

        $condition = [
            'adapt_mensuality_month' => $request->get('adapt_mensuality_month'),
            'report_echeance_max' => $request->get('report_echeance_max')
        ];

        $tarification = [
            'type_taux' => $request->get('type_taux'),
            'interest' => $request->get('interest'),
            'min_interest' => $request->get('min_interest'),
            'max_interest' => $request->get('max_interest'),
        ];

        try {
            $type->update([
                'name' => $request->get('name'),
                'minimum' => $request->get('minimum'),
                'maximum' => $request->get('maximum'),
                'duration' => $request->get('duration'),
                'instruction' => $request->get('instruction'),
                'avantage' => json_encode($avantage),
                'condition' => json_encode($condition),
                'tarif' => json_encode($tarification),
                'type_pret' => $request->get('type_pret')
            ]);

            if($request->get('type_taux') == 'fixe') {
                $type->interests()->create([
                    'duration' => $request->get('duration'),
                    'interest' => $request->get('interest'),
                    'loan_plan_id' => $type->id
                ]);
            }
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage(), $exception);
            return response()->json($exception, 500);
        }

        return response()->json($type);
    }

    public function delete(Request $request, $pret_id)
    {
        $type = LoanPlan::find($pret_id);

        try {
            $type->delete();
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage(), $exception);
            return response()->json($exception, 500);
        }

        return response()->json($type);
    }
}
