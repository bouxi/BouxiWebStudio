FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libpng-dev \
    libjpeg-dev \
    libwebp-dev \
    libzip-dev \
 && docker-php-ext-configure intl \
 && docker-php-ext-configure gd --with-jpeg --with-webp \
 && docker-php-ext-install intl pdo pdo_mysql zip gd

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
