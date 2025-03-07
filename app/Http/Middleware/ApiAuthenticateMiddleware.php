<?php

namespace App\Http\Middleware;

use App\Helpers\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthenticateMiddleware
{

    /**
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            if (config('services.api_token') != $request->bearerToken()) {
                return ApiResponse::error(message: __('auth.failed'), code: 401);
            }
            return $next($request);
        } catch (\Throwable $e) {
            return ApiResponse::error(message: __('auth.failed'), code: 401);
        }
    }
}
