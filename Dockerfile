FROM composer:2 AS composer_builder
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-progress \
    --prefer-dist \
    --optimize-autoloader

FROM node:20-alpine AS node_builder
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY resources ./resources
COPY vite.config.js ./
RUN npm run build

FROM php:8.2-fpm-bookworm AS app
RUN apt-get update && apt-get install -y --no-install-recommends \
    libpng-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo_mysql mbstring bcmath exif gd zip \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www

COPY . .
COPY --from=composer_builder /app/vendor ./vendor
COPY --from=node_builder /app/public/build ./public/build
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN chown -R www-data:www-data storage bootstrap/cache
RUN rm -f public/storage && ln -s /var/www/storage/app/public public/storage

EXPOSE 9000
CMD ["php-fpm"]

FROM nginx:1.27-alpine AS nginx
WORKDIR /var/www
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY --from=app /var/www/public ./public
COPY --from=app /var/www/storage/app/public ./storage/app/public
