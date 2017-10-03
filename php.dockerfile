FROM php:7.1-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN apk add --update libpng-dev freetype-dev libjpeg-turbo-dev
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/
RUN docker-php-ext-install gd
