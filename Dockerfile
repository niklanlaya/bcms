FROM php:8.2-apache

# Install extensions
RUN docker-php-ext-install pdo pdo_mysql

# Enable mod_rewrite for MVC routing
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# ** แก้ไขจุดที่ 1: เปลี่ยน DocumentRoot ของ Apache ให้ชี้ไปที่โฟลเดอร์ public **
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Permissions
RUN chown -R www-data:www-data /var/www/html