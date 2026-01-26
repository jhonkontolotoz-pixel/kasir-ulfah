# 🧾 Laravel + Vue POS System

A **modern Point of Sale (POS)** system built with **Laravel 9 (backend)** and **Vue 3 (frontend)**, designed for speed, scalability, and an excellent user experience.
The system supports real-time data interaction, dynamic UI components, and robust backend APIs for managing sales, inventory, and users.

---

## 🚀 Features

### 🖥️ Frontend (Vue 3 + Vite + Tailwind + PrimeVue)

* **Modern SPA** built with Vue 3 Composition API
* **State Management** via Pinia + Persisted State
* **Dynamic UI Components** powered by PrimeVue and PrimeIcons
* **Customizable Themes** using `@primevue/themes`
* **Charts & Analytics** with Chart.js
* **Rich Text Editing** with Quill
* **Multi-language support** using Laravel Vue i18n
* **Lightning-fast build** with Vite

### ⚙️ Backend (Laravel 9)

* RESTful API architecture
* Authentication & authorization with Laravel Sanctum
* PDF generation with DomPDF (`barryvdh/laravel-dompdf`)
* HTTP client integration via Guzzle
* SQLite and PDO driver ready
* Developer tools (Tinker, Pint, PHPUnit, Ignition)
* Scalable structure ready for Docker/Sail

---

## 🏗️ Tech Stack

| Layer                | Technology                                   |
| -------------------- | -------------------------------------------- |
| **Backend**          | Laravel 9, PHP 8.0+ BISA DIUPDATE            |
| **Frontend**         | Vue 3, Vite, Tailwind CSS                    |
| **UI Library**       | PrimeVue 4.2, PrimeIcons 7                   |
| **State Management** | Pinia                                        |
| **Database**         | SQLite (default), MySQL/PostgreSQL supported |
| **Testing**          | PHPUnit, Mockery                             |
| **PDF Generation**   | barryvdh/laravel-dompdf                      |
| **HTTP Client**      | GuzzleHTTP                                   |
| **Localization**     | laravel-vue-i18n                             |

---

## 📦 Installation

### 1️⃣ Clone the repository

```bash
git clone https://github.com/mafifi96/kasir-ulfah.git
cd kasir-ulfah
```

### 2️⃣ Install PHP dependencies

```bash
composer install
```

### 3️⃣ Install Node dependencies

```bash
npm install
```

### 4️⃣ Environment setup

Copy `.env.example` to `.env` and configure your settings:

```bash
cp .env.example .env
php artisan key:generate
php artisan storage:link
```

Make sure your `.env` includes database credentials:

```env
DB_CONNECTION=sqlite
# or use
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=pos
# DB_USERNAME=root
# DB_PASSWORD=
```

### 5️⃣ Run migrations & seeders

```bash
php artisan migrate --seed
```

### 6️⃣ Build frontend

```bash
npm run build
# or for development
npm run dev
```

### 7️⃣ Run the server

```bash
php artisan serve
```

---

## 🧠 Development Mode (with Laravel Sail)

If you’re using Docker:

```bash
./vendor/bin/sail up -d
./vendor/bin/sail npm run dev
```

---

## 🧩 Folder Structure Overview

```
laravel-vue-pos/
├── app/                  # Laravel backend logic
├── bootstrap/
├── config/
├── database/
├── public/
│   ├── build/            # Vite build output
│   └── index.php
├── resources/
│   ├── js/
│   │   ├── components/   # Vue components
│   │   ├── stores/       # Pinia stores
│   │   ├── router/       # Vue Router config
│   │   └── app.js
│   └── views/
├── routes/
│   ├── api.php           # API endpoints
│   └── web.php
└── vite.config.js
```

---

## 🧾 Key Commands

| Purpose                  | Command             |
| ------------------------ | ------------------- |
| Start Laravel dev server | `php artisan serve` |
| Run frontend dev server  | `npm run dev`       |
| Compile for production   | `npm run build`     |

---

## 🔒 Authentication

* Token-based authentication via **Laravel Sanctum**
* Supports user roles (admin, cashier, etc.)
* Persistent session handled through frontend Pinia store


## 🌟 Author

sumber dari m afifi
