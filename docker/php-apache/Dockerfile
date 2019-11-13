FROM php:7.2-apache

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN apt-get update && apt-get install -y git libicu-dev zip libzip-dev libldb-dev libldap2-dev
RUN docker-php-ext-install -j$(nproc) intl zip ldap json