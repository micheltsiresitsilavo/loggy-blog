# Use PHP with Apache as the base image
FROM php:8.2-apache as web

# Install Additional System Dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libpq-dev \
    libzip-dev \
    libicu-dev \
    zip \
    unzip \
    git \
    nodejs \
    npm 
    

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite for URL rewriting
RUN a2enmod rewrite

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \ 
&& docker-php-ext-install -j$(nproc) gd intl zip exif 
RUN docker-php-ext-configure pgsql -with-pgsql=/user/local/pgsql \
&& docker-php-ext-install  pdo pdo_pgsql pgsql 
# RUN docker-php-ext-install  pdo pdo_pgsql pgsql intl zip exif  
RUN docker-php-ext-enable intl zip pdo_pgsql pgsql exif

# Configure Apache DocumentRoot to point to Laravel's public directory
# and update Apache configuration files
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
COPY apache-config.conf /etc/apache2/sites-available/000-default.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copy the application code
COPY . /var/www/html

# Set the working directory
WORKDIR /var/www/html

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Installation et configuration de votre site pour la production
# https://laravel.com/docs/10.x/deployment#optimizing-configuration-loading
RUN composer install --no-interaction --optimize-autoloader --no-dev
# Generate security key
RUN php artisan config:cache
# Optimizing Route loading
RUN php artisan route:cache
# Optimizing View loading
RUN php artisan view:cache
# echo "Running migrations..."
RUN php artisan migrate --force

# Compilation des assets de Breeze (ou de votre site)
RUN npm install
RUN npm run buil

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 80 for Apache.
EXPOSE 80

# Start Apache web server.
CMD ["apache2-foreground"]