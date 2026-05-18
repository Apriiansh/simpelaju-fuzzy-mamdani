# 04 — Routing dan Controller
> Bagaimana Simpelaju menangani permintaan data dan menjalankan logika bisnis.

Dalam Laravel, **Route** mendefinisikan "ke mana" user pergi, dan **Controller** mendefinisikan "apa" yang dilakukan di sana.

---

## 🛣️ Web Routing (`routes/web.php`)

Daftar URL utama aplikasi dikelola di file ini. Contoh rute di Simpelaju:
- `/dashboard`: Menampilkan ringkasan statistik.
- `/warga`: Mengelola data calon penerima bantuan.
- `/penilaian`: Form input kondisi rumah dan tombol hitung fuzzy.

```php
// Contoh definisi route
Route::resource('warga', WargaController::class);
Route::post('hitung-kelayakan/{id}', [PenilaianController::class, 'calculate']);
```

---

## 🎮 Controller Logic

Controller di Simpelaju bertugas menghubungkan data form dengan Engine Fuzzy.

### Tugas Utama Controller:
1. **Validasi Request**: Memastikan semua kolom pilar (A, B, C, D) diisi dengan benar.
2. **Data Processing**: Memanggil `FuzzyHelper` untuk mendapatkan skor kelayakan.
3. **Database Interaction**: Menyimpan skor akhir $Z^*$ dan status (Layak/Tidak) ke tabel `penilaian`.
4. **Redirection**: Mengalihkan user kembali ke halaman detail dengan pesan sukses.

---

## 🔐 Middleware (Security)

Untuk keamanan, rute-rute administratif dilindungi oleh middleware `auth`. Ini memastikan hanya petugas kecamatan yang login yang bisa memasukkan data warga atau menghitung skor bantuan.

```php
Route::middleware(['auth'])->group(function () {
    Route::get('/penilaian', [PenilaianController::class, 'index']);
});
```

---

## 📦 Mass Assignment Protection
Simpelaju menggunakan properti `$fillable` pada Model untuk mencegah input data ilegal ke kolom sensitif di database.

---

**Lanjut ke Bab berikutnya:**
[05 — View dan Blade Templating](./05_VIEW_DAN_BLADE_TEMPLATING.md)
