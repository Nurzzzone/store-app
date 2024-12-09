FROM php:8.2.26

RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    libzip-dev \
    git \
    curl \
    default-mysql-client \
    && docker-php-ext-install mysqli pdo pdo_mysql zip pcntl

RUN usermod -u 1000 www-data

