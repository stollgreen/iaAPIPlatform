FROM php:8.3-apache

# Installiere benötigte Pakete und Erweiterungen
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git mariadb-client net-tools netcat-openbsd \
    curl gnupg2 lsb-release \
    openjdk-17-jdk \
    && docker-php-ext-install zip pdo_mysql

# Apache mod_rewrite aktivieren
RUN a2enmod rewrite

# Arbeitsverzeichnis festlegen
WORKDIR /var/www/html

# Installiere Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Projektdateien kopieren
COPY . .

# Apache konfigurieren, um das public-Verzeichnis bereitzustellen
RUN echo '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        Options Indexes FollowSymLinks\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
    ErrorLog ${APACHE_LOG_DIR}/error.log\n\
    CustomLog ${APACHE_LOG_DIR}/access.log combined\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Installiere OpenJDK
#RUN apt-get update && apt-get install -y openjdk-11-jdk

# Setze die Umgebungsvariable JAVA_HOME
ENV JAVA_HOME=/usr/lib/jvm/java-17-openjdk-amd64
ENV PATH=$JAVA_HOME/bin:$PATH

# Berechtigungen setzen
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Installiere Node.js und npm
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Installiere TypeScript und OpenAPI Generator CLI
RUN npm install @openapitools/openapi-generator-cli -g

RUN npm install -g typescript
RUN node --version && npm --version && tsc --version && java -version

RUN npm install dotenv

ENV PATH="/usr/local/bin:$PATH"
ENV JAVA_HOME=/usr/lib/jvm/java-17-openjdk-amd64
ENV PATH="${JAVA_HOME}/bin:${PATH}"
# Exponiere Port 80
EXPOSE 80

# ENTRYPOINT-Skript kopieren und ausführbar machen
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# ENTRYPOINT auf das Skript setzen
ENTRYPOINT ["/entrypoint.sh"]