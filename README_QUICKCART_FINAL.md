# Mega Mall QuickCart - Laravel Final Project

## Stack
- Laravel 12, PHP 8.2, SQLite database
- Bootstrap 5 UI
- Eloquent models, migrations, controllers, seeders
- Laravel Mail for order/contact emails
- Gemini-ready AI shopping assistant with a free local fallback

## Main Features
- 72 seeded products across 16 mall categories
- Product photos instead of icon-only product cards
- Search, category filters, sorting, flash deals, cart, checkout
- Orders saved in database with order items
- Contact messages saved in database
- Newsletter subscribers saved with coupon codes
- Admin dashboard at `/admin`
- AI assistant at the bottom right of the shop

## How To Run
Open a terminal in this folder:

```bash
cd "C:\Users\EURO TEC COMPUTERS\Documents\Codex\2026-05-31\files-mentioned-by-the-user-quickcart\outputs\mega-mall-quickcart"
php artisan serve
```

Then open:

```text
http://127.0.0.1:8000
```

Admin dashboard:

```text
http://127.0.0.1:8000/admin
```

## Database
The project already has `database/database.sqlite` seeded. If you ever need to reset it:

```bash
php artisan migrate:fresh --seed
```

## Gemini AI
The AI feature works without money by using a free local product recommender fallback. To use real Gemini, put your free Google AI Studio key in `.env`:

```env
GEMINI_API_KEY=your_key_here
```

## Email
By default Laravel uses:

```env
MAIL_MAILER=log
```

That means emails are written to `storage/logs/laravel.log`, so the project works without paid email hosting. To receive real emails, replace the mail settings in `.env` with Gmail SMTP, Mailtrap, or another free SMTP provider.
