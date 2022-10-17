<?php

namespace App\Http\Controllers\Admin\Configuration;

use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Core\EpargnePlan;
use Illuminate\Http\Request;

class PlanEpargneController extends Controller
{
    public function index()
    {
        return view('admin.config.epargne.index', [
            "plans" => EpargnePlan::all()
        ]);
    }

    public function store(Request $request)
    {
        try {
            $plan = EpargnePlan::create($request->except('_token'));
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage(), $exception);
            return response()->json($exception, 500);
        }

        return response()->json($plan);
    }
}
