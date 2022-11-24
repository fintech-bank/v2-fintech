<?php

namespace App\Scope;

use App\Models\Core\EpargnePlan;
use App\Models\Customer\Customer;
use Illuminate\Http\Request;

trait VerifyEpargneFromPlanTrait
{
    public static function verifRequest(Request $request, Customer $customer)
    {
        $plan = EpargnePlan::find($request->get('epargne_plan_id'));

        if($request->get('initial_payment') <= $plan->init) {
            return false;
        }

        if($customer->epargnes()->where('epargne_plan_id', $request->get('epargne_plan_id'))->count() >= $plan->unique ? 1 : 9999) {
            return false;
        }

        return true;
    }
}
