# 02 — Model dan Relasi Eloquent
> Mendefinisikan objek data dan hubungan antar tabel.

**Eloquent** adalah ORM yang membuat interaksi dengan database menjadi sangat intuitif menggunakan sintaks objek PHP.

---

## 1. Membuat Model Warga
```bash
php artisan make:model Warga
```

Di dalam `app/Models/Warga.php`:
```php
class Warga extends Model {
    protected $fillable = ['nama', 'nik', 'alamat', 'latitude', 'longitude'];

    // Relasi: Satu warga bisa memiliki banyak riwayat penilaian
    public function penilaians() {
        return $this->hasMany(Penilaian::class);
    }
}
```

---

## 2. Membuat Model Penilaian
```bash
php artisan make:model Penilaian
```

Di dalam `app/Models/Penilaian.php`:
```php
class Penilaian extends Model {
    protected $fillable = ['warga_id', 'skor_a', 'skor_b', 'skor_c', 'skor_d', 'skor_akhir_z', 'status_kelayakan'];

    // Relasi: Penilaian dimiliki oleh satu warga
    public function warga() {
        return $this->belongsTo(Warga::class);
    }
}
```

---

## 3. Mass Assignment
Pastikan kolom-kolom penting sudah masuk ke dalam array `$fillable`. Ini adalah fitur keamanan Laravel untuk mencegah penginputan data ilegal ke kolom yang tidak seharusnya.

---

## 4. Keuntungan Menggunakan Relasi
Dengan mendefinisikan relasi, Anda bisa mengambil data dengan sangat mudah di Controller:
```php
// Mengambil semua data warga beserta nilai kelayakannya
$data = Warga::with('penilaians')->get();
```

---

## 💡 Tips Coding
- Ikuti konvensi penamaan Laravel (Nama Model Tunggal: `Warga`, Nama Tabel Jamak: `wargas`).
- Gunakan **Type Hinting** pada fungsi relasi untuk bantuan auto-complete di editor.

---

**Langkah Selanjutnya:**
[03 — Implementasi Fuzzy Engine PHP](./03_IMPLEMENTASI_FUZZY_ENGINE_PHP.md)
