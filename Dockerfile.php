FROM php:8-apache
ENV APACHE_DOCUMENT_ROOT /var/www/html

RUN a2enmod rewrite
# install mysqli
RUN docker-php-ext-install mysqli