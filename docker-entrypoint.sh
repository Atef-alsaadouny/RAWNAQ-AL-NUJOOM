#!/bin/sh
set -e

# Ensure storage framework directories exist (fixes "Please provide a valid cache path")
mkdir -p /var/www/html/storage/framework/cache/data
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/framework/testing

if [ ! -f /var/www/html/.env ]; then
    echo "Creating .env from .env.example..."
    cp /var/www/html/.env.example /var/www/html/.env
fi

CURRENT_KEY=$(grep -E '^APP_KEY=' /var/www/html/.env | head -1 | cut -d= -f2-)
if [ -z "$CURRENT_KEY" ] || [ "$CURRENT_KEY" = "base64:" ]; then
    echo "Generating APP_KEY..."
    php artisan key:generate --force
fi

echo "Caching config..."
php artisan config:cache 2>&1

echo "Caching routes..."
php artisan route:cache 2>&1 || true

echo "Caching views..."
php artisan view:cache 2>&1 || true

echo "Storage link..."
php artisan storage:link --force 2>&1 || true

echo "Running migrations..."
php artisan migrate --force 2>&1 || true

echo "Setup complete. Starting Apache..."

exec "$@"
