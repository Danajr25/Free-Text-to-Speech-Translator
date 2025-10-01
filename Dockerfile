FROM php:8.2-fpm

# Install dependencies (including PostgreSQL development libraries)
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libzip-dev \
    libonig-dev \
    nginx \
    libpq-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions (including PostgreSQL)
RUN docker-php-ext-install pdo_mysql pdo_pgsql mbstring zip exif pcntl
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy composer files first for better layer caching
COPY composer.json composer.lock ./

# Install dependencies with increased memory limit
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN php -d memory_limit=-1 /usr/bin/composer install --no-dev --no-autoloader --no-scripts

# Copy existing application directory
COPY . /var/www/

# Generate optimized autoload files
RUN php -d memory_limit=-1 /usr/bin/composer dump-autoload --optimize --no-dev

# Set up Nginx config
COPY docker/nginx/nginx.conf /etc/nginx/sites-enabled/default

# Create .env from .env.example and generate key if needed
RUN if [ ! -f .env ]; then cp .env.example .env; fi && php artisan key:generate --force

# Set permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Create start script that includes migrations
RUN echo '#!/bin/bash' > /start.sh && \
    echo 'echo "Starting Laravel application..."' >> /start.sh && \
    echo 'echo "Running database migrations..."' >> /start.sh && \
    echo 'php artisan migrate --force --no-interaction || echo "Migration failed - continuing startup"' >> /start.sh && \
    echo 'echo "Caching configuration..."' >> /start.sh && \
    echo 'php artisan config:cache || echo "Config cache failed"' >> /start.sh && \
    echo 'echo "Starting PHP-FPM..."' >> /start.sh && \
    echo 'php-fpm -D' >> /start.sh && \
    echo 'echo "Starting Nginx..."' >> /start.sh && \
    echo 'nginx -g "daemon off;"' >> /start.sh && \
    chmod +x /start.sh

# Expose port (Railway uses the PORT environment variable)
EXPOSE 80

# Start services
CMD ["/start.sh"]
