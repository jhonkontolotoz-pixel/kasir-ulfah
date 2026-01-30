# Kasir Ulfah - Point of Sale (POS) System

Sistem manajemen kasir berbasis web yang dirancang untuk mengelola transaksi penjualan, stok barang, dan laporan keuangan secara efisien dan akurat.

## 🌟 Fitur Utama

* **Manajemen Inventaris:** Input data barang, kategori, stok, serta harga jual/beli.
* **Transaksi Penjualan:** Antarmuka kasir yang responsif untuk memproses pesanan pelanggan.
* **Cetak Struk:** Mendukung pencetakan struk belanja setelah transaksi berhasil.
* **Laporan Penjualan:** Ringkasan laporan harian, mingguan, hingga bulanan untuk memantau performa bisnis.
* **Manajemen Pengguna:** Pengaturan hak akses untuk admin dan kasir.
* **Dashboard Informatif:** Visualisasi data stok kritis dan total pendapatan.

## 🛠️ Teknologi yang Digunakan

* **Backend:** PHP (Laravel Framework)
* **Frontend:** Tailwind CSS / Bootstrap (opsional, sesuaikan dengan yang Anda pakai)
* **Database:** MySQL
* **Lainnya:** DomPDF (untuk cetak laporan/struk)

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
## 📦 Instalasi

1.  **Clone Repositori**
    ```bash
    git clone [https://github.com/jhonkontolotoz-pixel/kasir-ulfah.git](https://github.com/jhonkontolotoz-pixel/kasir-ulfah.git)
    cd kasir-ulfah
    ```

2.  **Instal Dependensi**
    ```bash
    composer install
    npm install && npm run build
    ```

3.  **Konfigurasi Lingkungan**
    Salin file `.env.example` menjadi `.env` dan sesuaikan koneksi database Anda:
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Migrasi Database**
    ```bash
    php artisan migrate --seed
    ```

5.  **Jalankan Server**
    ```bash
    php artisan serve
    ```
