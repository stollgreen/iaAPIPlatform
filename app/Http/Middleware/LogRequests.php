<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class LogRequests
{
    /**
     * Logging for each request
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        Log::info('Incoming Request', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
        ]);

        $response = $next($request);

        Log::info('Outgoing Response', [
            'status' => $response->status(),
        ]);

        return $response;
    }
}
