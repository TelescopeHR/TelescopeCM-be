FROM php:8.4-fpm

# Set working directory
WORKDIR /var/www/html

# install system dependencies and php extensions
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    nginx \
    supervisor \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy composer files first (to leverage caching)
COPY composer.json composer.lock ./

# run any extra composer scripts (if needed) and optimize
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts \
    && php -r "file_exists('bootstrap/cache') || mkdir('bootstrap/cache', 0755, true);"

# Copy existing application directory contents
COPY . /var/www/html

# Copy existing application directory permissions
COPY --chown=www-data:www-data . /var/www/html

# copy rest of project
COPY . /app

# Run scripts now that artisan exists
RUN php artisan package:discover --ansi || true

# Permissions for Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Copy nginx config
COPY ./docker/nginx.conf /etc/nginx/nginx.conf

# Copy supervisor config
COPY ./docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

RUN php artisan config:cache \
 && php artisan route:cache \
 && php artisan view:cache


# expose php-fpm port
EXPOSE 80 443

# Start Apache
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
