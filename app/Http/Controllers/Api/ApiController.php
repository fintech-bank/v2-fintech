<?php

namespace App\Http\Controllers\Api;

use App\Helper\LogHelper;
use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    public function sendSuccess(string $message = null, array $data = null,int $status = 200)
    {
        return response()->json([
            "message" => $message,
            "data" => $data,
            "state" => "success"
        ], $status);
    }

    public function sendWarning(string $message = null, array $data = null,int $status = 200)
    {
        return response()->json([
            "message" => $message,
            "data" => $data,
            "state" => "warning"
        ], $status);
    }

    public function sendError(array|\Exception $data = null,int $status = 500)
    {
        LogHelper::notify('critical', "Erreur lors de l'execution de l'appel: ".$data->getFile(), $data);
        return response()->json([
            "message" => "Erreur lors de l'execution de l'appel, consulter les logs ou contacter un administrateur",
            "data" => $data,
            "state" => "error"
        ], $status);
    }
}
