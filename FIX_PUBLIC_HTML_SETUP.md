# 🔧 Fix for Laravel in public_html (Alternative Setup)

## Your Current Situation
You've uploaded the entire Laravel project to `public_html/` instead of separating it.

**Security Note:** This is not ideal (app code should be outside public_html), but it can work.

---

## ✅ IMMEDIATE FIXES NEEDED

### 1. Fix index.php (CRITICAL!)

You need to use the `index.php` from the `public/` folder, not the root.

**Option A: Move public contents to root (Recommended)**

1. Go to `public_html/public/` folder
2. Select ALL files inside (build, css, image, img, .htaccess, index.php, etc.)
3. Click "Move"
4. Move to: `/home2/wvagae5401/public_html/`
5. When asked about overwriting, click "Yes" or "Overwrite All"

**After moving, your index.php should have these paths:**

Edit `/home2/wvagae5401/public_html/index.php`:

```php
<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Since everything is in public_html, use these paths:
if (file_exists($maintenance = __DIR__.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';

$app->handleRequest(Request::capture());
```

**Key difference:** Use `__DIR__.'/folder'` instead of `__DIR__.'/../folder'`

---

### 2. Check .htaccess

Make sure `/home2/wvagae5401/public_html/.htaccess` exists with:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

---

### 3. Protect Sensitive Folders

Create `.htaccess` files to block access to sensitive folders:

**A. Create `/home2/wvagae5401/public_html/app/.htaccess`:**
```apache
Deny from all
```

**B. Create `/home2/wvagae5401/public_html/config/.htaccess`:**
```apache
Deny from all
```

**C. Create `/home2/wvagae5401/public_html/database/.htaccess`:**
```apache
Deny from all
```

**D. Create `/home2/wvagae5401/public_html/routes/.htaccess`:**
```apache
Deny from all
```

**E. Create `/home2/wvagae5401/public_html/storage/.htaccess`:**
```apache
Deny from all
```

**F. Create `/home2/wvagae5401/public_html/vendor/.htaccess`:**
```apache
Deny from all
```

**G. Protect .env file - Create `/home2/wvagae5401/public_html/.htaccess.env`:**

Actually, add this to your main `.htaccess` at the top:
```apache
# Protect .env file
<Files .env>
    Order allow,deny
    Deny from all
</Files>
```

---

### 4. Check PHP Version

1. cPanel → **Select PHP Version** or **MultiPHP Manager**
2. Set to **PHP 8.2** or **8.3**
3. Enable required extensions

---

### 5. Set Permissions

Set these folder permissions to **775**:
- `/home2/wvagae5401/public_html/storage/` (recursive)
- `/home2/wvagae5401/public_html/bootstrap/cache/`

---

### 6. Check .env File

Make sure `/home2/wvagae5401/public_html/.env` exists with:

```env
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:your_key_here
APP_URL=https://dpdc501.dpdatacenter.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

---

### 7. Create Storage Link

Visit: `https://dpdc501.dpdatacenter.com/symlink.php`

Then **DELETE** `symlink.php` immediately.

---

## 📁 Your Final Structure

```
/home2/wvagae5401/public_html/
├── app/                      ← Protected by .htaccess
├── bootstrap/
│   └── cache/               ← 775 permissions
├── config/                   ← Protected by .htaccess
├── database/                 ← Protected by .htaccess
├── public/                   ← Can delete after moving contents
├── resources/
├── routes/                   ← Protected by .htaccess
├── storage/                  ← Protected by .htaccess, 775 permissions
│   └── app/
│       └── public/          ← Symlinked to /storage
├── vendor/                   ← Protected by .htaccess
├── build/                    ← From public/build/
├── css/                      ← From public/css/
├── image/                    ← From public/image/
├── img/                      ← From public/img/
├── .env                      ← Protected by .htaccess
├── .htaccess                 ← Main rewrite rules + protections
├── index.php                 ← From public/index.php (edited)
├── favicon.ico
└── robots.txt
```

---

## 🔍 Missing Build Folder?

I notice you might be missing the `build/` folder. You need to:

1. **On your local computer:**
   ```powershell
   npm run build
   ```

2. **Upload the `public/build/` folder to cPanel:**
   - Upload to `/home2/wvagae5401/public_html/build/`

---

## ✅ Step-by-Step Checklist

- [ ] Move contents of `public/` folder to `public_html/` root
- [ ] Edit `index.php` to use `__DIR__.'/folder'` paths
- [ ] Create `.htaccess` files in sensitive folders (app, config, database, routes, storage, vendor)
- [ ] Add `.env` protection to main `.htaccess`
- [ ] Set PHP version to 8.2 or 8.3
- [ ] Set storage permissions to 775
- [ ] Set bootstrap/cache permissions to 775
- [ ] Verify .env file exists and is configured
- [ ] Run symlink.php and delete it
- [ ] Upload build/ folder if missing

---

## 🚨 Security Warning

**This setup exposes your application code in the web root!**

While it works, it's not as secure as the recommended structure. The `.htaccess` files help, but ideally:
- Laravel app should be in `/home2/wvagae5401/project_files/`
- Only `public/` contents should be in `public_html/`

**For now, this will work, but consider restructuring later for better security.**

---

## 🔧 If You Still Get 503 Error

1. Check PHP version is 8.2+
2. Check error logs in cPanel
3. Upload and run `check-installation.php`
4. Temporarily set `APP_DEBUG=true` to see errors
