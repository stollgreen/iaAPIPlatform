<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;

class GenerateAndValidateSwagger extends Command
{
    // Name und Beschreibung des Kommandos
    protected $signature = 'swagger:generate';
    protected $description = 'Generates Swagger documentation, adds server and validates it';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Generiere Swagger-Dokumentation
        $this->info('Generieren der Swagger-Dokumentation...');
        Artisan::call('l5-swagger:generate');
        $this->info('Swagger-Dokumentation wurde erfolgreich generiert.');

        // Füge den Server hinzu
        $this->info('Füge Server zur Swagger-Dokumentation hinzu...');
        Artisan::call('swagger:add-servers');
        $this->info('Server wurde erfolgreich hinzugefügt.');

        // Die generierte Swagger-Dokumentation laden
        $swaggerJsonPath = storage_path('/api-docs/api-docs.json');
        $swaggerJson = file_get_contents($swaggerJsonPath);

        // Validierung der Swagger-Dokumentation bei Swagger-Validator
        $this->info('Validiere die Swagger-Dokumentation...');
        $response = Http::post('https://validator.swagger.io/validator', [
            'input' => $swaggerJson
        ]);

        if ($response->successful()) {
            $this->info('Swagger-Dokumentation ist gültig!');
        } else {
            $this->error('Swagger-Dokumentation ist ungültig. Fehler: ' . $response->body());
        }
    }
}