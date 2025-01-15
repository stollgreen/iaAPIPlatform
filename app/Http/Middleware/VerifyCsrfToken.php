<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as OVerifyCsrfToken;


/**
 * Handles the verification of CSRF tokens in incoming requests.
 *
 * Extends the base functionality to allow certain URIs
 * to bypass CSRF checks.
 */
class VerifyCsrfToken extends OVerifyCsrfToken
{
    /**
     * Die URIs, die von der CSRF-Überprüfung ausgeschlossen sind.
     *
     * @var array<int, string>
     */
    protected $except = [
        'api/*', // Alle API-Routen von der CSRF-Prüfung ausschließen
    ];
}