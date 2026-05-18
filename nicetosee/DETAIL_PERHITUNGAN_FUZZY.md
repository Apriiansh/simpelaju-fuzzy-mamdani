# 🧪 Detail Teknis Perhitungan SPK Fuzzy Mamdani (Developer Guide)

Dokumentasi ini merinci alur pemanggilan fungsi (function calls) dan logika kode dari awal hingga akhir proses penilaian.

---

## 🏗️ 1. Orchestration: Titik Awal Perhitungan
Proses selalu dimulai dari `InputMapperService`.

*   **Function**: `runAssessment($pendudukId, $periode)`
*   **Alur Kerja**:
    1.  Mencari data `Rumah` berdasarkan `penduduk_id`.
    2.  Memanggil `mapToScores($rumah)` untuk mendapatkan nilai crisp (0.0 - 1.0) untuk K1, K2, K3, dan K4.
    3.  Menyimpan nilai tersebut ke tabel `nilai_kriteria`.
    4.  Memanggil `MamdaniEngine::calculate($penilaian)` untuk memproses mesin utama.

---

## ⚙️ 2. Stage 1: Input Mapping (`InputMapperService.php`)

### 2.1 Konversi Data Mentah (`mapToScores`)
*   **K1 (Keselamatan)**: Memanggil `mapBinary()` (untuk Pondasi) dan `mapQualitative()` (untuk Kolom/Konstruksi). Hasilnya dirata-rata.
*   **K2 (Kesehatan)**: Memanggil `mapBinary()` (untuk Jendela, Ventilasi, Jarak Air) dan `mapHealthSanitation()` (untuk Kamar Mandi). Hasilnya dirata-rata.
*   **K3 (Kepadatan)**: Memanggil `calculateDensityValue()`.
    *   *Rumus*: `luas_bangunan / (jumlah_tanggungan + 1)`.
*   **K4 (Komponen)**: Memanggil `calculatePilarDScore()`.

### 2.2 Sub-Inference Pilar D (`calculatePilarDScore`)
Inilah jalur pipa (pipeline) perhitungan pilar D:
1.  **`fuzzifyMaterial($x)` & `fuzzifyKondisi($x)`**: Mengubah skor material/kondisi menjadi derajat keanggotaan (Rendah, Sedang, Tinggi).
2.  **`evaluateKualitasRules($mat, $kon)`**: Menghitung kualitas tiap komponen (Atap, Dinding, Lantai) menggunakan 9 aturan implikasi MIN.
3.  **`evaluatePilarDRules($q_a, $q_l, $q_d)`**: Menggabungkan kualitas ke-3 komponen menggunakan 27 aturan agregasi.
4.  **`max($pilarD)`**: Mengambil nilai Alpha tertinggi (Max-Membership) sebagai skor akhir Pilar D.

---

## 🚀 3. Stage 2: FIS Mamdani (`MamdaniEngine.php`)

### 3.1 Proses Utama (`calculate`)
*   **Function**: `calculate(Penilaian $penilaian)`
*   **Langkah**:
    1.  Mengambil semua `nilai_input` dari database.
    2.  **Fuzzifikasi**: Memanggil `fuzzify($score, $kriteriaId)` untuk tiap pilar.
    3.  **Inferensi**: Memanggil `inference($fuzzifiedInputs, $rules)`.
    4.  **Defuzzifikasi**: Memanggil `defuzzify($inferredResult, $outputSets)`.
    5.  Menyimpan hasil akhir ke tabel `hasil_spk`.

### 3.2 Fuzzifikasi & Membership (`fuzzify`)
*   Mencari semua `FuzzySet` milik kriteria tersebut.
*   Memanggil `calculateMembership($x, $type, $params)`.
    *   Mendukung tipe **'segitiga'** dan **'trapesium'**.
    *   Menggunakan rumus bahu kiri/kanan jika parameter $a=b$ atau $b=c$.

### 3.3 Inferensi (`inference`)
*   Melakukan iterasi pada seluruh **81 Aturan** di database.
*   **MIN (Implikasi)**: `min($mu1, $mu2, $mu3, $mu4)` untuk mendapatkan $\alpha$-predikat tiap rule.
*   **MAX (Agregasi)**: Menggabungkan hasil rule ke dalam array `$inferredResult` berdasarkan set outputnya (LAYAK atau TIDAK LAYAK).

### 3.4 Defuzzifikasi Centroid (`defuzzify`)
*   Melakukan perulangan (loop) dari $z=0$ sampai $z=100$.
*   Pada setiap titik $z$, menghitung nilai keanggotaan gabungan (`$muCombine`) menggunakan **MAX**.
*   Menghitung pembilang: `sum(z * muCombine)` dan penyebut: `sum(muCombine)`.
*   **Hasil Akhir**: `pembilang / penyebut` (Titik Berat Area).

---

## 🛠️ Helper Math: `calculateMembership($x, $type, $params)`
Fungsi ini adalah tulang punggung matematika sistem:
*   Jika $x$ di luar rentang $[a, c]$, return `0`.
*   Jika $x$ di puncak $b$, return `1`.
*   Jika $x$ di lereng naik, return `(x - a) / (b - a)`.
*   Jika $x$ di lereng turun, return `(c - x) / (c - b)`.

---
> Dokumentasi ini diperbarui untuk mencerminkan implementasi kode per Mei 2026, termasuk sinkronisasi sub-inference Hierarki sesuai LA.pdf.
