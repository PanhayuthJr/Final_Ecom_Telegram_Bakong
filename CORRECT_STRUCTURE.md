# 📁 Correct cPanel File Structure

## Your Current Location
You showed: `/home2/wvagae5401/public_html/`

## ✅ What Should Be in public_html/

```
/home2/wvagae5401/public_html/
├── build/                    ← ❌ MISSING! Upload after npm run build
│   ├── manifest.json
│   └── assets/
│       ├── app-[hash].css
│       └── app-[hash].js
├── css/                      ← ✓ You have this
├── image/                    ← ✓ You have this  
├── img/                      ← ✓ You have this
├── .htaccess                 ← ✓ You have this
├── index.php                 ← ✓ You have this (needs editing)
├── favicon.ico               ← ✓ You have this
├── robots.txt                ← ✓ You have this
└── symlink.php               ← ✓ You have this
```

## ✅ What Should Be in project_files/

```
/home2/wvagae5401/project_files/    ← ❌ MISSING! Need to create
├── app/
├── bootstrap/
│   └── cache/
├── config/
├── database/
├── resources/
├── routes/
├── storage/
│   ├── app/
│   │   └── public/
│   ├── framework/
│   │   ├── cache/
│   │   ├── sessions/
│   │   └── views/
│   └── logs/
├── vendor/
├── .env                      ← Your environment config
├── composer.json
└── artisan
```

## 🔧 Step-by-Step Fix

### 1. Build Assets Locally (On Your Computer)
```powershell
cd d:\SU43\Ecomerce-Su43\su43_44_tg_khqr-backup
npm run build
```

This creates `public/build/` folder with compiled CSS/JS.

### 2. Create Deployment Package (On Your Computer)
```powershell
.\create-deployment-package.ps1
```

This creates a zip file like: `laptopshop_deploy_2026-01-29_182533.zip`

### 3. In cPanel File Manager

**A. Navigate to Home Directory**
- Click "Up One Level" until you see `/home2/wvagae5401/`
- You should see `public_html/` folder here

**B. Create project_files Folder**
- Click "+ Folder"
- Name: `project_files`
- Click "Create New Folder"

**C. Upload Your Zip**
- Open `project_files/` folder
- Click "Upload"
- Upload your deployment zip
- After upload, right-click zip → "Extract"
- Delete the zip file after extraction

**D. Move Public Files**
- Go into `project_files/public/`
- Select the `build/` folder
- Click "Move"
- Move to: `/home2/wvagae5401/public_html/build/`

### 4. Edit index.php

Open `/home2/wvagae5401/public_html/index.php` and change:

**Line 9:**
```php
if (file_exists($maintenance = __DIR__.'/../project_files/storage/framework/maintenance.php')) {
```

**Line 14:**
```php
require __DIR__.'/../project_files/vendor/autoload.php';
```

**Line 18:**
```php
$app = require_once __DIR__.'/../project_files/bootstrap/app.php';
```

### 5. Configure .env

Edit `/home2/wvagae5401/project_files/.env`:

```env
APP_URL=https://dpdc501.dpdatacenter.com

DB_DATABASE=your_cpanel_database_name
DB_USERNAME=your_cpanel_database_user
DB_PASSWORD=your_cpanel_database_password
```

### 6. Set Permissions

- `project_files/storage/` → 775 (recursive)
- `project_files/bootstrap/cache/` → 775

### 7. Create Storage Link

Visit: `https://dpdc501.dpdatacenter.com/symlink.php`
Then DELETE `symlink.php` from File Manager.

## ✅ Final Structure Check

After setup, your structure should be:

```
/home2/wvagae5401/
│
├── public_html/              ← Public web root
│   ├── build/               ✓ Vite assets
│   ├── css/                 ✓ Custom CSS
│   ├── image/               ✓ Product images
│   ├── img/                 ✓ Site images
│   ├── storage/             ✓ Symlink (created by symlink.php)
│   ├── .htaccess            ✓ Rewrite rules
│   ├── index.php            ✓ Entry point (edited)
│   ├── favicon.ico          ✓ Icon
│   └── robots.txt           ✓ SEO
│
└── project_files/            ← Secure Laravel app
    ├── app/                 ✓ Application code
    ├── bootstrap/           ✓ Framework bootstrap
    ├── config/              ✓ Configuration
    ├── database/            ✓ Migrations/seeders
    ├── resources/           ✓ Views/assets
    ├── routes/              ✓ Route definitions
    ├── storage/             ✓ Storage (775 permissions)
    ├── vendor/              ✓ Dependencies
    └── .env                 ✓ Environment config
```

## 🚨 Common Mistakes to Avoid

❌ **DON'T** put Laravel app folders in `public_html/`
❌ **DON'T** forget to run `npm run build` before uploading
❌ **DON'T** upload `node_modules/` folder
❌ **DON'T** forget to edit `index.php` paths
❌ **DON'T** forget to set storage permissions to 775

✅ **DO** create separate `project_files/` folder
✅ **DO** build assets locally first
✅ **DO** move only `public/build/` to `public_html/`
✅ **DO** update `index.php` paths to `../project_files/`
✅ **DO** set proper permissions on storage

## 📞 Need Help?

If you're stuck:
1. Upload `check-installation.php` to `public_html/`
2. Visit it in browser to see what's missing
3. Check `TROUBLESHOOT_503.md` for detailed help
