# Pre-Deployment Verification Script
# Run this before creating deployment package

Write-Host "=========================================" -ForegroundColor Cyan
Write-Host "Pre-Deployment Verification" -ForegroundColor Cyan
Write-Host "=========================================" -ForegroundColor Cyan
Write-Host ""

$allGood = $true

# Check 1: .env file exists
Write-Host "1. Checking .env file..." -ForegroundColor Yellow
if (Test-Path ".env") {
    Write-Host "   ✓ .env file exists" -ForegroundColor Green
    
    # Check critical settings
    $envContent = Get-Content ".env" -Raw
    
    if ($envContent -match "APP_ENV=production") {
        Write-Host "   ✓ APP_ENV=production" -ForegroundColor Green
    } else {
        Write-Host "   ✗ APP_ENV is not set to production!" -ForegroundColor Red
        $allGood = $false
    }
    
    if ($envContent -match "APP_DEBUG=false") {
        Write-Host "   ✓ APP_DEBUG=false" -ForegroundColor Green
    } else {
        Write-Host "   ✗ APP_DEBUG is not set to false!" -ForegroundColor Red
        $allGood = $false
    }
    
    if ($envContent -match "APP_KEY=base64:") {
        Write-Host "   ✓ APP_KEY is set" -ForegroundColor Green
    } else {
        Write-Host "   ✗ APP_KEY is not set!" -ForegroundColor Red
        $allGood = $false
    }
} else {
    Write-Host "   ✗ .env file not found!" -ForegroundColor Red
    $allGood = $false
}

Write-Host ""

# Check 2: Vendor directory exists
Write-Host "2. Checking vendor directory..." -ForegroundColor Yellow
if (Test-Path "vendor") {
    Write-Host "   ✓ vendor/ directory exists" -ForegroundColor Green
} else {
    Write-Host "   ✗ vendor/ directory not found! Run: composer install" -ForegroundColor Red
    $allGood = $false
}

Write-Host ""

# Check 3: Storage directories
Write-Host "3. Checking storage directories..." -ForegroundColor Yellow
$storageDirs = @(
    "storage/app",
    "storage/app/public",
    "storage/framework",
    "storage/framework/cache",
    "storage/framework/sessions",
    "storage/framework/views",
    "storage/logs"
)

foreach ($dir in $storageDirs) {
    if (Test-Path $dir) {
        Write-Host "   ✓ $dir exists" -ForegroundColor Green
    } else {
        Write-Host "   ✗ $dir not found! Creating..." -ForegroundColor Yellow
        New-Item -ItemType Directory -Path $dir -Force | Out-Null
        Write-Host "   ✓ Created $dir" -ForegroundColor Green
    }
}

Write-Host ""

# Check 4: Bootstrap cache directory
Write-Host "4. Checking bootstrap cache..." -ForegroundColor Yellow
if (Test-Path "bootstrap/cache") {
    Write-Host "   ✓ bootstrap/cache exists" -ForegroundColor Green
} else {
    Write-Host "   ✗ bootstrap/cache not found! Creating..." -ForegroundColor Yellow
    New-Item -ItemType Directory -Path "bootstrap/cache" -Force | Out-Null
    Write-Host "   ✓ Created bootstrap/cache" -ForegroundColor Green
}

Write-Host ""

# Check 5: Public directory structure
Write-Host "5. Checking public directory..." -ForegroundColor Yellow
$publicFiles = @(
    "public/index.php",
    "public/.htaccess",
    "public/symlink.php"
)

foreach ($file in $publicFiles) {
    if (Test-Path $file) {
        Write-Host "   ✓ $file exists" -ForegroundColor Green
    } else {
        Write-Host "   ✗ $file not found!" -ForegroundColor Red
        $allGood = $false
    }
}

Write-Host ""

# Check 6: Build directory (should exist after npm run build)
Write-Host "6. Checking frontend build..." -ForegroundColor Yellow
if (Test-Path "public/build") {
    $buildFiles = Get-ChildItem "public/build" -Recurse -File
    if ($buildFiles.Count -gt 0) {
        Write-Host "   ✓ public/build exists with $($buildFiles.Count) files" -ForegroundColor Green
    } else {
        Write-Host "   ⚠ public/build is empty! Run: npm run build" -ForegroundColor Yellow
        $allGood = $false
    }
} else {
    Write-Host "   ✗ public/build not found! Run: npm run build" -ForegroundColor Red
    $allGood = $false
}

Write-Host ""

# Check 7: Database backup reminder
Write-Host "7. Database backup..." -ForegroundColor Yellow
if (Test-Path "backup.sql") {
    $backupAge = (Get-Date) - (Get-Item "backup.sql").LastWriteTime
    if ($backupAge.TotalHours -lt 24) {
        Write-Host "   ✓ backup.sql exists (created $([math]::Round($backupAge.TotalHours, 1)) hours ago)" -ForegroundColor Green
    } else {
        Write-Host "   ⚠ backup.sql is $([math]::Round($backupAge.TotalDays, 1)) days old - consider updating" -ForegroundColor Yellow
    }
} else {
    Write-Host "   ⚠ backup.sql not found - remember to export your database!" -ForegroundColor Yellow
}

Write-Host ""
Write-Host "=========================================" -ForegroundColor Cyan

if ($allGood) {
    Write-Host "✅ All Checks Passed!" -ForegroundColor Green
    Write-Host "=========================================" -ForegroundColor Cyan
    Write-Host ""
    Write-Host "Your project is ready for deployment!" -ForegroundColor Green
    Write-Host ""
    Write-Host "Next steps:" -ForegroundColor Cyan
    Write-Host "1. Export database to backup.sql (if not done)" -ForegroundColor White
    Write-Host "2. Run: .\create-deployment-package.ps1" -ForegroundColor White
    Write-Host "3. Follow QUICK_DEPLOY.md for upload" -ForegroundColor White
} else {
    Write-Host "⚠️  Some Issues Found" -ForegroundColor Yellow
    Write-Host "=========================================" -ForegroundColor Cyan
    Write-Host ""
    Write-Host "Please fix the issues above before deploying." -ForegroundColor Yellow
    Write-Host ""
    Write-Host "Common fixes:" -ForegroundColor Cyan
    Write-Host "- Run: composer install" -ForegroundColor White
    Write-Host "- Run: npm run build" -ForegroundColor White
    Write-Host "- Check .env configuration" -ForegroundColor White
}

Write-Host ""
