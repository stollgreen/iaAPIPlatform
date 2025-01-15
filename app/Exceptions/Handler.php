<?php
namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $e
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Throwable $e): Response
    {
        // Nur für die API-Umgebung
        if ($request->is('api/*')) {
            // ModelNotFoundException behandeln
            if ($e instanceof ModelNotFoundException) {
                return response()->json([
                    'error' => 'Resource not found',
                    'message' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ], 404);
            }

            // ValidationException behandeln
            if ($e instanceof ValidationException) {
                return response()->json([
                    'error' => 'Validation error',
                    'message' => $e->getMessage(),
                    'errors' => $e->errors(),
                    'trace' => $e->getTrace(),
                ], 422);
            }

            // Alle anderen Fehler werden als Serverfehler behandelt
            return response()->json([
                'error' => 'Server Error',
                'message' => $e->getMessage(),
                'trace' => $e->getTrace(),
            ], 500);
        }

        // Rückgabe für alle anderen Fehler außerhalb der API-Route
        return response()->json([
            'error' => 'Not Found',
            'message' => $e->getMessage(),
            'trace' => $e->getTrace(),
        ], 404);
    }
}