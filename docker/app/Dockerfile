FROM php:7.1-fpm

RUN apt-get update && apt-get install -y \
    libmcrypt-dev && \
    docker-php-ext-install pdo_mysql mcrypt

ARG INSTALL_XDEBUG=false
ARG DOCKER_HOST_IP=localhost
ARG XDEBUG_IDE_KEY=PHPSTORM
ARG XDEBUG_REMOTE_PORT=9000

RUN if [ ${INSTALL_XDEBUG} = true ]; then \
    pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=1" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_handler=dbgp" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_port=${XDEBUG_REMOTE_PORT}" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_connect_back=0" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.idekey=${XDEBUG_IDE_KEY}" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_host=${DOCKER_HOST_IP}" >> /usr/local/etc/php/conf.d/xdebug.ini \
;fi

