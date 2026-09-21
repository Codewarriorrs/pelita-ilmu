#!/usr/bin/env bash
composer install --no-dev --optimize-autoloader --working-dir=/var/www/html
php artisan storage:link --force
php artisan filament:assets
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force