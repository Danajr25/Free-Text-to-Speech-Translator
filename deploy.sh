#!/bin/bash

# Render deployment script for Laravel
echo "Starting Laravel deployment..."

# Install dependencies
echo "Installing Composer dependencies..."
composer install --optimize-autoloader --no-dev

# Generate application key if not exists
echo "Generating application key..."
php artisan key:generate --force

# Run database migrations
echo "Running database migrations..."
php artisan migrate --force --no-interaction

# Cache configuration for better performance
echo "Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Deployment complete!"