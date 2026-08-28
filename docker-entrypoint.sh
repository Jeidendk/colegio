#!/bin/sh
set -e

# Render no monta un archivo .env. Sin APP_KEY, Laravel lanza MissingAppKeyException
# al cifrar la sesión y todas las respuestas salen 500. Generamos uno si no llega.
# Las variables reales del entorno tienen prioridad: phpdotenv no sobrescribe lo ya definido.
if [ ! -f .env ]; then
    app_key="${APP_KEY:-base64:$(head -c 32 /dev/urandom | base64)}"

    if [ -z "${APP_KEY:-}" ]; then
        echo "[entrypoint] APP_KEY no definida: se generó una temporal para esta instancia."
    fi

    {
        echo "APP_NAME=\"ESPOCH Electricidad\""
        echo "APP_ENV=${APP_ENV:-production}"
        echo "APP_KEY=${app_key}"
        echo "APP_DEBUG=${APP_DEBUG:-false}"
        echo "APP_URL=${APP_URL:-https://${RENDER_EXTERNAL_HOSTNAME:-localhost}}"
        echo "LOG_CHANNEL=${LOG_CHANNEL:-stderr}"
        echo "SESSION_DRIVER=${SESSION_DRIVER:-cookie}"
        echo "CACHE_STORE=${CACHE_STORE:-file}"
        echo "DB_CONNECTION=${DB_CONNECTION:-sqlite}"
    } > .env

    chown www-data:www-data .env
fi

# Evita el aviso AH00558 de Apache en cada arranque.
echo "ServerName ${RENDER_EXTERNAL_HOSTNAME:-localhost}" > /etc/apache2/conf-available/servername.conf
a2enconf servername >/dev/null

exec apache2-foreground
