# 03 — Logika Fuzzy Mamdani
> Memahami "Otak" Simpelaju: Alur perhitungan kelayakan dari angka mentah ke keputusan akhir.

Simpelaju menggunakan **Fuzzy Logic Metode Mamdani** (sering disebut metode Min-Max) untuk mengolah ketidakpastian data lapangan menjadi skor kelayakan (0-100).

---

## ⚙️ Tahapan Proses Fuzzy

### 1. Fuzzifikasi (Input)
Nilai mentah (0.0 - 1.0) diubah menjadi **Himpunan Fuzzy** (derajat keanggotaan).
- Contoh Pilar A (Struktur):
    - **Buruk**: `[0, 0, 0.15, 0.35]`
    - **Sedang**: `[0.2, 0.5, 0.8]`
    - **Baik**: `[0.65, 0.85, 1, 1]`

### 2. Inferensi (Rule Evaluation)
Sistem memiliki **37 Aturan Utama** (Rule Base). Aturan ini menggunakan operator **AND (Min)**.
- *Contoh Rule 1*: **IF** (A=Buruk) **AND** (B=Tidak Sehat) **AND** (C=Padat) **AND** (D=Buruk) **THEN** (Keputusan=Layak).
- Jika ada banyak aturan yang aktif, sistem mengambil nilai maksimal (**Max**) untuk setiap kategori keputusan.

### 3. Sub-Inferensi Pilar D (Material)
Khusus pilar D, sistem melakukan pengolahan ganda:
1. Menghitung kualitas masing-masing komponen (Atap, Dinding, Lantai) berdasarkan materialnya.
2. Menggabungkan ketiganya untuk mendapatkan satu skor Pilar D.

### 4. Defuzzifikasi (Centroid / COA)
Ini adalah tahap akhir di mana grafik fuzzy hasil penggabungan aturan dihitung luasnya untuk mencari **Titik Pusat (Centroid)**.
- **Hasil Akhir ($Z^*$)**: Sebuah angka antara 0 hingga 100.

---

## 🏆 Kriteria Keputusan Akhir

Setelah skor $Z^*$ didapat, sistem mengklasifikasikannya berdasarkan ambang batas (*threshold*):
- **Skor 0 – 50**: **TIDAK LAYAK** (Warga tidak direkomendasikan menerima bantuan).
- **Skor 51 – 100**: **LAYAK** (Warga direkomendasikan mendapatkan prioritas bantuan).

---

## 📂 Lokasi Kode Engine
Logika perhitungan ini dapat Anda temukan di:
- `app/Helpers/FuzzyHelper.php` (atau file serupa di folder Helpers).
- Fungsi utama biasanya bernama `calculate()` atau `runMamdani()`.

---

**Lanjut ke Bab berikutnya:**
[04 — Routing dan Controller](./04_ROUTING_DAN_CONTROLLER.md)
