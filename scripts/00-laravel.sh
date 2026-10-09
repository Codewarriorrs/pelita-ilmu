#!/usr/bin/env bash
# scripts/00-laravel.sh
# Runs automatically on container startup via richarvey/nginx-php-fpm RUN_SCRIPTS=1
# Urutan penting:
#   1. Clear semua cache lama agar environment variables Railway terbaca fresh
#   2. Cache ulang config + route + view untuk performa production
#   3. Jalankan migrate (safe dengan --force)
#   4. Jalankan queue worker di background

set -e

cd /var/www/html

# ── 1. Clear semua cache lama ────────────────────────────────────────────────
echo "[deploy] Clearing old caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan event:clear

# ── 2. Cache ulang untuk performa production ─────────────────────────────────
# config:cache HARUS dijalankan setelah environment variable Railway tersedia
echo "[deploy] Caching config, routes, views, events..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# ── 3. Optimasi autoloader & package discovery ───────────────────────────────
echo "[deploy] Running optimize..."
php artisan optimize

# ── 4. Database migrations ───────────────────────────────────────────────────
echo "[deploy] Running database migrations..."
php artisan migrate --force

# ── 5. Queue worker (background) ─────────────────────────────────────────────
# Jalankan worker di background agar queue jobs tidak blocking request user.
# Diperlukan karena QUEUE_CONNECTION=database di production.
echo "[deploy] Starting queue worker in background..."
php artisan queue:work --sleep=3 --tries=3 --max-time=3600 --daemon &

echo "[deploy] Done."
