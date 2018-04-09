ARG PHP_VERSION=7.2
ARG ALPINE_VERSION=3.7
FROM php:${PHP_VERSION}-fpm-alpine${ALPINE_VERSION}

ENV APP_DIR=/srv/symfony

LABEL maintainer="Daniel Stancu <birkof@birkof.ro>"

RUN apk add --no-cache \
		git

ARG APCU_VERSION=5.1.11
RUN set -xe \
	&& apk add --no-cache --virtual .build-deps \
		$PHPIZE_DEPS \
		icu-dev \
		postgresql-dev \
		zlib-dev \
	&& docker-php-ext-install -j$(nproc) \
		intl \
		pdo_pgsql \
		zip \
		pcntl \
	&& pecl install \
		apcu-${APCU_VERSION} \
	&& pecl clear-cache \
	&& docker-php-ext-enable --ini-name 20-apcu.ini apcu \
	&& docker-php-ext-enable --ini-name 05-opcache.ini opcache \
	&& runDeps="$( \
		scanelf --needed --nobanner --format '%n#p' --recursive /usr/local/lib/php/extensions \
			| tr ',' '\n' \
			| sort -u \
			| awk 'system("[ -e /usr/local/lib/" $1 " ]") == 0 { next } { print "so:" $1 }' \
	)" \
	&& apk add --no-cache --virtual .api-phpexts-rundeps $runDeps \
	&& apk del .build-deps

# Build for production
ARG APP_ENV=prod

RUN rm -rf /var/cache/apk/* && rm -rf /tmp/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Tune php configuration.
COPY php.ini /usr/local/etc/php/php.ini

# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer global require "hirak/prestissimo" --prefer-dist --no-progress --no-suggest --classmap-authoritative \
	&& composer clear-cache
ENV PATH="${PATH}:/root/.composer/vendor/bin"
ENV PATH=${APP_DIR}/bin:${APP_DIR}/vendor/bin:${PATH}

# Symfony console shortcut
RUN echo '#!/bin/bash' > /usr/local/bin/console \
    && echo 'php -dmemory_limit=-1 ${APP_DIR}/app/bin/console $@' >> /usr/local/bin/console \
    && chmod +x /usr/local/bin/console

# Working dir
WORKDIR ${APP_DIR}
