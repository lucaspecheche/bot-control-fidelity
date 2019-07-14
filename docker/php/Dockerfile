FROM php:7.2-fpm
RUN docker-php-ext-install mysqli pdo_mysql

## Install composer globally
RUN echo "Install composer globally"
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer
