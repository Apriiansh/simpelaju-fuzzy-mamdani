# 🗄️ Skema Database & Relasi SPK Bantuan RTLH

Dokumen ini berisi struktur database **terkini** yang sudah diimplementasikan (hasil migrasi terakhir) untuk sistem Pendukung Keputusan Kelayakan Penerima Bantuan RTLH dengan metode Fuzzy Mamdani. 

Struktur ini dirancang khusus agar sesuai dengan 4 Pilar / Aspek penilaian RTLH (Berdasarkan Aturan Pemerintah PUPR No 7 / 2022) seperti yang tertera di dokumen `LA.pdf`.

---

## 1. Entitas Master Data Wilayah & Pengguna

### 🏢 Tabel `users`
Menyimpan data petugas/admin yang berhak login ke dalam sistem.
*   `id` (PK)
*   `name`, `email`, `password`
*   `timestamps`

### 🗺️ Tabel `kelurahan`
Menyimpan referensi wilayah administratif kelurahan di Kecamatan Plaju.
*   `id` (PK)
*   `nama`
*   `timestamps`

---

## 2. Entitas Survei & Objek Sasaran

### 👨‍👩‍👧‍👦 Tabel `penduduk`
Menyimpan identitas calon penerima bantuan.
*   `id` (PK)
*   `nik` (Unique) - Nomor Induk Kependudukan
*   `nama_lengkap`, `alamat`, `no_telepon`
*   `kelurahan_id` (FK -> `kelurahan.id`)
*   `status_pernikahan`, `jumlah_tanggungan`, `penghasilan`
*   `latitude`, `longitude` - Koordinat GPS (GIS Map)

### 🏠 Tabel `rumah` (Core Update Sesuai LA.pdf)
Menyimpan data kondisi teknis rumah yang menjadi parameter survei (Terbagi 4 Pilar Utama).
*   `id` (PK)
*   `penduduk_id` (FK -> `penduduk.id`)
*   **[Pilar A] Keselamatan Bangunan**: `pondasi`, `kolom_balok`, `konstruksi_atap`
*   **[Pilar B] Kesehatan Penghuni**: `jendela`, `ventilasi`, `kamar_mandi`, `jarak_sumber_air`
*   **[Pilar C] Kepadatan Hunian**: `luas_bangunan` (m²)
*   **[Pilar D] Komponen Bangunan**: `material_atap`, `kondisi_atap`, `material_dinding`, `kondisi_dinding`, `material_lantai`, `kondisi_lantai`
*   `status_kepemilikan`, `foto_rumah`

---

## 3. Entitas Fuzzy Mamdani (Engine Master Data)

### 📊 Tabel `kriteria`
Menyimpan daftar kriteria (misal: Aspek Keselamatan, Kesehatan, Kepadatan, Komponen).
*   `id` (PK)
*   `kode` (Unique) - Misal: K1, K2, K3
*   `nama` - Misal: Aspek Keselamatan
*   `min_value`, `max_value` - Skala nilai (contoh: 0 sampai 100)
*   `satuan`

### 📉 Tabel `fuzzy_sets`
Menyimpan himpunan fuzzy (Linguistik) untuk setiap kriteria (misal: "Jelek", "Sedang", "Baik").
*   `id` (PK)
*   `kriteria_id` (FK -> `kriteria.id`)
*   `nama` - Misal: "Buruk"
*   `tipe` - Bentuk kurva (contoh: "trapesium", "segitiga")
*   `parameter` (JSON) - Titik kurva: `[a, b, c]` atau `[a, b, c, d]`

### 🧠 Tabel `fuzzy_rules` & `fuzzy_rule_details`
Menyimpan Basis Aturan (Rule Base) IF-THEN.
*   **`fuzzy_rules`**:
    *   `id` (PK)
    *   `kategori_hasil` / rekomendasi (Misal: "LAYAK" atau "TIDAK LAYAK")
*   **`fuzzy_rule_details`** (Membentuk klausa IF "AND" ... "AND" ...):
    *   `id` (PK)
    *   `fuzzy_rule_id` (FK)
    *   `fuzzy_set_id` (FK)

---

## 4. Entitas Penilaian (Transaction & Hasil)

### 📋 Tabel `penilaian`
Sesi penilaian (survei) untuk satu penduduk oleh satu petugas di periode tertentu.
*   `id` (PK)
*   `penduduk_id` (FK)
*   `user_id` (FK) - Petugas survei
*   `periode` - Misal: "2026-Q1"
*   `tanggal_penilaian`
*   `status` - 'DRAFT', 'DIPROSES', 'SELESAI'

### 📝 Tabel `nilai_kriteria`
Data skor kuantitatif (hasil konversi kondisi rumah) per kriteria untuk sesi penilaian.
*   `id` (PK)
*   `penilaian_id` (FK)
*   `kriteria_id` (FK)
*   `nilai_input` - Nilai tegas/crisp (0-100) sebelum difuzzifikasi

### 🏆 Tabel `hasil_spk`
Menyimpan hasil akhir komputasi Fuzzy Mamdani (Z*).
*   `id` (PK)
*   `penilaian_id` (FK)
*   `nilai_defuzzifikasi` - Nilai Z* akhir (Centroid)
*   `kategori_kelayakan` - enum('TIDAK_LAYAK', 'LAYAK')
*   `detail_perhitungan` (JSON) - Menyimpan log proses fuzzy (Fuzzifikasi, Rule Min, Max) untuk akuntabilitas.
*   `rekomendasi`

---
*Dokumen ini merupakan snapshot dari database schema yang aktif di development. Arsitektur ini sudah diuji dan berjalan lancar (100% Normalized).*
