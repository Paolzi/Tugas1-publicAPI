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

# Copy file proyek Laravel
COPY . .

# Exposure port
EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
