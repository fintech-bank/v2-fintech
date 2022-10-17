<?php

namespace App\Http\Controllers\Admin\Configuration;

use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Core\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        return view('admin.config.service.index', [
            'services' => Service::all()
        ]);
    }

    public function store(Request $request)
    {
        try {
            $service = Service::create($request->except('_token'));
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage(), $exception);
            return response()->json($exception, 500);
        }

        return response()->json($service);
    }
}
