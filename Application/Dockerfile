FROM php:apache
RUN docker-php-ext-install mysqli
RUN docker-php-ext-install pdo
COPY src /var/www/html
EXPOSE 80
