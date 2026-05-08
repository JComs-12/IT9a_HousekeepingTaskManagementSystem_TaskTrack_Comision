#!/bin/sh
set -e

# ── Copy .env if missing ──────────────────────
if [ ! -f /var/www/html/.env ]; then
    echo "⚠  .env not found — copying from .env.example"
    cp /var/www/html/.env.example /var/www/html/.env
fi

# ── Generate app key if not set ───────────────
if grep -q "^APP_KEY=$" /var/www/html/.env; then
    echo "🔑  Generating application key..."
    php /var/www/html/artisan key:generate --force
fi

# ── Run migrations ────────────────────────────
echo "🗄  Running database migrations..."
php /var/www/html/artisan migrate --force --no-interaction

# ── Optimise for production ───────────────────
echo "⚡  Caching config, routes & views..."
php /var/www/html/artisan config:cache
php /var/www/html/artisan route:cache
php /var/www/html/artisan view:cache

# ── Storage link ──────────────────────────────
php /var/www/html/artisan storage:link --quiet || true

echo "✅  TaskTrack is ready — starting services..."
exec "$@"
