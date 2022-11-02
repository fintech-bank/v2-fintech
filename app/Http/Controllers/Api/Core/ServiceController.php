<?php

namespace App\Http\Controllers\Api\Core;

use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Core\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function info($service_id)
    {
        return response()->json(Service::find($service_id));
    }

    public function update(Request $request, $service_id)
    {
        $service = Service::find($service_id);

        try {
            $service->update($request->except('_token'));
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage(), $exception);
            return response()->json($exception, 500);
        }

        return response()->json($service);
    }

    public function delete($service_id)
    {
        $service = Service::find($service_id);

        try {
            $service->delete();
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage(), $exception);
            return response()->json($exception, 500);
        }

        return response()->json($service);
    }

}
