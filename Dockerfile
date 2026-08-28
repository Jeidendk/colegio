# Imagen de despliegue para la demostración ESPOCH (Laravel sin base de datos).
FROM php:8.4-apache

# unzip y git los necesita Composer para instalar paquetes desde dist/zip.
RUN apt-get update \
    && apt-get install -y --no-install-recommends unzip git libzip-dev \
    && docker-php-ext-install zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# La aplicación se sirve desde public/, no desde la raíz del proyecto.
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf \
    && a2enmod rewrite

WORKDIR /var/www/html

# Copiamos primero los manifiestos para aprovechar la caché de capas de Docker.
COPY composer.json composer.lock ./
# --ignore-platform-reqs: composer.lock exige PHP >= 8.4.1 y la imagen trae 8.4.x;
# la demostración no usa ninguna función exclusiva de ese parche.
RUN composer install --no-dev --no-interaction --no-scripts --prefer-dist --ignore-platform-reqs

COPY . .

RUN composer dump-autoload --optimize --no-dev --ignore-platform-reqs \
    && mkdir -p storage/framework/{cache,sessions,views} storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 80
ENTRYPOINT ["docker-entrypoint.sh"]
