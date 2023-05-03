# ONLY FOR DEVELOPMENT PURPOSES - Heroku is used in prod
FROM php:8.2-apache

RUN apt-get update \
    && apt-get install -y iproute2 wget gnupg git bash unzip autoconf build-essential libicu-dev \
    && docker-php-ext-install opcache intl bcmath \
    && yes | pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.log=/tmp/xdebug.log" >> /usr/local/etc/php/conf.d/xdebug.ini

COPY --from=composer:2.5 /usr/bin/composer /usr/bin/composer

ADD ./docker/web/dev-entrypoint.sh /dev-entrypoint.sh
ADD ./docker/web/php.ini /usr/local/etc/php/php.ini

RUN a2enmod rewrite

WORKDIR /app
ENV APACHE_DOCUMENT_ROOT /app/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN echo "ServerName local-dev.jamestitcumb.com" >> /etc/apache2/apache2.conf

ADD composer.json composer.lock /app/
RUN composer install --prefer-dist --no-scripts

ADD /config /app/config
ADD /data /app/data
ADD /public /app/public
ADD /src /app/src
ADD /templates /app/templates
ADD /test /app/test
ADD app.php phpcs.xml.dist phpunit.xml.dist psalm.xml.dist .psalm-baseline.xml /app/

ENTRYPOINT ["/dev-entrypoint.sh"]
CMD ["apache2-foreground"]
