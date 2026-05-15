# 🧠 04. Controller (Logika Bisnis Utama)

**Controller** adalah "otak" aplikasi. Tugas utamanya adalah menerima *Request* dari Route, mengolahnya (biasanya memanggil Model), dan memberikan *Response* (biasanya mengirim data ke View atau redirect). Controller disimpan di folder `app/Http/Controllers/`.

## 1. Membuat Controller
Untuk membuat controller baru:
```bash
php artisan make:controller LaporanController
```

*(Tips: Tambahkan `--resource` jika ingin Laravel otomatis membuatkan 7 fungsi CRUD standar: index, create, store, show, edit, update, destroy).*

## 2. Anatomi Dasar Controller

Mari kita lihat controller yang bertugas menampilkan daftar data dan memproses form (simpan).

```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan; // Import Model yang dipakai

class LaporanController extends Controller
{
    // ----------------------------------------------------
    // FUNGSI 1: MENAMPILKAN DATA (READ)
    // ----------------------------------------------------
    public function index()
    {
        // 1. Ambil data dari database melalui Model
        // (contoh ini pakai paginate agar otomatis terpotong per halaman)
        $laporans = Laporan::with('user')->latest()->paginate(10);
        
        // 2. Lempar data tersebut ke View
        // file view-nya ada di: resources/views/laporan/index.blade.php
        return view('laporan.index', compact('laporans'));
    }

    // ----------------------------------------------------
    // FUNGSI 2: MENAMPILKAN FORMULIR (CREATE)
    // ----------------------------------------------------
    public function create()
    {
        return view('laporan.create');
    }

    // ----------------------------------------------------
    // FUNGSI 3: MEMPROSES FORM DAN SIMPAN (STORE)
    // ----------------------------------------------------
    public function store(Request $request)
    {
        // 1. VALIDASI: Pastikan input user benar
        $validatedData = $request->validate([
            'judul' => 'required|max:255',
            'deskripsi' => 'required|min:10',
        ], [
            // Kustomisasi pesan error (opsional)
            'judul.required' => 'Judul laporan wajib diisi, ya!',
        ]);

        // 2. SIMPAN KE DATABASE
        Laporan::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'user_id' => auth()->id() // Ambil ID user yang sedang login
        ]);

        // 3. REDIRECT: Arahkan kembali dengan pesan sukses (Flash Session)
        return redirect()->route('laporan.index')
                         ->with('success', 'Berhasil! Laporan Anda telah tersimpan.');
    }
}
```

## 3. Penjelasan Fitur Penting Controller

### A. Validasi (`$request->validate()`)
Sangat penting untuk mencegah aplikasi error. Jika user mengirim data kosong pada field yang `required`, Laravel akan otomatis menolak prosesnya dan melempar *error* tersebut ke halaman asal beserta dengan isian yang tadi diketik user.

### B. Objek `$request`
Tugasnya menangkap semua yang dikirim dari HTML Form atau Parameter URL.
- Ambil 1 input form: `$request->judul`
- Ambil semua input form: `$request->all()`

### C. Flash Session (`->with('success', 'pesan')`)
Saat operasi berhasil (menyimpan, menghapus), kita memindahkan user ke halaman lain (Redirect). Kita sering ingin menampilkan notifikasi (misal: kotak hijau "Data Berhasil Disimpan"). Fungsi `with()` akan menitipkan pesan sementara, yang hanya akan muncul sekali saat halaman ter-load, lalu otomatis hilang.

---
➡️ **Langkah Terakhir**: Pelajari cara mendesain dan menampilkan datanya di [View, Blade & TailwindCSS](./05_VIEW_BLADE_TAILWIND.md).
