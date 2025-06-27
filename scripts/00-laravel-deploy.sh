#!/usr/bin/env bash
echo "📦 Installing dependencies..."
composer install --no-dev --working-dir=/var/www/html

echo "🛠 Building frontend assets..."
npm install
npm run build

echo "⚙️ Caching configs & routes..."
php artisan config:cache
php artisan route:cache

echo "🧱 Running migrations..."
php artisan migrate --force

echo "🎉 Deploy script complete!"
