FROM richarvey/nginx-php-fpm:3.1.6


RUN apk add postgresql-dev nodejs npm 
  

# Install PHP extensions
RUN docker-php-ext-configure pgsql \
&& docker-php-ext-install exif  pdo_pgsql pgsql 
# RUN docker-php-ext-install  pdo pdo_pgsql pgsql intl zip exif  
RUN docker-php-ext-enable intl zip pdo_pgsql pgsql exif    
COPY . .

# Image config
ENV SKIP_COMPOSER 1
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Laravel config
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

# Allow composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER 1

CMD ["/start.sh"]