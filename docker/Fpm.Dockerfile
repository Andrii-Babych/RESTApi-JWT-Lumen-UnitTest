FROM php:8.0-fpm

RUN apt-get update
RUN apt-get install -y libpq-dev
RUN docker-php-ext-install pdo
RUN docker-php-ext-install pdo_pgsql
