# 1. Base image with nginx + php-fpm
FROM richarvey/nginx-php-fpm:latest

# 2. Install Node.js (for asset builds like Vite or Mix)
RUN apk update && apk add --no-cache nodejs npm

# 3. Add Composer binary
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# 4. Copy application code
WORKDIR /var/www/html
COPY . .

# 5. Install PHP & JS dependencies, build assets, cache config/routes, run migrations
RUN composer install --no-dev --optimize-autoloader && \
    npm install && npm run build && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan migrate --force

# 6. Set environment variables for Render
ENV WEBROOT=/var/www/html/public \
    PHP_ERRORS_STDERR=1 \
    REAL_IP_HEADER=1 \
    RUN_SCRIPTS=0 

# 7. Use default start command (nginx + php-fpm)
CMD ["/start.sh"]
