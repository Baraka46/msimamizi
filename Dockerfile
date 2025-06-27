FROM richarvey/nginx-php-fpm:latest

RUN apk update && apk add --no-cache nodejs npm
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

WORKDIR /var/www/html
COPY . .

ENV SKIP_COMPOSER=1 \
    RUN_SCRIPTS=1 \
    WEBROOT=/var/www/html/public \
    PHP_ERRORS_STDERR=1 \
    REAL_IP_HEADER=1 \
    COMPOSER_ALLOW_SUPERUSER=1

CMD ["/start.sh"]
