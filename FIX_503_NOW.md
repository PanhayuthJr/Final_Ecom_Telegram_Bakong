# 🚨 QUICK FIX: 503 Service Unavailable

## ⚡ Do This NOW (In Order)

### 1️⃣ Upload Diagnostic File
1. Upload `public/check-installation.php` to your `public_html/` folder
2. Visit: `https://dpdc501.dpdatacenter.com/check-installation.php`
3. This will show you EXACTLY what's wrong
4. **DELETE the file after checking!**

---

### 2️⃣ Most Likely Fix: PHP Version
1. Log in to cPanel: `https://web2.dpdatacenter.com:2083`
2. Search for: **"Select PHP Version"** or **"MultiPHP Manager"**
3. Select your domain
4. Change to: **PHP 8.2** or **PHP 8.3**
5. Click **Apply**

**This fixes 80% of 503 errors!**

---

### 3️⃣ Check index.php Paths
1. Go to cPanel → File Manager
2. Open: `public_html/index.php`
3. Verify line 9 says:
   ```php
   if (file_exists($maintenance = __DIR__.'/../project_files/storage/framework/maintenance.php')) {
   ```
4. Verify line 14 says:
   ```php
   require __DIR__.'/../project_files/vendor/autoload.php';
   ```
5. Verify line 18 says:
   ```php
   $app = require_once __DIR__.'/../project_files/bootstrap/app.php';
   ```

**All paths must have `../project_files/` not just `../`**

---

### 4️⃣ Check .env File Location
1. Go to: `/home/username/project_files/`
2. Verify `.env` file exists HERE (not in public_html)
3. Check it has:
   ```env
   APP_ENV=production
   APP_DEBUG=false
   APP_KEY=base64:...
   ```

---

### 5️⃣ Fix Permissions
1. Go to: `/home/username/project_files/storage/`
2. Right-click → **Change Permissions**
3. Set to: **775**
4. Check: **Recurse into subdirectories**
5. Click: **Change Permissions**

Repeat for: `/home/username/project_files/bootstrap/cache/`

---

## 🔍 Still Not Working?

### Enable Debug Mode (Temporarily)
1. Edit: `project_files/.env`
2. Change to:
   ```env
   APP_DEBUG=true
   ```
3. Refresh your site
4. You'll see the exact error
5. **Set back to `false` after fixing!**

### Check Error Logs
1. cPanel → **Errors** or **Error Log**
2. Look at the most recent errors
3. Common issues:
   - "No such file" → Path problem
   - "Permission denied" → Permission problem
   - "Class not found" → Composer problem

---

## 📖 Full Guide

For detailed troubleshooting, see: **TROUBLESHOOT_503.md**

---

**90% of 503 errors are fixed by:**
1. ✅ Setting PHP to 8.2+
2. ✅ Fixing index.php paths
3. ✅ Setting storage permissions to 775
