FROM php:8.1-cli

RUN docker-php-ext-install gd

WORKDIR /app
COPY . /app

RUN composer install --no-dev --optimize-autoloader

CMD ["php", "index.php"]
