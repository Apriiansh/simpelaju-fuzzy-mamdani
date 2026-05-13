# Migrasi Laporan Prioritas RTLH ke Format Excel

Sesuai dengan permintaan, laporan akan diubah dari format PDF menjadi Excel. Laporan Excel ini akan lebih lengkap (menyertakan data detail penduduk dan rumah), memiliki KOP dengan logo, dan dipisah ke dalam beberapa *sheet* berdasarkan Kelurahan.

## User Review Required

> [!WARNING]
> **Dukungan Logo SVG di Excel**
> PHPSpreadsheet (library di balik export Excel di Laravel) tidak mendukung format `.svg` secara langsung (native) untuk dimasukkan ke dalam file Excel. 
> **Mohon sediakan file logo dalam format `.png` atau `.jpg`** (misalnya `public/logo_dinas.png`) agar logo dapat tertampil dengan sempurna di Excel. Jika tidak ada, logo terpaksa tidak ditampilkan di file Excel.

## Open Questions

1. **Format KOP Excel**: Menambahkan KOP Surat (Header) lengkap dengan baris-baris teks di Excel sedikit *tricky* (biasanya memakan baris 1-5 dan di-*merge*). Apakah Anda setuju jika baris 1-5 digunakan untuk KOP (Logo + Teks Dinas), lalu baris 7 mulai untuk Header Tabel?
2. **Package Excel**: Saya akan menginstal package `maatwebsite/excel` versi terbaru. Apakah ada larangan menambah package baru?

## Proposed Changes

### 1. Database & Struktur Kolom (Excel Data)
Data yang akan diekspor akan mencakup seluruh atribut dari tabel `penduduk`, `rumah`, `penilaian`, dan `hasil_spk`.
Kolom-kolom di dalam Excel:
- **Data Diri**: No, NIK, Nama Lengkap, Alamat, Kelurahan, No Telepon, Status Pernikahan, Jumlah Tanggungan, Penghasilan.
- **Data Bangunan (Pilar A-D)**: Luas Bangunan, Status Kepemilikan, Pondasi, Kolom Balok, Konstruksi Atap, Jendela, Ventilasi, Kamar Mandi, Jarak Sumber Air, Material Atap, Kondisi Atap, Material Dinding, Kondisi Dinding, Material Lantai, Kondisi Lantai.
- **Hasil SPK**: Skor Z* (Defuzzifikasi), Status Kelayakan, Rekomendasi/Keterangan.

---

### Package Installation
Saya akan menjalankan perintah berikut untuk menginstal package Excel:
```bash
composer require maatwebsite/excel
```

---

### [App/Exports]

#### [NEW] [LaporanExport.php](file:///d:/job-besak/simpelaju/app/Exports/LaporanExport.php)
- Class utama yang mengimplementasikan antarmuka `WithMultipleSheets`.
- Berfungsi untuk mengelompokkan data berdasarkan Kelurahan dan membuat satu *sheet* (`KelurahanSheetExport`) untuk masing-masing Kelurahan.

#### [NEW] [KelurahanSheetExport.php](file:///d:/job-besak/simpelaju/app/Exports/KelurahanSheetExport.php)
- Mengimplementasikan `FromQuery` atau `FromCollection`, `WithHeadings`, `WithMapping`, `WithTitle`, `WithStyles`, `WithDrawings`, dan `WithColumnWidths`.
- Mengelola data per Kelurahan.
- Menyisipkan KOP / Header di baris-baris pertama (menggabungkan sel dan menambahkan logo jika format `.png`/`.jpg` tersedia).

---

### [App/Http/Controllers]

#### [MODIFY] [LaporanController.php](file:///d:/job-besak/simpelaju/app/Http/Controllers/LaporanController.php)
- Mengubah logika pada method `cetak()` yang sebelumnya menggunakan `Pdf::loadView(...)` menjadi menggunakan `Excel::download(new LaporanExport(...), 'Laporan_Prioritas.xlsx')`.
- Tetap mengirimkan parameter filter (Tgl Mulai, Tgl Akhir, Status, Kelurahan). Jika filter Kelurahan aktif, maka Excel hanya akan meng-generate 1 sheet untuk kelurahan tersebut.

---

### [Resources/Views/Laporan]

#### [MODIFY] [index.blade.php](file:///d:/job-besak/simpelaju/resources/views/laporan/index.blade.php)
- Mengubah teks tombol dari "Cetak PDF" menjadi "Export Excel" dan memperbarui icon-nya agar lebih relevan dengan Excel.

#### [DELETE] [pdf.blade.php](file:///d:/job-besak/simpelaju/resources/views/laporan/pdf.blade.php)
- File ini tidak lagi digunakan karena kita beralih ke *native Excel generation*.

## Verification Plan

### Automated Tests
1. Menjalankan fungsi Export di browser.
2. Memastikan file `.xlsx` terunduh.

### Manual Verification
1. Membuka file `.xlsx` yang diunduh menggunakan aplikasi Spreadsheet.
2. Memverifikasi bahwa *sheet* terpisah dengan benar berdasarkan Kelurahan.
3. Memastikan KOP dan seluruh kolom data terisi sesuai dengan urutan dan format yang benar.
