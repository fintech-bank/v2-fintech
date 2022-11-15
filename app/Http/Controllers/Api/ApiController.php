<?php

namespace App\Http\Controllers\Api;

use App\Helper\LogHelper;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    public function sendSuccess(string $message = null, array $data = null, $status = 200)
    {
        return response()->json([
            "message" => $message,
            "data" => $data,
            "state" => "success"
        ], $status);
    }

    public function sendWarning(string $message = null, array $data = null, $status = 200)
    {
        return response()->json([
            "message" => $message,
            "data" => $data,
            "state" => "warning"
        ], $status);
    }

    public function sendError(string $message = null, array|\Exception $data = null, $status = 500)
    {
        LogHelper::notify('critical', $message, $data);
        return response()->json([
            "message" => $message,
            "data" => $data,
            "state" => "error"
        ], $status);
    }
}
