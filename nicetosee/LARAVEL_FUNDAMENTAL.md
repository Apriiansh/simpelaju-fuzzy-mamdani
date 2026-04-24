# 🏛️ Fundamental Laravel (Senior Architect Perspective)

Memahami Laravel bukan sekadar menghafal syntax, tapi memahami alur data (Request Lifecycle).

## 1. Alur Kerja (MVC Pattern)
Laravel menggunakan pola **Model-View-Controller**:
*   **Routes**: Gerbang masuk. Menentukan URL mana yang ditangani oleh Controller mana.
*   **Controller**: Otak/Logika. Mengambil data dari Model dan mengirimkannya ke View.
*   **Model (Eloquent)**: Representasi Database. Semua interaksi tabel dilakukan di sini (ORM).
*   **View (Blade)**: Tampilan. Tempat HTML dan CSS berada.

## 2. Konsep Penting
### A. Migrations (Version Control for Database)
Jangan pernah membuat tabel manual di phpMyAdmin. Gunakan migrasi agar skema database bisa dilacak di Git dan dijalankan oleh orang lain dengan satu perintah.
`php artisan make:migration create_nama_tabel`

### B. Eloquent ORM
Interaksi database yang manusiawi.
*   `Penduduk::all()` -> Ambil semua data.
*   `Penduduk::where('nik', '123')->first()` -> Cari data spesifik.

### C. Blade Templating
Laravel menggunakan `@` sebagai shortcut PHP di HTML.
*   `{{ $variable }}` -> Cetak data (otomatis aman dari XSS).
*   `@if(...)` / `@foreach(...)` -> Control flow.
*   `<x-component>` -> Komponen UI yang bisa dipakai ulang (DRY).

### D. Middleware
Lapisan keamanan sebelum masuk ke Controller. Contoh: `auth` middleware memastikan hanya user yang sudah login yang bisa akses.

### E. Service Pattern (Advanced)
Untuk logika kompleks (seperti Fuzzy Mamdani), jangan tumpuk di Controller. Buatlah class khusus di folder `app/Services`. Ini membuat kode Anda **SOLID** dan mudah dites.

## 🛠️ Best Practice Tips
1.  **KISS (Keep It Simple, Stupid)**: Jika Laravel sudah punya fiturnya, jangan buat fungsi manual.
2.  **DRY (Don't Repeat Yourself)**: Jika Anda menulis kode yang sama dua kali, buatlah fungsi/komponen.
3.  **Thin Controller, Fat Model/Service**: Controller harusnya hanya bertugas menerima input dan mengarahkan output. Logika berat harus ada di Service.
4.  **Eager Loading**: Selalu gunakan `->with('relasi')` untuk menghindari query database yang terlalu banyak (N+1 Problem).
