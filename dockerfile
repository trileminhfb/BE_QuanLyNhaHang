FROM php:8.2-apache

# Cài extension Laravel cần
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git curl libpng-dev libonig-dev libxml2-dev zip \
    && docker-php-ext-install pdo pdo_mysql zip mbstring exif pcntl

# Cài Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy code vào container
COPY . /var/www/html

WORKDIR /var/www/html

# Cài Laravel dependencies
RUN composer install --optimize-autoloader --no-dev

# Set quyền
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Enable rewrite mod
RUN a2enmod rewrite

EXPOSE 80
