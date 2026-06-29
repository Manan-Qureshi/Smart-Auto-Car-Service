# Setup & Installation Guide

Follow these steps to set up the Smart Auto Car Services project on your local machine.

## Prerequisites

Ensure you have the following installed:
- **PHP**: ^8.1
- **Composer**: Dependency manager for PHP.
- **Node.js & NPM**: For frontend asset compilation.
- **MySQL**: Or any Laravel-supported database.

---

## Installation Steps

### 1. Clone & Dependencies
Clone the repository and install the backend and frontend dependencies.

```bash
composer install
npm install
```

### 2. Environment Configuration
Copy the example environment file and generate an application key.

```bash
cp .env.example .env
php artisan key:generate
```

### 3. Database Setup
1. Create a database in MySQL (e.g., `smart_auto_db`).
2. Update your `.env` file with the database credentials:
   ```env
   DB_DATABASE=smart_auto_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```
3. Run the migrations and seed the database.
   ```bash
   php artisan migrate --seed
   ```

### 4. Stripe Integration
To enable payments and refunds, you must provide your Stripe API keys in the `.env` file:
```env
STRIPE_KEY=your_public_key
STRIPE_SECRET=your_secret_key
```

### 5. Google Login (Optional)
For Google authentication, configure your credentials from the Google Cloud Console:
```env
GOOGLE_CLIENT_ID=your_id
GOOGLE_CLIENT_SECRET=your_secret
GOOGLE_REDIRECT_URL=http://localhost:8000/auth/google/callback
```

---

## Running the Application

### Start the Development Server
```bash
php artisan serve
```

### Compile Assets
In a separate terminal, run the Vite development server:
```bash
npm run dev
```

The application should now be accessible at `http://localhost:8000`.

---

## Default Accounts (if seeded)
- **Admin**: admin@example.com / password
- **Worker**: worker@example.com / password
- **Test User**: user@example.com / password
