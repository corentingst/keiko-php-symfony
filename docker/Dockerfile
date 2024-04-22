# the different stages of this Dockerfile are meant to be built into separate images
# https://docs.docker.com/compose/compose-file/#target

ARG PHP_VERSION=8.2
ARG NODE_VERSION=18

# PHP + Nginx
FROM php:${PHP_VERSION}-fpm-alpine AS backend_php

# persistent / runtime deps

RUN apk add --no-cache \
	acl \
	fcgi \
	file \
	gettext \
	mysql-client \
	openssl \
	nginx \
	nginx-mod-http-brotli \
	libc6-compat \
	supervisor \
	;

ARG APCU_VERSION=5.1.21
RUN set -eux; \
	apk add --no-cache --virtual .build-deps \
	$PHPIZE_DEPS \
	icu-dev \
	libzip-dev \
	zip \
	zlib-dev \
	libpng-dev \
    libpq-dev \
	; \
	\
	docker-php-ext-install -j$(nproc) \
	intl \
	mysqli \
	pdo \
	pdo_mysql \
    pdo_pgsql \
	zip \
	gd \
	; \
	pecl install \
	apcu-${APCU_VERSION} \
	; \
	pecl clear-cache; \
	docker-php-ext-enable \
	apcu \
	opcache \
	pdo_mysql \
    pdo_pgsql \
	gd \
	; \
	\
	runDeps="$( \
	scanelf --needed --nobanner --format '%n#p' --recursive /usr/local/lib/php/extensions \
	| tr ',' '\n' \
	| sort -u \
	| awk 'system("[ -e /usr/local/lib/" $1 " ]") == 0 { next } { print "so:" $1 }' \
	)"; \
	apk add --no-cache --virtual .api-phpexts-rundeps $runDeps; \
	\
	apk del .build-deps && \
	rm -rf /tmp/pear

COPY docker/supervisor/supervisord.conf /etc/supervisord.conf
COPY docker/supervisor/conf.d /etc/supervisor/conf.d

COPY --from=composer:2.1.9 /usr/bin/composer /usr/bin/composer
COPY docker/php/php.ini /usr/local/etc/php/php.ini
COPY docker/php/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
RUN echo "pm.max_children = 25" >> /usr/local/etc/php-fpm.d/zz-docker.conf

# https://getcomposer.org/doc/03-cli.md#composer-allow-superuser
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV PATH="${PATH}:/root/.composer/vendor/bin"

COPY docker/php/docker-entrypoint.sh /usr/local/bin/docker-entrypoint

# Config Nginx
COPY docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker/nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf

WORKDIR /srv/api

# prevent the reinstallation of vendors at every changes in the source code

COPY ./backend/composer.json  ./backend/composer.lock ./
RUN set -eux; \
	composer install --prefer-dist --no-dev --no-autoloader --no-scripts --no-progress; \
	composer clear-cache

#Set up debugger if needed
ARG INSTALL_XDEBUG=false
RUN if [ "$INSTALL_XDEBUG" = "true" ] ; then \
	apk add --no-cache $PHPIZE_DEPS \
	&& apk add --update linux-headers \
	&& pecl install xdebug \
	&& docker-php-ext-enable xdebug \
	&& apk del $PHPIZE_DEPS \
	&& rm -rf /tmp/pear; \
	fi ;

COPY ./backend ./
RUN set -eux; \
	mkdir -p var/cache var/log; \
	composer dump-autoload --classmap-authoritative --no-dev; \
	touch .env; \
	chmod +x bin/console; sync

VOLUME /srv/api/var
EXPOSE 80 2222
ENTRYPOINT ["docker-entrypoint"]
CMD ["php-fpm"]
