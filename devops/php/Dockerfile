FROM php:7.2-fpm-alpine

RUN apk add --no-cache autoconf g++ make

RUN docker-php-source extract \
    && pecl install -o -f xdebug \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable xdebug \
    && docker-php-source delete

COPY php/config/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

WORKDIR /var/www/app

RUN rm -R /var/www/html