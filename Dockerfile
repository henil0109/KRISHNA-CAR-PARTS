FROM php:8.2-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN a2enmod rewrite headers

WORKDIR /var/www/html
COPY . /var/www/html/
COPY apache.conf /etc/apache2/sites-available/000-default.conf

RUN mkdir -p /var/www/html/Admin/uploads /var/www/html/User/uploads \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 777 /var/www/html/Admin/uploads /var/www/html/User/uploads

EXPOSE 80
CMD ["apache2-foreground"]
