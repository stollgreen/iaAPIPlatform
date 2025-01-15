<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Middleware to set a default pagination limit if not provided in the request.
 */
class SetPaginationLimit
{
    /**
     * Handle the request to apply a default pagination limit if not provided.
     *
     * This middleware checks if the 'perPage' parameter is present in the request.
     * If not, it sets a default value from the API configuration.
     * The value is added or overridden in the request.
     *
     * @param \Illuminate\Http\Request $request The incoming HTTP request.
     * @param \Closure $next The next middleware to call in the pipeline.
     * @return mixed The response after the middleware processes the request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->has('perPage')) {
            $request->merge(['perPage' => config('api.pagination')]);
        }

        return $next($request);
    }
}