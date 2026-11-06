#!/bin/sh
set -e

# Ensure Laravel storage and cache directories exist
mkdir -p /var/www/storage/framework/cache/data \
         /var/www/storage/framework/sessions \
         /var/www/storage/framework/views \
         /var/www/storage/logs \
         /var/www/bootstrap/cache

# Fix ownership and permissions for web server (www-data)
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# If vendor directory doesn't exist, install Composer dependencies
if [ ! -d "/var/www/vendor" ]; then
    echo "Vendor directory not found. Running composer install..."
    composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev
fi

# Execute main command (php-fpm)
exec "$@"

