FROM dunglas/frankenphp:1.0.3-php8.2 as base

# Be sure to replace "your-domain-name.example.com" by your domain name
ENV SERVER_NAME=loggy-blog.onrender.com

RUN apt-get update \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y --no-install-recommends \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    unzip \
    libpq-dev \
    libzip-dev \
    libicu-dev \
    nodejs \
    npm 

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \ 
&& docker-php-ext-install -j$(nproc) gd intl zip exif 
RUN docker-php-ext-configure pgsql -with-pgsql=/user/local/pgsql \
&& docker-php-ext-install  pdo pdo_pgsql pgsql 
# RUN docker-php-ext-install  pdo pdo_pgsql pgsql intl zip exif  
RUN docker-php-ext-enable intl zip pdo_pgsql pgsql exif

# Enable PHP production settings
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Copy the PHP files of your project in the public directory
# COPY . /app/public
# If you use Symfony or Laravel, you need to copy the whole project instead:
COPY . /app

WORKDIR /app

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Installation et configuration de votre site pour la production
# https://laravel.com/docs/10.x/deployment#optimizing-configuration-loading
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Optimization
RUN php artisan optimize

# Compilation des assets de Breeze (ou de votre site)
RUN npm install
RUN npm run build

# Set permissions
RUN chown -R www-data:www-data vendor node_modules

