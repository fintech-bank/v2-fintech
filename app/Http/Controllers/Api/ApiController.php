<?php

namespace App\Http\Controllers\Api;

use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ApiController extends Controller
{
    /**
     * success response method.
     *
     * @param array|string|null $result
     * @param string|null $message
     * @param string $type
     * @return JsonResponse
     */
    public function sendResponse(array|string|null $result, string|null $message,string $type = 'success')
    {
        $response = [
            'success' => $type,
            'data'    => $result,
            'message' => $message,
        ];


        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @param string $error
     * @param array|string $errorMessages
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendError(string $error, array|string $errorMessages = [], int $code = 500)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];


        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }
}
