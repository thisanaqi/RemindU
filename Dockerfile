# Use an official PHP image with Apache
FROM php:8.1-apache

# Install required PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Copy project files into the Apache server directory
COPY . /var/www/html/

# Enable mod_rewrite for Apache
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html/

# Change permissions
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
