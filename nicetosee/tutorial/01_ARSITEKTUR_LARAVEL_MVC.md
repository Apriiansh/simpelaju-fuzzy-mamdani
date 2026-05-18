# 01 — Arsitektur Laravel MVC
> Memahami struktur proyek Simpelaju yang berbasis framework Laravel.

Simpelaju menggunakan pola arsitektur **MVC (Model-View-Controller)** yang memisahkan antara data, tampilan, dan logika bisnis.

---

## 🏗️ Struktur Direktori Utama

Berikut adalah folder-folder penting yang perlu diketahui:

```text
simpelaju/
├── app/
│   ├── Http/Controllers/   # Logika penanganan request & Fuzzy trigger
│   ├── Models/             # Representasi tabel database (Eloquent)
│   └── Helpers/            # Engine utama Fuzzy Mamdani (Logika Matematika)
├── config/                 # Konfigurasi aplikasi (Database, App, dll)
├── database/
│   ├── migrations/         # Struktur tabel (Schema)
│   └── seeders/            # Data awal (Admin, Data Wilayah)
├── public/                 # Aset publik (CSS, JS, Images)
├── resources/
│   └── views/              # Tampilan aplikasi (Blade Templates)
├── routes/                 # Definisi URL/Route aplikasi
└── nicetosee/              # Folder dokumentasi ini
```

---

## ⚛️ Komponen MVC Simpelaju

### 1. Model (M)
Terletak di `app/Models/`. Contoh: `Warga.php` atau `Penilaian.php`. Model ini digunakan untuk berinteraksi dengan database tanpa perlu menulis query SQL manual.

### 2. View (V)
Terletak di `resources/views/`. Menggunakan engine **Blade**. View bertugas menampilkan dashboard, tabel warga, dan peta interaktif kepada user.

### 3. Controller (C)
Terletak di `app/Http/Controllers/`. Controller adalah "polisi lalu lintas" yang menerima input dari user, memprosesnya (memanggil engine Fuzzy), dan mengembalikan hasil ke View.

---

## 🛠️ Tech Stack Simpelaju

- **Backend**: PHP 8.x + Laravel.
- **Frontend**: Blade Templating + Tailwind CSS.
- **Database**: MySQL.
- **Maps**: Leaflet.js (untuk visualisasi GIS).
- **Fuzzy Engine**: Custom PHP implementation (Mamdani).

---

## ⚙️ Cara Kerja Request

1. User klik tombol "Hitung Kelayakan" di browser.
2. **Route** meneruskan request ke **Controller**.
3. **Controller** mengambil data input, mengirimnya ke **Fuzzy Helper**.
4. **Fuzzy Helper** menghitung skor (Fuzzifikasi -> Inferensi -> Defuzzifikasi).
5. **Controller** menyimpan hasil ke database melalui **Model**.
6. **Controller** mengembalikan hasil (Layak/Tidak) ke **View** untuk ditampilkan.

---

**Lanjut ke Bab berikutnya:**
[02 — Konsep SPK dan RTLH](./02_KONSEP_SPK_DAN_RTLH.md)
