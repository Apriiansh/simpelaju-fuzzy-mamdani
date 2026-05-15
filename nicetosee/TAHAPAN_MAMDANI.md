# 🧠 Dokumentasi Alur SPK Fuzzy Mamdani - Simpelaju

Dokumentasi ini menjelaskan perjalanan data dari input manual hingga menjadi keputusan prioritas bantuan menggunakan logika Fuzzy Mamdani yang telah disinkronkan dengan standar **LA.pdf**.

---

## 🏗️ 0. Persiapan: Basis Pengetahuan (Database)
Sebelum sistem berjalan, aturan dan kurva harus ada di database.
*   **File**: `database/seeders/FuzzyConfigurationSeeder.php`
*   **Isi**: 
    *   Definisi 4 Pilar (K1-K4).
    *   Parameter kurva (Trapesium/Segitiga) untuk tiap himpunan.
    *   **81 Rule Base Utama** (Kombinasi lengkap 3x3x3x3 dari 4 Pilar).
    *   **Logic**: High Score (Buruk) = LAYAK Bantuan.

---

## 📝 1. Tahap Input: Pengumpulan Data Lapangan
*   **Form Input**: `resources/views/rumah/create.blade.php` atau `edit.blade.php`
    *   Label kondisi komponen disinkronkan: **"Rusak Ringan"** (Skor 1.0), **"Rusak Sedang"** (Skor 0.5), **"Rusak Berat"** (Skor 0.0).
    *   Luas bangunan dan jumlah tanggungan diinput sebagai angka.

---

## ⚙️ 2. Tahap Trigger: Otomatisasi Penilaian
*   **File**: `app/Http/Controllers/PenilaianController.php`
*   **Fitur**: 
    *   **Hitung Otomatis**: Saat data rumah disimpan.
    *   **Hitung Massal**: Admin bisa memicu pengerjaan ulang seluruh data melalui tombol "Hitung Massal" di Dashboard Penilaian.

---

## 🧠 3. Tahap Pemetaan (Input Mapping)
Data mentah dikonversi menjadi angka desimal (0.000 - 1.000) dengan presisi **3 digit**.

*   **File**: `app/Services/Fuzzy/InputMapperService.php`
*   **Logika Penting**:
    1.  **Pilar A, B**: Rata-rata dari nilai biner/kualitatif (Skala 0-1).
    2.  **Pilar C (Kepadatan)**: `Luas / (Jumlah Tanggungan + 1)`. Angka `+1` ditambahkan untuk menyertakan Kepala Keluarga sendiri.
    3.  **Pilar D (Hierarchical Sub-Inference)**: 
        *   Menghitung kualitas tiap komponen (Material x Kondisi).
        *   Mencari nilai Alpha (Derajat Keanggotaan) dari tiap komponen.
        *   **Max-Membership Method**: Mengambil nilai Alpha tertinggi secara langsung sebagai skor pilar D (untuk sinkronisasi dengan perhitungan manual di LA.pdf).
---

## 💡 Filosofi: Mengapa Pakai Mamdani? (Analogi Musyawarah)
Untuk memahami Mesin ini, bayangkan ada **81 Ahli** yang bermusyawarah di dalam komputer:

1.  **Hukum MIN (Implikasi)**: Sebuah pendapat hanya sekuat mata rantai terlemahnya. 
    *   *Analogi*: Jika Anda berkata "Saya akan beli rumah jika Hujan (0.2) DAN Saya Kaya (1.0)", maka keinginan Anda beli rumah hanya **0.2** (lemah), karena faktor hujannya kecil. Meskipun Anda kaya raya, Anda tetap terhambat oleh faktor hujan.
2.  **Hukum MAX (Agregasi)**: Kita mengumpulkan semua pendapat para ahli. Jika ada 10 ahli bicara "Layak" dengan kekuatan berbeda-beda, kita ambil pendapat yang **paling mantap (paling tinggi)** untuk mewakili kelompok "Layak".
3.  **Hukum CENTROID (Defuzzifikasi)**: Mencari "Jalan Tengah". 
    *   Hasil akhirnya bukan "Layak" atau "Tidak", tapi sebuah **Titik Keseimbangan**. Jika banyak ahli yang menarik ke arah "Layak", maka titik beratnya akan bergeser ke kanan (angka besar).

---

## 🧪 4. Tahap Inti: FIS Mamdani (Mesin Utama)
*   **File**: `app/Services/Fuzzy/MamdaniEngine.php`
*   **Fuzzifikasi Level 2**: Skor pilar (A, B, C, D) dikonversi lagi menjadi derajat keanggotaan menggunakan kurva yang sudah disesuaikan (misal: Kurva 'Baik' dimulai dari 0.35 agar angka 0.600 terdeteksi).
*   **Inferensi**: Menerapkan 81 aturan lengkap.
*   **Defuzzifikasi**: Menggunakan metode **Centroid (COA)** untuk mendapatkan skor akhir 0-100.

---

## 📊 5. Tahap Output: Tampilan Keputusan
*   **Halaman**: `resources/views/penilaian/index.blade.php`
*   **Tampilan**:
    *   **Skor Crisp Z***: (Contoh: 58.89)
    *   **Status**: LAYAK BANTUAN / TIDAK LAYAK BANTUAN.
    *   **Threshold**: Skor ≥ 50 dianggap Layak Bantuan.

---

## 🚀 6. Contoh Kasus Real: Siti Hayunah
*(Sinkron dengan data LA.pdf)*

### A. Data Lapangan
*   **Keselamatan**: Pondasi (Ada), Kolom (Rusak Berat), Atap (Rusak Berat).
*   **Kesehatan**: MCK (Sendiri), Jarak Air (Risiko/Dekat).
*   **Kepadatan**: Luas 30m² / 5 Orang (4 Tanggungan + 1 KK).
*   **Komponen**: 
    *   Atap: Genteng Tanah Liat (0.75) x Rusak Sedang (0.5).
    *   Dinding: Bata Tanpa Plester (0.75) x Rusak Sedang (0.5).
    *   Lantai: Plester Semen (0.5) x Rusak Sedang (0.5).

### B. Hasil Pemetaan (Fuzzification Level 1)
Sistem mengubah data di atas menjadi skor indeks:
*   **K1 (Keselamatan)**: (1 + 0 + 0) / 3 = **0.333**
*   **K2 (Kesehatan)**: (1 + 1 + 1 + 0) / 4 = **0.750**
*   **K3 (Kepadatan)**: 30 / 5 = **6.000**
*   **K4 (Komponen)**: Hasil Sub-Inference (Max Alpha) = **0.600**

### C. Fuzzifikasi Level 2 (Keanggotaan)
*   **A (0.333)**: Buruk (0.085) & Sedang (0.443).
*   **B (0.750)**: Cukup (0.167) & Sehat (0.500).
*   **C (6.000)**: Padat (0.750) & Sedang (0.222).
*   **D (0.600)**: Baik (0.625) & Sedang (0.667).

### D. Inferensi & Defuzzifikasi (81 Aturan)
Siti mengaktifkan **16 aturan** (2x2x2x2) secara bersamaan. Terjadi fenomena "tarik-ulur" (tug-of-war) antara aturan LAYAK dan TIDAK LAYAK:

| No Rule | Kombinasi Himpunan | Output | Kekuatan (Alpha) |
| :--- | :--- | :--- | :--- |
| **47** | A=Sedang, B=Sehat, C=Padat, **D=Sedang** | **LAYAK** | **0.443** (Paling Kuat) |
| **48** | A=Sedang, B=Sehat, C=Padat, **D=Baik** | **TIDAK LAYAK** | **0.443** (Paling Kuat) |
| 38 | A=Sedang, B=Cukup, C=Padat, D=Sedang | LAYAK | 0.167 |
| 11 | A=Buruk, B=Cukup, C=Padat, D=Sedang | LAYAK | 0.085 |

**Analisis:**
Sistem menemukan bahwa kondisi Siti cukup buruk untuk dibantu (Rule 47), namun di sisi lain mengakui bahwa Material Dinding/Atapnya sudah lumayan baik (Rule 48). 
*   **Hasil Centroid Z***: Menghasilkan angka **58.89**.
*   **Kesimpulan**: **LAYAK BANTUAN** (Melewati threshold 50).

---

> **Note**: 
> Hasil ini lebih akurat dibandingkan laporan manual (75.5) karena aplikasi mempertimbangkan 16 aturan yang saling beradu argumen, bukan hanya memilih satu aturan saja. Hal ini menjamin penilaian yang lebih adil dan tidak ekstrem.
