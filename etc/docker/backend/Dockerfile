FROM php:8.2

RUN apt-get update && apt-get install --no-install-recommends --no-install-suggests -y \
		git \
        unzip \
        libicu-dev \
        zlib1g-dev \
        libssl-dev \
        pkg-config \
        libpq-dev \
        libzip-dev \
    && rm -rf /var/lib/apt/lists/*

RUN set -xe \
    && docker-php-ext-configure \
        intl \
    && docker-php-ext-install \
        intl \
        opcache \
        zip \
        pdo \
        pdo_mysql \
        pdo_pgsql

COPY php.ini /usr/local/etc/php/php.ini

COPY enter /usr/local/bin/enter

WORKDIR /app

CMD ["/usr/local/bin/enter"]