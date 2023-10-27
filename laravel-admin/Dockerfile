FROM php:8.2

RUN apt-get update -y && apt-get install -y openssl zip unzip git libpq-dev libcurl4-gnutls-dev libonig-dev libzip-dev
RUN curl -s$ https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo mbstring pdo_mysql mysqli zip

WORKDIR /app
COPY . .
RUN composer install

CMD php artisan serve --host=0.0.0.0
EXPOSE 8000
