#!/bin/sh
set -e

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
php artisan config:cache

echo "Caching routes..."
php artisan route:cache 2>/dev/null || true

echo "Caching views..."
php artisan view:cache 2>/dev/null || true

echo "Setup complete. Starting Apache..."

exec "$@"
