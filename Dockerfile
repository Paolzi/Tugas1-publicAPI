
# Stage 1: Install Composer dependencies
FROM composer:latest AS composer-vendor

WORKDIR /app

COPY . .

RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist


# Stage 2: PHP-FPM runtime
FROM php:8.2-fpm-alpine

WORKDIR /var/www/html

# Install system dependencies and PHP extensions
RUN apk add --no-cache \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    oniguruma-dev \
    postgresql-dev \
    $PHPIZE_DEPS \
    && docker-php-ext-install -j"$(nproc)" \
        pdo_mysql \
        pdo_pgsql \
        mbstring \
        gd \
        xml \
        bcmath \
        opcache \
    && apk del $PHPIZE_DEPS

# Copy Laravel application
COPY . .

# Copy Composer dependencies from the first stage
COPY --from=composer-vendor /app/vendor ./vendor

# Set permissions for Laravel writable directories
RUN mkdir -p storage/framework/cache \
             storage/framework/sessions \
             storage/framework/views \
             storage/logs \
             bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Set Laravel environment
ENV APP_ENV=production
ENV APP_DEBUG=false

EXPOSE 9000

CMD ["php-fpm"]
