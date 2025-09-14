FROM php:8.2-apache

# Enable Apache modules commonly needed for PHP apps
RUN a2enmod rewrite headers

# Install PHP extensions (mysqli + pdo_mysql for MySQL/MariaDB)
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Optional: dev-oriented php.ini
COPY docker/php/php.ini /usr/local/etc/php/conf.d/dev.ini

# Set proper permissions for Apache (www-data)
WORKDIR /var/www/html
