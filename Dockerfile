FROM php:8.1-cli

# تثبيت المكتبات المطلوبة لـ GD
RUN apt-get update && apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libwebp-dev \
    zlib1g-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install gd

# تثبيت Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . /app

# تثبيت الاعتمادات
RUN composer install --no-dev --optimize-autoloader

CMD ["php", "index.php"]
