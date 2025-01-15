<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AddServersToSwagger extends Command
{
    protected $signature = 'swagger:add-servers';
    protected $description = 'Fügt die Server-Sektion zur Swagger API-Dokumentation hinzu';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $swaggerFile = storage_path('api-docs/api-docs.json');

        if (!file_exists($swaggerFile)) {
            $this->error('Die Swagger-Dokumentation konnte nicht gefunden werden.');
            return;
        }

        // Die bestehende API-Dokumentation laden
        $swaggerJson = json_decode(file_get_contents($swaggerFile), true);

        // Füge die server-URLs hinzu
        $swaggerJson['servers'] = [
            [
                'url' => env('L5_SWAGGER_CONST_HOST', 'http://localhost:8000/api'), // Hier Umgebungsvariablen verwenden
                'description' => 'APIv1',
            ],
        ];

        // Die Änderungen in der JSON-Datei speichern
        file_put_contents($swaggerFile, json_encode($swaggerJson, JSON_PRETTY_PRINT));

        $this->info('Server-Sektion erfolgreich zur Swagger-Dokumentation hinzugefügt.');
    }
}