FROM php:8.1.2-fpm-alpine

ADD ./php/www.conf /usr/local/etc/php-fpm.d/www.conf

RUN addgroup -g 1000 laravel && adduser -G laravel -g laravel -s /bin/sh -D laravel

RUN mkdir -p /var/www/html

RUN chown laravel:laravel /var/www/html
# Install selected extensions and other stuff
RUN apk update \
	&& apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
	&& pecl install redis \
	&& apk --no-cache add \
	postgresql-dev \
	&& apk del -f .build-deps


WORKDIR /var/www/html

RUN docker-php-ext-install pdo pdo_pgsql

RUN docker-php-ext-enable redis