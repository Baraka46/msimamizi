# 1. Base image with nginx + php-fpm
FROM richarvey/nginx-php-fpm:latest

# 2. Install Node.js for asset building
RUN apk update && apk add --no-cache nodejs npm

# 3. Add Composer binary
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# 4. Copy application code
WORKDIR /var/www/html
COPY . .

# 5. Build everything before runtime
RUN composer install --no-dev --optimize-autoloader && \
    npm ci && npm run build && \
    php artisan migrate --force && \
    php artisan config:cache && \
    php artisan route:cache

# 6. Tell the container to run deploy scripts and set other flags
ENV WEBROOT=/var/www/html/public \
    PHP_ERRORS_STDERR=1 \
    REAL_IP_HEADER=1 \
    RUN_SCRIPTS=1 \
    SKIP_COMPOSER=1 \
    COMPOSER_ALLOW_SUPERUSER=1

# 7. Default command: start nginx + php-fpm
CMD ["/start.sh"]
