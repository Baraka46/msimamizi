FROM richarvey/nginx-php-fpm:latest

# Install Node.js, npm, and Composer
RUN apk update && apk add --no-cache nodejs npm && \
    curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy app files
COPY . .

# Copy and make any custom scripts executable
COPY scripts/ /scripts/
RUN chmod +x /scripts/*.sh || true

# Copy .env.example to prevent artisan errors during build
RUN cp .env.example .env

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Environment variables (Render will override these at runtime)
ENV RUN_SCRIPTS=1 \
    SKIP_COMPOSER=0 \
    WEBROOT=/var/www/html/public \
    PHP_ERRORS_STDERR=1 \
    REAL_IP_HEADER=1 \
    COMPOSER_ALLOW_SUPERUSER=1

  
    COPY docker/php.ini /etc/php8/conf.d/99-custom.ini
EXPOSE 80



# ✅ This is the only CMD — and it's in the correct position
CMD ["/start.sh"]
