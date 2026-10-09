#!/usr/bin/env bash
# scripts/00-laravel.sh
# Runs automatically on container startup via richarvey/nginx-php-fpm RUN_SCRIPTS=1

cd /var/www/html

# ── 0. Pastikan vendor/autoload.php siap sebelum artisan dipanggil ──────────────
if [ ! -f /var/www/html/vendor/autoload.php ]; then
    echo "[deploy] vendor/autoload.php missing, running composer install..."
    export COMPOSER_ALLOW_SUPERUSER=1
    composer install --no-dev --prefer-dist --optimize-autoloader --no-interaction || true
fi

# ── 1. Clear semua cache lama agar ENV Railway terbaca fresh ──────────────────
echo "[deploy] Clearing old caches..."
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true
php artisan event:clear || true
php artisan filament:clear-cached-components || true

# ── 2. Discover packages & Cache ulang untuk performa production ──────────────
echo "[deploy] Discovering packages..."
php artisan package:discover --ansi || true

echo "[deploy] Caching config, routes, views, filament components..."
php artisan config:cache || echo "[deploy] Warning: config:cache failed"
php artisan route:cache || echo "[deploy] Warning: route:cache failed"
php artisan view:cache || echo "[deploy] Warning: view:cache failed"
php artisan filament:cache-components || echo "[deploy] Warning: filament:cache-components failed"

# ── 3. Database migrations (safe, migrasikan sessions & semua tabel) ───────────
echo "[deploy] Running database migrations..."
php artisan migrate --force || echo "[deploy] Warning: migrate failed (database might be waking up), continuing boot..."

# ── 4. Queue worker (background) ─────────────────────────────────────────────
echo "[deploy] Starting queue worker in background..."
php artisan queue:work --sleep=3 --tries=3 --max-time=3600 --daemon &

echo "[deploy] Startup script completed. Nginx & PHP-FPM ready."
