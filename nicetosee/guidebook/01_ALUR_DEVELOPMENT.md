# 🔄 01. Alur Development Laravel yang Benar

Dalam Laravel, kita bekerja menggunakan arsitektur **MVC (Model-View-Controller)**. Namun, ketika men-develop fitur baru, urutan pengerjaannya sebaiknya **TIDAK** dari depan ke belakang, melainkan dari **DATABASE (belakang) ke VIEW (depan)**.

Berikut adalah urutan standar (Best Practice) saat membuat fitur baru di Laravel:

## Urutan Development: "Dari Kulkas ke Meja Makan"

### Langkah 1: Merencanakan Data (Database & Migration)
Sebelum memikirkan tampilan, kita harus tahu data apa yang akan disimpan.
* **Tindakan**: Anda membuat file **Migration** untuk menentukan kolom tabel (contoh: `nama`, `alamat`, `tanggal_lahir`).
* **Perintah**: `php artisan make:model NamaModel -m` (Otomatis membuat Model dan file Migration-nya).
* **Lanjut**: Anda menulis skema tabel di file migrasi, lalu menjalankan `php artisan migrate`.

### Langkah 2: Menyiapkan Jembatan Data (Model)
Setelah tabel jadi, Laravel butuh representasi PHP untuk tabel tersebut.
* **Tindakan**: Buka file **Model** yang baru dibuat.
* **Lanjut**: Anda tentukan mana kolom yang boleh diisi pengguna (`$fillable`) dan tentukan relasi tabelnya (misal: "Setiap laporan dimiliki 1 user").

### Langkah 3: Menentukan Pintu Masuk (Routes)
Data sudah siap, sekarang buat URL/pintu masuk agar user bisa mengakses fitur tersebut.
* **Tindakan**: Buka `routes/web.php`.
* **Lanjut**: Tulis rute, misalnya ketika user mengakses `/laporan`, aplikasi harus memanggil Controller A fungsi B.

### Langkah 4: Logika Bisnis (Controller)
Ini adalah "Pelayan" yang menghubungkan permintaan User dengan Database.
* **Tindakan**: Buat Controller dengan `php artisan make:controller NamaController`.
* **Lanjut**: Tulis fungsi (misal: `index()`). Di dalamnya, panggil Model untuk ambil data, lalu lempar data tersebut ke View. Atau jika menerima input (POST), validasi inputnya, simpan lewat Model, lalu arahkan kembali (Redirect).

### Langkah 5: Antarmuka / Tampilan (View, Blade, & TailwindCSS)
Terakhir, buat tampilan yang indah menggunakan Blade dan TailwindCSS.
* **Tindakan**: Buat file `.blade.php` di folder `resources/views/`.
* **Lanjut**: Gunakan sintaks Blade (`{{ $data }}`) untuk mencetak data yang dikirim oleh Controller. Hias elemen HTML-nya dengan class TailwindCSS (misal: `class="text-red-500 font-bold"`).

---

## 🎯 Bagaimana Mereka Terhubung? (Ilustrasi End-to-End)

1. User mengetik `http://localhost:8000/laporan` di browser.
2. Laravel mengecek **Route (`web.php`)**. Ketemu! Route mengarahkan ke `LaporanController@index`.
3. Di dalam **`LaporanController`**, ia meminta semua data laporan ke **`Laporan` Model**.
4. **Model** menerjemahkannya menjadi Query SQL, mengambil data dari **Database**.
5. **Model** mengembalikan data (bentuk *collection/array*) ke **Controller**.
6. **Controller** membungkus data tersebut dan mengirimkannya ke **View (`laporan.blade.php`)**.
7. **View** melakukan *looping* (perulangan) data menggunakan **Blade**, merendernya menjadi HTML mentah berhiaskan **TailwindCSS**, lalu mengirim kembali HTML tersebut ke Browser User.

---
➡️ **Langkah Selanjutnya**: Pelajari secara spesifik tentang [Database & Model](./02_DATABASE_DAN_MODEL.md).
