FROM php:8.2-apache

# تثبيت المكتبات والامتدادات المطلوبة
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install gd zip mysqli

# نسخ ملفات المشروع
COPY . /var/www/html/

WORKDIR /var/www/html

# تفعيل rewrite فقط (بدون تحميل MPM إضافي)
RUN a2enmod rewrite

# تثبيت Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php

# تحديث الاعتمادات
RUN composer update --no-dev --optimize-autoloader

EXPOSE 80

CMD ["apache2-foreground"]
