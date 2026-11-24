#!/bin/bash
set -e

# Create SQLite database if not exists
if [ ! -f /var/www/html/database/database.sqlite ]; then
    touch /var/www/html/database/database.sqlite
fi

# Ensure storage and database permissions
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database
chmod 664 /var/www/html/database/database.sqlite

# Generate APP_KEY if empty
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Run database migrations and seed default data (admin, kasir, services, demo orders)
php artisan migrate --force --seed

# Optimize Laravel caching
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

exec "$@"
