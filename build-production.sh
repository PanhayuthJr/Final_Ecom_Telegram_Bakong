#!/bin/bash
# Production Build Script for cPanel Deployment
# Run this script before uploading to hosting

echo "========================================="
echo "Laravel Production Build Script"
echo "========================================="
echo ""

# Step 1: Install Node Dependencies
echo "📦 Installing Node dependencies..."
npm install

# Step 2: Build Frontend Assets
echo "🏗️  Building production assets..."
npm run build

# Step 3: Install Composer Dependencies (Production)
echo "📚 Installing Composer dependencies (production mode)..."
composer install --optimize-autoloader --no-dev

# Step 4: Clear All Caches
echo "🧹 Clearing all caches..."
php artisan optimize:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Step 5: Verify Build
echo ""
echo "========================================="
echo "✅ Build Complete!"
echo "========================================="
echo ""
echo "Next Steps:"
echo "1. Export your database to backup.sql"
echo "2. Zip the project (exclude node_modules and .git)"
echo "3. Follow CPANEL_DEPLOY.md for upload instructions"
echo ""
echo "Files to verify before upload:"
echo "  ✓ public/build/ directory exists"
echo "  ✓ vendor/ directory exists"
echo "  ✓ .env file is configured"
echo ""
