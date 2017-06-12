FROM php:7.0-apache
COPY / /var/www/html

RUN apt-get update && apt-get install -y git vim libmcrypt-dev zip unzip libpng-dev curl libcurl4-openssl-dev

RUN docker-php-ext-install pdo pdo_mysql gd curl
RUN docker-php-ext-install mcrypt

RUN a2enmod rewrite && service apache2 restart