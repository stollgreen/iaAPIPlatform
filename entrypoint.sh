#!/bin/bash

# Warten, bis MySQL verfügbar ist
until nc -z -v -w30 db 3306
do
  echo "Warte auf MySQL..."
  sleep 1
done

# Composer-Installationen ausführen
composer install --optimize-autoloader

# Migrationen ausführen
php artisan migrate --force --seed

# Schlüssel generieren, falls notwendig
php artisan key:generate

# Apache starten
apache2-foreground