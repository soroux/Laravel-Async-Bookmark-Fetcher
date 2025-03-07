FROM php:8.4-fpm

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    libzip-dev \
    libfreetype6-dev \
    libpq-dev \
    libsqlite3-dev \
    libjpeg-dev \
    libpng-dev \
    autoconf \
    zip \
    unzip \
    git \
    curl \
    supervisor \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install zip pdo_mysql pcntl bcmath gd pdo pdo_sqlite sockets \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/*


COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . /var/www

RUN composer install --no-interaction --prefer-dist


RUN chown -R www-data:www-data /var/www

USER www-data

COPY docker/nginx/supervisor.conf /etc/supervisord.conf

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
