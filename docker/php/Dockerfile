FROM php:8.4-fpm

# Set working directory
WORKDIR /var/www

# Install dependencies
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
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install zip pdo_mysql pcntl bcmath gd pdo pdo_sqlite sockets \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/*


# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application
COPY . /var/www

# Install Laravel dependencies
RUN composer install --no-interaction --prefer-dist

# Set permissions

RUN chown -R www-data:www-data /var/www

# Switch to non-root user to avoid permission issues
USER www-data

# Expose port
EXPOSE 9000

CMD ["php-fpm"]
