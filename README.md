# E-commerce Project Documentation

## 1. Project Overview
This project is a Laravel-based E-commerce web application designed to facilitate online shopping with integrated KHQR payment solutions. It features a modern, responsive user interface built with TailwindCSS and Vite, offering a seamless experience for browsing products, managing a shopping cart, and processing transactions.

### Group Members
- Thet Panhayuth (Group Leader)
- Menrorn Virakvuth (Frontend Developer)
- Prum David (Backend Developer)
- Vonnvirak Khemra (Hosting)
- Koun Channit (Database)

## 2. Technology Stack

### Backend
- **Framework**: Laravel 12.x
- **Language**: PHP 8.2+
- **Database**: MySQL
- **Payment Integration**: Bakong KHQR (`fidele007/bakong-khqr-php`)
- **Notification Service**: Telegram Bot API

### Frontend
- **Styling**: TailwindCSS v4
- **Bundler**: Vite
- **Templating**: Laravel Blade
- **HTTP Client**: Axios
- **Social Sharing**: Facebook Share URL & Telegram Share URL

## 3. Key Features

### Storefront
- **Product Catalog**: Browse available products with a responsive layout.
- **Product Details**: Detailed view of products including descriptions, pricing, and images.
- **Shopping Cart**: Full cart management (add, update, remove items, clear cart).
- **Buy Now**: Quick purchase option for immediate checkout.

### Checkout & Payment
- **User Authentication**: Secure Login and Registration system.
- **Checkout Process**: Step-by-step checkout flow.
- **KHQR Payment**: Integrated Bakong KHQR for seamless payments.
- **Transaction Status**: Automated checks for transaction validity.

### Administration
- **Admin Dashboard**: Backend interface for managing the store.
- **Product Management**: Create, read, update, and delete (CRUD) operations for products.

### Notifications & Social Sharing

#### Telegram Owner Notification
- Automatically sends order notifications to the store owner via Telegram Bot.
- Includes customer name, order ID, total amount, and payment status.
- Helps store owners monitor sales in real time.

#### Product Sharing
- **Facebook Share**: Allows users to share product detail links directly to Facebook.
- **Telegram Share**: Allows users to share product links via Telegram.
- Improves product visibility and social engagement.

## 4. Installation & Setup Guide

### Prerequisites
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL Database
- Telegram Bot Token (for notifications)

### Steps

1. **Clone the Repository**
   ```bash
   git clone <repository_url>
   cd <project_directory>
   ```

2. **Install PHP Dependencies**
   ```bash
   composer install
   ```

3. **Install Frontend Dependencies**
   ```bash
   npm install
   ```

4. **Environment Configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Update `.env`:
   ```env
   DB_DATABASE=your_db
   DB_USERNAME=your_user
   DB_PASSWORD=your_password

   TELEGRAM_BOT_TOKEN=your_bot_token
   TELEGRAM_CHAT_ID=your_chat_id
   ```

5. **Database Migration**
   ```bash
   php artisan migrate
   ```

6. **Build Assets**
   ```bash
   npm run dev
   ```
   or
   ```bash
   npm run build
   ```

7. **Serve Application**
   ```bash
   php artisan serve
   ```
   
   **Application URL:**
   [https://dpdc501.dpdatacenter.com](https://dpdc501.dpdatacenter.com)

## 5. API & Routes
- **Home**: `/` or `/catalog`
- **Product Detail**: `/product/{id}`
- **Cart**: `/cart`
- **Checkout**: `/checkout`
- **Admin Products**: `/admin/products`

## 6. Deployment Notes
- Configure Apache/Nginx to point to the `public/` directory.
- Set correct permissions for:
  - `storage/`
  - `bootstrap/cache/`
- Ensure HTTPS is enabled for secure payments and social sharing.
