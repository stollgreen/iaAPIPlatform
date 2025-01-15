<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Der Namespace für die Controller.
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Definiere die Route-Registrierungslogik.
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Registriere die Routen für die Anwendung.
     */
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    /**
     * API-Routen laden.
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api') // Präfix für API-Routen
        ->middleware('api') // Middleware für API-Routen
        ->namespace($this->namespace) // Namespace der Controller
        ->group(base_path('routes/api.php')); // Definiert in `routes/api.php`
    }

    /**
     * Web-Routen laden.
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web') // Middleware für Web-Routen
        ->namespace($this->namespace) // Namespace der Controller
        ->group(base_path('routes/web.php')); // Definiert in `routes/web.php`
    }
}