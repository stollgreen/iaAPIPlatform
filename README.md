# Kurzinfo

Dieses Projekt ist eine Laravel-basierte API-Anwendung. Sie enthält grundlegende Konfigurationen sowie die Struktur für eine API-Only-Anwendung für den Betrieb einer PHP-basierten API-Schnittstelle mit einem Generator für einen TypeScript-Client.

---

## **Verwendete Technologien**

- **PHP 8.3**
- **Laravel Framework 11**
- **Composer**
- **MariaDB**
- **Swagger**
- **Docker**
- **OpenAPI**

# Inbetriebnahme

1. Klonen des Git-Repositorys
   ```
   git clone git@github.com:stollgreen/iaAPIPlatform.git
   ```
2. Wechsel ins Verzeichnis
   ```
   cd iaAPIPlatform
   ```
3. Erstellen der .env-Datei und Anpassen der Werte. Gewöhnlich sollte nichts geändert werden müssen.
   ```
   cp .env.example .env
   ```
4. Wechsel in das Verzeichnis, das `git` erstellt hat.
   ```
   cd iaAPIPlatform
   ```

## Beim erstmaligen Start

Wenn der Container zum ersten Mal gestartet wird, sind die folgenden Schritte obligatorisch:

1. Starten des Docker-Containers

   ```
   docker-compose up --build -d
   ```

   Dieser Prozess kann je nach Leistung einige Zeit in Anspruch nehmen. Selten hat es länger als 2 Minuten gedauert.

2. Nachdem der Container ohne Fehler vollständig gestartet ist, rufe die `bash` des Containers auf:

   ```
   docker exec -it laravel_app /bin/bash
   ```

   Du siehst jetzt etwas wie:

   ```
   root@aee4fdb96ce7:/var/www/html#
   ```

   Dies ist das Wurzelverzeichnis der Laravel-Anwendung.

### TypeScript-Client

Der TypeScript-Client besteht aus vordefinierten .ts-Dateien, die die Funktionalität für alle definierten API-Endpunkte abdecken.

Der TypeScript-Client wird aus der Konfiguration der Datei `storage/api-docs/api-docs.json` generiert und in `storage/ts` abgelegt. Dort können die .ts-Dateien entsprechend angepasst werden. Anschließend können die Änderungen innerhalb des `storage/ts`-Ordners mit `tsc --build` kompiliert werden.

1. Damit der TypeScript-Client generiert werden kann, ist es notwendig, alle Einstellungen und Routen im System zu cachen. Die besten Erfahrungen wurden mit `artisan optimize` gemacht. Zusätzlich muss die Datei `api-docs.json` generiert werden:

   ```
   php artisan optimize
   php artisan swagger:generate
   ```

2. Um den TypeScript-Client aus dem aktuellen Build zu generieren, verwenden wir `openapi-generator-cli`, bereitgestellt durch Docker:

   ```
   openapi-generator-cli generate -i storage/api-docs/api-docs.json -g typescript-fetch -o storage/ts
   ```

   Es erfolgt eine Logausgabe, die darüber informiert, welche Controller, Ressourcen und Collections generiert wurden.

3. Wechsel ins Verzeichnis `storage/ts`:

   ```
   cd storage/ts
   ```

4. Bevor der Client kompiliert werden kann, sollten die Paketabhängigkeiten geladen werden. Dieser Schritt ist bei der ersten Inbetriebnahme obligatorisch, da im Verzeichnis `storage/ts` eine eigene `package.json`-Datei vorhanden ist:

   ```
   npm install
   ```

5. Nun kann der TypeScript-Client kompiliert werden:

   ```
   tsc --build
   ```

   Wenn Fehler auftreten, führe folgende Befehle aus:

   ```
   cd ../..
   php artisan optimize
   php artisan swagger:generate
   ```

   und wiederhole ab Schritt 2.

6. Es ist bereits eine `test.js`-Datei für den TypeScript-Client vorhanden. Diese führt eine Abfrage durch, um die Verbindung zu testen:

   ```
   node test.js
   ```

   Die Anfrage ist beendet, wenn ein leeres Data-Array ausgegeben wird.

## API-Dokumentation /api/documentation

Eine Dokumentation zur API ist ebenfalls verfügbar und erreichbar, wenn der Docker-Container läuft: [localhost:8000/api/documentation](http://localhost:8000/api/documentation)

**Sollten Probleme mit den Pfaden auftreten, wenn Eingaben in der API-Dokumentation genutzt werden:**

Führe im Container folgende Befehle aus:

```
php artisan optimize
php artisan swagger:generate
```

### Beenden des Docker-Containers:

```
docker-compose down -v
```

### Starten:

```
docker-compose up -d
```

### Docker-Bash:

```
docker exec -it laravel_app /bin/bash
```

### Tests

PHPUnit-Tests stehen zur Verfügung:

```
php artisan test
```

Nur wenn Tests ausgeführt wurden:

```
artisan migrate:fresh --seed
```

# Namenskonventionen

Jede Entität wird durch die `EntityResource` ausgegeben. Diese werden aus der Datenbank mit dem Model `Entity` verwaltet. `EntityCollection` repräsentiert mehrere `EntityResources`.

Über den jeweiligen `EntityController` werden zunächst alle Standardanfragen über die `apiResource()`-Methode bereitgestellt. Create- und Update-Requests werden mit `EntityStoreRequest` oder `EntityUpdateRequest` abgewickelt – zusätzliche Request-Methoden sollten diesem Prinzip folgen.

# OpenAPI-Dokumentation

Für den reibungslosen Betrieb wird die API-Dokumentation genutzt, da aus diesen Informationen der TypeScript-Client generiert werden kann. Außerdem wird die Dokumentation unter `url/api/documentation` zur Verfügung gestellt, um die Qualität der Dokumentation sicherzustellen.

Die Controller-Methoden, Ressourcen und Requests erhalten die entsprechenden Annotationen:

```php
#[OA\Get(
    path: '/commitments',
    operationId: 'listCommitments',
    description: 'Retrieve a paginated list of commitments',
    summary: 'List commitments',
    security: [],
    tags: ['Commitments'],
    parameters: [
        new OA\QueryParameter(
            name: 'perPage',
            description: 'Number of items per page',
            required: false,
            schema: new OA\Schema(type: 'integer', default: 5), // Optional: Standardwert
            example: 15 // Optional: Beispielwert
        ),
        new OA\QueryParameter(
            name: 'page',
            description: 'Number of page',
            required: false,
            schema: new OA\Schema(type: 'integer', default: '1'), // Optional: Standardwert
            example: 1 // Optional: Beispielwert
        )
    ],
    responses: [
        new OA\Response(
            response: 200,
            description: 'Successfully retrieved list of commitments',
            x: [
                new OA\JsonContent(
                    ref: '#/components/schemas/CommitmentCollection'
                ),
                new OA\Response(
                    ref: '#/components/responses/Default',
                )
            ]
        )
    ]
)]
public function show(Commitment $commitment): CommitmentResource
{
    return new CommitmentResource($commitment);
}
```

Dies ermöglicht eine gezielte Dokumentation aller zugänglichen Endpunkte. Außerdem werden diese Informationen für die Generierung des TypeScript-Clients genutzt und erleichtern dessen Weiterentwicklung.

Ich kann deine Ausgabe nicht verwenden. die Markups etc fehlen 

