
FROM php:8.2-apache

RUN docker-php-ext-install mysqli
RUN a2enmod rewrite

ENV PORT=10000

WORKDIR /var/www/html

COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html

CMD ["bash", "-lc", "sed -i 's/Listen 80/Listen ${PORT}/' /etc/apache2/ports.conf && sed -i 's/:80>/:${PORT}>/' /etc/apache2/sites-available/000-default.conf && apache2-foreground"]
