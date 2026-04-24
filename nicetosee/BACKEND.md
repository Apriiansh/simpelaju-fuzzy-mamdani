# ⚙️ Arsitektur Backend (Laravel 12)

## 🛠️ Deskripsi Sistem
Backend sistem ini menggunakan **Laravel 12 (PHP 8.2+)** sebagai core engine. Tugas utamanya adalah mengelola data master, menangani autentikasi, dan mengeksekusi perhitungan algoritma **Fuzzy Mamdani**.

## 🧠 Konsep Utama & Algoritma
### 1. Fuzzy Logic Service (Mamdani Engine)
Semua logika matematika tidak diletakkan di Controller, melainkan di dalam `App\Services\Fuzzy\MamdaniEngine.php`.
*   **Fuzzifikasi**: Mengubah input tegas (skor 0-100) menjadi derajat keanggotaan (Low, Mid, High).
*   **Inferensi**: Mengevaluasi aturan (Rule Base) menggunakan operator MIN-MAX.
*   **Defuzzifikasi**: Menghitung titik pusat (Centroid) untuk mendapatkan skor akhir kelayakan.

## 🏆 Best Practices (Clean Code)
1.  **KISS (Keep It Simple, Stupid)**: Jangan membuat kode yang over-engineered. Jika fitur bisa diselesaikan dengan native Laravel helper, gunakan itu.
2.  **DRY (Don't Repeat Yourself)**: Gunakan *Trait* atau *Service* untuk logika yang dipakai berulang (misalnya perhitungan skor atau formatting koordinat).
3.  **SOLID Principles**:
    *   *Single Responsibility*: Satu class (Service) hanya menangani satu tugas (Fuzzy calculation).
    *   *Interface Segregation*: Gunakan interface jika nantinya algoritma SPK ingin diganti (misal ke TOPSIS atau AHP).
4.  **Request Validation**: Selalu gunakan `FormRequest` untuk validasi data sebelum masuk ke logic bisnis.

## 🛡️ Keamanan & Performa
*   **Breeze Auth**: Autentikasi aman bawaan Laravel.
*   **Database Transaction**: Digunakan pada saat menyimpan data `Penilaian` dan `HasilSpk` secara bersamaan untuk menjaga integritas data.
*   **Logging**: Mencatat setiap kegagalan perhitungan fuzzy ke dalam `storage/logs/laravel.log`.
