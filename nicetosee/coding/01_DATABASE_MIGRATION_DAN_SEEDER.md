# 01 — Database Migration dan Seeder
> Membangun fondasi data menggunakan sistem migrasi Laravel.

Laravel menggunakan **Migration** untuk membuat tabel database melalui kode PHP. Ini memudahkan kolaborasi dan versioning struktur database.

---

## 1. Membuat Migrasi Tabel Warga
Jalankan perintah artisan:
```bash
php artisan make:migration create_wargas_table
```

Edit file migrasi di `database/migrations/`:
```php
public function up()
{
    Schema::create('wargas', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->string('nik')->unique();
        $table->text('alamat');
        $table->decimal('latitude', 10, 8);
        $table->decimal('longitude', 11, 8);
        $table->timestamps();
    });
}
```

---

## 2. Membuat Migrasi Tabel Penilaian
Tabel ini akan menyimpan skor fuzzy dari 4 pilar.

```php
Schema::create('penilaians', function (Blueprint $table) {
    $table->id();
    $table->foreignId('warga_id')->constrained();
    $table->float('skor_a'); // Safety
    $table->float('skor_b'); // Health
    $table->float('skor_c'); // Density
    $table->float('skor_d'); // Material
    $table->float('skor_akhir_z'); // Hasil Fuzzy
    $table->string('status_kelayakan'); // Layak/Tidak
    $table->timestamps();
});
```

---

## 3. Menjalankan Migrasi
Kirim skema ke database MySQL:
```bash
php artisan migrate
```

---

## 4. Seeder Data Awal
Untuk mengisi data contoh (dummy), gunakan **Seeder**.
```bash
php artisan make:seeder WargaSeeder
```

Di dalam `WargaSeeder.php`:
```php
Warga::create([
    'nama' => 'Budi Santoso',
    'nik' => '1234567890',
    'latitude' => -2.973,
    'longitude' => 104.756
]);
```

---

## 💡 Tips Coding
- Gunakan tipe data `decimal(10,8)` untuk Latitude agar akurasi lokasi terjamin.
- Selalu tambahkan `constrained()` pada foreign key untuk integritas data.

---

**Langkah Selanjutnya:**
[02 — Model dan Relasi Eloquent](./02_MODEL_DAN_RELASI_ELOQUENT.md)
