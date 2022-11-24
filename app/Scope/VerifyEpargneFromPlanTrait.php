<?php

namespace App\Scope;

use App\Models\Core\EpargnePlan;
use App\Models\Customer\Customer;
use Illuminate\Http\Request;

trait VerifyEpargneFromPlanTrait
{
    public static function verifRequest(Request $request, Customer $customer): array
    {
        $plan = EpargnePlan::find($request->get('epargne_plan_id'));

        if($request->get('initial_payment') < $plan->init) {
            return collect([
                'state' => false,
                'reason' => "Montant initial inférieur à {$plan->init_format}"
            ])->all();
        }

        if($customer->epargnes()->where('epargne_plan_id', $request->get('epargne_plan_id'))->count() >= $plan->unique ? 1 : 9999) {
            return collect([
                'state' => false,
                'reason' => "Vous avez déjà un compte épargne de ce type: ".$customer->epargnes()->where('epargne_plan_id', $request->get('epargne_plan_id'))->count()
            ])->all();
        }

        return collect([
            'state' => true,
            'reason' => null
        ])->all();
    }
}
