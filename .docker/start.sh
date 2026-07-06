#!/bin/sh
set -e

cd /var/www/html

# Laravel still needs a .env file present for artisan commands. It also
# needs an APP_KEY= line to already exist, otherwise `key:generate` finds
# nothing to replace, prints an error, and exits 0 anyway — leaving the
# app running with no encryption key at all (every request 500s).
touch .env
grep -q '^APP_KEY=' .env || echo 'APP_KEY=' >> .env

# Only generate a key when one wasn't provided via the environment
# (e.g. local docker-compose). On Render, APP_KEY should be set to a
# valid base64 value in the dashboard and is used directly — do NOT
# regenerate or unset it. If it's still missing here, generate one as a
# fallback so the app stays up, though sessions won't survive a redeploy
# until a real APP_KEY is set in the environment.
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Run migrations
php artisan migrate --force

# Run seeders on every deploy. Each seeder guards its own inserts (checks
# for an existing row before creating one), so this is safe to repeat and
# won't touch real data added through the app — it only fills in gaps.
# This also self-heals the demo admin account if it's ever missing.
php artisan db:seed --force || true

# Create storage symlink
php artisan storage:link --force 2>/dev/null || true

# Cache config/routes/views for production. The valid APP_KEY from the
# environment is baked into the cached config here.
if [ "$APP_ENV" = "production" ]; then
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
fi

# Start supervisord (php-fpm workers use the cached config / env APP_KEY)
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
