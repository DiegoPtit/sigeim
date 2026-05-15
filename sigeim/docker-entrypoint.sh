#!/bin/bash
set -e

# Wait for database to be ready
echo "Waiting for database to be ready..."
until mysqladmin ping -h"$DB_HOST" -u"$DB_USER" -p"$DB_PASS" --silent --skip-ssl; do
    echo "Database not ready yet, retrying in 1s..."
    sleep 1
done

echo "Database is up - executing migrations"
php migrate.php

# Ensure permissions for storage (important when using volumes)
echo "Setting permissions for storage..."
chown -R www-data:www-data /var/www/html/storage
chmod -R 775 /var/www/html/storage

# Execute the original CMD
echo "Starting Apache..."
exec apache2-foreground
