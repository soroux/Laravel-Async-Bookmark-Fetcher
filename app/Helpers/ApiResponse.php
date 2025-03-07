<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function success(mixed $data = null, mixed $message = null, int $code = 200): JsonResponse
    {
        return response()->json(['data' => $data, 'message' => $message], $code);
    }

    public static function error($message = null, int $code = 422, $data = null): JsonResponse
    {
        return response()->json(['data' => $data, 'message' => $message], $code);
    }
}
