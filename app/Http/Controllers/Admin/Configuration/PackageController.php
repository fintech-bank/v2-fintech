<?php

namespace App\Http\Controllers\Admin\Configuration;

use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Core\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        return view('admin.config.package.index', [
            'packages' => Package::all()
        ]);
    }

    public function store(Request $request)
    {
        try {
            $package = Package::create($request->except('_token'));
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
            LogHelper::notify('critical', $exception->getMessage(), $exception);
            return response()->json($exception, 500);
        }

        return response()->json($package);
    }
}
