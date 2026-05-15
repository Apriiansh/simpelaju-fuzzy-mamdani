# 💾 02. Database & Model (Eloquent ORM)

Bagian ini adalah dasar dari penyimpanan data di Laravel. Laravel menggunakan fitur luar biasa bernama **Eloquent ORM** yang memungkinkan kita berinteraksi dengan Database menggunakan sintaks PHP biasa, tanpa perlu menulis `SELECT * FROM ...` secara manual.

## 1. Migration (Cetak Biru Tabel)

Migration adalah "Git" untuk database Anda. Daripada mengubah tabel manual di aplikasi database, Anda menulisnya melalui kode PHP.

### Membuat Migration & Model
Selalu gunakan perintah ini agar cepat:
```bash
php artisan make:model NamaModel -m
```
*(Huruf `-m` akan otomatis membuatkan file Migration untuk Model tersebut)*

### Contoh Isi File Migration (di `database/migrations/`)
```php
public function up()
{
    Schema::create('laporan', function (Blueprint $table) {
        $table->id(); // Auto increment ID
        $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Relasi ke tabel users
        $table->string('judul'); // Teks pendek (VARCHAR)
        $table->text('deskripsi')->nullable(); // Teks panjang, boleh kosong
        $table->boolean('is_selesai')->default(false); // TRUE/FALSE
        $table->timestamps(); // Otomatis membuat kolom created_at dan updated_at
    });
}
```

### Menjalankan Migration
Setelah file migration ditulis, jalankan di terminal:
```bash
php artisan migrate
```

---

## 2. Model (Penghubung ke Tabel)

Model adalah file PHP yang merepresentasikan satu tabel. File ini ada di folder `app/Models/`.

### Aturan Dasar Model: `$fillable`
Untuk alasan keamanan (mencegah *Mass Assignment Vulnerability*), Laravel mengharuskan kita mendeklarasikan kolom apa saja yang BISA diisi dari formulir secara massal.

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    // Nama tabel di DB. (Opsional jika nama tabel adalah versi jamak bahasa inggris dari model, misal 'Laporan' -> 'laporans').
    protected $table = 'laporan';

    // WAJIB: Tentukan kolom yang bisa diisi user.
    protected $fillable = [
        'user_id',
        'judul',
        'deskripsi',
        'is_selesai'
    ];

    // Mendifinisikan Relasi (BelongsTo: 1 Laporan dimiliki 1 User)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
```

## 3. Berinteraksi dengan Eloquent (Contoh Penggunaan)

Nantinya, di dalam Controller, Anda bisa memanggil data dengan sangat mudah:

```php
// Mengambil semua laporan
$semuaLaporan = Laporan::all();

// Mengambil laporan yang sudah selesai
$laporanSelesai = Laporan::where('is_selesai', true)->get();

// Mengambil 1 laporan berdasarkan ID (jika tidak ada akan Error 404)
$laporan = Laporan::findOrFail(5);

// Menambah data baru
Laporan::create([
    'judul' => 'Rumah Atap Bocor',
    'deskripsi' => 'Atap bocor di ruang tamu',
    'user_id' => 1
]);

// Mengupdate data
$laporan = Laporan::find(1);
$laporan->update(['is_selesai' => true]);

// Menghapus data
Laporan::find(2)->delete();
```

---
➡️ **Langkah Selanjutnya**: Pelajari tentang pintu masuk aplikasi, yaitu [Routes](./03_ROUTES.md).
