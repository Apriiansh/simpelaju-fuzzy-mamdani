# 🎨 05. View, Blade, & TailwindCSS

Ini adalah layer terakhir. Di sinilah HTML dibuat dan dipercantik. File **View** di Laravel menggunakan ekstensi `.blade.php` dan berada di folder `resources/views/`.

## 1. Apa itu Blade Templating?
Blade adalah *template engine* bawaan Laravel yang sangat kuat. Blade mengizinkan kita menyisipkan logika PHP ke dalam HTML secara elegan tanpa perlu tanda `<?php ... ?>`.

### Blade Basics (Sintaks Utama)

#### Menampilkan Data
Jika Controller mengirim data `$nama`, tampilkan dengan:
```html
<h1>Halo, {{ $nama }}!</h1>
```
*(Sintaks `{{ }}` secara otomatis membersihkan kode HTML/JS berbahaya (XSS Protection).)*

#### Logika If-Else (Kondisional)
```html
@if($nilai > 75)
    <p>Lulus</p>
@elseif($nilai == 75)
    <p>Lulus Pas-Pasan</p>
@else
    <p>Remedial</p>
@endif
```

#### Looping (Perulangan Data Tabel)
`@foreach` digunakan untuk mencetak banyak data array (misal dari Database). `@forelse` lebih canggih: jika datanya kosong, ia menjalankan bagian `@empty`.
```html
<ul>
    @forelse($semua_laporan as $laporan)
        <li>{{ $laporan->judul }}</li>
    @empty
        <li>Belum ada data.</li>
    @endforelse
</ul>
```

---

## 2. Komponen & Layouts
Di PHP biasa (Native), Anda memakai `include 'header.php'`. Di Laravel Blade yang modern, kita menggunakan konsep **Component**.

Di folder `resources/views/layouts/`, biasanya ada file layout utama (misal `app.blade.php`). Layout ini ibarat pigura.
Kita memanggil pigura tersebut dengan `<x-app-layout>`.

Contoh file **Halaman Index** kita:
```html
<!-- 1. Memanggil File Layouts (Pigura) -->
<x-app-layout>
    
    <!-- 2. Mengisi Slot (Bagian tertentu di Layout, misal Header judul halaman) -->
    <x-slot name="header">
        <h2>Daftar Laporan</h2>
    </x-slot>

    <!-- 3. Semua tag di bawah ini adalah Konten Utama -->
    <div>
        <!-- Menampilkan pesan dari fungsi ->with() di Controller -->
        @if(session('success'))
            <div class="bg-green-500 text-white p-4">
                {{ session('success') }}
            </div>
        @endif

        Isi Halaman Laporan ada di sini...
    </div>

</x-app-layout>
```

---

## 3. Integrasi TailwindCSS
Project ini menggunakan **TailwindCSS**, yaitu framework CSS berkonsep *Utility-First*.
Daripada menulis kode CSS panjang di file terpisah, Anda membangun desain langsung di HTML dengan merakit class-class kecil.

**Perbandingan CSS Tradisional vs Tailwind:**

*CSS Tradisional:*
```html
<button class="btn-primary">Simpan</button>
<!-- Anda harus bikin .btn-primary { background: blue; padding: 10px; border-radius: 5px; color: white } -->
```

*TailwindCSS:*
```html
<button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
    Simpan
</button>
<!-- Selesai. Tidak perlu buka file .css -->
```

### Kamus Singkat Tailwind:
* `p-4` = Padding `1rem` di semua sisi.
* `px-4 py-2` = Padding horizontal (kiri-kanan) 4, vertikal (atas-bawah) 2.
* `mt-5` = Margin top 5.
* `w-full` = Width 100%.
* `bg-red-500` = Background warna merah.
* `text-center text-gray-700` = Teks rata tengah, warna abu-abu.
* `rounded-lg shadow-md` = Sudut melengkung (border-radius), diberi bayangan.
* `flex items-center justify-between` = Menggunakan flexbox untuk memposisikan elemen anak sejajar dan menyebar.

### Menggabungkan Blade dan Tailwind
Sangat mudah. Anda bisa menggabungkan logika Blade ke class Tailwind.
Contoh: Tombol berwarna merah jika *status Selesai*, hijau jika *Aktif*.
```html
<span class="px-2 py-1 rounded text-white {{ $laporan->is_selesai ? 'bg-red-500' : 'bg-green-500' }}">
    {{ $laporan->is_selesai ? 'Sudah Selesai' : 'Sedang Aktif' }}
</span>
```

---
🏁 **Selamat! Anda sudah memahami dasar MVC, Routing, Controller, Blade, dan Tailwind pada Laravel.**
Pahami kelima tahapan (guidebook) ini, maka Anda siap untuk membedah atau menambahkan fitur baru di project **Simpelaju**!
