# Stage 1: Build dependency menggunakan Composer
FROM composer:latest AS composer-vendor
WORKDIR /app
COPY . .
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Stage 2: Runtime Image menggunakan PHP 8.2 FPM Alpine
FROM php:8.2-fpm-alpine

# Install dependensi sistem & ekstensi PHP untuk Laravel / Database (MySQL/PostgreSQL)
RUN apk add --no-cache \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    oniguruma-dev \
    postgresql-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring gd xml

# Set direktori kerja
WORKDIR /var/www/html

# Copy file proyek dan vendor dari stage Composer
COPY . .
COPY --from=composer-vendor /app/vendor ./vendor

# Berikan izin akses folder storage & bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Exposure port
EXPOSE 8000

# Jalankan server Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
