#!/usr/bin/env bash
# scripts/00-laravel.sh
# Runs automatically on container startup via richarvey/nginx-php-fpm RUN_SCRIPTS=1
# Ensure correct permissions & clear cached config so our dynamic database.php
# IIFE is always re-evaluated on each boot.

set -e

cd /var/www/html

echo "[deploy] Clearing cached config (allows dynamic database.php to work)..."
php artisan config:clear

echo "[deploy] Clearing route & view caches..."
php artisan route:clear
php artisan view:clear

echo "[deploy] Caching routes & views (safe to cache, no closures)..."
php artisan route:cache
php artisan view:cache

echo "[deploy] Running database migrations..."
php artisan migrate --force

echo "[deploy] Done."
