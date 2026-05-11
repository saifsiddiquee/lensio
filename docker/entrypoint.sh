#!/bin/bash
# =============================================================================
# Lensio CRM — Container Entrypoint
# Runs once on container start before supervisord takes over.
# =============================================================================

set -e

APP_DIR="/var/www/html"

echo "──────────────────────────────────────────"
echo "  Lensio CRM — Starting up"
echo "──────────────────────────────────────────"

cd "$APP_DIR"

# ── 1. Ensure storage directories exist and are writable ─────────────────────
echo "[1/6] Setting up storage directories..."
mkdir -p storage/framework/{sessions,views,cache}
mkdir -p storage/logs
mkdir -p bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# ── 2. Generate APP_KEY if not set ───────────────────────────────────────────
if [ -z "$APP_KEY" ]; then
    echo "[2/6] Generating application key..."
    php artisan key:generate --force
else
    echo "[2/6] APP_KEY already set — skipping."
fi

# ── 3. Wait for PostgreSQL to be ready ───────────────────────────────────────
echo "[3/6] Waiting for PostgreSQL at ${DB_HOST}:${DB_PORT}..."
MAX_TRIES=30
COUNT=0
until php -r "
    try {
        \$pdo = new PDO(
            'pgsql:host=${DB_HOST};port=${DB_PORT};dbname=${DB_DATABASE}',
            '${DB_USERNAME}',
            '${DB_PASSWORD}'
        );
        echo 'ok';
    } catch (Exception \$e) {
        exit(1);
    }
" 2>/dev/null | grep -q "ok"; do
    COUNT=$((COUNT + 1))
    if [ "$COUNT" -ge "$MAX_TRIES" ]; then
        echo "ERROR: PostgreSQL did not become ready in time. Exiting."
        exit 1
    fi
    echo "  Waiting... (attempt $COUNT/$MAX_TRIES)"
    sleep 2
done
echo "  PostgreSQL is ready."

# ── 4. Run database migrations ───────────────────────────────────────────────
echo "[4/6] Running migrations..."
php artisan migrate --force --no-interaction

# ── 5. Cache configuration for production ────────────────────────────────────
if [ "$APP_ENV" = "production" ]; then
    echo "[5/6] Caching config, routes, and views..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    php artisan event:cache
else
    echo "[5/6] Non-production env — skipping cache."
    php artisan config:clear
    php artisan route:clear
    php artisan view:clear
fi

# ── 6. Optimise autoloader ───────────────────────────────────────────────────
echo "[6/6] Optimising autoloader..."
composer dump-autoload --optimize --no-dev 2>/dev/null || true

echo "──────────────────────────────────────────"
echo "  Setup complete. Starting services..."
echo "──────────────────────────────────────────"

# Hand off to CMD (supervisord)
exec "$@"
