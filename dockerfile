FROM composer:latest
COPY . /usr/src/hotel/
WORKDIR /usr/src/hotel/
RUN docker-php-ext-install pdo pdo_mysql
CMD ["php", "artisan", "serve","--host=0.0.0.0"]


