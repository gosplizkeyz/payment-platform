<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

#BUILT gosplizkeyz

# Payment Platform

A Laravel-based payment platform for multiple businesses to collect payments, calculate platform fees, deduct applicable taxes, and manage wallets. 
This project is built as a **local setup** using **mock payment flows** for testing purposes.

---

## Features

- Process customer payments  
- Deduct platform fees (2.5%)  
- Deduct applicable taxes (7.5%)  
- Manage business, platform, and tax wallets  
- Ledger entries for all transactions  
- Works in both browser form and Postman  
- Safe under concurrent transactions  

---

## Tech Stack

- **Backend:** PHP 8+, Laravel 10  
- **Database:** PostgreSQL  
- **Frontend:** Blade templates  
- **Dependencies:** Composer packages, Laravel standard packages  

---

## Project Overview

The payment flow works as follows:
Customer Payment
↓
Business Wallet (credit net amount)
↓
Ledger Entries
↓
Platform Wallet (platform fee)
↓
Tax Wallet (tax deduction)
↓
Payment record created

- Each transaction creates ledger entries for **business**, **platform**, and **tax** wallets.  
- Payment references are stored in the `payments` table.  

---

## Installation

1. **Clone the repository**

```bash
git clone https://github.com/<your-username>/payment-platform.git
cd payment-platform

2. Install dependencies

composer install

3. Setup environment

Copy .env.example to .env:

cp .env.example .env

Update database credentials in .env:

DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=payment_platform
DB_USERNAME=postgres
DB_PASSWORD=your_password

4. Generate app key
php artisan key:generate

5.Run migrations
php artisan migrate

6.Seed initial data
Open Tinker:
php artisan tinker

7. Run:

$business = App\Models\Business::create(['name' => 'Demo Business']);
App\Models\Wallet::create(['owner_type'=>'business','owner_id'=>$business->id]);
App\Models\Wallet::create(['owner_type'=>'platform','owner_id'=>null]);
App\Models\Wallet::create(['owner_type'=>'tax','owner_id'=>null]);

Run the application
php artisan serve --port=8081

Visit in your browser: http://127.0.0.1:8081/pay

Usage
Browser

Open /pay in your browser.

Enter Business ID and Amount (in kobo).

Click Pay → you should see a success message with payment reference.






