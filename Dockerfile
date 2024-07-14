# Use the official PHP image as base
FROM php:8.3-fpm

# Set working directory
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install pdo_mysql zip

# Install GD extension
RUN apt-get install -y libwebp-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install gd

# Copy project files
COPY . .


RUN chmod -R 777 storage
