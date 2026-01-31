# E-commerce Project Documentation

## 1. Project Overview
This project is a Laravel-based E-commerce web application designed to facilitate online shopping with integrated KHQR payment solutions. It features a modern, responsive user interface built with TailwindCSS and Vite, offering a seamless experience for browsing products, managing a shopping cart, and processing transactions.
+Member

1. Thet Panhayuth (Group Leader)
2. Menrorn Virakvuth (Frontend Developer)
3. Prum David (Backend Developer)
4. Vonnvirak Khemra (Hosting)
5. Koun Channit (Database)

## 2. Technology Stack

### Backend
- **Framework**: Laravel 12.x
- **Language**: PHP 8.2+
- **Database**: MySQL / MariaDB (Standard Laravel support)
- **Payment Integration**: Bakong KHQR (`fidele007/bakong-khqr-php`)

### Frontend
- **Styling**: TailwindCSS v4
- **Bundler**: Vite
- **Templating**: Laravel Blade
- **HTTP Client**: Axios

## 3. Key Features

### Storefront
- **Product Catalog**: Browse available products with a responsive layout.
- **Product Details**: Detailed view of products including descriptions and pricing.
- **Shopping Cart**: Full cart management (add, update, remove items, clear cart).
- **Buy Now**: Quick purchase option for immediate checkout.

### Checkout & Payment
- **User Authentication**: Secure Login and Registration system.
- **Checkout Process**: Step-by-step checkout flow.
- **KHQR Payment**: Integrated Bakong KHQR for seamless payments.
- **Transaction Status**: Automated checks for transaction validity.

### Administration
- **Admin Dashboard**: backend interface for managing the store.
- **Product Management**: Create, read, update, and delete (CRUD) operations for products.

## 4. Installation & Setup guide

### Prerequisites
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL Database

### Steps
1.  **Clone the Repository**
    ```bash
    git clone <repository_url>
    cd <project_directory>
    ```

2.  **Install PHP Dependencies**
    ```bash
    composer install
    ```

3.  **Install Frontend Dependencies**
    ```bash
    npm install
    ```

4.  **Environment Configuration**
    - Copy the example environment file:
        ```bash
        cp .env.example .env
        ```
    - Update `.env` with your database credentials and application settings.
    - Generate the application key:
        ```bash
        php artisan key:generate
        ```

5.  **Database Migration**
    - Run migrations to set up the database schema:
        ```bash
        php artisan migrate
        ```

6.  **Build Assets**
    - For development:
        ```bash
        npm run dev
        ```
    - For production:
        ```bash
        npm run build
        ```

7.  **Serve Application**
    ```bash
    php artisan serve
    ```
    The application will be available at `https://dpdc501.dpdatacenter.com`.

## 5. API & Routes
- **Home**: `/` or `/catalog`
- **Product**: `/product/{id}`
- **Cart**: `/cart`
- **Checkout**: `/checkout`
- **Admin**: `/admin/products`

## 6. Deployment Note
- Ensure the web server (Apache/Nginx) points to the `public/` directory.
- Configure folder permissions for `storage/` and `bootstrap/cache/`.
