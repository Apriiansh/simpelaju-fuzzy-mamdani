# 03 — Implementasi Fuzzy Engine PHP
> Membangun mesin matematika Mamdani menggunakan Service Pattern di Laravel.

Berbeda dengan aplikasi Laravel sederhana, Simpelaju memisahkan logika matematika yang kompleks ke dalam **Service Layer**. Ini membuat kode lebih mudah diuji, rapi, dan tidak ambigu.

---

## 📂 Struktur Folder Services
Logika utama terletak di `app/Services/Fuzzy/`:
1.  **`InputMapperService.php`**: Bertugas mengonversi data mentah (kualitatif) menjadi angka (0.0 - 1.0).
2.  **`MamdaniEngine.php`**: Mesin utama yang menjalankan Fuzzifikasi, Inferensi, dan Defuzzifikasi.

---

## 1. Input Mapping (`InputMapperService.php`)
Sebelum dihitung, data dari model `Rumah` harus dipetakan. Service ini menangani konversi seperti:
- **Binary**: `Ada` (1.0), `Tidak Ada` (0.0).
- **Qualitative**: `Baik` (1.0), `Sedang` (0.5), `Buruk` (0.0).
- **Sub-Inference Pilar D**: Khusus pilar material, service ini melakukan perhitungan awal untuk menggabungkan Atap, Dinding, dan Lantai sebelum dikirim ke engine utama.

```php
// Contoh pemetaan Pilar A (Safety)
$s1 = $this->mapBinary($rumah->pondasi, 'Ada', 'Tidak Ada');
$s2 = $this->mapQualitative($rumah->kolom_balok);
$scores['K1'] = ($s1 + $s2 + $s3) / 3;
```

---

## 2. Mamdani Engine (`MamdaniEngine.php`)
Ini adalah jantung dari sistem SPK. Engine ini melakukan 3 langkah standar Mamdani:

### A. Fuzzifikasi
Mengambil nilai pasti (*crisp*) dari database dan menghitung derajat keanggotaannya menggunakan fungsi keanggotaan Segitiga atau Trapesium.
```php
$fuzzifiedInput = $this->fuzzify($penilaian);
```

### B. Evaluasi Aturan (Inference)
Mengevaluasi **37 Aturan** yang tersimpan di database menggunakan operator **MIN** (untuk AND) dan **MAX** (untuk komposisi).
```php
$inferredResult = $this->inference($fuzzifiedInput);
```

### C. Defuzzifikasi (Centroid)
Menghitung titik pusat area (*Center of Area*) untuk menghasilkan skor akhir antara 0-100.
```php
$score = $this->defuzzify($inferredResult);
```

---

## 3. Cara Penggunaan di Controller
Anda tidak perlu memanggil rumus satu-satu. Cukup panggil `runAssessment()` pada `InputMapperService`.

```php
use App\Services\Fuzzy\InputMapperService;

public function calculate($id) {
    $service = app(InputMapperService::class);
    $hasil = $service->runAssessment($id, '2024');
    
    return back()->with('hasil', $hasil);
}
```

---

## 💡 Mengapa Menggunakan Service?
1.  **Reusability**: Logika fuzzy bisa dipanggil dari Web Controller, API, atau bahkan Artisan Command (CLI).
2.  **Testability**: Anda bisa membuat *Unit Test* khusus untuk mengetes apakah input `0.5` menghasilkan skor yang benar tanpa harus menjalankan browser.
3.  **Clarity**: Memisahkan "Apa yang dilakukan" (Controller) dengan "Bagaimana cara menghitungnya" (Service).

---

**Langkah Selanjutnya:**
[04 — Controller dan Validasi Form](./04_CONTROLLER_DAN_VALIDASI_FORM.md)
