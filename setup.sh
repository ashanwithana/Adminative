#!/bin/bash

# Laravel 12 Admin Panel - Quick Start Script
# This script sets up the project for first-time use

echo "🚀 Laravel 12 Admin Panel - Setup Starting..."
echo ""

# Check if .env exists
if [ ! -f .env ]; then
    echo "📝 Creating .env file..."
    cp .env.example .env
    php artisan key:generate
fi

# Install dependencies if needed
if [ ! -d "vendor" ]; then
    echo "📦 Installing Composer dependencies..."
    composer install
fi

if [ ! -d "node_modules" ]; then
    echo "📦 Installing NPM dependencies..."
    npm install
fi

# Setup database
if [ ! -f "database/database.sqlite" ]; then
    echo "🗄️  Creating SQLite database..."
    touch database/database.sqlite
fi

# Run migrations and seeds
echo "🔄 Running migrations and seeders..."
php artisan migrate:fresh --seed

# Build assets
echo "🎨 Building frontend assets..."
npm run build

echo ""
echo "✅ Setup Complete!"
echo ""
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo "🎉 LARAVEL 12 ADMIN PANEL - READY TO USE"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
echo ""
echo "📚 Default Users:"
echo "   Admin:   admin@example.com    (password)"
echo "   Manager: manager@example.com  (password)"
echo "   User:    user@example.com     (password)"
echo ""
echo "🔐 OTP Codes:"
echo "   Check: storage/logs/laravel.log"
echo ""
echo "🌐 Start the server:"
echo "   php artisan serve"
echo ""
echo "🔗 Then visit: http://localhost:8000"
echo ""
echo "📖 Read README.md for full documentation"
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━"
