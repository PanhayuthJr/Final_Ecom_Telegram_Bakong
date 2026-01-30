# 🚀 Hosting Preparation Checklist

**Project**: Laravel E-commerce with KHQR Payment Integration  
**Target**: cPanel Hosting (LiteSpeed Server)  
**Date**: 2026-01-29

---

## ✅ Pre-Deployment Checklist

### 1. Local Environment Preparation

- [ ] **Build Frontend Assets**
  ```bash
  npm install
  npm run build
  ```
  - This creates optimized production assets in `public/build/`
  - Required for Tailwind CSS and Vite to work properly

- [ ] **Clear All Caches**
  ```bash
  php artisan optimize:clear
  php artisan config:clear
  php artisan route:clear
  php artisan view:clear
  ```

- [ ] **Test Database Export**
  - Export your local database to `backup.sql`
  - Verify the export includes all tables: `products`, `carts`, `orders`, `sessions`, etc.

- [ ] **Verify Composer Dependencies**
  ```bash
  composer install --optimize-autoloader --no-dev
  ```
  - This installs production dependencies only
  - Optimizes autoloader for better performance

### 2. Environment Configuration

- [ ] **Review `.env` File**
  - ✅ `APP_ENV=production` (Currently set)
  - ✅ `APP_DEBUG=false` (Currently set)
  - ⚠️ `APP_URL` - Update to your actual domain when you know it
  - ⚠️ Database credentials - Update after creating cPanel database
  - ✅ `SESSION_DRIVER=database` (Good for shared hosting)
  - ✅ `QUEUE_CONNECTION=database` (Good for shared hosting)
  - ✅ `CACHE_STORE=database` (Good for shared hosting)

- [ ] **Security Tokens**
  - ✅ `APP_KEY` is set
  - ✅ `BAKONG_TOKEN` is configured
  - ✅ `TELEGRAM_BOT_TOKEN` is configured
  - ⚠️ **IMPORTANT**: Never commit `.env` to Git

### 3. File Structure Verification

- [ ] **Check Required Directories Exist**
  - `storage/app/public/` - For uploaded images
  - `storage/framework/cache/`
  - `storage/framework/sessions/`
  - `storage/framework/views/`
  - `storage/logs/`
  - `bootstrap/cache/`

- [ ] **Verify Public Assets**
  - `public/build/` - Vite compiled assets
  - `public/css/` - Custom stylesheets
  - `public/image/` - Product images
  - `public/img/` - Site images
  - `public/.htaccess` - Laravel rewrite rules
  - `public/index.php` - Entry point
  - `public/symlink.php` - Storage link helper

### 4. Code Quality Checks

- [ ] **Remove Debug Files** (Optional cleanup)
  - `artisan_error.txt`
  - `debug_migrate.php`
  - `full_debug.txt`
  - `migration_error.txt`
  - `migration_log.txt`
  - `seed_log.txt`
  - `create_db.php`

- [ ] **Verify Critical Routes Work**
  - Home page
  - Product listing
  - Cart functionality
  - Checkout with KHQR
  - Admin dashboard

---

## 📦 Files to Upload

### Include:
- ✅ `app/` - Application code
- ✅ `bootstrap/` - Framework bootstrap
- ✅ `config/` - Configuration files
- ✅ `database/` - Migrations and seeders
- ✅ `public/` - Public assets
- ✅ `resources/` - Views and raw assets
- ✅ `routes/` - Route definitions
- ✅ `storage/` - Storage directories
- ✅ `vendor/` - Composer dependencies
- ✅ `.env` - Environment configuration
- ✅ `composer.json` & `composer.lock`
- ✅ `artisan` - CLI tool

### Exclude:
- ❌ `node_modules/` - Too large, not needed
- ❌ `.git/` - Version control history
- ❌ `.env.example` - Not needed in production
- ❌ `tests/` - Optional, can exclude
- ❌ Debug files listed above

---

## 🌐 cPanel Deployment Steps

### Phase 1: Database Setup

1. **Create Database via MySQL Database Wizard**
   - Database name: `username_laptopshop`
   - User: `username_admin`
   - Password: Generate strong password (save it!)
   - Privileges: ALL PRIVILEGES

2. **Import Data via phpMyAdmin**
   - Upload `backup.sql`
   - Verify all tables imported successfully

### Phase 2: File Upload

1. **Create Secure Structure**
   ```
   /home/username/
   ├── project_files/          ← Your Laravel app (secure)
   │   ├── app/
   │   ├── bootstrap/
   │   ├── config/
   │   ├── database/
   │   ├── resources/
   │   ├── routes/
   │   ├── storage/
   │   ├── vendor/
   │   └── .env
   └── public_html/            ← Public files only
       ├── build/
       ├── css/
       ├── image/
       ├── img/
       ├── .htaccess
       ├── index.php
       ├── favicon.ico
       └── symlink.php
   ```

2. **Upload Process**
   - Zip your project (exclude `node_modules`, `.git`)
   - Upload to `/home/username/project_files/`
   - Extract the zip
   - Move contents of `public/` to `/home/username/public_html/`

### Phase 3: Configuration

1. **Edit `public_html/index.php`**
   - Update paths to point to `../project_files/`
   - See `CPANEL_DEPLOY.md` for exact changes

2. **Edit `project_files/.env`**
   - Update `APP_URL` to your domain
   - Update database credentials
   - Verify `APP_ENV=production` and `APP_DEBUG=false`

3. **Set Permissions**
   - `project_files/storage/` → 775 (recursive)
   - `project_files/bootstrap/cache/` → 775

### Phase 4: Finalization

1. **Create Storage Link**
   - Visit `https://yourdomain.com/symlink.php`
   - Should display "Symlink created successfully"
   - **DELETE `symlink.php` immediately after**

2. **Run Artisan Commands via SSH/Terminal** (if available)
   ```bash
   cd /home/username/project_files
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

3. **Test Your Site**
   - [ ] Home page loads
   - [ ] Products display with images
   - [ ] Add to cart works
   - [ ] Checkout flow works
   - [ ] KHQR payment generates QR code
   - [ ] Admin dashboard accessible
   - [ ] No errors in browser console

---

## 🔧 Troubleshooting

### Issue: 500 Internal Server Error
- Check `.env` file exists in `project_files/`
- Verify `index.php` paths are correct
- Check storage permissions (775)
- Review error logs in cPanel

### Issue: Images Not Loading
- Verify storage link exists: `public_html/storage` → `project_files/storage/app/public`
- Check image paths in database
- Ensure `FILESYSTEM_DISK=public` in `.env`

### Issue: CSS/JS Not Loading
- Verify `public_html/build/` directory exists
- Check `APP_URL` matches your domain
- Clear browser cache

### Issue: Database Connection Failed
- Verify database credentials in `.env`
- Check database exists in cPanel
- Ensure user has privileges
- Use `127.0.0.1` not `localhost`

---

## 📝 Post-Deployment

- [ ] **Monitor Error Logs**
  - Check `storage/logs/laravel.log`
  - Check cPanel error logs

- [ ] **Performance Optimization**
  - Enable OPcache in cPanel PHP settings
  - Consider using Redis/Memcached if available

- [ ] **Security**
  - Ensure `.env` is not publicly accessible
  - Verify `APP_DEBUG=false`
  - Keep Laravel and dependencies updated

- [ ] **Backup Strategy**
  - Regular database backups
  - File backups via cPanel

---

## 🎯 Quick Reference

**cPanel Access**: `https://web2.dpdatacenter.com:2083`  
**Current Domain**: `https://dpdc501.dpdatacenter.com`  
**PHP Version Required**: 8.2 or 8.3  
**Server**: LiteSpeed  
**Database**: MySQL (1 DB limit)

---

**Status**: Ready for deployment ✅  
**Last Updated**: 2026-01-29
