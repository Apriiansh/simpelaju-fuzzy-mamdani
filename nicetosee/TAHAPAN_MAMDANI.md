# 🧠 Dokumentasi Alur SPK Fuzzy Mamdani - Simpelaju

Dokumentasi ini menjelaskan perjalanan data dari input manual hingga menjadi keputusan prioritas bantuan menggunakan logika Fuzzy Mamdani.

---

## 🏗️ 0. Persiapan: Basis Pengetahuan (Database)
Sebelum sistem berjalan, aturan dan kurva harus ada di database.
*   **File**: `database/seeders/FuzzyConfigurationSeeder.php`
*   **Isi**: 
    *   Definisi 4 Pilar (K1-K4).
    *   Parameter kurva (Trapesium/Segitiga) untuk tiap himpunan.
    *   37 Rule Base Utama (AND Logic).

---

## 📝 1. Tahap Input: Pengumpulan Data Lapangan
Semua bermula dari interaksi petugas di lapangan.

*   **Halaman**: `resources/views/penduduk/show.blade.php`
    *   Petugas menekan tombol **"Input Kondisi Rumah"**.
*   **Form Input**: `resources/views/rumah/create.blade.php` atau `edit.blade.php`
    *   Data kualitatif (misal: "Rusak Berat", "Ada", "Permanen") dipilih melalui dropdown.
    *   Luas bangunan dan jumlah tanggungan diinput sebagai angka.

---

## ⚙️ 2. Tahap Trigger: Otomatisasi Penilaian
Saat tombol **"Simpan Data"** ditekan, controller tidak hanya menyimpan data rumah, tapi langsung memicu otak SPK.

*   **File**: `app/Http/Controllers/RumahController.php`
*   **Kode**:
    ```php
    // Memanggil Service SPK secara otomatis
    $penilaianService = app(\App\Services\Fuzzy\InputMapperService::class);
    $penilaianService->runAssessment($rumah->penduduk_id, date('Y'));
    ```

---

## 🧠 3. Tahap Pemetaan (Input Mapping)
Data mentah (string) dikonversi menjadi angka desimal (0.0 - 1.0) agar bisa diproses matematika.

*   **File**: `app/Services/Fuzzy/InputMapperService.php`
*   **Logika Penting**:
    1.  **Pilar A, B**: Rata-rata dari nilai biner/kualitatif (Skala 0-1).
    2.  **Pilar C (Kepadatan)**: Luas / Jumlah Penghuni.
    3.  **Pilar D (Sub-Inferensi)**: Mengadu Material vs Kondisi (DR1-DR9) lalu digabung (KR1-KR27).
*   **Output**: 4 Nilai Indeks (K1, K2, K3, K4) yang siap masuk ke Mesin Mamdani.

---

## 🧪 4. Tahap Inti: FIS Mamdani
Inilah "Otak" utama yang menghitung probabilitas kelayakan.

*   **File**: `app/Services/Fuzzy/MamdaniEngine.php`

### A. Fuzzifikasi (`fuzzify`)
Mengubah nilai 0-1 menjadi derajat keanggotaan kurva.
*   *Contoh*: Skor 0.33 di pilar Keselamatan diterjemahkan menjadi: **Buruk (0.1)** dan **Sedang (0.43)**.

### B. Evaluasi Rule Base (`inference`)
Menerapkan 37 aturan IF-THEN menggunakan operator **MIN** (mencari nilai terkecil dalam satu aturan) dan **MAX** (menggabungkan hasil seluruh aturan).

### C. Defuzzifikasi (`defuzzify`) - Metode Centroid (COA)
Menghitung titik berat area hasil inferensi untuk mendapatkan skor 0-100.
```php
for ($z = 0; $z <= 100; $z++) {
    // Menghitung integrasi nilai z dikali bobot keanggotaan
    $sumNumerator += $z * $muCombine;
    $sumDenominator += $muCombine;
}
return $sumNumerator / $sumDenominator;
```

---

## 📊 5. Tahap Output: Tampilan Keputusan
Hasil akhir disimpan dan ditampilkan kembali ke user.

*   **Halaman**: `resources/views/penduduk/show.blade.php` (Dashboard SPK)
*   **Tampilan**:
    *   **Skor Akhir**: (Contoh: 78.78)
    *   **Kategori**: LAYAK / TIDAK LAYAK.
    *   **Rekomendasi**: Narasi otomatis berdasarkan kategori.

---

## 🚀 6. Contoh Kasus: Muhammad Sahrony Ansorry

Berdasarkan simulasi pada file `scratch/test_fuzzy_full.php`, berikut adalah perjalanan datanya:

### A. Data Lapangan (Raw Data)
*   **Keselamatan**: Pondasi (Tidak Ada), Balok (Rusak Berat), Atap (Rusak Berat).
*   **Kesehatan**: MCK (Tidak Ada), Jarak Air (Dekat TPA).
*   **Kepadatan**: Luas 20m² / 5 Orang = **4.0 m²/orang**.
*   **Komponen**: Material Rendah & Kondisi Rusak Berat.

### B. Hasil Pemetaan (Fuzzification)
Sistem mengubah data di atas menjadi skor 0.0 - 1.0:
*   **K1 (Keselamatan)**: 0.00
*   **K2 (Kesehatan)**: 0.00
*   **K3 (Kepadatan)**: 4.00
*   **K4 (Komponen)**: 0.20

### D. Tabel Perbandingan Simulasi
Berikut adalah perbandingan beberapa skenario rumah untuk melihat sensitivitas skor:

| Skenario | Kondisi A, B, D | Kepadatan (C) | Skor Akhir | Status | Kesimpulan |
| :--- | :--- | :--- | :--- | :--- | :--- |
| **1. Sangat Buruk** | Hancur / Rusak Berat | Sangat Padat | **78.78** | **LAYAK** | Prioritas Utama Bantuan |
| **2. Sedang** | Rusak Sebagian | Cukup/Normal | **50.00** | **LAYAK/TIDAK** | Ambang Batas (Tergantung Rule) |
| **3. Sangat Baik** | Permanen / Sehat | Luas / Layak | **25.01** | **TIDAK LAYAK** | Tidak Direkomendasikan |

### E. Detail Perhitungan (Deep Dive Skenario 1)
Berikut adalah rincian bagaimana sistem menghitung skor Sahrony:

1.  **Pilar A (Keselamatan)**: 
    *   Input: Pondasi (0), Balok (0), Atap (0).
    *   Rumus: $(0 + 0 + 0) / 3 = \mathbf{0.00}$ (Fuzzy: Buruk).
2.  **Pilar B (Kesehatan)**:
    *   Input: MCK (0), Jarak Air (0), Ventilasi (1), Jendela (1).
    *   Rumus: $(0 + 0 + 1 + 1) / 4 = \mathbf{0.50}$ (Fuzzy: Cukup).
3.  **Pilar C (Kepadatan)**:
    *   Input: Luas 20m², Penghuni 5.
    *   Rumus: $20 / 5 = \mathbf{4.00}$ (Fuzzy: Padat).
4.  **Pilar D (Komponen)**:
    *   Hasil Sub-Inferensi (Material Rendah + Kondisi Rusak) = **0.20** (Fuzzy: Buruk).

**Proses Akhir:**
Sistem mencari aturan yang cocok, misalnya **Rule R4**: 
`IF A=Buruk AND B=Cukup AND C=Padat AND D=Buruk THEN LAYAK`.
*   Nilai Alpha = $min(1.0, 1.0, 1.0, 1.0) = 1.0$.
*   Hasil ini ditarik ke kurva **LAYAK** `[50, 70, 100, 100]` dan dihitung Centroid-nya, menghasilkan angka **78.78**.

---

> **Note for Notion**: 
> Silakan salin konten Markdown ini. Blok kode di atas akan otomatis terformat rapi di Notion. Dokumentasi ini sinkron dengan codebase per April 2026.
