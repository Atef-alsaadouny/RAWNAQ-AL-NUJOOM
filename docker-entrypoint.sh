#!/bin/sh
set -e

CURRENT_KEY=$(grep -E '^APP_KEY=' /var/www/html/.env | head -1 | cut -d= -f2-)
if [ -z "$CURRENT_KEY" ] || [ "$CURRENT_KEY" = "base64:" ]; then
    echo "⚙️  Generating APP_KEY..."
    php artisan key:generate --force
fi

if [ ! -f /var/www/html/storage/framework/cache/config.php ]; then
    echo "⚙️  Caching config..."
    php artisan config:cache
fi

echo "⚙️  Caching routes..."
php artisan route:cache 2>/dev/null || true

echo "⚙️  Caching views..."
php artisan view:cache 2>/dev/null || true

echo "✅ Setup complete. Starting PHP-FPM..."

exec "$@"
