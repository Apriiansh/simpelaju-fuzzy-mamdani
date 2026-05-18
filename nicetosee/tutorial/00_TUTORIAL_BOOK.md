# 📚 SIMPELAJU — Tutorial Book
> Panduan memahami Sistem Pendukung Keputusan (SPK) RTLH berbasis Laravel & Fuzzy Mamdani.

Dokumen ini adalah **indeks utama** dari tutorial book Simpelaju. Proyek ini menggabungkan kecerdasan buatan (Fuzzy Logic) dengan sistem informasi geografis (GIS) untuk menentukan kelayakan bantuan rumah tidak layak huni.

---

## 🗺️ Peta Belajar (Learning Path)

```
CORE ARCHITECTURE                   BUSINESS LOGIC
─────────────────                   ──────────────
01_ARSITEKTUR_LARAVEL_MVC.md        02_KONSEP_SPK_DAN_RTLH.md
  └─ Model-View-Controller            └─ 4 Pilar PUPR (Safety, Health, etc)
  └─ Eloquent ORM                     └─ Variabel Penilaian RTLH
  └─ Blade Templating
                                    03_LOGIKA_FUZZY_MAMDANI.md
04_ROUTING_DAN_CONTROLLER.md          └─ Fuzzifikasi & Sub-Inferensi
  └─ Web Routing                      └─ Rule Evaluation (37 Rules)
  └─ Controller Logic                 └─ Defuzzifikasi (Centroid)
  └─ Form Validation
                                    06_GIS_DAN_PETA_INTERAKTIF.md
05_VIEW_DAN_BLADE_TEMPLATING.md       └─ Koordinat Spasial
  └─ Master Layout                    └─ Visualisasi Marker Peta
  └─ Tailwind CSS Integration         └─ Geofencing Wilayah Plaju
```

---

## 📖 Daftar Bab

| # | File | Topik Utama | Estimasi |
|---|------|-------------|----------|
| 1 | [01_ARSITEKTUR_LARAVEL_MVC.md](./01_ARSITEKTUR_LARAVEL_MVC.md) | Struktur Laravel, MVC, dan folder Simpelaju | 25 menit |
| 2 | [02_KONSEP_SPK_DAN_RTLH.md](./02_KONSEP_SPK_DAN_RTLH.md) | Aturan PUPR, 4 Pilar, dan Variabel Input | 20 menit |
| 3 | [03_LOGIKA_FUZZY_MAMDANI.md](./03_LOGIKA_FUZZY_MAMDANI.md) | Hitungan Fuzzy, Rules, dan Centroid | 45 menit |
| 4 | [04_ROUTING_DAN_CONTROLLER.md](./04_ROUTING_DAN_CONTROLLER.md) | Alur Request, CRUD, dan Trigger Fuzzy | 30 menit |
| 5 | [05_VIEW_DAN_BLADE_TEMPLATING.md](./05_VIEW_DAN_BLADE_TEMPLATING.md) | UI Dashboard, Blade, dan Tailwind | 25 menit |
| 6 | [06_GIS_DAN_PETA_INTERAKTIF.md](./06_GIS_DAN_PETA_INTERAKTIF.md) | Integrasi Peta dan Data Spasial | 30 menit |
| 7 | [GLOSARIUM.md](./GLOSARIUM.md) | Istilah teknis SPK, Fuzzy, dan Laravel | 10 menit |

**Total estimasi: ±3 jam belajar aktif.**

---

## 🧠 Prasyarat
- **PHP 8.x**: Dasar-dasar OOP dan array.
- **Laravel 10/11**: Paham konsep dasar route dan controller.
- **Logika Matematika**: Dasar-dasar himpunan (untuk memahami Fuzzy).

---

## 💡 Cara Membaca Tutorial Ini
1. **Teori Dulu**: Pahami Bab 2 & 3 agar mengerti "otak" dari sistem ini.
2. **Lihat Struktur**: Pelajari Bab 1 untuk navigasi kode di VS Code.
3. **Praktik**: Gunakan [Coding Tutorial](../coding/CODING_INDEX.md) jika ingin membangun fitur serupa dari awal.

_Simpelaju Tutorial Book — Dokumentasi Teknis Internal._
