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

# Install Pact Ruby Standalone (platform-independent)
ENV PACT_STANDALONE_VERSION=2.0.2

RUN set -eux; \
    ARCH="$(uname -m)"; \
    if [ "$ARCH" = "x86_64" ]; then \
      PLATFORM="linux-x86_64"; \
    elif [ "$ARCH" = "aarch64" ]; then \
      PLATFORM="linux-arm64"; \
    else \
      echo "Unsupported architecture: $ARCH"; exit 1; \
    fi; \
    apt-get update && apt-get install -y curl && \
    curl -Lo /tmp/pact.tar.gz "https://github.com/pact-foundation/pact-ruby-standalone/releases/download/v${PACT_STANDALONE_VERSION}/pact-${PACT_STANDALONE_VERSION}-${PLATFORM}.tar.gz" && \
    mkdir -p /opt/pact && \
    tar -xzf /tmp/pact.tar.gz -C /opt/pact && \
    ln -s /opt/pact/pact/bin/pact /usr/local/bin/pact && \
    rm /tmp/pact.tar.gz

ENV PATH="/opt/pact/pact/bin:${PATH}"

# Disable PHP deprecation warnings
RUN sed -i 's/^error_reporting = .*/error_reporting = E_ALL \& ~E_DEPRECATED \& ~E_USER_DEPRECATED/' /usr/local/etc/php/php.ini || \
    echo "error_reporting = E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED" >> /usr/local/etc/php/php.ini

WORKDIR /app
