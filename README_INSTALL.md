# Installation Instructions (Manual Workaround)

Because the automatic dependency installation failed due to an SSL firewall/antivirus issue (Avast), please follow these steps to manually set up the application.

## 1. Fix SSL / Install Dependencies

You need to run `composer install` successfully for the application to work.

**Option A: Fix the Firewall**
1. Open Avast (or your antivirus).
2. Disable "HTTPS Scanning" or add the project folder to exceptions.
3. Open a terminal in `D:\xampp\htdocs\tokomasivers` and run:
   ```bash
   composer install
   ```

**Option B: Manual Bypass (If Option A fails)**
Try running this command in your terminal:
```bash
composer config -g disable-tls true
composer config -g secure-http false
composer install --ignore-platform-reqs
```

## 2. Database Setup

Once dependencies are installed, set up the database.

1. Create a database named `tokomasivers` in phpMyAdmin.
2. Run migrations and seeders:
   ```bash
   php artisan migrate:fresh --seed
   ```
   
   **If `php artisan` fails due to missing dependencies:**
   Import the provided `database.sql` file (if generated) into phpMyAdmin.

## 3. Run the Application

```bash
php artisan serve
```
Visit `http://localhost:8000`

## 4. Accounts

- **Admin**: `admin@tokomasivers.com` / `password`
- **Customer**: `customer@example.com` / `password`

## 5. Features Implemented

- **Frontend**: Home, Product Detail, Cart, Checkout, My Orders.
- **Admin**: Dashboard, Category Management, Product Management, Order Management (with WhatsApp link).
- **Integrations**: RajaOngkir (Shipping), Tripay (Payment) - *Requires API Keys in .env*.
