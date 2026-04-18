# استخدام صورة PHP الرسمية
FROM php:8.1-cli

# تثبيت المكتبات والامتدادات المطلوبة
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install gd zip

# نسخ ملفات المشروع إلى داخل الحاوية
COPY . /var/www/html

# تحديد مجلد العمل
WORKDIR /var/www/html

# تثبيت الاعتمادات عبر Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php

RUN composer install --no-dev --optimize-autoloader

# تشغيل التطبيق
CMD ["php", "index.php"]
