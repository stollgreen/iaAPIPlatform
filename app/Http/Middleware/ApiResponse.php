<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Middleware for modifying the response headers for API routes.
 *
 * This middleware ensures that all API responses have the
 * 'Content-Type' header set to 'application/json'.
 *
 * Middleware is applied to routes starting with 'api/'.
 */
class ApiResponse
{
    public function handle(Request $request, Closure $next)
    {
        Log::info('ApiResponse');
        $response = $next($request);

        if ($request->is('api/*')) {

            $response->headers->set('Content-Type', 'application/json;');

            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With');

            $response->headers->set('Date', gmdate('D, d M Y H:i:s T'));
            $response->headers->set('Server', 'LaravelAppUnderApache/1.0 (PHP 8.3)');

            $response->headers->set('X-Powered-By', 'PHP/8.3');

            // Header Media Tyoe
            $response->headers->set('Content-Type', 'application/json');
        }

        return $response;
    }
}