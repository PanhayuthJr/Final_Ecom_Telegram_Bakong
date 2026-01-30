# Create Deployment Package for cPanel
# This script creates a clean zip file ready for upload

Write-Host "=========================================" -ForegroundColor Cyan
Write-Host "Creating Deployment Package" -ForegroundColor Cyan
Write-Host "=========================================" -ForegroundColor Cyan
Write-Host ""

$timestamp = Get-Date -Format "yyyy-MM-dd_HHmmss"
$zipName = "laptopshop_deploy_$timestamp.zip"

Write-Host "📦 Preparing files for deployment..." -ForegroundColor Yellow
Write-Host ""

# Files and folders to EXCLUDE
$excludePatterns = @(
    "node_modules",
    ".git",
    ".gitignore",
    ".gitattributes",
    ".editorconfig",
    "tests",
    "*.log",
    "*.txt",
    "build-production.ps1",
    "build-production.sh",
    "create-deployment-package.ps1",
    "HOSTING_CHECKLIST.md",
    "README.md",
    "Procfile",
    ".env.example",
    "phpunit.xml"
)

# Create a temporary directory
$tempDir = "temp_deploy_$timestamp"
Write-Host "Creating temporary directory: $tempDir" -ForegroundColor Yellow

# Copy project to temp directory
Write-Host "Copying project files..." -ForegroundColor Yellow
Copy-Item -Path "." -Destination $tempDir -Recurse -Force

# Remove excluded items
Write-Host "Removing excluded files..." -ForegroundColor Yellow
foreach ($pattern in $excludePatterns) {
    $items = Get-ChildItem -Path $tempDir -Filter $pattern -Recurse -Force -ErrorAction SilentlyContinue
    foreach ($item in $items) {
        Remove-Item -Path $item.FullName -Recurse -Force -ErrorAction SilentlyContinue
        Write-Host "  - Removed: $($item.Name)" -ForegroundColor Gray
    }
}

# Create zip file
Write-Host ""
Write-Host "Creating zip file: $zipName" -ForegroundColor Yellow
Compress-Archive -Path "$tempDir\*" -DestinationPath $zipName -Force

# Clean up temp directory
Write-Host "Cleaning up temporary files..." -ForegroundColor Yellow
Remove-Item -Path $tempDir -Recurse -Force

# Get file size
$fileSize = (Get-Item $zipName).Length / 1MB
$fileSizeFormatted = "{0:N2}" -f $fileSize

Write-Host ""
Write-Host "=========================================" -ForegroundColor Green
Write-Host "✅ Deployment Package Created!" -ForegroundColor Green
Write-Host "=========================================" -ForegroundColor Green
Write-Host ""
Write-Host "Package Details:" -ForegroundColor Cyan
Write-Host "  File: $zipName" -ForegroundColor White
Write-Host "  Size: $fileSizeFormatted MB" -ForegroundColor White
Write-Host ""
Write-Host "Next Steps:" -ForegroundColor Cyan
Write-Host "1. Upload $zipName to cPanel File Manager" -ForegroundColor White
Write-Host "2. Extract to /home/username/project_files/" -ForegroundColor White
Write-Host "3. Move public/* to /home/username/public_html/" -ForegroundColor White
Write-Host "4. Follow CPANEL_DEPLOY.md for configuration" -ForegroundColor White
Write-Host ""
