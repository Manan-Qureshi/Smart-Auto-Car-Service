# Smart Auto Car Services

## Project Description
Smart Auto Car Services is a web application developed in Laravel (PHP). It helps customers find car workshops (service providers) nearby, select their car type/model, and book various car services like oil changes, washing, and general maintenance. It supports online payment using Stripe, and role-based panels for Admins, Providers, and Workers.

## Key Features

### 1. Customer Panel
- Register and login (supports normal registration and Google Login).
- Select car brand and model (e.g., Sedan/SUV, Civic/Corolla) which adjusts service pricing.
- Add standard services (Car Wash, Oil Change, etc.) to a cart and select available timeslots.
- Secure online payment checkout using Stripe.
- Check booking history and rate completed bookings.

### 2. Admin Panel
- Manage Car Types and Models.
- Manage Service Providers (Workshops) and approve their accounts.
- Manage the global catalog of standard services.
- View financial reports, total bookings, earnings, and platform commission.

### 3. Provider Panel (Workshops)
- Manage profile details and set opening/closing timings.
- Toggle availability of standard services they offer.
- Add and manage Workers/Mechanics.
- Assign workers to incoming customer bookings and track booking status.

### 4. Worker Panel (Mechanics)
- View a dashboard of tasks assigned to them.
- Update task status from "Assigned" -> "In Progress" -> "Completed".

---

## System Requirements
- PHP (version 8.1 or higher)
- Composer
- MySQL Database
- Web server (like XAMPP or Laragon)

---

## Installation & Setup Guide

Follow these steps to set up the project on your local machine:

1. **Clone the Repository**
   Download the project code to your local machine.

2. **Install Dependencies**
   Run the following command in the project root directory:
   ```bash
   composer install
   ```

3. **Environment Setup**
   - Copy `.env.example` to a new file named `.env`.
   - Update the database credentials in the `.env` file:
     ```env
     DB_DATABASE=your_database_name
     DB_USERNAME=your_database_username
     DB_PASSWORD=your_database_password
     ```
   - Update your Stripe keys in the `.env` file to enable payments:
     ```env
     STRIPE_KEY=your_stripe_public_key
     STRIPE_SECRET=your_stripe_secret_key
     ```

4. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

5. **Run Migrations & Seeders**
   Create the database tables and seed the initial Admin account:
   ```bash
   php artisan migrate --seed
   ```

6. **Link Public Storage**
   ```bash
   php artisan storage:link
   ```

7. **Run the Development Server**
   Start the local server by running:
   ```bash
   php artisan serve
   ```
   Open `http://127.0.0.1:8000` in your web browser.

---

## Default Login Credentials

You can use the following default account to log in as Admin and test the dashboard:

- **Admin Account:**
  - **Email:** `admin123@gmail.com`
  - **Password:** `password`

