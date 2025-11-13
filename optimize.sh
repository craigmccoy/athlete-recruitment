#!/bin/bash

# Laravel Optimization Script
# Run this after deploying to production for best performance

echo "🚀 Optimizing Laravel application..."

# Clear all caches first
echo "Clearing existing caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimize for production
echo "Caching configuration..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Caching views..."
php artisan view:cache

echo "Optimizing autoloader..."
composer dump-autoload --optimize --no-dev

echo "✅ Optimization complete!"
echo ""
echo "Your application is now optimized for production."
echo "To revert optimizations during development, run:"
echo "  php artisan optimize:clear"
