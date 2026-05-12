# Workflow Verifikasi Multi-Step RTLH (REVISED)

Implementasi workflow verifikasi multi-step untuk memastikan integritas data dan pemisahan wewenang yang jelas antara Kelurahan (Input), Admin Kecamatan (Verifikasi), dan Camat (Validasi).

## 🔄 **Workflow Baru (Corrected)**

### **1. Operator Lurah (Input & Pengajuan)**
- **Input Data:** Operator input data penduduk & rumah.
- **Status Awal:** `verifikasi_status` = "draft".
- **TANPA Perhitungan:** Pada tahap ini, mesin Fuzzy **BELUM** dijalankan.
- **Kirim Data:** Operator klik "Kirim" → Update `verifikasi_status` = "dikirim".
- **Revisi:** Jika status "dikembalikan", Operator memperbaiki data berdasarkan `catatan_revisi` lalu mengirim ulang.

### **2. Admin Camat (Verifikasi & Filter)**
- **Review:** Admin memeriksa kelayakan data yang masuk (status "dikirim").
- **Keputusan A:** **"Kembalikan"** → Status = "dikembalikan" + Isi `catatan_revisi`.
- **Keputusan B:** **"Terima/Verifikasi"** → Status = "terverifikasi".
- **🚀 TRIGGER FUZZY:** Hanya saat status berubah menjadi **"terverifikasi"**, sistem menjalankan `MamdaniEngine` untuk menghasilkan `hasil_spk`.

### **3. Camat (Validasi & Finalisasi)**
- **Review Ranking:** Camat melihat daftar perankingan yang sudah dihitung (status "terverifikasi").
- **Validasi:** Camat klik "Validasi" → Update `verifikasi_status` = "valid" + `tanggal_validasi`.
- **Lock Data:** Data yang sudah "valid" terkunci secara sistem (tidak bisa diedit/dihapus).

## 🛠️ **Perubahan Kode yang Diperlukan**

### **1. PenilaianController@store**
- Hapus trigger `$this->fuzzyEngine->calculate($penilaian)`.
- Set default `verifikasi_status` ke "draft".

### **2. PenilaianController@verifikasi**
- Tambahkan logika: Jika status diupdate ke "terverifikasi", maka jalankan `$this->fuzzyEngine->calculate($penilaian)`.

### **3. PenilaianController@validasi**
- Pastikan hanya data dengan status "terverifikasi" yang bisa divalidasi.
- Set `tanggal_validasi`.

### **4. UI Updates**
- Dashboard Admin Camat: Tombol "Verifikasi" & "Kembalikan".
- Dashboard Camat: Tombol "Validasi".
- Proteksi tombol "Edit" & "Hapus": Hanya muncul jika status "draft" atau "dikembalikan".

## 📊 **Status Map**
| Status | Deskripsi | Aktor Selanjutnya |
| :--- | :--- | :--- |
| `draft` | Baru diinput | Operator Lurah |
| `dikirim` | Menunggu verifikasi | Admin Camat |
| `dikembalikan` | Perlu revisi | Operator Lurah |
| `terverifikasi` | Sudah dihitung Fuzzy | Camat |
| `valid` | Selesai & Terkunci | (Final) |
