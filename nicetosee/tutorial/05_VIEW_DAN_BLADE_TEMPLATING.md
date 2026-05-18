# 05 — View dan Blade Templating
> Membangun antarmuka yang bersih dan interaktif bagi petugas kecamatan.

Simpelaju menggunakan **Blade**, templating engine bawaan Laravel, dikombinasikan dengan **Tailwind CSS** untuk desain yang responsif.

---

## 🏛️ Master Layout (`layouts/app.blade.php`)

Agar tampilan konsisten di semua halaman (Sidebar, Header, Footer), Simpelaju menggunakan sistem *Layout Inheritance*.

- **`@extends('layouts.app')`**: Digunakan di awal file halaman.
- **`@section('content')`**: Tempat di mana isi spesifik halaman diletakkan.
- **`@yield('content')`**: Perintah di file master untuk menampilkan isi dari section tersebut.

---

## 🎨 Komponen UI Simpelaju

### 1. Dashboard Cards
Menampilkan statistik cepat seperti "Total Warga", "Rumah Layak Bantuan", dan "Menunggu Verifikasi".

### 2. Form Penilaian (Multi-Input)
Input data kualitatif menggunakan *Dropdown/Select* (Pondasi: Ada/Tidak) dan input numerik (Luas Bangunan).

### 3. Tabel Data (DataTables)
Menampilkan daftar warga dengan fitur pencarian dan pengurutan berdasarkan skor Fuzzy tertinggi.

---

## ⚡ Tailwind CSS Integration

Simpelaju tidak menggunakan file CSS panjang. Sebaliknya, gaya desain ditentukan langsung di HTML menggunakan utility classes:
- `bg-blue-600`: Memberi warna latar biru.
- `rounded-lg`: Membuat sudut kotak melengkung.
- `shadow-md`: Memberi efek bayangan agar tampilan lebih premium.

---

## 🧩 Conditional Rendering
Blade mempermudah tampilan dinamis berdasarkan data:
```blade
@if($skor >= 51)
    <span class="badge badge-success">LAYAK</span>
@else
    <span class="badge badge-danger">TIDAK LAYAK</span>
@endif
```

---

**Lanjut ke Bab berikutnya:**
[06 — GIS dan Peta Interaktif](./06_GIS_DAN_PETA_INTERAKTIF.md)
