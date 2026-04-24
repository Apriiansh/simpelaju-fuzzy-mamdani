# 🚀 Cara Menjalankan Project Simpelaju

Ikuti langkah-langkah berikut untuk menyiapkan lingkungan pengembangan:

## 1. Persyaratan Sistem
*   PHP >= 8.2
*   Composer
*   Node.js & NPM
*   Database (MySQL / MariaDB / PostgreSQL)

## 2. Instalasi Dependensi
Buka terminal di folder project, lalu jalankan:

### A. Backend (PHP)
```bash
composer install
```

### B. Frontend (JavaScript)
```bash
npm install
```
*Langkah ini akan menginstal `concurrently`, `tailwind`, `vite`, dll. agar perintah `composer run dev` bisa berjalan.*

## 3. Konfigurasi Lingkungan (.env)
Salin file contoh env:
```bash
cp .env.example .env
```
Lalu buka file `.env` dan sesuaikan pengaturan database Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=simpelaju
DB_USERNAME=root
DB_PASSWORD=
```

## 4. Setup Aplikasi
Jalankan perintah berikut secara berurutan:
```bash
php artisan key:generate
php artisan migrate --seed
```
*Catatan: `--seed` akan mengisi data awal seperti User Admin, Kelurahan, dan Kriteria.*

## 5. Menjalankan Server (Development)
Gunakan perintah singkat yang sudah ada di `composer.json`:
```bash
composer run dev
```
Atau jika ingin menjalankan secara terpisah di dua terminal:
1.  **Terminal 1 (PHP Server)**: `php artisan serve`
2.  **Terminal 2 (Vite/Asset Compiler)**: `npm run dev`

## 6. Akses Aplikasi
Buka browser dan akses: `http://localhost:8000`
