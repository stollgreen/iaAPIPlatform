<?php

use App\Http\Middleware\ApiResponse;
use App\Http\Middleware\LogRequests;
use App\Http\Middleware\SetPaginationLimit;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

if(!function_exists('routinggenerator')) {
    function routinggenerator(): void
    {
        $swaggerFile = storage_path('api-docs/api-docs.json'); // Pfad zur generierten API-Dokumentation
        $swaggerJson = json_decode(file_get_contents($swaggerFile), true);

        // Füge die server-URLs hinzu
        $swaggerJson['servers'] = [
            [
                'url' => "", // Beispiel für lokale URL
                'description' => 'APIv1',
            ],

        ];

        // Schreibe die Änderungen zurück in die JSON-Datei
        file_put_contents($swaggerFile, json_encode($swaggerJson, JSON_PRETTY_PRINT));
    }
}


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->appendToGroup('api', LogRequests::class);
        $middleware->appendToGroup('api', ApiResponse::class);
        $middleware->appendToGroup('api', SetPaginationLimit::class);

            $middleware->alias(
            [
//                'logrequests' => LogRequests::class,
//                'api_response' => ApiResponse::class,
            ]
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
