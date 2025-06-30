# Build Stage
FROM richarvey/nginx-php-fpm:latest AS builder

WORKDIR /var/www/html

# Install Node and Composer
RUN apk update && apk add --no-cache nodejs npm \
  && curl -sS https://getcomposer.org/installer | php \
  && mv composer.phar /usr/local/bin/composer

COPY . .

RUN cp .env.example .env
RUN composer install --no-dev --optimize-autoloader
RUN npm ci && npm run build
RUN php artisan key:generate && php artisan config:cache && php artisan route:cache && php artisan view:cache

# Runtime Stage
FROM richarvey/nginx-php-fpm:latest

WORKDIR /var/www/html

COPY --from=builder /var/www/html .
COPY nginx.conf /etc/nginx/conf.d/default.conf

COPY docker/php-memory.ini /etc/php8/conf.d/99-memory-limit.ini

# ✅ Tell NGINX to serve Laravel from /public
ENV WEBROOT=/var/www/html/public

CMD ["/bin/sh", "-c", "php artisan config:clear && php artisan route:clear && php artisan cache:clear && php artisan view:clear && /start.sh"]
