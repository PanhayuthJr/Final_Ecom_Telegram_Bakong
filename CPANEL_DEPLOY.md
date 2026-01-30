# Hosting Laravel on cPanel (Launcher Plan) - Step by Step

**Hosting Spec:**
- **Server**: LiteSpeed (Fully compatible with Laravel's `.htaccess`)
- **Database**: mysql (1 DB Limit)
- **PHP Version Required**: 8.2 or 8.3

---

## 1. Prepare Local Project
Before uploading, we need to build assets and ensure the code is ready for production.

1.  **Check PHP Version on cPanel**:
    - Log in to cPanel (`https://web2.dpdatacenter.com:2083`).
    - Search for **"Select PHP Version"**.
    - Ensure it is set to **8.2** or **8.3**.
    - Ensure extensions like `mbstring`, `openssl`, `pdo`, `pdo_mysql`, `tokenizer`, `xml` are checked (usually default).

2.  **Build Frontend Assets** (Run locally):
    ```bash
    npm run build
    ```

3.  **Clear Caches** (Run locally):
    ```bash
    php artisan optimize:clear
    ```

## 2. Prepare Database
*Note: Your plan has a **1 Database Limit**. You cannot create multiple databases.*

1.  **Export Local Database**:
    - Open your local database tool (TablePlus, phpMyAdmin, etc.).
    - Export your entire database to a `.sql` file (e.g., `backup.sql`).

2.  **Create cPanel Database**:
    - In cPanel, go to **MySQL Database Wizard**.
    - **Step 1: Create Database**: Name it (e.g., `username_shop`).
    - **Step 2: Create User**: Name it (e.g., `username_admin`) and generate a STRONG password. **SAVE THIS PASSWORD**.
    - **Step 3: Privileges**: Check **ALL PRIVILEGES**.

3.  **Import Data**:
    - In cPanel, go to **phpMyAdmin**.
    - Click on your new database on the left.
    - Click **Import** tab at the top.
    - Upload your `backup.sql` file and click **Go**.

## 3. File Structure Setup (The Secure Way)
We will separate your **application code** (secure) from your **public files** (exposed).

### Step A: Zip Your Project
On your computer, zip your project folder.
- **INCLUDE**: `app`, `bootstrap`, `config`, `database`, `public`, `resources`, `routes`, `storage`, `vendor`, `.env`, `composer.json`, `package.json`, etc.
- **EXCLUDE**: `node_modules`, `.git`.

### Step B: Upload to cPanel
1.  Go to **File Manager** in cPanel.
2.  **Navigate directly to `/home/username/`** (Click "Up One Level" if you are in `public_html`).
3.  Create a new folder named `project_files`.
4.  Open `project_files` and **Upload** your zip file.
5.  Right-click the zip > **Extract**.
6.  *Result: `/home/username/project_files/` should contain `app`, `public`, `vendor`, etc.*

### Step C: Move Public Files
1.  Go into `/home/username/project_files/public`.
2.  Click **Select All**.
3.  Click **Move**.
4.  Change the path to `/public_html`.
5.  *Result: `public_html` should contain `index.php`, `build`, `favicon.ico`, etc.*

## 4. Configuration

### Step A: Edit index.php
1.  Go to `public_html/index.php`.
2.  Right-Click > **Edit**.
3.  Update the paths to point back to your secure `project_files`:
    ```php
    // Change this:
    if (file_exists(__DIR__.'/../storage/framework/maintenance.php')) {
        require __DIR__.'/../storage/framework/maintenance.php';
    }
    
    // To this (Update path):
    if (file_exists(__DIR__.'/../project_files/storage/framework/maintenance.php')) {
        require __DIR__.'/../project_files/storage/framework/maintenance.php';
    }
    
    // Change this:
    require __DIR__.'/../vendor/autoload.php';
    
    // To this:
    require __DIR__.'/../project_files/vendor/autoload.php';
    
    // Change this:
    $app = require_once __DIR__.'/../bootstrap/app.php';
    
    // To this:
    $app = require_once __DIR__.'/../project_files/bootstrap/app.php';
    ```

### Step B: Edit .env
1.  Go to `/home/username/project_files/.env`.
2.  Right-Click > **Edit**.
3.  Update these critical lines:
    ```env
    APP_NAME=LaptopShop
    APP_ENV=production
    APP_DEBUG=false
    APP_URL=https://yourdomain.com  <-- Replace with your actual domain

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=username_shop    <-- Your cPanel DB Name
    DB_USERNAME=username_admin   <-- Your cPanel DB User
    DB_PASSWORD=your_password    <-- Your Password
    ```

## 5. Finalize

### A. Storage Link
1.  Visit `https://yourdomain.com/symlink.php`
2.  It should say "Success".
3.  **Delete `symlink.php` from File Manager** immediately after use.

### B. Permissions (If needed)
If you get "Permission Denied" errors, set these folders to **775** in File Manager:
- `project_files/storage` (and all subfolders)
- `project_files/bootstrap/cache`

---
**Done!** Your site should now be loading.
