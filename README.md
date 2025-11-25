# Smartkasir

Aplikasi Point of Sale (POS) dan Manajemen Toko berbasis Laravel.

## Fitur Utama
- Manajemen Produk
- Manajemen Stok
- Sistem Kasir (POS)
- Barcode Scanner
- Laporan Penjualan
- Multi User (Admin & Kasir)
- Pembayaran Midtrans
- Manajemen Pelanggan
- Keranjang Belanja

## Teknologi
- Laravel 10
- PHP 8+
- MySQL
- Bootstrap / Tailwind
- JavaScript

## Cara Instalasi
1. Clone repo:
   ```bash
   git clone https://github.com/ikarhmwti1907/Smartkasir.git
   ```
2. Masuk folder:
   ```bash
   cd Smartkasir
   ```
3. Install dependency:
   ```bash
   composer install
   npm install
   npm run dev
   ```
4. Copy file `.env`:
   ```bash
   cp .env.example .env
   ```
5. Generate key:
   ```bash
   php artisan key:generate
   ```
6. Set database di `.env`, lalu jalankan:
   ```bash
   php artisan migrate --seed
   ```

## License
