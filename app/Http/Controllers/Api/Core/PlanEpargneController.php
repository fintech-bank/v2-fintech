<?php

namespace App\Http\Controllers\Api\Core;

use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Core\EpargnePlan;
use Illuminate\Http\Request;

class PlanEpargneController extends Controller
{
    public function info($plan_id)
    {
        $plan = EpargnePlan::find($plan_id);

        return response()->json($plan);
    }

    public function update(Request $request, $plan_id)
    {
        $plan = EpargnePlan::find($plan_id);

        try {
            $plan->update($request->except('_token'));
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception);
            return response()->json($exception, 500);
        }

        return response()->json($plan);
    }

    public function delete(Request $request, $plan_id)
    {
        $plan = EpargnePlan::find($plan_id);

        try {
            $plan->delete();
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception);
            return response()->json($exception, 500);
        }

        return response()->json($plan);
    }
}
