# Deployment Instructions for Railway/Heroku

## 1. Prerequisites
- **GitHub Repository**: Ensure this project is pushed to GitHub.
- **Railway Account**: Sign up at railway.app.

## 2. Environment Variables
When setting up the project on Railway, you must provide the following variables in the "Variables" tab:

| Variable | Value / Description |
|----------|---------------------|
| `APP_NAME` | `TechStore` |
| `APP_ENV` | `production` |
| `APP_KEY` | (Copy from your local .env or generate a new one) |
| `APP_DEBUG` | `false` |
| `APP_URL` | `https://your-project-name.up.railway.app` (Update after deployment) |
| `DB_CONNECTION` | `pgsql` |
| `DB_URL` | `${DATABASE_URL}` (Railway provides this automatically if you add a Database) |
| `BROADCAST_CONNECTION` | `log` |
| `LOG_CHANNEL` | `stderr` (Important for viewing logs in Railway console) |
| `SESSION_DRIVER` | `database` |
| `SESSION_SECURE_COOKIE` | `true` |

## 3. Database Setup
1. In your Railway project, Click **New > Database > PostgreSQL**.
2. Railway will automatically inject `DATABASE_URL` into your environment.
3. Because Laravel expects `DB_URL` (as per our config), create a new variable called `DB_URL` and set its value to `${DATABASE_URL}` (reference the system variable) OR just ensure your `config/database.php` uses `DATABASE_URL` if you modified it (we configured `pgsql` to use `DB_URL`, so mapping it is key).
   - **Simpler method**: Just add a custom variable `DB_URL` with value `${DATABASE_URL}`.

## 4. Build Settings (Crucial for CSS/JS)
Since this project uses Vite (Node.js) and Laravel (PHP), you need **two** buildpacks.
1. Go to **Settings > Build**.
2. Under "Buildpacks", ensure you have:
   1. `heroku/nodejs` (First, to build assets)
   2. `heroku/php` (Second, to run the app)
3. If Railway doesn't auto-detect both, add them manually in that order.

## 5. Deployment Command
Railway might default to a simple start, but for Laravel we need to migrate.
- **Build Command**: `npm install && npm run build` (This usually runs automatically with the Node buildpack)
- **Deploy Command** (Start Command): `vendor/bin/heroku-php-apache2 public/` (Defined in Procfile)
- **Migrations**: You usually want to run migrations on deploy. You can add a "Custom Start Command" or use the `Procfile`.
  - Recommended: Add a `redeploy` hook or just run `php artisan migrate --force` in the Railway Console after first deploy.
  - Or update `composer.json` scripts.

## 6. Important Notes
- **Storage**: Railway has an **ephemeral filesystem**. This means images uploaded to `public/storage` (like product images) **WILL BE DELETED** every time you redeploy.
  - **Solution**: Use AWS S3, Cloudinary, or similar for production storage.
  - Currently, we are using the `local` disk. It will work for demo purposes but is not permanent.

## 7. Admin Access
To create an admin account, open the Railway Console (Post-deploy) and run:
```bash
php artisan migrate --force
php artisan db:seed --class=AdminUserSeeder
```
Or if you included it in `DatabaseSeeder`, just `php artisan db:seed`.
