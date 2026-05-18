# 04 — Controller dan Validasi Form
> Menangani data dari user dan menghubungkannya ke database.

Controller adalah jembatan antara tampilan dan logika. Di sini kita akan membuat alur penyimpanan data warga dan pemicu hitungan fuzzy.

---

## 1. Membuat PenilaianController
```bash
php artisan make:controller PenilaianController
```

---

## 2. Implementasi Store & Calculate
```php
public function store(Request $request) {
    // 1. Validasi Input
    $validated = $request->validate([
        'warga_id' => 'required',
        'skor_a' => 'required|numeric',
        // pilar lainnya...
    ]);

    // 2. Panggil Fuzzy Engine
    $fuzzyResult = FuzzyMamdani::calculate($validated);

    // 3. Tentukan Status berdasarkan skor (Threshold 51)
    $status = $fuzzyResult >= 51 ? 'LAYAK' : 'TIDAK LAYAK';

    // 4. Simpan ke Database
    Penilaian::create([
        'warga_id' => $validated['warga_id'],
        'skor_akhir_z' => $fuzzyResult,
        'status_kelayakan' => $status
        // ... data lainnya
    ]);

    return redirect()->back()->with('success', 'Perhitungan selesai!');
}
```

---

## 3. Flash Messages
Gunakan sistem session flash di Laravel untuk memberitahu user bahwa data berhasil disimpan:
```php
return back()->with('message', 'Data Berhasil Dihitung');
```

---

## 4. Middleware Protection
Pastikan fungsi hitungan ini hanya bisa diakses petugas yang sudah login:
```php
public function __construct() {
    $this->middleware('auth');
}
```

---

## 💡 Tips Coding
- Simpan logika validasi yang kompleks ke dalam **FormRequest** agar Controller tidak terlalu panjang.
- Gunakan `try...catch` jika Anda khawatir ada kesalahan matematis pada Engine Fuzzy.

---

**Langkah Selanjutnya:**
[05 — Frontend dengan Tailwind & Blade](./05_FRONTEND_DENGAN_TAILWIND_BLADE.md)
