#!/bin/sh

php artisan migrate --force
php artisan storage:link
exec /start-container
