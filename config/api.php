<?php

return [

    /*
    |--------------------------------------------------------------------------
    | API Versioning
    |--------------------------------------------------------------------------
    |
    | Definiere die aktuelle API-Version und unterstützte Versionen.
    |
    */
    'version' => 'v1',
    'supported_versions' => ['v1'],

    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    |
    | Konfiguration für die Begrenzung der API-Anfragen.
    |
    */
    'rate_limits' => [
        'default' => env('API_RATE_LIMIT', 60), // Standard: 60 Anfragen pro Minute
        'authenticated' => env('AUTH_API_RATE_LIMIT', 120), // Für authentifizierte Nutzer
    ],

    /*
    |--------------------------------------------------------------------------
    | API Debug Modus
    |--------------------------------------------------------------------------
    |
    | Definiert, ob Debugging-Informationen für die API ausgegeben werden.
    |
    */
    'debug' => env('API_DEBUG', true),

    /*
    |--------------------------------------------------------------------------
    | Authentifizierungsmethoden
    |--------------------------------------------------------------------------
    |
    | Liste der unterstützten Authentifizierungsarten für die API.
    |
    */
    'auth_methods' => [
        'token',  // Token-basierte Authentifizierung
        'passport', // Laravel Passport (falls verwendet)
    ],
    /*
    |--------------------------------------------------------------------------
    | Paginierung
    |--------------------------------------------------------------------------
    |
    | Standardwert maximale Ausgabe
    |
    */

    'pagination' => 5

];