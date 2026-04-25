<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Prioritas RTLH</title>
    <style>
        @page { margin: 1cm 1.5cm; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; font-size: 11pt; color: #111; line-height: 1.3; }
        
        .kop-surat { width: 100%; border-bottom: 3px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .kop-surat table { width: 100%; border: none; }
        .kop-surat td { vertical-align: middle; border: none; }
        .logo-cell { width: 80px; text-align: left; }
        .logo-cell img { width: 75px; height: auto; }
        .header-text { text-align: center; padding-right: 80px; /* Balance the logo width */ }
        
        h1, h2, h3, h4, p { margin: 0; padding: 2px 0; }
        h1 { font-size: 18pt; font-weight: bold; }
        h2 { font-size: 14pt; font-weight: normal; }
        p.alamat { font-size: 9pt; font-style: italic; margin-top: 5px; }
        
        .title { text-align: center; margin-bottom: 20px; margin-top: 10px; }
        .title h3 { text-transform: uppercase; text-decoration: underline; font-size: 13pt; }
        .title p { font-size: 10pt; font-weight: bold; }
        
        .filter-info { margin-bottom: 10px; font-size: 9pt; }
        
        .table { width: 100%; border-collapse: collapse; margin-bottom: 30px; font-size: 9pt; }
        .table th, .table td { border: 1px solid #000; padding: 6px; vertical-align: middle; }
        .table th { background-color: #e2e8f0; text-align: center; font-weight: bold; text-transform: uppercase; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        
        .signature { width: 100%; margin-top: 40px; page-break-inside: avoid; }
        .signature td { width: 50%; text-align: center; border: none; }
        .signature-name { text-decoration: underline; font-weight: bold; margin-top: 70px; display: inline-block; }
    </style>
</head>
<body>

    <div class="kop-surat">
        <table>
            <tr>
                <td class="logo-cell">
                    {{-- Menggunakan base64 SVG jika ada logo_dinas.svg, tapi fallback ke teks jika gagal render --}}
                    @if(file_exists(public_path('logo_dinas.svg')))
                        <img src="{{ public_path('logo_dinas.svg') }}" alt="Logo">
                    @endif
                </td>
                <td class="header-text">
                    <h2>PEMERINTAH KOTA PALEMBANG</h2>
                    <h1>DINAS PERUMAHAN RAKYAT DAN KAWASAN PERMUKIMAN</h1>
                    <p class="alamat">Jl. Merdeka No. 1, 22 Ilir, Bukit Kecil, Kota Palembang, Sumatera Selatan 30113</p>
                    <p class="alamat" style="margin-top: 0;">Email: disperkim@palembang.go.id | Website: palembang.go.id</p>
                </td>
            </tr>
        </table>
    </div>

    <div class="title">
        <h3>Laporan Daftar Prioritas Penerima Bantuan RTLH</h3>
        <p>Tahun Anggaran {{ date('Y') }}</p>
    </div>

    @if(!empty($filters))
    <div class="filter-info">
        <strong>Filter Diterapkan:</strong> 
        @foreach($filters as $key => $value)
            <span style="margin-right: 15px;">{{ ucfirst($key) }}: {{ $value }}</span>
        @endforeach
    </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">NIK</th>
                <th width="25%">Nama Lengkap</th>
                <th width="15%">Kelurahan</th>
                <th width="15%">Status Kelayakan</th>
                <th width="10%">Skor Z*</th>
                <th width="15%">Rekomendasi / Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporan as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ $item->penilaian->penduduk->nik }}</td>
                <td class="font-bold">{{ $item->penilaian->penduduk->nama_lengkap }}</td>
                <td class="text-center">{{ $item->penilaian->penduduk->kelurahan->nama ?? '-' }}</td>
                <td class="text-center font-bold">
                    {{ str_replace('_', ' ', $item->kategori_kelayakan) }}
                </td>
                <td class="text-center font-bold">{{ number_format($item->nilai_defuzzifikasi, 2) }}</td>
                <td style="font-size: 8pt;">{{ $item->rekomendasi }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada data yang ditemukan berdasarkan filter yang dipilih.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <table class="signature">
        <tr>
            <td></td>
            <td>
                Palembang, {{ \Carbon\Carbon::now()->locale('id')->isoFormat('D MMMM YYYY') }}<br>
                Mengetahui,<br>
                <strong>Kepala Dinas Perkim Kota Palembang</strong><br>
                <br>
                <br>
                <br>
                <span class="signature-name">Ir. H. Affan Prapanca, MT</span><br>
                NIP. 19700101 199503 1 001
            </td>
        </tr>
    </table>

</body>
</html>
