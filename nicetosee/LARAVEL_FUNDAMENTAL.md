# 🏛️ Laravel Fundamental: Panduan Lengkap Project Simpelaju

Selamat datang di direktori panduan (Guidebook) untuk pengembangan menggunakan Laravel pada project **Simpelaju**. 

Berdasarkan pengecekan sistem, project ini menggunakan **Laravel Framework versi 12.x** dengan engine UI menggunakan **Blade dan TailwindCSS**.

Untuk memudahkan Anda dalam membaca dan mencari referensi, buku panduan ini telah kami **pisahkan dan susun secara terstruktur** mengikuti urutan *development* fitur Laravel yang paling direkomendasikan.

---

## 📚 Daftar Isi Guidebook Laravel:

Silakan klik tautan di bawah ini untuk mempelajari setiap komponen secara detail dan mendalam:

### 🔄 1. [Alur Development Laravel yang Benar](./guidebook/01_ALUR_DEVELOPMENT.md)
*Wajib dibaca pertama kali.* Menjelaskan siklus bagaimana semua komponen (MVC) saling terhubung dari awal hingga akhir, dan urutan pengerjaan coding yang benar saat membuat fitur baru.

### 💾 2. [Database & Model (Eloquent ORM)](./guidebook/02_DATABASE_DAN_MODEL.md)
Bagaimana merancang arsitektur data (Migrations), serta bagaimana menghubungkan kode PHP dengan Database menggunakan Model dan fungsi `$fillable`.

### 🛣️ 3. [Routes (Pintu Masuk Aplikasi)](./guidebook/03_ROUTES.md)
Pelajari tentang URL, method `GET/POST`, parameter dinamis, pendaftaran *Middleware*, dan fungsi penamaan `Route::name()`.

### 🧠 4. [Controller (Logika Bisnis Utama)](./guidebook/04_CONTROLLER.md)
Pusat kendali aplikasi. Cara menangani permintaan (*Request*), memvalidasi formulir (`$request->validate()`), mengambil data, dan mengarahkan halaman (*Redirect & Flash Session*).

### 🎨 5. [View, Blade & TailwindCSS](./guidebook/05_VIEW_BLADE_TAILWIND.md)
Mengatur antarmuka pengguna (UI). Pelajari keajaiban *template engine* Blade (`@foreach`, `@if`, `{{ $var }}`) dan cara cepat mendesain layout cantik yang responsif menggunakan *utility classes* **TailwindCSS**.

---
