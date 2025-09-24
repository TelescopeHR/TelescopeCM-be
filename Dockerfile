FROM php:8.2-fpm

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

# Copy existing application directory contents
COPY . /var/www/html

# Copy existing application directory permissions
COPY --chown=www-data:www-data . /var/www/html

# copy rest of project
COPY . /app

# run any extra composer scripts (if needed) and optimize
RUN composer install --no-dev --optimize-autoloader --no-interaction \
 && php -r "file_exists('bootstrap/cache') || mkdir('bootstrap/cache', 0755, true);"

RUN php artisan config:cache \
 && php artisan route:cache \
 && php artisan view:cache

# make sure permissions for storage & cache
RUN addgroup -g 1000 appuser \
 && adduser -D -u 1000 -G appuser appuser \
 && chown -R appuser:appuser /var/www/html/storage /var/www/html/bootstrap/cache

# Copy Nginx configuration
COPY docker/nginx.conf /etc/nginx/sites-available/default

# Copy Supervisor configuration
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# switch to non-root user
USER appuser

# expose php-fpm port
EXPOSE 80 443

# Start Apache
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
