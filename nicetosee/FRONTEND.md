# 🎨 Arsitektur Frontend (Modern Stack)

## ⚡ Tech Stack
*   **Blade Templates**: Engine rendering sisi server yang powerful.
*   **Tailwind CSS**: Utility-first CSS untuk desain yang responsif dan estetik premium.
*   **Vite**: Build tool modern untuk bundling aset JavaScript dan CSS.
*   **Alpine.js**: Reactive framework ringan untuk interaksi UI (seperti modal dan dropdown).

## 🗺️ Integrasi Web-GIS
*   **Leaflet.js**: Library utama untuk menampilkan peta interaktif.
*   **Map Markers**: Menampilkan lokasi rumah dengan warna marker dinamis (Hijau = Layak, Merah = Tidak Layak).
*   **GeoJSON**: (Opsional) Digunakan untuk menggambar batas wilayah Kelurahan di atas peta.

## 🧩 Komponen UI
*   **Reusable Components**: Menggunakan `@components` blade untuk elemen berulang seperti Card Stats, Badge Status, dan Form Input.
*   **Dynamic Modals**: Untuk input kriteria cepat tanpa pindah halaman.

## 🚀 Best Practices
1.  **Mobile First**: Desain harus nyaman diakses oleh petugas lapangan menggunakan smartphone saat survei lokasi.
2.  **Asset Optimization**: Gunakan Vite untuk minify CSS/JS agar load time < 2 detik.
3.  **Accessibility (a11y)**: Pastikan kontras warna cukup dan form memiliki label yang jelas.
