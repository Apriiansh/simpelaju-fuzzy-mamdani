# 05 — Frontend dengan Tailwind & Blade
> Membangun antarmuka yang bersih dan user-friendly.

Simpelaju menggunakan **Tailwind CSS** untuk mempercepat proses desain langsung di dalam file **Blade**.

---

## 1. Setup Tailwind di Laravel
Jika Anda baru membuat project, jalankan:
```bash
npm install -D tailwindcss postcss autoprefixer
npx tailwindcss init -p
```
Pastikan file `tailwind.config.js` sudah diarahkan ke folder `resources/views`.

---

## 2. Membuat Komponen Card Statistik
Dashboard butuh tampilan ringkasan yang menarik.

```blade
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="bg-white p-6 rounded-xl shadow-sm border-l-4 border-blue-500">
        <h3 class="text-gray-500 text-sm font-medium">Total Warga</h3>
        <p class="text-2xl font-bold">{{ $totalWarga }}</p>
    </div>
    <!-- Card lainnya... -->
</div>
```

---

## 3. Form Input Kondisi Rumah
Gunakan input yang intuitif seperti `select` agar petugas mudah mengisi.

```blade
<form action="{{ route('penilaian.store') }}" method="POST">
    @csrf
    <label class="block text-sm font-bold mb-2">Kondisi Pondasi</label>
    <select name="skor_a" class="w-full border-gray-300 rounded-lg shadow-sm">
        <option value="1.0">Kokoh / Ada</option>
        <option value="0.5">Rusak Ringan</option>
        <option value="0.0">Buruk / Tidak Ada</option>
    </select>
    <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
        Hitung Fuzzy
    </button>
</form>
```

---

## 4. Menampilkan Hasil dengan Badge
Beri warna yang berbeda untuk status kelayakan agar pimpinan mudah membaca data.

```blade
<td class="px-6 py-4">
    @if($item->skor_akhir_z >= 51)
        <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-bold">LAYAK</span>
    @else
        <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-bold">TIDAK LAYAK</span>
    @endif
</td>
```

---

## 💡 Tips Coding
- Manfaatkan **Vite** (`npm run dev`) untuk melihat perubahan desain secara real-time.
- Gunakan `@include` untuk memisahkan bagian sidebar dan navbar agar kode tidak menumpuk di satu file.

---

**Langkah Selanjutnya:**
[06 — Integrasi Leaflet JS](./06_INTEGRASI_LEAFLET_JS.md)
