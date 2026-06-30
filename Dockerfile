# === Stage 1: Build Assets dengan Node.js ===
FROM node:20-alpine AS asset-builder
WORKDIR /app
COPY package*.json vite.config.js ./
COPY resources/ ./resources/
COPY public/ ./public/
RUN npm ci && npm run build

# === Stage 2: Main Application dengan PHP Apache ===
FROM php:8.3-apache

# 1. Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libwebp-dev \
    libzip-dev \
    libpq-dev \
    libicu-dev \
    zip \
    unzip \
    git \
    curl \
    && rm -rf /var/lib/apt/lists/*

# 2. Configure and install PHP extensions (GD WebP, zip, pgsql, intl)
RUN docker-php-ext-configure gd --with-jpeg --with-webp \
    && docker-php-ext-install gd zip pdo_pgsql intl

# 3. Enable Apache mod_rewrite untuk routing Laravel
RUN a2enmod rewrite

# 4. Ganti Document Root Apache ke folder public Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 5. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 6. Set working directory
WORKDIR /var/www/html

# 7. Copy seluruh file proyek ke container
COPY --chown=www-data:www-data . .

# 8. Copy hasil kompilasi aset Vite dari Stage 1 (Node.js)
COPY --from=asset-builder --chown=www-data:www-data /app/public/build ./public/build

# 9. Set permission folder storage & cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 10. Jalankan composer install untuk mengunduh dependensi produksi
RUN composer install --no-interaction --optimize-autoloader --no-dev

# 11. Expose port 80 untuk Apache
EXPOSE 80
