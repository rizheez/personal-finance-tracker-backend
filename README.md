# Personal Finance Tracker (PFT) REST API

<p align="center">
<a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="200" alt="Laravel Logo"></a>
</p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About PFT REST API

Personal Finance Tracker (PFT) is a comprehensive REST API built with Laravel that helps users manage their personal finances effectively. The API provides endpoints for tracking income and expenses, categorizing transactions, and generating financial insights through dashboard analytics.

## Features

### 🔐 Authentication & Authorization

-   User registration and login with Laravel Sanctum
-   Secure token-based authentication
-   Protected API endpoints

### 💰 Transaction Management

-   Create, read, update, and delete transactions
-   Support for income and expense tracking
-   Transaction categorization
-   Date-based filtering and search functionality

### 📊 Categories

-   Custom category creation with color coding
-   Category-based transaction organization
-   User-specific categories

### 📈 Dashboard Analytics

-   Financial summary overview
-   Monthly summary reports
-   Recent transactions list
-   Category breakdown analysis

### 🛠 Technical Features

-   RESTful API design
-   Repository pattern implementation
-   Request validation
-   Resource transformation
-   Comprehensive error handling

## API Endpoints

### Authentication

-   `POST /api/v1/auth/register` - User registration
-   `POST /api/v1/auth/login` - User login
-   `POST /api/v1/auth/logout` - User logout (authenticated)

### Transactions

-   `GET /api/v1/transactions` - List all transactions
-   `POST /api/v1/transactions` - Create new transaction
-   `GET /api/v1/transactions/{id}` - Get specific transaction
-   `PUT /api/v1/transactions/{id}` - Update transaction
-   `DELETE /api/v1/transactions/{id}` - Delete transaction

### Categories

-   `GET /api/v1/categories` - List all categories
-   `POST /api/v1/categories` - Create new category
-   `GET /api/v1/categories/{id}` - Get specific category
-   `PUT /api/v1/categories/{id}` - Update category
-   `DELETE /api/v1/categories/{id}` - Delete category

### Dashboard

-   `GET /api/v1/dashboard/summary` - Get financial summary
-   `GET /api/v1/dashboard/monthly-summary` - Get monthly summary
-   `GET /api/v1/dashboard/recent-transactions` - Get recent transactions
-   `GET /api/v1/dashboard/category-breakdown` - Get category breakdown

## Technology Stack

-   **Framework**: Laravel 12.x
-   **PHP**: ^8.2
-   **Authentication**: Laravel Sanctum
-   **Database**: MySQL/PostgreSQL/SQLite
-   **Testing**: Pest PHP
-   **Code Quality**: Laravel Pint

## Installation

1. **Clone the repository**

    ```bash
    git clone <repository-url>
    cd pft-restAPI
    ```

2. **Install dependencies**

    ```bash
    composer install
    ```

3. **Environment setup**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Database configuration**

    ```bash
    # Update .env file with your database credentials
    php artisan migrate
    php artisan db:seed
    ```

5. **Start the development server**
    ```bash
    php artisan serve
    ```

## Development

### Running Tests

```bash
php artisan test
```

### Code Formatting

```bash
./vendor/bin/pint
```

### Development Script

```bash
composer run dev
```

## Project Structure

```
app/
├── Http/
│   ├── Controllers/API/
│   │   ├── Auth/AuthController.php
│   │   └── V1/
│   │       ├── CategoryController.php
│   │       ├── DashboardController.php
│   │       └── TransactionController.php
│   ├── Requests/
│   │   ├── CategoryRequest.php
│   │   └── TransactionRequest.php
│   └── Resources/
│       ├── CategoryResource.php
│       └── TransactionResource.php
├── Interface/
│   ├── CategoryRepositoryInterface.php
│   └── TransactionRepositoryInterface.php
├── Models/
│   ├── Category.php
│   ├── Transaction.php
│   └── User.php
└── Repositories/
    ├── CategoryRepository.php
    └── TransactionRepository.php
```

---
