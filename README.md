# 🚀 bKash Payment Gateway Integration for Laravel v12

bKash Payment Gateway Integration for Laravel v12 is a simple and secure implementation of bKash Tokenized Checkout (v1.2.0-beta) for both sandbox and live environments.

This package allows developers to accept payments through bKash directly from their Laravel applications using token-based authentication. It supports payment creation, execution, and status query with clean, modular code architecture.

---

## 🧩 Features

- Token-based authentication with bKash  
- Secure payment creation and redirection  
- Callback & execution handling  
- Sandbox and live mode supported  
- Well-structured Laravel service and controller pattern  
- Logs requests and responses for debugging  

---

## 📂 Project Structure
```
├── app/
│ ├── Http/
│ │ └── Controllers/
│ │ └── BkashController.php
│ └── Providers/
│ └── BkashService.php
├── config/
│ └── bkash.php
├── resources/
│ └── views/
│ └── payment/
│ ├── form.blade.php
│ ├── success.blade.php
│ └── failed.blade.php
├── .env
```
---

## 🧪 Sandbox Testing

1. Sign up at [bKash Merchant Wallet](https://pgw-integration.bkash.com/#/sign-up)  
2. Get your **sandbox credentials**
3. Set `'mode' => 'sandbox'` in `api.php`

---

## ⚙️ Installation & Setup

### 1. Clone the Repository

```bash
git clone https://github.com/your-username/your-repo-name.git
cd your-repo-name
```
### 2. Install Dependencies
```
composer install
```
### 3. bKash API Configuration
Copy .env.example to .env and set the following:
⚠️ Replace the values with your bKash credentials.
```
# Use BKASH_MODE is 'sandbox' for testing, 'live' for real payments
BKASH_MODE=sandbox
BKASH_APP_KEY=your_app_key
BKASH_APP_SECRET=your_app_secret
BKASH_USERNAME=your_bkash_username
BKASH_PASSWORD=your_bkash_password
BKASH_CALLBACK=https://yourdomain.com/pay/status
```


### 4. Set Up Routes
In routes/web.php:
```
use App\Http\Controllers\BkashController;

Route::get('/pay', [BkashController::class, 'showForm']);
Route::post('/pay', [BkashController::class, 'createPayment']);
Route::get('/pay/status', [BkashController::class, 'callback']);
```
---

## ⚠️ Notes

- `callbackURL` **must be HTTPS** and publicly accessible  
- Don't hardcode credentials in production; use environment variables  
- Customize `success.blade.php` to store transaction info in a database  
- You can enhance form design in `form.blade.php` with your own styles
---

## 🧑‍💻 Developer Info

> Developed with ❤️ by [Soleman IT](https://github.com/solemanit)  
> 🌐 Website: [https://solemanit.com](https://solemanit.com)
