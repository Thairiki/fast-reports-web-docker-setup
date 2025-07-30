FROM php:8.2-fpm
RUN apt-get update && apt-get install -y libcurl4-openssl-dev
RUN docker-php-ext-install curl
WORKDIR /var/www/html
COPY index.php .
EXPOSE 9000
CMD ["php-fpm"]