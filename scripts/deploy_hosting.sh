#!/usr/bin/env bash
set -euo pipefail

if [[ ! -f artisan ]]; then
  echo "Run this script from the project root."
  exit 1
fi

if [[ ! -f .env ]]; then
  echo ".env not found. Copy .env.production.example to .env and fill secrets first."
  exit 1
fi

echo "Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

echo "Generating APP_KEY if missing..."
if ! grep -qE '^APP_KEY=base64:' .env; then
  php artisan key:generate --force
else
  echo "APP_KEY already set, skipping."
fi

echo "Running database migrations..."
php artisan migrate --force

echo "Linking storage..."
php artisan storage:link || true

echo "Caching config/routes/views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Deployment commands finished."
