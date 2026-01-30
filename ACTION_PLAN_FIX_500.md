# 🚨 FIXING YOUR HTTP 500 ERROR - ACTION PLAN

## 🎯 Current Problem
Your site shows: **"HTTP ERROR 500"** at https://dpdc501.dpdatacenter.com

## 🔍 Root Causes Found

Based on your `.env` file, here are the issues:

1. ❌ **Database credentials are for localhost** (won't work on cPanel)
   - Current: `DB_DATABASE=laptopshop_db`, `DB_USERNAME=root`, `DB_PASSWORD=` (empty)
   - These are your local development settings!

2. ⚠️ **LOG_LEVEL=debug** (should be `error` in production)

3. ❓ **Unknown file structure** (need to verify in cPanel)

---

## ✅ STEP-BY-STEP FIX (Follow in Order!)

### 🔴 STEP 1: Upload Diagnostic Tool (2 minutes)

1. **Find the file:** `check-installation.php` in your `public/` folder
2. **Upload to cPanel:**
   - Log into cPanel File Manager
   - Navigate to `/home2/wvagae5401/public_html/`
   - Click "Upload"
   - Upload `check-installation.php`
3. **Visit:** https://dpdc501.dpdatacenter.com/check-installation.php
4. **Take a screenshot** of the results
5. **This will tell us exactly what's wrong!**

---

### 🔴 STEP 2: Create Database in cPanel (5 minutes)

1. **Go to cPanel → MySQL® Databases**

2. **Create New Database:**
   - Database Name: `laptopshop` (it will become `wvagae5401_laptopshop`)
   - Click "Create Database"
   - **Write down the full name:** `wvagae5401_laptopshop`

3. **Create Database User:**
   - Username: `admin` (it will become `wvagae5401_admin`)
   - Password: **Create a strong password** (save it somewhere safe!)
   - Click "Create User"
   - **Write down:**
     - Username: `wvagae5401_admin`
     - Password: (your password)

4. **Add User to Database:**
   - Select user: `wvagae5401_admin`
   - Select database: `wvagae5401_laptopshop`
   - Click "Add"
   - Select "ALL PRIVILEGES"
   - Click "Make Changes"

✅ **You now have:**
- Database: `wvagae5401_laptopshop`
- User: `wvagae5401_admin`
- Password: (your chosen password)

---

### 🔴 STEP 3: Import Your Database (5 minutes)

1. **Go to cPanel → phpMyAdmin**

2. **Select your database** (`wvagae5401_laptopshop`) from the left sidebar

3. **Click "Import" tab**

4. **Choose your database file:**
   - Click "Choose File"
   - Select your `backup.sql` or database export file
   - Click "Import"

5. **Wait for success message**

⚠️ **Don't have a database export?**
- You'll need to export from your local database first
- Use TablePlus, phpMyAdmin, or MySQL Workbench
- Export as `.sql` file

---

### 🔴 STEP 4: Update .env File in cPanel (3 minutes)

1. **Go to cPanel File Manager**

2. **Navigate to:** `/home2/wvagae5401/public_html/`

3. **Enable "Show Hidden Files"** (Settings in top right)

4. **Find `.env` file** and right-click → Edit

5. **Update these lines ONLY:**

```env
# Change these 3 lines:
DB_DATABASE=wvagae5401_laptopshop
DB_USERNAME=wvagae5401_admin
DB_PASSWORD=YOUR_ACTUAL_PASSWORD_HERE

# Also change this:
LOG_LEVEL=error
```

6. **Save the file**

---

### 🔴 STEP 5: Fix Permissions (2 minutes)

1. **In cPanel File Manager, navigate to:** `/home2/wvagae5401/public_html/`

2. **Fix storage/ folder:**
   - Find `storage` folder
   - Right-click → "Change Permissions"
   - Set to: **775** (or check: Read, Write, Execute for Owner and Group)
   - ✅ Check "Recurse into subdirectories"
   - Click "Change Permissions"

3. **Fix bootstrap/cache/ folder:**
   - Navigate to `bootstrap/cache/`
   - Right-click → "Change Permissions"
   - Set to: **775**
   - ✅ Check "Recurse into subdirectories"
   - Click "Change Permissions"

---

### 🔴 STEP 6: Verify File Structure (3 minutes)

**Check where your Laravel files are located:**

#### Option A: Everything in public_html/

If you see these folders in `/home2/wvagae5401/public_html/`:
- `app/`
- `bootstrap/`
- `config/`
- `vendor/`
- `storage/`

Then you need to:

1. **Go to:** `/home2/wvagae5401/public_html/public/`
2. **Select ALL files** inside (index.php, .htaccess, css, js, images, etc.)
3. **Click "Move"**
4. **Move to:** `/home2/wvagae5401/public_html/`
5. **Overwrite when asked**

6. **Edit index.php:**
   - Open `/home2/wvagae5401/public_html/index.php`
   - Make sure it has these paths (NO `../`):
   ```php
   require __DIR__.'/vendor/autoload.php';
   $app = require_once __DIR__.'/bootstrap/app.php';
   ```

#### Option B: Laravel outside public_html/

If your Laravel files are in a different folder (like `project_files/`), then:

1. **Edit index.php:**
   - Open `/home2/wvagae5401/public_html/index.php`
   - Update paths to point to your Laravel folder:
   ```php
   require __DIR__.'/../project_files/vendor/autoload.php';
   $app = require_once __DIR__.'/../project_files/bootstrap/app.php';
   ```

---

### 🔴 STEP 7: Check PHP Version (2 minutes)

1. **Go to cPanel → MultiPHP Manager** (or "Select PHP Version")

2. **Select your domain:** `dpdc501.dpdatacenter.com`

3. **Change PHP version to:** **8.2** or **8.3**

4. **Enable these extensions:**
   - ✅ pdo_mysql
   - ✅ mbstring
   - ✅ xml
   - ✅ openssl
   - ✅ curl
   - ✅ fileinfo
   - ✅ tokenizer
   - ✅ bcmath
   - ✅ ctype
   - ✅ json

5. **Click "Apply"**

---

### 🔴 STEP 8: Create Storage Link (2 minutes)

1. **Upload `symlink.php`** from your `public/` folder to cPanel `/home2/wvagae5401/public_html/`

2. **Visit:** https://dpdc501.dpdatacenter.com/symlink.php

3. **You should see:** "Storage link created successfully!"

4. **IMMEDIATELY delete `symlink.php`** from cPanel (security!)

---

### 🔴 STEP 9: Test Your Site (1 minute)

1. **Visit:** https://dpdc501.dpdatacenter.com

2. **Expected results:**
   - ✅ Site loads without errors
   - ✅ You see your homepage
   - ✅ Images load correctly
   - ✅ CSS styles are applied

3. **If you still see an error:**
   - Go to Step 10 (Enable Debug Mode)

---

### 🔴 STEP 10: Enable Debug Mode (If Still Broken)

1. **Edit `.env` in cPanel**

2. **Change:**
   ```env
   APP_DEBUG=true
   ```

3. **Refresh your website**

4. **You'll see the actual error message**

5. **Take a screenshot and send it to me**

6. **After fixing, change back to:**
   ```env
   APP_DEBUG=false
   ```

---

## 📊 Quick Checklist

Before you start, prepare:

- [ ] Database export file (`backup.sql`)
- [ ] cPanel login credentials
- [ ] Notepad to write down database credentials
- [ ] 20-30 minutes of time

After each step, check off:

- [ ] Step 1: Uploaded diagnostic tool
- [ ] Step 2: Created database in cPanel
- [ ] Step 3: Imported database
- [ ] Step 4: Updated .env file
- [ ] Step 5: Fixed permissions
- [ ] Step 6: Verified file structure
- [ ] Step 7: Set PHP version to 8.2+
- [ ] Step 8: Created storage link
- [ ] Step 9: Tested site
- [ ] Step 10: (If needed) Enabled debug mode

---

## 🆘 Common Errors & Quick Fixes

| Error | Quick Fix |
|-------|-----------|
| "No application encryption key" | Check `APP_KEY` in `.env` is not empty |
| "SQLSTATE[HY000] [1045]" | Wrong database password in `.env` |
| "SQLSTATE[HY000] [2002]" | Wrong database host (should be `127.0.0.1`) |
| "Class 'X' not found" | Upload `vendor/` folder |
| "Permission denied" | Fix `storage/` permissions to 775 |
| Blank white page | Enable `APP_DEBUG=true` to see error |

---

## 📸 What to Send Me If Still Stuck

1. **Screenshot of:** https://dpdc501.dpdatacenter.com/check-installation.php
2. **Screenshot of:** Your cPanel file structure (show folders in public_html)
3. **Screenshot of:** The error with `APP_DEBUG=true`
4. **Confirm:**
   - PHP version: _______
   - Database created: Yes/No
   - Database imported: Yes/No
   - vendor/ folder exists: Yes/No

---

## 🎯 Most Likely Fix

Based on your `.env` file, **99% chance** your issue is:

**❌ Wrong database credentials**

Your `.env` has:
```
DB_DATABASE=laptopshop_db  ← Local database name
DB_USERNAME=root            ← Local username
DB_PASSWORD=                ← Empty password
```

These won't work on cPanel! You MUST:
1. Create database in cPanel (Step 2)
2. Update `.env` with cPanel credentials (Step 4)

---

**Created:** 2026-01-29  
**Time to fix:** 20-30 minutes  
**Difficulty:** Easy (just follow steps!)  

🚀 **Let's fix this! Start with Step 1!**
