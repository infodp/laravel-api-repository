<?php

namespace App\Classes;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ApiResponseHelper
{
    public static function rollback($e, $message = 'Failure in the process')
    {
        DB::rollBack();
        self::throw($e, $message);
    }

    public static function throw($e, $message = 'Failure in the process')
    {
        Log::info($e);
        throw new HttpResponseException(response()->json([
            'message'=>$message
        ], 500));
    }

    public static function sendResponse($result, $message = '', $code = 200)
    {
        if($code === 204) {
            return response()->noContent();
        }

        $response = [
            'success' => true,
            'data' => $result
        ];

        if(!empty($message)) {
            $response['message'] = $message;
        }

        return response()->json($response, $code);
    }
}
