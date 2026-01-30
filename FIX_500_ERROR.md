# 🔧 Fix HTTP 500 Error - Quick Guide

## 🚨 You're Getting: "HTTP ERROR 500"

This means the server is trying to run your Laravel app but something is misconfigured.

---

## ⚡ IMMEDIATE FIXES (Do These First!)

### Step 1: Upload Diagnostic File

1. **Upload `check-installation.php`** from your `public/` folder to cPanel
2. **Visit:** `https://dpdc501.dpdatacenter.com/check-installation.php`
3. **Read the report** - it will tell you exactly what's wrong

---

### Step 2: Fix Common Issues

Based on your screenshot, here are the most likely causes:

#### ❌ Issue #1: Wrong index.php Paths

Your `index.php` in `public_html/` might have wrong paths.

**Fix:** Edit `/home2/wvagae5401/public_html/index.php` in cPanel File Manager:

```php
<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// IMPORTANT: Check if everything is in public_html or if Laravel is outside
// If you see folders like 'app', 'config', 'vendor' in public_html, use these paths:

if (file_exists($maintenance = __DIR__.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$app->handleRequest(Request::capture());
```

**Key Point:** If your Laravel files are in `public_html/`, use `__DIR__.'/folder'`  
If Laravel is outside public_html, use `__DIR__.'/../folder'`

---

#### ❌ Issue #2: Missing or Wrong .env File

**Fix:**

1. Go to cPanel File Manager → `/home2/wvagae5401/public_html/`
2. Check if `.env` file exists (enable "Show Hidden Files")
3. If missing, create it with this content:

```env
APP_NAME="Laptop Shop"
APP_ENV=production
APP_KEY=base64:YOUR_KEY_HERE
APP_DEBUG=false
APP_TIMEZONE=Asia/Phnom_Penh
APP_URL=https://dpdc501.dpdatacenter.com

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=wvagae5401_laptopshop
DB_USERNAME=wvagae5401_admin
DB_PASSWORD=your_password_here

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=public
QUEUE_CONNECTION=database

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

CACHE_STORE=database
CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

VITE_APP_NAME="${APP_NAME}"
```

**CRITICAL:** Replace these values:
- `APP_KEY` - Your actual app key
- `DB_DATABASE` - Your actual database name
- `DB_USERNAME` - Your actual database user
- `DB_PASSWORD` - Your actual database password

---

#### ❌ Issue #3: Wrong Permissions

**Fix in cPanel:**

1. Select `storage` folder → Right-click → Change Permissions
2. Set to **775** (or 755)
3. Check "Recurse into subdirectories"
4. Click "Change Permissions"

5. Do the same for `bootstrap/cache/` folder

---

#### ❌ Issue #4: Missing vendor/ Folder

If you didn't upload `vendor/` folder:

**Fix:**

1. You MUST upload the `vendor/` folder from your local project
2. It's large (~50-100MB) but required
3. Upload it to the same location as your other Laravel folders

**Alternative:** Use SSH if available:
```bash
cd /home2/wvagae5401/public_html
composer install --no-dev --optimize-autoloader
```

---

#### ❌ Issue #5: PHP Version Too Old

**Fix:**

1. cPanel → **MultiPHP Manager** or **Select PHP Version**
2. Select your domain
3. Change to **PHP 8.2** or **PHP 8.3**
4. Enable these extensions:
   - ✅ pdo_mysql
   - ✅ mbstring
   - ✅ xml
   - ✅ openssl
   - ✅ curl
   - ✅ fileinfo
   - ✅ tokenizer

---

## 🔍 How to See the Actual Error

Temporarily enable debug mode to see what's wrong:

1. Edit `.env` file
2. Change: `APP_DEBUG=false` to `APP_DEBUG=true`
3. Refresh your website
4. You'll see the actual error message
5. **IMPORTANT:** Change it back to `false` after fixing!

---

## 📋 Quick Checklist

Go through this list:

- [ ] **PHP Version:** 8.2 or 8.3 (check in cPanel)
- [ ] **index.php:** Correct paths (check file in public_html)
- [ ] **.env file:** Exists and has correct database credentials
- [ ] **vendor/ folder:** Uploaded and exists
- [ ] **storage/ permissions:** 775 or 755
- [ ] **bootstrap/cache/ permissions:** 775 or 755
- [ ] **Database:** Created in cPanel and credentials match .env
- [ ] **APP_KEY:** Set in .env (not empty)

---

## 🎯 Step-by-Step Fix Process

### Option A: If Everything is in public_html/

1. **Check your structure in cPanel:**
   ```
   /home2/wvagae5401/public_html/
   ├── app/
   ├── bootstrap/
   ├── config/
   ├── database/
   ├── public/
   ├── resources/
   ├── routes/
   ├── storage/
   ├── vendor/
   ├── .env
   └── artisan
   ```

2. **Move public/ contents to root:**
   - Go to `public_html/public/` folder
   - Select ALL files (.htaccess, index.php, css, js, images, etc.)
   - Click "Move"
   - Move to: `/home2/wvagae5401/public_html/`
   - Overwrite when asked

3. **Edit index.php** to use these paths:
   ```php
   require __DIR__.'/vendor/autoload.php';
   $app = require_once __DIR__.'/bootstrap/app.php';
   ```

4. **Create .htaccess protection files** (see FIX_PUBLIC_HTML_SETUP.md)

### Option B: If Laravel is Outside public_html/

1. **Check your structure:**
   ```
   /home2/wvagae5401/
   ├── project_files/          ← Laravel app here
   │   ├── app/
   │   ├── bootstrap/
   │   ├── config/
   │   └── ...
   └── public_html/            ← Only public/ contents here
       ├── .htaccess
       ├── index.php
       ├── css/
       └── ...
   ```

2. **Edit index.php** to use these paths:
   ```php
   require __DIR__.'/../project_files/vendor/autoload.php';
   $app = require_once __DIR__.'/../project_files/bootstrap/app.php';
   ```

---

## 🆘 Still Not Working?

### Check Error Logs

**Method 1: cPanel Error Logs**
1. cPanel → **Metrics** → **Errors**
2. Look at the latest errors

**Method 2: Laravel Logs**
1. Download: `/home2/wvagae5401/public_html/storage/logs/laravel.log`
2. Open in text editor
3. Look at the bottom for recent errors

### Common Error Messages & Fixes

| Error Message | Fix |
|---------------|-----|
| "No application encryption key" | Set APP_KEY in .env |
| "Class not found" | Upload vendor/ folder |
| "Permission denied" | Fix storage/ permissions |
| "Connection refused" | Check database credentials |
| "File not found" | Fix paths in index.php |

---

## 🎓 What to Send Me

If you're still stuck, run the diagnostic and send me:

1. Screenshot of `check-installation.php` results
2. Your current file structure (screenshot from cPanel)
3. The error from Laravel logs or cPanel error logs
4. Confirmation of:
   - PHP version
   - Whether vendor/ folder exists
   - Whether .env file exists

---

## ⚡ Quick Commands for SSH (If Available)

If you have SSH access:

```bash
# Go to your Laravel directory
cd /home2/wvagae5401/public_html

# Fix permissions
chmod -R 775 storage bootstrap/cache

# Clear cache
rm -rf bootstrap/cache/*.php
rm -rf storage/framework/cache/*
rm -rf storage/framework/sessions/*
rm -rf storage/framework/views/*

# If composer is available
composer install --no-dev --optimize-autoloader
```

---

**Created:** 2026-01-29  
**For:** HTTP 500 Error on cPanel  
**Domain:** dpdc501.dpdatacenter.com
