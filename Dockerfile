FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libicu-dev \
    && docker-php-ext-install zip pdo_mysql intl  \
    && pecl install apcu xdebug\
    && docker-php-ext-enable apcu xdebug

# Install AMQP extension for PHP
RUN apt-get update \
    && apt-get install -y librabbitmq-dev \
    && docker-php-ext-install sockets \
    && pecl install amqp \
    && docker-php-ext-enable amqp

ENV UMASK=0000
RUN echo "umask $UMASK" >> /etc/profile

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
