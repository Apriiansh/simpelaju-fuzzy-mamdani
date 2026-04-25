<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center py-2">
            <div>
                <h2 class="font-serif font-bold text-2xl text-forest leading-tight">
                    Penilaian & Hasil SPK
                </h2>
                <p class="text-xs text-forest/40 font-bold tracking-widest uppercase mt-1">
                    Rekap Lengkap · Fuzzy Mamdani · Centroid COA
                </p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-8 pb-12">

        {{-- =============================================
             STATS: Rata-rata Skor per Kelurahan
             ============================================= --}}
        @if($statsPerKelurahan->isNotEmpty())
        <div>
            <h3 class="text-[10px] font-black text-forest/40 uppercase tracking-widest mb-4">Rata-rata Skor Crisp per Kelurahan</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($statsPerKelurahan as $stat)
                @php
                    $rata = round($stat->rata_skor, 1);
                    $isLayak = $rata >= 51;
                    $pct = min($rata, 100);
                @endphp
                <div class="bg-white/70 backdrop-blur-sm rounded-2xl border border-premium-border/50 p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <p class="text-[10px] font-black text-forest/40 uppercase tracking-widest">{{ $stat->kelurahan_nama }}</p>
                            <p class="text-3xl font-serif font-extrabold mt-1 {{ $isLayak ? 'text-forest' : 'text-red-600' }}">
                                {{ $rata }}
                            </p>
                        </div>
                        <span class="text-[9px] font-black px-2 py-1 rounded-lg {{ $isLayak ? 'bg-forest/10 text-forest' : 'bg-red-50 text-red-600' }}">
                            {{ $isLayak ? 'LAYAK' : 'TIDAK LAYAK' }}
                        </span>
                    </div>
                    {{-- Progress bar --}}
                    <div class="w-full bg-paper rounded-full h-1.5 mb-3">
                        <div class="h-1.5 rounded-full transition-all duration-700 {{ $isLayak ? 'bg-forest' : 'bg-red-500' }}"
                             style="width: {{ $pct }}%"></div>
                    </div>
                    <div class="flex justify-between text-[9px] font-bold text-forest/40 uppercase tracking-widest">
                        <span>{{ $stat->total_layak }} Layak</span>
                        <span>{{ $stat->total }} Total</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- =============================================
             TABEL DETAIL LENGKAP
             ============================================= --}}
        <div class="bg-white/70 backdrop-blur-sm rounded-2xl border border-premium-border/50 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-premium-border/30 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 rounded-lg bg-premium-amber/10 flex items-center justify-center text-premium-amber">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-serif font-bold text-forest text-sm">Rekap Detail Seluruh Penilaian</h3>
                        <p class="text-[10px] text-forest/40 uppercase tracking-widest font-bold">{{ $penilaian->total() }} Data Tercatat</p>
                    </div>
                </div>
                <div class="text-[10px] text-forest/40 italic">← Geser kanan untuk melihat semua kolom</div>
            </div>

            {{-- Scrollable table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-[11px] text-forest">
                    <thead>
                        {{-- Group header row --}}
                        <tr class="bg-paper/80 border-b border-premium-border/30">
                            <th rowspan="2" class="px-4 py-3 text-left font-black uppercase tracking-widest text-[9px] text-forest/50 border-r border-premium-border/20 sticky left-0 bg-paper/90 z-10 min-w-[200px]">
                                Penduduk
                            </th>
                            {{-- Aspek A --}}
                            <th colspan="3" class="px-4 py-2 text-center font-black uppercase tracking-widest text-[9px] text-red-500 bg-red-50/50 border-r border-red-100">
                                Aspek A — Keselamatan
                            </th>
                            {{-- Aspek B --}}
                            <th colspan="4" class="px-4 py-2 text-center font-black uppercase tracking-widest text-[9px] text-emerald-600 bg-emerald-50/50 border-r border-emerald-100">
                                Aspek B — Kesehatan
                            </th>
                            {{-- Aspek C --}}
                            <th colspan="2" class="px-4 py-2 text-center font-black uppercase tracking-widest text-[9px] text-blue-600 bg-blue-50/50 border-r border-blue-100">
                                Aspek C — Kepadatan
                            </th>
                            {{-- Aspek D --}}
                            <th colspan="6" class="px-4 py-2 text-center font-black uppercase tracking-widest text-[9px] text-amber-600 bg-amber-50/50 border-r border-amber-100">
                                Aspek D — Komponen Material
                            </th>
                            {{-- Skor --}}
                            <th colspan="4" class="px-4 py-2 text-center font-black uppercase tracking-widest text-[9px] text-forest bg-forest/5 border-r border-premium-border/20">
                                Hasil Mamdani
                            </th>
                            {{-- Aksi --}}
                            <th rowspan="2" class="px-4 py-3 text-center font-black uppercase tracking-widest text-[9px] text-forest/50 sticky right-0 bg-paper/90 z-10 min-w-[120px] border-l border-premium-border/20">
                                Aksi
                            </th>
                        </tr>
                        <tr class="bg-paper/50 border-b-2 border-premium-border/40 text-[9px] font-black uppercase tracking-widest text-forest/50">
                            {{-- Aspek A --}}
                            <th class="px-3 py-2 whitespace-nowrap bg-red-50/30 text-red-400">Pondasi</th>
                            <th class="px-3 py-2 whitespace-nowrap bg-red-50/30 text-red-400">Kolom & Balok</th>
                            <th class="px-3 py-2 whitespace-nowrap bg-red-50/30 text-red-400 border-r border-red-100">Konst. Atap</th>
                            {{-- Aspek B --}}
                            <th class="px-3 py-2 whitespace-nowrap bg-emerald-50/30 text-emerald-500">Jendela</th>
                            <th class="px-3 py-2 whitespace-nowrap bg-emerald-50/30 text-emerald-500">Ventilasi</th>
                            <th class="px-3 py-2 whitespace-nowrap bg-emerald-50/30 text-emerald-500">MCK</th>
                            <th class="px-3 py-2 whitespace-nowrap bg-emerald-50/30 text-emerald-500 border-r border-emerald-100">Jarak Air</th>
                            {{-- Aspek C --}}
                            <th class="px-3 py-2 whitespace-nowrap bg-blue-50/30 text-blue-500">Luas (m²)</th>
                            <th class="px-3 py-2 whitespace-nowrap bg-blue-50/30 text-blue-500 border-r border-blue-100">Rasio m²/org</th>
                            {{-- Aspek D --}}
                            <th class="px-3 py-2 whitespace-nowrap bg-amber-50/30 text-amber-500">Mat. Atap</th>
                            <th class="px-3 py-2 whitespace-nowrap bg-amber-50/30 text-amber-500">Mat. Dinding</th>
                            <th class="px-3 py-2 whitespace-nowrap bg-amber-50/30 text-amber-500">Mat. Lantai</th>
                            <th class="px-3 py-2 whitespace-nowrap bg-amber-50/30 text-amber-500">Kond. Atap</th>
                            <th class="px-3 py-2 whitespace-nowrap bg-amber-50/30 text-amber-500">Kond. Dinding</th>
                            <th class="px-3 py-2 whitespace-nowrap bg-amber-50/30 text-amber-500 border-r border-amber-100">Kond. Lantai</th>
                            {{-- Skor --}}
                            <th class="px-3 py-2 whitespace-nowrap text-forest/60">Skor A</th>
                            <th class="px-3 py-2 whitespace-nowrap text-forest/60">Skor B</th>
                            <th class="px-3 py-2 whitespace-nowrap text-forest/60">Skor C</th>
                            <th class="px-3 py-2 whitespace-nowrap text-forest font-black border-r border-premium-border/20">Crisp Z*</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-premium-border/20">
                        @forelse($penilaian as $p)
                        @php
                            $rumah = $p->penduduk->rumah;
                            $hasil = $p->hasilSPK;
                            $penghuni = ($p->penduduk->jumlah_tanggungan ?? 0) + 1;
                            $rasio = $rumah ? round($rumah->luas_bangunan / $penghuni, 1) : '-';

                            // Get per-aspek scores from NilaiKriteria
                            $nilaiMap = $p->nilaiKriteria->keyBy(fn($n) => $n->kriteria->kode ?? $n->kriteria_id);
                            $skorA = $nilaiMap['K1'] ?? $nilaiMap->first(fn($n) => str_contains($n->kriteria->nama ?? '', 'Keselamatan'));
                            $skorB = $nilaiMap['K2'] ?? $nilaiMap->first(fn($n) => str_contains($n->kriteria->nama ?? '', 'Kesehatan'));
                            $skorC = $nilaiMap['K3'] ?? $nilaiMap->first(fn($n) => str_contains($n->kriteria->nama ?? '', 'Kepadatan'));

                            $isLayak = $hasil && $hasil->kategori_kelayakan === 'LAYAK';
                        @endphp
                        <tr class="hover:bg-paper/30 transition-colors {{ $isLayak ? '' : 'bg-red-50/20' }}">
                            {{-- Penduduk info (sticky) --}}
                            <td class="px-4 py-3 sticky left-0 bg-white/90 border-r border-premium-border/20 z-10">
                                <div class="flex items-center space-x-3">
                                    <div class="w-7 h-7 rounded-full bg-forest/10 flex items-center justify-center text-forest font-black text-[10px] flex-shrink-0">
                                        {{ substr($p->penduduk->nama_lengkap, 0, 1) }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-forest leading-tight">{{ $p->penduduk->nama_lengkap }}</p>
                                        <p class="text-[9px] text-forest/40 font-bold tracking-widest uppercase">{{ $p->penduduk->kelurahan->nama ?? '-' }}</p>
                                        <p class="text-[9px] text-forest/30 font-mono">{{ $p->periode }}</p>
                                    </div>
                                </div>
                            </td>

                            {{-- Aspek A --}}
                            @if($rumah)
                            <td class="px-3 py-3 bg-red-50/10 whitespace-nowrap">
                                <span class="px-1.5 py-0.5 rounded text-[9px] font-bold {{ $rumah->pondasi === 'Ada' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $rumah->pondasi }}
                                </span>
                            </td>
                            <td class="px-3 py-3 bg-red-50/10 whitespace-nowrap">
                                <span class="px-1.5 py-0.5 rounded text-[9px] font-bold {{ str_contains($rumah->kolom_balok, 'Baik') ? 'bg-emerald-100 text-emerald-700' : (str_contains($rumah->kolom_balok, 'Berat') ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                                    {{ Str::limit($rumah->kolom_balok, 18) }}
                                </span>
                            </td>
                            <td class="px-3 py-3 bg-red-50/10 whitespace-nowrap border-r border-red-100">
                                <span class="px-1.5 py-0.5 rounded text-[9px] font-bold {{ str_contains($rumah->konstruksi_atap, 'Baik') ? 'bg-emerald-100 text-emerald-700' : (str_contains($rumah->konstruksi_atap, 'Berat') ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                                    {{ Str::limit($rumah->konstruksi_atap, 18) }}
                                </span>
                            </td>

                            {{-- Aspek B --}}
                            <td class="px-3 py-3 bg-emerald-50/10 whitespace-nowrap">
                                <span class="px-1.5 py-0.5 rounded text-[9px] font-bold {{ $rumah->jendela === 'Ada' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $rumah->jendela }}
                                </span>
                            </td>
                            <td class="px-3 py-3 bg-emerald-50/10 whitespace-nowrap">
                                <span class="px-1.5 py-0.5 rounded text-[9px] font-bold {{ $rumah->ventilasi === 'Ada' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                                    {{ $rumah->ventilasi }}
                                </span>
                            </td>
                            <td class="px-3 py-3 bg-emerald-50/10 whitespace-nowrap">
                                <span class="text-[9px] font-bold {{ str_contains($rumah->kamar_mandi, 'Sendiri') ? 'text-emerald-600' : (str_contains($rumah->kamar_mandi, 'Tidak') ? 'text-red-600' : 'text-amber-600') }}">
                                    {{ Str::limit($rumah->kamar_mandi, 14) }}
                                </span>
                            </td>
                            <td class="px-3 py-3 bg-emerald-50/10 whitespace-nowrap border-r border-emerald-100">
                                <span class="text-[9px] font-bold {{ str_contains($rumah->jarak_sumber_air, 'Lebih') ? 'text-emerald-600' : 'text-red-600' }}">
                                    {{ str_contains($rumah->jarak_sumber_air, 'Lebih') ? '✓ Aman' : '✗ Berisiko' }}
                                </span>
                            </td>

                            {{-- Aspek C --}}
                            <td class="px-3 py-3 bg-blue-50/10 whitespace-nowrap text-center font-bold text-blue-700">
                                {{ $rumah->luas_bangunan }} m²
                            </td>
                            <td class="px-3 py-3 bg-blue-50/10 whitespace-nowrap border-r border-blue-100 text-center">
                                <span class="font-bold {{ is_numeric($rasio) && $rasio < 9 ? 'text-red-600' : 'text-blue-700' }}">
                                    {{ $rasio }} m²/org
                                </span>
                            </td>

                            {{-- Aspek D --}}
                            <td class="px-3 py-3 bg-amber-50/10 whitespace-nowrap text-[9px]">{{ Str::limit($rumah->material_atap, 16) }}</td>
                            <td class="px-3 py-3 bg-amber-50/10 whitespace-nowrap text-[9px]">{{ Str::limit($rumah->material_dinding, 16) }}</td>
                            <td class="px-3 py-3 bg-amber-50/10 whitespace-nowrap text-[9px]">{{ Str::limit($rumah->material_lantai, 16) }}</td>
                            <td class="px-3 py-3 bg-amber-50/10 whitespace-nowrap">
                                <span class="text-[9px] font-bold {{ str_contains($rumah->kondisi_atap ?? '', 'Baik') ? 'text-emerald-600' : (str_contains($rumah->kondisi_atap ?? '', 'Berat') ? 'text-red-600' : 'text-amber-600') }}">
                                    {{ Str::limit($rumah->kondisi_atap ?? '-', 14) }}
                                </span>
                            </td>
                            <td class="px-3 py-3 bg-amber-50/10 whitespace-nowrap">
                                <span class="text-[9px] font-bold {{ str_contains($rumah->kondisi_dinding ?? '', 'Baik') ? 'text-emerald-600' : (str_contains($rumah->kondisi_dinding ?? '', 'Berat') ? 'text-red-600' : 'text-amber-600') }}">
                                    {{ Str::limit($rumah->kondisi_dinding ?? '-', 14) }}
                                </span>
                            </td>
                            <td class="px-3 py-3 bg-amber-50/10 whitespace-nowrap border-r border-amber-100">
                                <span class="text-[9px] font-bold {{ str_contains($rumah->kondisi_lantai ?? '', 'Baik') ? 'text-emerald-600' : (str_contains($rumah->kondisi_lantai ?? '', 'Berat') ? 'text-red-600' : 'text-amber-600') }}">
                                    {{ Str::limit($rumah->kondisi_lantai ?? '-', 14) }}
                                </span>
                            </td>
                            @else
                            <td colspan="15" class="px-4 py-3 text-center text-forest/30 italic text-[10px] border-r border-premium-border/20">
                                — Data rumah belum diinput —
                            </td>
                            @endif

                            {{-- Skor per aspek (dari NilaiKriteria) --}}
                            <td class="px-3 py-3 text-center text-[10px] font-mono">
                                {{ $skorA ? number_format($skorA->nilai_input, 3) : '—' }}
                            </td>
                            <td class="px-3 py-3 text-center text-[10px] font-mono">
                                {{ $skorB ? number_format($skorB->nilai_input, 3) : '—' }}
                            </td>
                            <td class="px-3 py-3 text-center text-[10px] font-mono">
                                {{ $skorC ? number_format($skorC->nilai_input, 3) : '—' }}
                            </td>

                            {{-- Skor Crisp (Defuzzifikasi) --}}
                            <td class="px-3 py-3 text-center">
                                @if($hasil)
                                <div class="flex flex-col items-center space-y-1">
                                    <span class="text-sm font-serif font-extrabold {{ $isLayak ? 'text-forest' : 'text-red-600' }}">
                                        {{ number_format($hasil->nilai_defuzzifikasi, 2) }}
                                    </span>
                                    <span class="px-2 py-0.5 rounded-full text-[8px] font-black tracking-widest {{ $isLayak ? 'bg-forest text-cream' : 'bg-red-600 text-white' }}">
                                        {{ $hasil->kategori_kelayakan }}
                                    </span>
                                </div>
                                @else
                                <span class="text-forest/20 text-[9px] italic">—</span>
                                @endif
                            </td>

                            {{-- Tombol Aksi --}}
                            <td class="px-3 py-3 sticky right-0 bg-white/95 border-l border-premium-border/20 z-10">
                                <div class="flex flex-col gap-1.5 items-center">
                                    {{-- Lihat Detail --}}
                                    <a href="{{ route('penduduk.show', $p->penduduk) }}"
                                       title="Lihat Detail Penduduk"
                                       class="w-full flex items-center justify-center gap-1.5 px-2 py-1.5 rounded-lg bg-forest/10 hover:bg-forest text-forest hover:text-cream text-[9px] font-black uppercase tracking-widest transition-all duration-200 group">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        Detail
                                    </a>

                                    @if($rumah)
                                    {{-- Edit Rumah --}}
                                    <a href="{{ route('rumah.edit', $rumah) }}"
                                       title="Edit Data Rumah"
                                       class="w-full flex items-center justify-center gap-1.5 px-2 py-1.5 rounded-lg bg-amber-50 hover:bg-amber-500 text-amber-600 hover:text-white text-[9px] font-black uppercase tracking-widest transition-all duration-200">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                        Rumah
                                    </a>

                                    {{-- Recalculate --}}
                                    <form action="{{ route('rumah.recalculate', $rumah) }}" method="POST" class="w-full">
                                        @csrf
                                        <button type="submit"
                                                title="Hitung Ulang Fuzzy Mamdani"
                                                class="w-full flex items-center justify-center gap-1.5 px-2 py-1.5 rounded-lg bg-forest/5 hover:bg-forest text-forest/60 hover:text-cream text-[9px] font-black uppercase tracking-widest transition-all duration-200 group">
                                            <svg class="w-3 h-3 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                            Hitung
                                        </button>
                                    </form>
                                    @else
                                    {{-- Input Rumah --}}
                                    <a href="{{ route('rumah.create', ['penduduk_id' => $p->penduduk->id]) }}"
                                       title="Input Data Rumah"
                                       class="w-full flex items-center justify-center gap-1.5 px-2 py-1.5 rounded-lg bg-red-50 hover:bg-red-500 text-red-500 hover:text-white text-[9px] font-black uppercase tracking-widest transition-all duration-200">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                        Input Rumah
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="21" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center text-forest/30">
                                    <svg class="w-10 h-10 mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <p class="font-serif italic text-sm">Belum ada data penilaian.</p>
                                    <p class="text-[10px] mt-1 uppercase tracking-widest">Input data rumah penduduk untuk memulai penilaian.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($penilaian->hasPages())
            <div class="px-6 py-4 border-t border-premium-border/30">
                {{ $penilaian->links() }}
            </div>
            @endif
        </div>

        {{-- Legend --}}
        <div class="flex flex-wrap gap-4 text-[10px] font-bold uppercase tracking-widest text-forest/40">
            <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded bg-emerald-500"></span> Baik / Aman</span>
            <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded bg-amber-400"></span> Sedang / Perlu Perhatian</span>
            <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded bg-red-500"></span> Buruk / Tidak Layak</span>
            <span class="flex items-center gap-1.5 ml-auto text-forest/60">Skor Crisp Z* = Nilai Defuzzifikasi Centroid (COA) · Threshold LAYAK ≥ 50</span>
        </div>
    </div>
</x-app-layout>
