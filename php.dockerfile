FROM php:7.1-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql mysqli
