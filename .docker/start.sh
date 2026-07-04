#!/bin/sh
set -e

cd /var/www/html

# Laravel still needs a .env file present for artisan commands.
touch .env

# Only generate a key when one wasn't provided via the environment
# (e.g. local docker-compose). On Render, APP_KEY is set to a valid
# base64 value and is used directly — do NOT regenerate or unset it.
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Run migrations
php artisan migrate --force

# Seed only when the database is empty (fresh install). This prevents a
# redeploy from truncating/overwriting real data entered through the app.
USER_COUNT=$(php artisan tinker --execute="echo \App\Models\User::count();" 2>/dev/null | tr -dc '0-9')
if [ -z "$USER_COUNT" ] || [ "$USER_COUNT" = "0" ]; then
    php artisan db:seed --force || true
fi

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
