# Production Build Script for cPanel Deployment (Windows)
# Run this script before uploading to hosting

Write-Host "=========================================" -ForegroundColor Cyan
Write-Host "Laravel Production Build Script" -ForegroundColor Cyan
Write-Host "=========================================" -ForegroundColor Cyan
Write-Host ""

# Step 1: Install Node Dependencies
Write-Host "📦 Installing Node dependencies..." -ForegroundColor Yellow
npm install

if ($LASTEXITCODE -ne 0) {
    Write-Host "❌ npm install failed!" -ForegroundColor Red
    exit 1
}

# Step 2: Build Frontend Assets
Write-Host "🏗️  Building production assets..." -ForegroundColor Yellow
npm run build

if ($LASTEXITCODE -ne 0) {
    Write-Host "❌ npm build failed!" -ForegroundColor Red
    exit 1
}

# Step 3: Install Composer Dependencies (Production)
Write-Host "📚 Installing Composer dependencies (production mode)..." -ForegroundColor Yellow
composer install --optimize-autoloader --no-dev

if ($LASTEXITCODE -ne 0) {
    Write-Host "⚠️  Composer install had issues, but continuing..." -ForegroundColor Yellow
}

# Step 4: Clear All Caches (if PHP works)
Write-Host "🧹 Attempting to clear caches..." -ForegroundColor Yellow
php artisan optimize:clear 2>$null
php artisan config:clear 2>$null
php artisan route:clear 2>$null
php artisan view:clear 2>$null

# Step 5: Verify Build
Write-Host ""
Write-Host "=========================================" -ForegroundColor Green
Write-Host "✅ Build Complete!" -ForegroundColor Green
Write-Host "=========================================" -ForegroundColor Green
Write-Host ""
Write-Host "Verifying build output..." -ForegroundColor Cyan

$buildExists = Test-Path "public\build"
$vendorExists = Test-Path "vendor"
$envExists = Test-Path ".env"

if ($buildExists) {
    Write-Host "  ✓ public/build/ directory exists" -ForegroundColor Green
} else {
    Write-Host "  ✗ public/build/ directory NOT found!" -ForegroundColor Red
}

if ($vendorExists) {
    Write-Host "  ✓ vendor/ directory exists" -ForegroundColor Green
} else {
    Write-Host "  ✗ vendor/ directory NOT found!" -ForegroundColor Red
}

if ($envExists) {
    Write-Host "  ✓ .env file exists" -ForegroundColor Green
} else {
    Write-Host "  ✗ .env file NOT found!" -ForegroundColor Red
}

Write-Host ""
Write-Host "Next Steps:" -ForegroundColor Cyan
Write-Host "1. Export your database to backup.sql" -ForegroundColor White
Write-Host "2. Zip the project (exclude node_modules and .git)" -ForegroundColor White
Write-Host "3. Follow CPANEL_DEPLOY.md for upload instructions" -ForegroundColor White
Write-Host ""
