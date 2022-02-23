#!/bin/sh
set -e

/usr/bin/supervisord

# first arg is `-f` or `--some-option`
if [ "${1#-}" != "$1" ]; then
	set -- php-fpm "$@"
fi

mkdir -p config/jwt/
if [ ! -f config/jwt/private.pem ]; then
	echo "$JWT_SECRET_KEY_CONTENT" > config/jwt/private.pem
	echo "COPY PRIVATE KEY INFO"
fi
export JWT_SECRET_KEY="%kernel.project_dir%/config/jwt/private.pem"
#
if [ ! -f config/jwt/public.pem ]; then
	echo "$JWT_PUBLIC_KEY_CONTENT" > config/jwt/public.pem
	echo "COPY public KEY INFO"
fi
export JWT_PUBLIC_KEY="%kernel.project_dir%/config/jwt/public.pem"

# Backup env variables for kudu ssh user
export > /etc/profile

if [ "$1" = "php-fpm" ] || [ "$1" = "bin/console" ]; then
	rm -rf var/cache var/log && mkdir -p var/cache var/log
	setfacl -R -m u:www-data:rwX -m u:"$(whoami)":rwX var
	setfacl -dR -m u:www-data:rwX -m u:"$(whoami)":rwX var

	if [ "$APP_ENV" != "prod" ]; then
		composer install --prefer-dist --no-progress --no-interaction
		if [ "$LOAD_FIXTURES" == "true" ]; then
			bin/console h:f:l -n
		fi
	fi

#	if [ "$SKIP_MIGRATION" != "true" ]; then
#		bin/console doctrine:migrations:migrate --no-interaction
#	fi
fi

exec docker-php-entrypoint "$@"
