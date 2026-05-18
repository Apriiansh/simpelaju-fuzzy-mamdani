# 06 — GIS dan Peta Interaktif
> Visualisasi data spasial untuk pemetaan kemiskinan di Kecamatan Plaju.

Simpelaju menggabungkan data statistik dengan **Geographic Information System (GIS)** agar pimpinan bisa melihat sebaran rumah tidak layak huni secara geografis.

---

## 🗺️ Integrasi Leaflet.js

Kita menggunakan **Leaflet.js** karena ringan dan mudah digunakan di dalam Laravel.

### Fitur Peta:
1. **Marker Clustering**: Mengelompokkan banyak titik rumah yang berdekatan agar peta tidak penuh.
2. **Color Coding**: Marker berubah warna berdasarkan kelayakan (Hijau = Layak Bantuan, Merah = Tidak Layak).
3. **Popup Info**: Menampilkan foto rumah dan ringkasan skor saat marker diklik.

---

## 📍 Penanganan Koordinat

Data lokasi disimpan di database MySQL dalam format:
- **Latitude**: Garis lintang (misal: `-2.9876`).
- **Longitude**: Garis bujur (misal: `104.7890`).

Saat halaman peta dimuat, Controller mengirimkan koleksi data warga yang sudah memiliki koordinat ke View, lalu JavaScript Leaflet akan me-render titik-titik tersebut.

---

## 🛡️ Geofencing Wilayah

Untuk memastikan akurasi data, sistem dapat menggunakan data **GeoJSON** batas wilayah Kecamatan Plaju. Marker yang berada di luar batas ini akan diberi tanda peringatan (verifikasi lokasi).

---

## 📊 Manfaat Analisis Spasial
- **Identifikasi Klaster**: Melihat kelurahan mana yang memiliki konsentrasi RTLH paling tinggi.
- **Perencanaan Wilayah**: Membantu dinas terkait dalam menentukan arah pembangunan infrastruktur pendukung (jalan, drainase).

---

**Selesai!**
Kembali ke [Daftar Bab](./TUTORIAL_BOOK.md) atau lihat istilah di [Glosarium](./GLOSARIUM.md).
