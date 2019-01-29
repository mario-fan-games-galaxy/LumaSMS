ARG PHP_VERSION=""
FROM php:${PHP_VERSION:+${PHP_VERSION}-}fpm-alpine

# Keep packages up to date
RUN apk update; \
    apk upgrade;

# Copy datetime setting over
COPY date.ini /usr/local/etc/php/conf.d/date.ini

# Copy session settings over
COPY session.ini /usr/local/etc/php/conf.d/session.ini

# Copy xdebug settings over
COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

# Copy short_tag settings over
COPY short_tag.ini /usr/local/etc/php/conf.d/short_tag.ini

# PHP module dependencies
RUN apk add --update $PHPIZE_DEPS argon2-dev curl-dev freetype-dev \
  gettext-dev icu-dev libedit-dev libpng-dev libxml2-dev libmemcached-dev \
  postgresql-dev zlib-dev;

# PHP Modules
RUN docker-php-ext-install bcmath exif gd gettext intl opcache \
  pdo_pgsql zip

# PECL - these package versions need to be changed if newer php is installed
RUN pecl install apcu-4.0.11 memcached-2.2.0 xdebug-2.5.5; \
  docker-php-ext-enable apcu memcached xdebug;

# Permissions
ARG FILES_USER_ID=""
ARG FILES_GROUP_ID=""
RUN apk add --update shadow && usermod -u ${FILES_USER_ID:-1000} www-data && groupmod -g ${FILES_GROUP_ID:-1000} www-data
