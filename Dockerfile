FROM php:7.4-fpm-alpine
  
RUN apk add --no-cache \
        freetype-dev \
        libjpeg-turbo-dev \
        libwebp-dev \
        libpng-dev

RUN docker-php-ext-configure gd --with-freetype --with-webp --with-jpeg && \
    docker-php-ext-install gd