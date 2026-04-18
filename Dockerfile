FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install gd zip mysqli

COPY . /var/www/html/

WORKDIR /var/www/html

RUN a2enmod rewrite

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php

RUN composer update --no-dev --optimize-autoloader

EXPOSE 80

CMD ["apache2-foreground"]
