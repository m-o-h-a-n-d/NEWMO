FROM php:8.2-fpm

# تثبيت system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    curl \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libcurl4-openssl-dev \
    libssl-dev \
    vim

# تثبيت PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# إعداد مجلد العمل
WORKDIR /var/www

# نسخ الملفات
COPY . .

# إعداد صلاحيات الملفات
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage

# تثبيت الحزم
RUN composer install --optimize-autoloader --no-dev

# إنشاء key تلقائي لو مش موجود
RUN if [ ! -f .env ]; then cp .env.example .env; fi \
    && php artisan config:clear \
    && php artisan key:generate \
    && php artisan config:cache \
    && php artisan route:cache || true

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=8000
