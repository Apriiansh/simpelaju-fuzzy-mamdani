# 02 — Konsep SPK dan RTLH
> Memahami variabel penilaian bantuan rumah berdasarkan standar PUPR.

Simpelaju bukan hanya aplikasi pendataan, melainkan **Sistem Pendukung Keputusan (SPK)** yang dirancang untuk objektifitas pemilihan penerima bantuan Rumah Tidak Layak Huni (RTLH).

---

## 🏗️ 4 Pilar Penilaian RTLH
Berdasarkan regulasi PUPR No. 7 / 2022, terdapat 4 pilar utama yang diukur:

### A. Pilar Keselamatan Bangunan (Safety)
Mengukur kekuatan struktur agar rumah tidak roboh.
- **Pondasi**: Apakah kokoh atau tidak ada.
- **Kolom & Balok**: Kondisi tiang penyangga utama.
- **Konstruksi Atap**: Kekuatan rangka penutup rumah.

### B. Pilar Kesehatan Penghuni (Health)
Mengukur kualitas sanitasi dan lingkungan.
- **Pencahayaan**: Cukup sinar matahari masuk.
- **Ventilasi**: Sirkulasi udara yang baik.
- **Sanitasi**: Kepemilikan jamban/WC sendiri.
- **Air Bersih**: Jarak aman sumber air dari limbah.

### C. Pilar Luas dan Kepadatan (Density)
Mengukur kelayakan ruang gerak manusia.
- Rumus: $\text{Luas Bangunan} / \text{Jumlah Penghuni}$.
- Standar: Minimal 7.2 - 9 m² per orang.

### D. Pilar Komponen Bangunan (Material)
Mengukur kualitas fisik material penutup.
- Jenis material Atap, Dinding, dan Lantai (misal: Seng vs Genteng, Tanah vs Keramik).

---

## 📊 Konversi Data Kualitatif ke Kuantitatif

Karena mesin (Fuzzy) hanya mengerti angka, data kualitatif dari lapangan harus dikonversi:
- **Baik / Ada / Kokoh** $\rightarrow$ Skor **1.0**
- **Rusak Ringan** $\rightarrow$ Skor **0.5**
- **Buruk / Tidak Ada** $\rightarrow$ Skor **0.0**

Nilai-nilai ini kemudian menjadi input bagi **Fuzzy Engine** untuk diproses lebih lanjut.

---

## 🎯 Mengapa Menggunakan SPK?
1. **Transparansi**: Keputusan diambil berdasarkan data matematis, bukan perasaan petugas.
2. **Prioritas**: Sistem bisa memberikan rangking dari warga yang "Sangat Layak Bantuan" hingga "Tidak Layak".
3. **Standarisasi**: Penilaian yang seragam di seluruh Kecamatan Plaju.

---

**Lanjut ke Bab berikutnya:**
[03 — Logika Fuzzy Mamdani](./03_LOGIKA_FUZZY_MAMDANI.md)
