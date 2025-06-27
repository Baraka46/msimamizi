FROM richarvey/nginx-php-fpm:latest

# Install Node & Composer
RUN apk update && apk add --no-cache nodejs npm
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Copy your application code
WORKDIR /var/www/html
COPY . .

# Copy deploy scripts into the container root
COPY scripts/ /scripts/
RUN chmod +x /scripts/*.sh

# Tell the image to run those scripts on startup
ENV RUN_SCRIPTS=1 \
    SKIP_COMPOSER=1 \
    WEBROOT=/var/www/html/public \
    PHP_ERRORS_STDERR=1 \
    REAL_IP_HEADER=1 \
    COMPOSER_ALLOW_SUPERUSER=1

# Start nginx + php-fpm
CMD ["/start.sh"]
