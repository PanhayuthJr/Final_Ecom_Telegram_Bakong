# Simple Pre-Deployment Check
Write-Host "Checking deployment readiness..." -ForegroundColor Cyan
Write-Host ""

# Check .env
if (Test-Path ".env") {
    Write-Host "[OK] .env file exists" -ForegroundColor Green
} else {
    Write-Host "[FAIL] .env file missing" -ForegroundColor Red
}

# Check vendor
if (Test-Path "vendor") {
    Write-Host "[OK] vendor directory exists" -ForegroundColor Green
} else {
    Write-Host "[FAIL] vendor missing - run: composer install" -ForegroundColor Red
}

# Check build
if (Test-Path "public/build") {
    Write-Host "[OK] public/build exists" -ForegroundColor Green
} else {
    Write-Host "[FAIL] build missing - run: npm run build" -ForegroundColor Red
}

# Check storage
if (Test-Path "storage/app/public") {
    Write-Host "[OK] storage directories exist" -ForegroundColor Green
} else {
    Write-Host "[WARN] storage/app/public missing" -ForegroundColor Yellow
}

# Check public files
if (Test-Path "public/index.php") {
    Write-Host "[OK] public/index.php exists" -ForegroundColor Green
} else {
    Write-Host "[FAIL] public/index.php missing" -ForegroundColor Red
}

if (Test-Path "public/symlink.php") {
    Write-Host "[OK] public/symlink.php exists" -ForegroundColor Green
} else {
    Write-Host "[WARN] public/symlink.php missing" -ForegroundColor Yellow
}

Write-Host ""
Write-Host "Next: Run build-production.ps1 to prepare for deployment" -ForegroundColor Cyan
