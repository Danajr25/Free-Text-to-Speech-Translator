#!/bin/bash

# Render deployment script for Laravel
echo "Starting Laravel deployment..."

# Install dependencies
composer install --optimize-autoloader --no-dev

# Generate application key if not exists
php artisan key:generate --force

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run database migrations
php artisan migrate --force

echo "Deployment complete!"