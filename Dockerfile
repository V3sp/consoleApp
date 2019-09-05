FROM php:7.3-fpm

RUN apt update
RUN apt -y install curl git unzip php7.3-common/stable php7.3-opcache/stable php7.3-readline/stable php7.3-json/stable php7.3-cli/stable
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
