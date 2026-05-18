# 06 — Integrasi Leaflet JS
> Memasang peta interaktif untuk visualisasi spasial RTLH.

Langkah terakhir adalah memvisualisasikan data di atas peta menggunakan library **Leaflet**.

---

## 1. Menambahkan CDN Leaflet
Letakkan di dalam bagian `<head>` pada file layout utama Anda:
```html
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
```

---

## 2. Inisialisasi Peta di Halaman
Buat div dengan ID `map` dan tentukan tinggi kotaknya.

```blade
<div id="map" class="h-96 w-full rounded-xl shadow-lg"></div>

<script>
    var map = L.map('map').setView([-2.973, 104.756], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
</script>
```

---

## 3. Menampilkan Data dari Database (Marker)
Loop data warga dari Controller dan buat marker di JavaScript.

```blade
<script>
    var dataWarga = @json($wargas); // Konversi array PHP ke JSON JS
    
    dataWarga.forEach(function(item) {
        var color = item.status_kelayakan == 'LAYAK' ? 'green' : 'red';
        
        L.marker([item.latitude, item.longitude])
            .addTo(map)
            .bindPopup("<b>" + item.nama + "</b><br>Status: " + item.status_kelayakan);
    });
</script>
```

---

## 4. Fitur Lokasi Otomatis (GPS)
Jika petugas ingin mengambil lokasi saat sedang berada di depan rumah warga:
```javascript
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            document.getElementById('lat_input').value = position.coords.latitude;
            document.getElementById('lng_input').value = position.coords.longitude;
        });
    }
}
```

---

## 💡 Tips Coding
- Gunakan **MarkerCluster** jika data warga mencapai ratusan agar peta tidak lag.
- Pastikan koordinat yang disimpan di database valid (Latitude antara -90 sampai 90, Longitude antara -180 sampai 180).

---

**Selamat!**
Anda telah menyelesaikan seluruh rangkaian pengembangan teknis proyek Simpelaju.
[Kembali ke Index Tutorial](./CODING_INDEX.md)
