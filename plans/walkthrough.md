# Walkthrough: Perbaikan Workflow Verifikasi RTLH

Saya telah merombak sistem verifikasi untuk mematuhi proses bisnis yang lebih ketat dan transparan.

## Perubahan Utama

### 1. Pergeseran Trigger Kalkulasi Fuzzy
Sebelumnya, kalkulasi Fuzzy berjalan saat data disimpan oleh Operator. Sekarang, kalkulasi **HANYA** berjalan setelah **Admin Camat** melakukan verifikasi (`terverifikasi`). Hal ini memastikan:
- Ranking tidak tercemar data sampah/draft.
- Ada proses filter sebelum mesin berat (Fuzzy) berjalan.

### 2. Status Tracking yang Jelas
Saya menambahkan kolom status verifikasi pada tabel `penilaian` (jika belum ada/sudah ada di migration sebelumnya) dan menampilkannya di UI dengan indikator warna:
- **Draft/Dikirim**: Belum ada hasil SPK.
- **Terverifikasi**: Hasil SPK muncul, menunggu validasi Camat.
- **Valid**: Data terkunci & final.

### 3. Kontrol Akses Berbasis Role
- **Operator Lurah**: Hanya bisa mengirim data (Kirim/Kirim Ulang).
- **Admin Camat**: Bisa melakukan Verifikasi atau Pengembalian (dengan catatan).
- **Camat**: Memvalidasi data yang sudah diverifikasi untuk menjadikannya keputusan final.

## File yang Dimodifikasi
- `app/Http/Controllers/PenilaianController.php`: Logika workflow & trigger.
- `routes/web.php`: Hak akses route.
- `resources/views/penilaian/index.blade.php`: Kolom status & tombol aksi dinamis.
- `resources/views/penduduk/show.blade.php`: Feedback visual status pendaftaran.

## Verifikasi Database
Data saat ini masih dalam status `draft`, sehingga aman untuk transisi ke workflow baru ini.
