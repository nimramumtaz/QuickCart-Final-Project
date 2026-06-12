# 🛒 Mega Mall QuickCart

> **Pakistan's Mega Mall — built with Laravel.**  
> A fully functional e-commerce web application with 72 products across 16 categories, a real database backend, admin dashboard, and a Gemini-ready AI shopping assistant.

---

## 📌 Project Overview

**Mega Mall QuickCart** is a complete online shopping platform developed as a semester project for **CSC336 — Web Technologies** at COMSATS University Islamabad, Vehari Campus.

The project simulates a real-world mega mall where users can browse products from 16 departments, add items to a cart, place orders (saved to database), contact support, subscribe to a newsletter, and interact with an AI shopping assistant — all from a single, responsive web application.

---

## 🚀 Live Demo & Repository

| | Link |
|---|---|
| 🌐 **Deployed Project** | [quickcart-final-project-production.up.railway.app](#) |
| 💻 **GitHub Repository** | [https://github.com/nimramumtaz/QuickCart-Final-Project](#) |

---

## ✨ Features

- 🏬 **16 Product Categories** — Automotive, Beauty, Books, Clothing, Electronics, Fashion, Food, Footwear, Grocery, Home, Jewelry, Pets, Pharmacy, Sports, Stationery, Toys
- 📦 **72 Products** with real images, prices (in Rs.), ratings, and badge tags (sale / hot / deal / best / new)
- 🔍 **Search & Sort** — filter products by keyword, sort by price or name
- ⚡ **Flash Deals Section** — limited-time discounted products on the homepage
- 🛒 **Shopping Cart** — add/update/remove items, live total calculation with Cash on Delivery
- 📋 **Checkout System** — order form saved to SQLite database with unique Order ID (e.g., QC-260531-0PJDB)
- 📬 **Contact Form** — messages saved to database, visible in admin panel
- 📧 **Newsletter Subscription** — auto-generates unique discount coupons (e.g., QC10-9757)
- 🤖 **QuickCart AI Assistant** — Gemini-ready chatbot with free local fallback system
- 🖥️ **Admin Dashboard** — real-time stats (products, orders, revenue, messages), recent orders table, contact messages, and newsletter subscribers
- 📱 **Fully Responsive** — works on desktop and mobile using Bootstrap 5

---

## 🛠️ Tech Stack

| Technology | Version | Purpose |
|---|---|---|
| PHP | 8.x | Server-side scripting language |
| Laravel | 10.x | MVC backend framework |
| Bootstrap | 5.3 | Responsive frontend UI |
| HTML5 / CSS3 | Latest | Markup and styling |
| JavaScript (ES6) | Latest | Client-side interactivity and cart logic |
| SQLite | 3.x | Lightweight file-based database |
| Blade Templates | Built-in | Laravel's dynamic view rendering engine |
| Composer | Latest | PHP dependency manager |
| Gemini AI API | Free Tier | AI assistant (with local fallback) |

---

## 🗂️ Project Structure

```
mega-mall-quickcart/
├── app/
│   ├── Http/Controllers/
│   │   ├── ProductController.php
│   │   ├── CartController.php
│   │   ├── OrderController.php
│   │   ├── ContactController.php
│   │   ├── NewsletterController.php
│   │   └── AdminController.php
│   └── Models/
│       ├── Product.php
│       ├── Order.php
│       ├── OrderItem.php
│       ├── ContactMessage.php
│       └── NewsletterSubscriber.php
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── database.sqlite
├── resources/views/
│   ├── layouts/
│   ├── home.blade.php
│   ├── shop.blade.php
│   ├── cart.blade.php
│   ├── contact.blade.php
│   └── admin/
│       └── dashboard.blade.php
├── routes/
│   └── web.php
├── public/
└── .env
```

---

## ⚙️ Installation & Setup

### Prerequisites
- PHP 8.x
- Composer
- Laravel 10.x
- Node.js & npm (optional, for assets)

### Steps

```bash
# 1. Clone the repository
git clone https://github.com/your-username/mega-mall-quickcart.git
cd mega-mall-quickcart

# 2. Install PHP dependencies
composer install

# 3. Copy environment file
cp .env.example .env

# 4. Generate application key
php artisan key:generate

# 5. Run database migrations
php artisan migrate

# 6. Seed the database (72 products across 16 categories)
php artisan db:seed

# 7. Start the development server
php artisan serve
```

Then open your browser and go to: **http://localhost:8000**

---

## 🤖 AI Assistant Setup (Optional)

The QuickCart AI assistant works out of the box using the **free local fallback** system — no API key needed.

To enable **Gemini AI** for smarter responses:

1. Get a free API key from [Google AI Studio](https://aistudio.google.com/)
2. Add it to your `.env` file:

```env
GEMINI_API_KEY=your_api_key_here
```

3. Restart the server — the AI widget will now use Gemini.

---

## 🖥️ Admin Dashboard

Access the admin panel at:

```
http://localhost:8000/admin
```

The dashboard shows:
- 📦 Total Products (72 active catalog items)
- 🛍️ Total Orders (customer checkouts)
- 💬 Total Messages (support inbox)
- 💰 Total Revenue (Rs. total sales value)
- Recent orders with Order ID, customer name, items, total, and status
- Contact messages with category tags
- Newsletter subscribers with their coupon codes

---

## 📬 Email / Mail Setup

By default, all emails (order confirmations, contact replies) are saved to:

```
storage/logs/laravel.log
```

No external email service is required for development. To enable real email sending, configure your SMTP settings in `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your@email.com
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
```

---

## 📸 Screenshots

### 🏠 Homepage
<img width="1912" alt="Homepage" src="https://github.com/user-attachments/assets/3eee576e-59bd-410d-b9c9-866e9fc6bd79" />

### 🏬 Browse Categories
<img width="1920" alt="Browse Categories" src="https://github.com/user-attachments/assets/f4cfd36d-a881-4636-a87c-63b68a1f70a2" />

### 🛍️ Product Listing
<img width="1920" alt="Product Listing" src="https://github.com/user-attachments/assets/a27ffcc6-bed3-4302-9b1b-55537aaf00dc" />

<img width="1920" alt="Product Cards" src="https://github.com/user-attachments/assets/e7b20098-27de-46a4-86cd-5ab59b85c791" />

### ⚡ Flash Deals
<img width="1907" alt="Flash Deals" src="https://github.com/user-attachments/assets/9b856d75-240d-48a4-be0e-4c2d0bb03e62" />

### 📬 Contact Page
<img width="1917" alt="Contact Page" src="https://github.com/user-attachments/assets/d1f88746-fe50-4167-8a52-a1e87012b6d8" />

### 📧 Newsletter Subscription
<img width="1918" alt="Newsletter" src="https://github.com/user-attachments/assets/0205560b-acac-41da-abbc-b7f1a9c5f529" />

### 🛒 Shopping Cart & Checkout
<img width="568" alt="Shopping Cart and Checkout" src="https://github.com/user-attachments/assets/e55d340c-cf50-4de8-bf58-8e477dafd0ee" />

### 🤖 AI Assistant
<img width="465" alt="QuickCart AI Widget" src="https://github.com/user-attachments/assets/367f5d5d-4be0-4d33-a589-bca6e0469531" />

<img width="1920" alt="AI Assistant Response" src="https://github.com/user-attachments/assets/f4cfd36d-a881-4636-a87c-63b68a1f70a2" />

### 🖥️ Admin Dashboard
<img width="1920" alt="Admin Dashboard" src="https://github.com/user-attachments/assets/039b2b74-d04f-4caa-ae71-f8dcc569664c" />

<img width="1692" alt="Admin Orders and Messages" src="https://github.com/user-attachments/assets/236176f6-21c5-4ae8-a99a-a3ccece7a3fd" />

---

## 🗃️ Database Tables

| Table | Description |
|---|---|
| `products` | All 72 products with name, category, price, image, badge, rating |
| `orders` | Customer orders with unique Order ID, name, contact, address, total |
| `order_items` | Individual items linked to each order |
| `contact_messages` | Customer messages from the contact form |
| `newsletter_subscribers` | Subscriber emails with generated coupon codes |

---

## 👩‍💻 Developer

| | |
|---|---|
| **Name** | Nimra Mumtaz |
| **Registration No.** | CIIT/SP24-BSSE-022/VHR |
| **Program** | BS Software Engineering |
| **University** | COMSATS University Islamabad, Vehari Campus |
| **Course** | CSC336 — Web Technologies |
| **Instructor** | Ms. Yasmeen Jana |
| **Semester** | Spring 2026 |

---

## 📄 License

This project was developed for academic purposes at COMSATS University Islamabad.

---

*Built with ❤️ using Laravel + Bootstrap*

