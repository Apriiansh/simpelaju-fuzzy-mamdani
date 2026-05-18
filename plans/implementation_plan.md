# 🏛️ Rencana Implementasi Migrasi Database Laporan Excel

Rencana ini dibuat untuk menyelaraskan skema database aplikasi **Simpelaju** dengan data terstruktur dari template laporan Excel Kelurahan (misalnya `PLAJU ULU.xlsx` dan `TALANG BUBUK.xlsx`). Fokus saat ini adalah pembuatan file migrasi database Laravel.

---

## 🎯 Target & Kebutuhan Laporan
Berdasarkan hasil analisis sheet Excel Laporan, terdapat beberapa informasi penting yang saat ini belum terakomodasi di dalam tabel `penduduk` dan `rumah`. Dengan menyelaraskan skema database ini, admin kelurahan dapat mengunggah dan mengekspor laporan dengan format 9 sheet yang lengkap dan terstruktur.

### 1. Penambahan Kolom di Tabel `penduduk`:
*   `rt` (VARCHAR) & `rw` (VARCHAR) - Untuk penataan alamat yang lebih terstruktur.
*   `usia` (INTEGER) - Data demografi penting.
*   `pendidikan_terakhir` (VARCHAR) - Kualifikasi ijazah KRT.
*   `jenis_kelamin` (CHAR(1)) - 'L' atau 'P'.
*   `pekerjaan_utama` (VARCHAR) - Klasifikasi pekerjaan KRT.
*   `pernah_dapat_bantuan` (BOOLEAN) - Status riwayat bantuan pemerintah.
*   `jenis_kawasan` (VARCHAR) - Klasifikasi kawasan (misal: 'Kumuh', 'Rawan Air', dll).
*   `aset_rumah_lain` (BOOLEAN) - Aset kepemilikan rumah di lokasi lain.
*   `aset_tanah_lain` (BOOLEAN) - Aset kepemilikan tanah di lokasi lain.

### 2. Penambahan Kolom di Tabel `rumah`:
*   `nomor_sertifikat` (VARCHAR) - Nomor identifikasi kepemilikan tanah/rumah untuk aspek legalitas.
*   *Catatan 1*: `jumlah_penghuni` tidak perlu ditambahkan sebagai kolom fisik baru karena **dihitung secara dinamis dari `jumlah_tanggungan + 1`** (tanggungan ditambah Kepala Keluarga).
*   *Catatan 2*: `status_kepemilikan` tetap digabung di satu kolom sesuai instruksi user ("gabung saja gausah diganti").

---

## 🧠 Analisis Keputusan & Trade-Offs

Sebelum membuat migrasi, mari kita pertimbangkan dua pendekatan utama untuk merombak skema database:

### Opsi A: Membuat File Migrasi Baru (`ALTER TABLE`)
Membuat file migrasi baru untuk menambahkan kolom-kolom yang hilang pada tabel `penduduk` dan `rumah` tanpa mengubah migrasi lama.

*   **PROS**:
    *   **Aman untuk Production**: Tidak merusak data yang sudah ada di database saat ini.
    *   **Langkah Standar Git/Laravel**: Menjaga riwayat evolusi database yang tercatat secara kronologis.
*   **CONS**:
    *   Jumlah file migrasi bertambah.
    *   Saat setup awal di local, sistem tetap harus menjalankan file migrasi lama terlebih dahulu lalu baru file alter ini.

### Opsi B: Mengedit File Migrasi Lama (`Schema::create` awal) & Re-migrate
Mengedit langsung file migrasi awal `create_penduduk_table` dan `create_rumah_table` lalu menjalankan `migrate:fresh --seed`.

*   **PROS**:
    *   Skema database bersih, tidak ada file *alter* yang menumpuk.
    *   Semua definisi kolom terpusat di satu tempat dari awal pembentukan tabel.
*   **CONS**:
    *   **Destruktif**: Menghapus seluruh data di database saat melakukan fresh migration. (Namun di lingkungan development local, data dummy dapat diisi ulang dengan seeder).

---

### ⚖️ Keputusan Arsitektur
Kita memilih **Opsi A** (Membuat file migrasi baru `ALTER TABLE`) karena ini adalah *best practice* senior architect. Pendekatan ini aman, tidak merusak data uji coba yang sudah ada di sistem user saat ini, dan memastikan transisi database berjalan *backwards-compatible*.

---

## 🛠️ Rencana Langkah Kerja (Step-by-Step)

### Langkah 1: Pembuatan File Migrasi
Kita akan membuat satu file migrasi terpadu untuk melakukan alter pada kedua tabel:
*   Nama file: `2026_05_18_110000_add_excel_report_fields_to_penduduk_and_rumah_tables.php`

### Langkah 2: Edit Migration Content
Mengisi method `up()` dengan penambahan kolom baru menggunakan `nullable()` agar data lama yang sudah ada tidak mengalami error *constraint*. Method `down()` akan drop kolom-kolom tersebut agar migrasi dapat di-rollback secara aman.

### Langkah 3: Eksekusi Migrasi
Menjalankan perintah:
```bash
php artisan migrate
```

### Langkah 4: Sinkronisasi Model & Seeder (Untuk Tahapan Selanjutnya)
Setelah migrasi ini sukses, langkah berikutnya (di luar scope migrasi) adalah memperbarui properti `$fillable` pada Model `Penduduk` dan `Rumah`, serta menyesuaikan `FuzzyConfigurationSeeder` / `UserSeeder` jika diperlukan.

---

## 📝 Verifikasi & Penanganan Edge Case
*   **Null Scenario**: Semua kolom baru dibuat `nullable()` atau memiliki `default()` value agar data penduduk lama yang belum memiliki kolom baru tetap bisa diakses tanpa memicu DB error.
*   **Data Type Safety**: Kolom `jenis_kelamin` dibatasi 1 karakter (`CHAR(1)`), sedangkan flag boolean menggunakan default `false`.
*   **Rollback Safety**: Fungsi `down()` dirancang dengan teliti untuk melakukan drop kolom secara berurutan sesuai urutan pembuatannya.
