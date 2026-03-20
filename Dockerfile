FROM php:8.1-apache

# Включение mod_rewrite и разрешение .htaccess
RUN a2enmod rewrite
RUN sed -i 's|AllowOverride None|AllowOverride All|' /etc/apache2/apache2.conf

# Установка системных зависимостей, PHP-расширений и Composer
RUN apt-get update && apt-get install -y \
        curl \
        unzip \
        libzip-dev \
    && docker-php-ext-install mysqli zip pdo pdo_mysql \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
