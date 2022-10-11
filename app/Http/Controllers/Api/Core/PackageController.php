<?php

namespace App\Http\Controllers\Api\Core;

use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Core\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function info($forfait_id)
    {
        return response()->json(Package::find($forfait_id));
    }

    public function update(Request $request, $forfait_id)
    {
        $package = Package::find($forfait_id);

        try {
            $package->update($request->except('_token'));
            $package->update([
                'visa_classic' => $request->has('visa_classic'),
                'check_deposit' => $request->has('check_deposit'),
                'payment_withdraw' => $request->has('payment_withdraw'),
                'overdraft' => $request->has('overdraft'),
                'cash_deposit' => $request->has('cash_deposit'),
                'withdraw_international' => $request->has('withdraw_international'),
                'payment_international' => $request->has('payment_international'),
                'payment_insurance' => $request->has('payment_insurance'),
                'check' => $request->has('check'),
            ]);
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception);
            return response()->json($exception, 500);
        }

        return response()->json($package);
    }

    public function delete(Request $request, $forfait_id)
    {
        $package = Package::find($forfait_id);

        try {
            $package->delete();
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception);
            return response()->json($exception, 500);
        }

        return response()->json();
    }
}
