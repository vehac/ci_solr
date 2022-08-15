FROM php:7.4-apache

RUN apt-get update && apt-get install -y git libzip-dev zlib1g-dev libicu-dev g++ libxml2-dev libmcrypt-dev libreadline-dev curl libcurl4-gnutls-dev pkg-config libssl-dev libonig-dev \
 default-mysql-client openssl build-essential vim nano zip unzip wget

# install mcrypt ext
RUN pecl install mcrypt-1.0.4

# install ext php
RUN docker-php-ext-configure intl && docker-php-ext-install intl \
 && docker-php-ext-install zip pdo pdo_mysql mysqli xml \
 && docker-php-ext-install soap && docker-php-ext-enable mcrypt \
 && docker-php-ext-install mbstring && docker-php-ext-install curl \
 && docker-php-ext-install bcmath && docker-php-ext-install sockets \
 && apt-get install -y libfreetype6-dev libpng-dev libjpeg-dev libwebp-dev \
 && docker-php-ext-configure gd \
    --with-freetype=/usr/include/ \
    --with-jpeg=/usr/include/ \
    --with-webp=/usr/include/ \
 && docker-php-ext-install -j$(nproc) gd \
 && apt-get purge -y libfreetype6-dev libpng-dev libjpeg-dev

#active a2enmod and install composer
RUN a2enmod rewrite && a2enmod ssl && a2enmod headers \
 && curl -sS https://getcomposer.org/installer \
  | php -- --install-dir=/usr/local/bin --filename=composer

# clean the image
RUN rm -rf /var/lib/apt/lists/* /tmp/*

EXPOSE 80

ADD ./localhost.conf /etc/apache2/sites-enabled/000-default.conf

WORKDIR /var/www/html