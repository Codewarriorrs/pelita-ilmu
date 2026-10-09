#!/usr/bin/env bash
# scripts/00-laravel.sh
# Runs automatically on container startup via richarvey/nginx-php-fpm RUN_SCRIPTS=1
# Urutan penting:
#   1. Clear semua cache lama agar environment variables Railway terbaca fresh
#   2. Cache ulang config + route + view untuk performa production
#   3. Jalankan migrate (safe dengan --force)
#   4. Jalankan queue worker di background

cd /var/www/html

# ── 1. Clear semua cache lama agar ENV Railway terbaca fresh ──────────────────
echo "[deploy] Clearing old caches..."
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true
php artisan event:clear || true

# ── 2. Cache ulang untuk performa production ─────────────────────────────────
echo "[deploy] Caching config, routes, views..."
php artisan config:cache || echo "[deploy] Warning: config:cache failed"
php artisan route:cache || echo "[deploy] Warning: route:cache failed"
php artisan view:cache || echo "[deploy] Warning: view:cache failed"

# ── 3. Database migrations (safe, jangan biarkan crash container) ─────────────
echo "[deploy] Running database migrations..."
php artisan migrate --force || echo "[deploy] Warning: migrate failed (database might be waking up), continuing boot..."

# ── 4. Queue worker (background) ─────────────────────────────────────────────
echo "[deploy] Starting queue worker in background..."
php artisan queue:work --sleep=3 --tries=3 --max-time=3600 --daemon &

echo "[deploy] Startup script completed. Nginx & PHP-FPM ready."
