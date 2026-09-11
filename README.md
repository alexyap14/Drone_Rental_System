# Drone Rental System

A full-stack web application for browsing and renting drones. The system provides a customer-facing catalogue and rental workflow together with an administrator interface for managing drone listings.

This project was developed as a team-based academic project using Laravel.

## Features

### Customer

- Create an account, sign in, sign out, and reset a forgotten password
- Set up, view, and update a user profile
- Browse available drones and view individual product details
- Add drones to a shopping cart and remove cart items
- Complete the checkout flow using the available payment options
- View purchase and rental history
- Submit enquiries through the contact form
- View the privacy policy and terms of service

### Administrator

- Access protected administrator functions using role-based authorization
- Create new drone listings
- Edit existing drone information
- Delete drone listings
- Manage product descriptions, images, and rental prices

## Technology Stack

- **Backend:** PHP and Laravel 8
- **Frontend:** Blade, HTML, CSS, JavaScript, Bootstrap 5, and Vue 2
- **Database:** MySQL
- **Build tool:** Laravel Mix
- **Authentication:** Laravel session-based authentication
- **Version control:** Git and GitHub

## Requirements

Before running the project, install:

- PHP 7.3 or later
- Composer
- Node.js and npm
- MySQL
- PHP extensions required by Laravel 8

## Installation

1. Clone the repository:

   ```bash
   git clone https://github.com/alexyap14/Drone_Rental_System.git
   cd Drone_Rental_System
   ```

2. Install the PHP dependencies:

   ```bash
   composer install
   ```

3. Install and compile the frontend dependencies:

   ```bash
   npm install
   npm run dev
   ```

4. Create a `.env` file in the project root. Since this repository does not currently include an `.env.example`, add the normal Laravel environment settings and configure at least the application and database values:

   ```env
   APP_NAME="Drone Rental System"
   APP_ENV=local
   APP_KEY=
   APP_DEBUG=true
   APP_URL=http://localhost:8000

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=drone_rental_system
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. Generate the application key:

   ```bash
   php artisan key:generate
   ```

6. Create a MySQL database named `drone_rental_system`, then run the migrations and seeders:

   ```bash
   php artisan migrate --seed
   ```

   The seeders add an administrator account and sample drone listings. For security, change the development administrator credentials in `database/seeders/AdminSeeder.php` before deploying the application.

7. If uploaded files are stored using Laravel's public disk, create the storage link:

   ```bash
   php artisan storage:link
   ```

8. Start the development server:

   ```bash
   php artisan serve
   ```

9. Open [http://localhost:8000](http://localhost:8000) in your browser.

## Main Application Routes

| Area | Route |
|---|---|
| Home | `/` |
| Drone catalogue | `/products` |
| Cart | `/cart` |
| Checkout | `/checkout` |
| User profile | `/profile` |
| Purchase history | `/purchase-history` |
| Contact | `/contact` |

Administrator product-management routes require an authenticated account with the administrator role.

## Project Structure

```text
app/                 Application models, middleware, and controllers
database/migrations/ Database schema
database/seeders/    Administrator and sample-product data
public/              Public assets and images
resources/views/     Blade templates
routes/web.php       Web routes
```

## Notes

- This repository is intended for learning and demonstration purposes.
- Do not commit a real `.env` file or production credentials.
- Configure mail-related environment variables if you want contact-form emails and password-reset emails to work.
- Replace all development credentials before using the application outside a local environment.

## Contributors

Developed as a four-person team project led by Yap Wen Qing.

## License

This project is built with the Laravel framework, which is licensed under the [MIT License](https://opensource.org/licenses/MIT).
