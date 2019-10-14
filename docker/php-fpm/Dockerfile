FROM php:7.3-fpm-alpine

RUN mkdir -p /usr/share/php-fpm \
    && apk add --update iproute2 wget gnupg netcat-openbsd git bash unzip autoconf build-base \
      icu-dev \
    && docker-php-ext-install opcache intl \
    && yes | pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_connect_back=off" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_addr_header=REMOTE_ADDR" >> /usr/local/etc/php/conf.d/xdebug.ini

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ADD ./docker/php-fpm/php-fpm.conf /usr/local/etc/php-fpm.d/php-fpm.conf
ADD ./docker/php-fpm/php.ini /usr/local/etc/php/php.ini
ADD ./docker/php-fpm/php-xdebug /usr/bin/php-xdebug

WORKDIR /app

EXPOSE 9001

CMD ["php-fpm", "--allow-to-run-as-root"]
