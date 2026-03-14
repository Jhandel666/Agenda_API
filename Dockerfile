FROM php:8.2-apache

RUN docker-php-ext-install mysqli

COPY . /var/www/html/

ENV PORT 80
EXPOSE 80
