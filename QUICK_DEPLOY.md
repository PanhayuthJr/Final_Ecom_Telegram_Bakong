# Quick Reference Guide for cPanel Deployment

## 🎯 Your Hosting Details
- **cPanel URL**: https://web2.dpdatacenter.com:2083
- **Current Domain**: https://dpdc501.dpdatacenter.com
- **PHP Version**: 8.2 or 8.3 (LiteSpeed Server)
- **Database**: MySQL (1 database limit)

---

## 🚀 Quick Deployment Steps

### 1️⃣ Build Production Assets (Run Locally)
```powershell
# Run this script to build everything
.\build-production.ps1
```

This will:
- Install npm dependencies
- Build Vite assets (Tailwind CSS)
- Install Composer dependencies (production mode)
- Clear Laravel caches

### 2️⃣ Export Database
- Open your database tool (TablePlus, phpMyAdmin, etc.)
- Export database to `backup.sql`

### 3️⃣ Create Deployment Package
```powershell
# Run this script to create a clean zip file
.\create-deployment-package.ps1
```

This creates a zip file excluding:
- `node_modules/`
- `.git/`
- Test files
- Debug files

### 4️⃣ Upload to cPanel

**A. Create Database**
1. Go to **MySQL Database Wizard**
2. Create database: `username_laptopshop`
3. Create user: `username_admin` (save password!)
4. Grant ALL PRIVILEGES

**B. Import Database**
1. Go to **phpMyAdmin**
2. Select your database
3. Import → Upload `backup.sql`

**C. Upload Files**
1. Go to **File Manager**
2. Navigate to `/home/username/`
3. Create folder: `project_files`
4. Upload and extract your deployment zip
5. Move `project_files/public/*` to `public_html/`

### 5️⃣ Configure

**A. Edit `public_html/index.php`**
Change these 3 paths:
```php
// Line 9: Change to
if (file_exists($maintenance = __DIR__.'/../project_files/storage/framework/maintenance.php')) {

// Line 14: Change to
require __DIR__.'/../project_files/vendor/autoload.php';

// Line 18: Change to
$app = require_once __DIR__.'/../project_files/bootstrap/app.php';
```

**B. Edit `project_files/.env`**
```env
APP_URL=https://yourdomain.com

DB_DATABASE=username_laptopshop
DB_USERNAME=username_admin
DB_PASSWORD=your_saved_password
```

**C. Set Permissions**
- `project_files/storage/` → 775 (recursive)
- `project_files/bootstrap/cache/` → 775

### 6️⃣ Create Storage Link
1. Visit: `https://yourdomain.com/symlink.php`
2. Should show: "Symlink created successfully"
3. **DELETE `symlink.php` immediately**

### 7️⃣ Test Your Site
- ✅ Home page loads
- ✅ Products display
- ✅ Add to cart works
- ✅ Checkout with KHQR works
- ✅ Images load properly

---

## 🔧 Common Issues

### 500 Error
- Check `.env` exists in `project_files/`
- Verify `index.php` paths
- Check storage permissions (775)

### Images Not Loading
- Verify storage symlink exists
- Check `FILESYSTEM_DISK=public` in `.env`

### CSS/JS Not Loading
- Verify `public_html/build/` exists
- Check `APP_URL` in `.env`
- Clear browser cache

### Database Error
- Verify credentials in `.env`
- Use `127.0.0.1` not `localhost`
- Check user has privileges

---

## 📋 Pre-Upload Checklist

- [ ] Run `build-production.ps1`
- [ ] Verify `public/build/` exists
- [ ] Export database to `backup.sql`
- [ ] Run `create-deployment-package.ps1`
- [ ] Review `.env` settings
- [ ] Have database credentials ready

---

## 📞 Support

If you encounter issues:
1. Check `storage/logs/laravel.log`
2. Check cPanel error logs
3. Review CPANEL_DEPLOY.md for detailed steps
4. Review HOSTING_CHECKLIST.md for troubleshooting

---

**Last Updated**: 2026-01-29
