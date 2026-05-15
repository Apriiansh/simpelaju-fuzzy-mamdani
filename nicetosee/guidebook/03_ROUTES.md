# 🛣️ 03. Routes (Pintu Masuk Aplikasi)

**Routes** adalah bagian yang menentukan URL apa yang tersedia di aplikasi Anda dan ke mana URL tersebut akan bermuara. File utamanya berada di `routes/web.php`.

## 1. Konsep Dasar Route

Di Laravel, Anda mendefinisikan rute berdasarkan *HTTP Verbs* (GET, POST, PUT, DELETE).

### A. Route GET (Mengambil / Menampilkan Halaman)
```php
use App\Http\Controllers\DashboardController;

// Menampilkan halaman biasa
Route::get('/tentang-kami', function () {
    return view('tentang');
});

// Memanggil Controller (CARA YANG DIREKOMENDASIKAN)
Route::get('/dashboard', [DashboardController::class, 'index']);
```

### B. Route POST (Mengirim Data Form)
Digunakan saat user men-submit form pendaftaran atau membuat data baru.
```php
Route::post('/laporan/simpan', [LaporanController::class, 'store']);
```

### C. Route PUT/PATCH & DELETE (Update & Hapus)
```php
Route::put('/laporan/{id}', [LaporanController::class, 'update']);
Route::delete('/laporan/{id}', [LaporanController::class, 'destroy']);
```

---

## 2. Parameter URL Dinamis
Bagaimana jika URL kita dinamis, seperti `/profil/andi` atau `/laporan/5`? Kita bisa menangkap nilainya menggunakan tanda kurung kurawal `{ }`.

```php
Route::get('/laporan/{id}', [LaporanController::class, 'show']);
// '{id}' nantinya akan dikirim ke fungsi show($id) di LaporanController.
```

---

## 3. Penamaan Route (Route Naming) - SANGAT PENTING!
Selalu berikan **nama** pada route Anda dengan fungsi `->name()`. 
Keuntungannya: Jika Anda nanti mengubah URL (misal dari `/profil` menjadi `/akun`), Anda **tidak perlu mengubah link di seluruh file HTML Anda**.

```php
Route::get('/user/profil-saya', [UserController::class, 'profile'])->name('profil.index');
```
Nantinya di file Blade/HTML Anda cukup memanggil:
`<a href="{{ route('profil.index') }}">Ke Profil</a>`

---

## 4. Middleware & Route Grouping
Middleware adalah penjaga pintu keamanan. Contoh paling umum: Hanya user yang sudah login yang boleh membuka halaman dashboard.

Daripada menulis proteksi di setiap baris route, kita bisa mengelompokkannya (*Group*).

```php
// Semua route di dalam group ini akan dicek oleh middleware 'auth'
// Jika belum login, otomatis dilempar ke halaman login.
Route::middleware(['auth'])->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::post('/laporan', [LaporanController::class, 'store'])->name('laporan.store');

});
```

---
➡️ **Langkah Selanjutnya**: Pelajari tempat kita meletakkan logika bisnis aplikasi di [Controller](./04_CONTROLLER.md).
