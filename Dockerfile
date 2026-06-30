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

# 2. Configure and install PHP extensions (termasuk GD dengan dukungan WebP & JPEG, serta intl)
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

# 8. Set permission folder storage & bootstrap cache agar Laravel bisa menulis log/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 9. Jalankan composer install untuk mengunduh dependensi produksi langsung saat build
RUN composer install --no-interaction --optimize-autoloader --no-dev

# 10. Expose port 80 untuk Apache
EXPOSE 80
