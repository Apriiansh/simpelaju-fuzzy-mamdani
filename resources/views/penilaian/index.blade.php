<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center py-2">
            <div>
                <h2 class="font-serif font-bold text-2xl text-forest leading-tight">
                    @if(Auth::user()->role === 'admin')
                        Verifikasi Usulan RTLH
                    @elseif(Auth::user()->role === 'camat')
                        Validasi Rekomendasi
                    @else
                        Penilaian & Hasil SPK
                    @endif
                </h2>
                <p class="text-xs text-forest/40 font-bold tracking-widest uppercase mt-1">
                    @if(Auth::user()->role === 'admin')
                        Review Kelayakan Data · Verifikasi Kecamatan
                    @elseif(Auth::user()->role === 'camat')
                        Pengesahan Akhir · Penentuan Penerima Bantuan
                    @else
                        Rekap Lengkap · Fuzzy Mamdani · Centroid COA
                    @endif
                </p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-8 pb-12" x-data="{
        layout: localStorage.getItem('penilaian_layout') || 'table',
        setLayout(val) {
            this.layout = val;
            localStorage.setItem('penilaian_layout', val);
        }
    }">

        {{-- ============================================================ --}}
        {{-- INFO BANNER PER ROLE                                         --}}
        {{-- ============================================================ --}}
        @if(auth()->user()->role === 'admin')
        <div class="bg-amber-50 border border-amber-200 rounded-[2rem] p-4 flex items-center shadow-sm">
            <div class="w-12 h-12 bg-amber-100 rounded-2xl flex items-center justify-center text-amber-600 mr-5 shrink-0 shadow-inner">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg>
            </div>
            <div>
                <p class="text-sm text-amber-700/80 font-medium leading-relaxed">Berikut adalah daftar usulan dari operator kelurahan yang perlu diverifikasi. Tekan tombol <span class="font-bold text-emerald-600 italic">Verifikasi</span> untuk menyetujui atau <span class="font-bold text-red-600 italic">Kembalikan</span> jika data belum sesuai atau perlu revisi.</p>
            </div>
        </div>
        @elseif(auth()->user()->role === 'camat')
        <div class="bg-forest/5 border border-forest/10 rounded-[2rem] p-4 flex items-center shadow-sm">
            <div class="w-12 h-12 bg-forest/10 rounded-2xl flex items-center justify-center text-forest mr-5 shrink-0 shadow-inner">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" /></svg>
            </div>
            <div>
                <p class="text-sm text-forest/70 font-medium leading-relaxed">Data Rekomendasi penerima bantuan telah siap. Silahkan tinjau hasil penilaian Fuzzy Mamdani dan lakukan <span class="font-bold text-forest italic uppercase">Pengesahan (Validasi)</span> untuk menetapkan penerima bantuan.</p>
            </div>
        </div>
        @endif

        {{-- ============================================================ --}}
        {{-- STATS PER KELURAHAN                                          --}}
        {{-- ============================================================ --}}
        @if($statsPerKelurahan->isNotEmpty() && Auth::user()->role !== 'operator')
        <div>
            <h3 class="text-[10px] font-black text-forest/40 uppercase tracking-widest mb-4">Rata-rata Skor Crisp per Kelurahan</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($statsPerKelurahan as $stat)
                @php
                    $isLayak = $stat->rata_skor >= 50;
                    $rata = round($stat->rata_skor, 1);
                    $pct = min($rata, 100);
                @endphp
                <div class="bg-white/70 backdrop-blur-sm rounded-2xl border border-premium-border/50 p-6 shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <p class="text-[10px] font-black text-forest/40 uppercase tracking-widest">{{ $stat->kelurahan_nama }}</p>
                            <p class="text-3xl font-serif font-extrabold mt-1 {{ $isLayak ? 'text-forest' : 'text-red-600' }}">{{ $rata }}</p>
                        </div>
                        <span class="text-[9px] font-black px-2 py-1 rounded-lg {{ $isLayak ? 'bg-forest/10 text-forest' : 'bg-red-50 text-red-600' }}">
                            {{ $isLayak ? 'LAYAK' : 'TDK LAYAK' }}
                        </span>
                    </div>
                    <div class="w-full bg-paper rounded-full h-1.5 mb-3">
                        <div class="h-1.5 rounded-full transition-all duration-700 {{ $isLayak ? 'bg-forest' : 'bg-red-500' }}" style="width: {{ $pct }}%"></div>
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

        {{-- ============================================================ --}}
        {{-- FILTER STATUS                                                 --}}
        {{-- ============================================================ --}}
        @if(auth()->user()->role !== 'operator')
        <div class="flex flex-col space-y-4">
            <h3 class="text-[10px] font-black text-forest/40 uppercase tracking-[0.2em]">Filter Status Alur Kerja</h3>
            <div class="flex flex-wrap gap-2">
                @php
                    $currentStatus = request('status');
                    $availableStatuses = [];
                    if(auth()->user()->role === 'admin') {
                        $availableStatuses = [
                            'dikirim'      => ['label' => 'Menunggu Verifikasi'],
                            'dikembalikan' => ['label' => 'Perlu Revisi'],
                            'terverifikasi'=> ['label' => 'Terverifikasi'],
                            'valid'        => ['label' => 'Disahkan (Valid)'],
                        ];
                    } elseif(auth()->user()->role === 'camat') {
                        $availableStatuses = [
                            'terverifikasi' => ['label' => 'Menunggu Validasi'],
                            'valid'         => ['label' => 'Disahkan (Valid)'],
                        ];
                    }
                @endphp
                <a href="{{ route('penilaian.index') }}"
                   class="px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all duration-300 border {{ !$currentStatus ? 'bg-forest text-cream border-forest shadow-lg shadow-forest/20' : 'bg-white text-forest/40 border-premium-border hover:border-forest/30 hover:text-forest' }}">
                   Semua Data
                </a>
                @foreach($availableStatuses as $statusKey => $cfg)
                    <a href="{{ route('penilaian.index', ['status' => $statusKey]) }}"
                       class="px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all duration-300 border flex items-center {{ $currentStatus === $statusKey ? 'bg-forest text-cream border-forest shadow-lg shadow-forest/20' : 'bg-white text-forest/40 border-premium-border hover:border-forest/30 hover:text-forest' }}">
                       <span class="mr-2">{{ $cfg['label'] }}</span>
                       @if($currentStatus === $statusKey)
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                       @endif
                    </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- ============================================================ --}}
        {{-- PANEL UTAMA — Header dengan Toggle Layout                    --}}
        {{-- ============================================================ --}}
        <div class="bg-white/70 backdrop-blur-sm rounded-2xl border border-premium-border/50 shadow-sm overflow-hidden">

            {{-- Header panel --}}
            <div class="px-6 py-4 border-b border-premium-border/30 flex items-center justify-between gap-4">
                <div class="flex items-center space-x-3 min-w-0">
                    <div class="w-8 h-8 rounded-lg bg-premium-amber/10 flex items-center justify-center text-premium-amber flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <h3 class="font-serif font-bold text-forest text-sm truncate">
                            @if(Auth::user()->role === 'admin')
                                @if(isset($currentStatus) && $currentStatus === 'dikirim') Antrian Verifikasi Usulan @else Daftar Penilaian Kecamatan @endif
                            @elseif(Auth::user()->role === 'camat')
                                @if(isset($currentStatus) && $currentStatus === 'terverifikasi') Antrian Validasi Rekomendasi @else Arsip Validasi @endif
                            @else
                                Rekap Detail Seluruh Penilaian
                            @endif
                        </h3>
                        <p class="text-[10px] text-forest/40 uppercase tracking-widest font-bold">{{ $penilaian->total() }} Data Tercatat</p>
                    </div>
                </div>

                <div class="flex items-center gap-3 flex-shrink-0">
                    {{-- Hitung Massal (Admin) --}}
                    @if(Auth::user()->role === 'admin')
                    <form action="{{ route('penilaian.hitung-massal') }}" method="POST" onsubmit="return confirm('Sistem akan memproses ulang seluruh data rumah penduduk menggunakan aturan fuzzy. Lanjutkan?')">
                        @csrf
                        <button type="submit" title="Hitung Ulang Massal" class="bg-forest/5 hover:bg-forest text-forest hover:text-cream px-3 py-2 rounded-xl border border-forest/20 text-[9px] font-black uppercase tracking-widest transition-all duration-300 flex items-center group">
                            <svg class="w-3.5 h-3.5 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        </button>
                    </form>
                    @endif

                    {{-- TOGGLE LAYOUT BUTTON --}}
                    <div class="flex items-center bg-paper/60 rounded-xl border border-premium-border/50 p-1 gap-1">
                        {{-- Table mode --}}
                        <button
                            @click="setLayout('table')"
                            :class="layout === 'table' ? 'bg-forest text-cream shadow-md shadow-forest/20' : 'text-forest/40 hover:text-forest'"
                            class="p-2 rounded-lg transition-all duration-200"
                            title="Tampilan Tabel">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 6h18M3 14h18M3 18h18"/>
                            </svg>
                        </button>
                        {{-- Grid mode --}}
                        <button
                            @click="setLayout('grid')"
                            :class="layout === 'grid' ? 'bg-forest text-cream shadow-md shadow-forest/20' : 'text-forest/40 hover:text-forest'"
                            class="p-2 rounded-lg transition-all duration-200"
                            title="Tampilan Grid Kartu">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Filter Bar --}}
            <div class="px-6 py-4 bg-paper/50 border-b border-premium-border/30">
                <form action="{{ route('penilaian.index') }}" method="GET" class="flex flex-wrap items-end gap-4">
                    {{-- Preserve existing status filter if any --}}
                    @if(request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif

                    {{-- Search --}}
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-[10px] font-black text-forest/40 uppercase tracking-widest mb-1.5 ml-1">Pencarian</label>
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Cari Nama atau NIK..."
                                   class="w-full pl-9 pr-4 py-2 bg-white border border-premium-border/50 rounded-xl text-xs focus:ring-2 focus:ring-premium-amber/20 focus:border-premium-amber transition-all">
                            <svg class="w-4 h-4 absolute left-3 top-2.5 text-forest/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                    </div>

                    {{-- Kelurahan (Admin/Camat only) --}}
                    @if(Auth::user()->role !== 'operator')
                    <div class="w-full md:w-48">
                        <label class="block text-[10px] font-black text-forest/40 uppercase tracking-widest mb-1.5 ml-1">Kelurahan</label>
                        <select name="kelurahan_id" class="w-full px-3 py-2 bg-white border border-premium-border/50 rounded-xl text-xs focus:ring-2 focus:ring-premium-amber/20 focus:border-premium-amber transition-all">
                            <option value="">Semua Kelurahan</option>
                            @foreach($kelurahans as $k)
                                <option value="{{ $k->id }}" {{ request('kelurahan_id') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    {{-- Status Layak --}}
                    <div class="w-full md:w-48">
                        <label class="block text-[10px] font-black text-forest/40 uppercase tracking-widest mb-1.5 ml-1">Status Kelayakan</label>
                        <select name="layak_status" class="w-full px-3 py-2 bg-white border border-premium-border/50 rounded-xl text-xs focus:ring-2 focus:ring-premium-amber/20 focus:border-premium-amber transition-all">
                            <option value="">Semua Status</option>
                            <option value="LAYAK" {{ request('layak_status') === 'LAYAK' ? 'selected' : '' }}>BERHAK (LAYAK)</option>
                            <option value="TIDAK_LAYAK" {{ request('layak_status') === 'TIDAK_LAYAK' ? 'selected' : '' }}>TIDAK LAYAK</option>
                        </select>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex items-center gap-2">
                        <button type="submit" class="px-4 py-2 bg-forest text-white rounded-xl text-xs font-bold hover:bg-forest/90 transition-all shadow-sm flex items-center gap-2">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                            </svg>
                            Filter
                        </button>
                        @if(request()->anyFilled(['search', 'kelurahan_id', 'layak_status']))
                        <a href="{{ route('penilaian.index', request()->only('status')) }}" class="px-4 py-2 bg-forest/5 text-forest rounded-xl text-xs font-bold hover:bg-forest/10 transition-all flex items-center gap-2">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Reset
                        </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- ========================================================== --}}
            {{-- MODE TABLE                                                  --}}
            {{-- ========================================================== --}}
            <div x-show="layout === 'table'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-[11px] text-forest">
                        <thead>
                            <tr class="bg-paper/80 border-b border-premium-border/30">
                                <th rowspan="2" class="px-4 py-3 text-left font-black uppercase tracking-widest text-[9px] text-forest/50 border-r border-premium-border/20 sticky left-0 bg-paper/90 z-10 min-w-[200px]">
                                    Penduduk
                                </th>
                                <th colspan="3" class="px-4 py-2 text-center font-black uppercase tracking-widest text-[9px] text-red-500 bg-red-50/50 border-r border-red-100">
                                    Aspek A — Keselamatan
                                </th>
                                <th colspan="4" class="px-4 py-2 text-center font-black uppercase tracking-widest text-[9px] text-emerald-600 bg-emerald-50/50 border-r border-emerald-100">
                                    Aspek B — Kesehatan
                                </th>
                                <th colspan="2" class="px-4 py-2 text-center font-black uppercase tracking-widest text-[9px] text-blue-600 bg-blue-50/50 border-r border-blue-100">
                                    Aspek C — Kepadatan
                                </th>
                                <th colspan="6" class="px-4 py-2 text-center font-black uppercase tracking-widest text-[9px] text-amber-600 bg-amber-50/50 border-r border-amber-100">
                                    Aspek D — Komponen Material
                                </th>
                                @if(Auth::user()->role !== 'operator')
                                <th colspan="5" class="px-4 py-2 text-center font-black uppercase tracking-widest text-[9px] text-forest bg-forest/5 border-r border-premium-border/20">
                                    Hasil Mamdani
                                </th>
                                @endif
                                <th rowspan="2" class="px-4 py-3 text-center font-black uppercase tracking-widest text-[9px] text-forest/50 border-r border-premium-border/20">
                                    Status
                                </th>
                                <th rowspan="2" class="px-4 py-3 text-center font-black uppercase tracking-widest text-[9px] text-forest/50 sticky right-0 bg-paper/90 z-10 min-w-[120px] border-l border-premium-border/20">
                                    Aksi
                                </th>
                            </tr>
                            <tr class="bg-paper/50 border-b-2 border-premium-border/40 text-[9px] font-black uppercase tracking-widest text-forest/50">
                                <th class="px-3 py-2 whitespace-nowrap bg-red-50/30 text-red-400">Pondasi</th>
                                <th class="px-3 py-2 whitespace-nowrap bg-red-50/30 text-red-400">Kolom & Balok</th>
                                <th class="px-3 py-2 whitespace-nowrap bg-red-50/30 text-red-400 border-r border-red-100">Konst. Atap</th>
                                <th class="px-3 py-2 whitespace-nowrap bg-emerald-50/30 text-emerald-500">Jendela</th>
                                <th class="px-3 py-2 whitespace-nowrap bg-emerald-50/30 text-emerald-500">Ventilasi</th>
                                <th class="px-3 py-2 whitespace-nowrap bg-emerald-50/30 text-emerald-500">MCK</th>
                                <th class="px-3 py-2 whitespace-nowrap bg-emerald-50/30 text-emerald-500 border-r border-emerald-100">Jarak Air</th>
                                <th class="px-3 py-2 whitespace-nowrap bg-blue-50/30 text-blue-500">Luas (m²)</th>
                                <th class="px-3 py-2 whitespace-nowrap bg-blue-50/30 text-blue-500 border-r border-blue-100">Rasio m²/org</th>
                                <th class="px-3 py-2 whitespace-nowrap bg-amber-50/30 text-amber-500">Mat. Atap</th>
                                <th class="px-3 py-2 whitespace-nowrap bg-amber-50/30 text-amber-500">Mat. Dinding</th>
                                <th class="px-3 py-2 whitespace-nowrap bg-amber-50/30 text-amber-500">Mat. Lantai</th>
                                <th class="px-3 py-2 whitespace-nowrap bg-amber-50/30 text-amber-500">Kond. Atap</th>
                                <th class="px-3 py-2 whitespace-nowrap bg-amber-50/30 text-amber-500">Kond. Dinding</th>
                                <th class="px-3 py-2 whitespace-nowrap bg-amber-50/30 text-amber-500 border-r border-amber-100">Kond. Lantai</th>
                                @if(Auth::user()->role !== 'operator')
                                <th class="px-3 py-2 whitespace-nowrap text-forest/60">Skor A</th>
                                <th class="px-3 py-2 whitespace-nowrap text-forest/60">Skor B</th>
                                <th class="px-3 py-2 whitespace-nowrap text-forest/60">Skor C</th>
                                <th class="px-3 py-2 whitespace-nowrap text-forest/60">Skor D</th>
                                <th class="px-3 py-2 whitespace-nowrap text-forest font-black border-r border-premium-border/20">Crisp Z*</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-premium-border/20">
                            @forelse($penilaian as $p)
                            @php
                                $rumah = $p->penduduk->rumah;
                                $hasil = $p->hasilSPK;
                                $penghuni = ($p->penduduk->jumlah_tanggungan ?? 0) + 1;
                                $rasio = $rumah ? round($rumah->luas_bangunan / $penghuni, 1) : '-';
                                $nilaiMap = $p->nilaiKriteria->keyBy(fn($n) => $n->kriteria->kode ?? $n->kriteria_id);
                                $skorA = $nilaiMap['K1'] ?? $nilaiMap->first(fn($n) => str_contains($n->kriteria->nama ?? '', 'Keselamatan'));
                                $skorB = $nilaiMap['K2'] ?? $nilaiMap->first(fn($n) => str_contains($n->kriteria->nama ?? '', 'Kesehatan'));
                                $skorC = $nilaiMap['K3'] ?? $nilaiMap->first(fn($n) => str_contains($n->kriteria->nama ?? '', 'Kepadatan'));
                                $skorD = $nilaiMap['K4'] ?? $nilaiMap->first(fn($n) => str_contains($n->kriteria->nama ?? '', 'Komponen'));
                                $isLayak = $hasil && $hasil->kategori_kelayakan === 'LAYAK';
                            @endphp
                            <tr class="hover:bg-paper/30 transition-colors {{ (Auth::user()->role !== 'operator' && !$isLayak) ? 'bg-red-50/20' : '' }}">
                                <td class="px-4 py-3 sticky left-0 bg-white/90 border-r border-premium-border/20 z-10">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-7 h-7 rounded-full bg-forest/10 flex items-center justify-center text-forest font-black text-[10px] flex-shrink-0">
                                            {{ substr($p->penduduk->nama_lengkap, 0, 1) }}
                                        </div>
                                        <div>
                                            <a href="{{ route('penduduk.show', $p->penduduk) }}" class="font-bold text-forest leading-tight hover:text-amber transition-colors">
                                                {{ $p->penduduk->nama_lengkap }}
                                            </a>
                                            <p class="text-[9px] text-forest/40 font-bold tracking-widest uppercase">{{ $p->penduduk->kelurahan->nama ?? '-' }}</p>
                                            <p class="text-[9px] text-forest/30 font-mono">{{ $p->periode }}</p>
                                        </div>
                                    </div>
                                </td>

                                @if($rumah)
                                {{-- Aspek A --}}
                                <td class="px-3 py-3 bg-red-50/10 whitespace-nowrap">
                                    <span class="px-1.5 py-0.5 rounded text-[9px] font-bold {{ $rumah->pondasi === 'Ada' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">{{ $rumah->pondasi }}</span>
                                </td>
                                <td class="px-3 py-3 bg-red-50/10 whitespace-nowrap">
                                    <span class="px-1.5 py-0.5 rounded text-[9px] font-bold {{ str_contains($rumah->kolom_balok, 'Baik') ? 'bg-emerald-100 text-emerald-700' : (str_contains($rumah->kolom_balok, 'Berat') ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">{{ Str::limit($rumah->kolom_balok, 18) }}</span>
                                </td>
                                <td class="px-3 py-3 bg-red-50/10 whitespace-nowrap border-r border-red-100">
                                    <span class="px-1.5 py-0.5 rounded text-[9px] font-bold {{ str_contains($rumah->konstruksi_atap, 'Baik') ? 'bg-emerald-100 text-emerald-700' : (str_contains($rumah->konstruksi_atap, 'Berat') ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">{{ Str::limit($rumah->konstruksi_atap, 18) }}</span>
                                </td>
                                {{-- Aspek B --}}
                                <td class="px-3 py-3 bg-emerald-50/10 whitespace-nowrap">
                                    <span class="px-1.5 py-0.5 rounded text-[9px] font-bold {{ $rumah->jendela === 'Ada' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">{{ $rumah->jendela }}</span>
                                </td>
                                <td class="px-3 py-3 bg-emerald-50/10 whitespace-nowrap">
                                    <span class="px-1.5 py-0.5 rounded text-[9px] font-bold {{ $rumah->ventilasi === 'Ada' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">{{ $rumah->ventilasi }}</span>
                                </td>
                                <td class="px-3 py-3 bg-emerald-50/10 whitespace-nowrap">
                                    <span class="text-[9px] font-bold {{ str_contains($rumah->kamar_mandi, 'Sendiri') ? 'text-emerald-600' : (str_contains($rumah->kamar_mandi, 'Tidak') ? 'text-red-600' : 'text-amber-600') }}">{{ Str::limit($rumah->kamar_mandi, 14) }}</span>
                                </td>
                                <td class="px-3 py-3 bg-emerald-50/10 whitespace-nowrap border-r border-emerald-100">
                                    <span class="text-[9px] font-bold {{ str_contains($rumah->jarak_sumber_air, 'Lebih') ? 'text-emerald-600' : 'text-red-600' }}">{{ str_contains($rumah->jarak_sumber_air, 'Lebih') ? '✓ Aman' : '✗ Berisiko' }}</span>
                                </td>
                                {{-- Aspek C --}}
                                <td class="px-3 py-3 bg-blue-50/10 whitespace-nowrap text-center font-bold text-blue-700">{{ $rumah->luas_bangunan }} m²</td>
                                <td class="px-3 py-3 bg-blue-50/10 whitespace-nowrap border-r border-blue-100 text-center">
                                    <span class="font-bold {{ is_numeric($rasio) && $rasio < 9 ? 'text-red-600' : 'text-blue-700' }}">{{ $rasio }} m²/org</span>
                                </td>
                                {{-- Aspek D --}}
                                <td class="px-3 py-3 bg-amber-50/10 whitespace-nowrap text-[9px]">{{ Str::limit($rumah->material_atap, 16) }}</td>
                                <td class="px-3 py-3 bg-amber-50/10 whitespace-nowrap text-[9px]">{{ Str::limit($rumah->material_dinding, 16) }}</td>
                                <td class="px-3 py-3 bg-amber-50/10 whitespace-nowrap text-[9px]">{{ Str::limit($rumah->material_lantai, 16) }}</td>
                                <td class="px-3 py-3 bg-amber-50/10 whitespace-nowrap">
                                    <span class="text-[9px] font-bold {{ str_contains($rumah->kondisi_atap ?? '', 'Baik') ? 'text-emerald-600' : (str_contains($rumah->kondisi_atap ?? '', 'Berat') ? 'text-red-600' : 'text-amber-600') }}">{{ Str::limit($rumah->kondisi_atap ?? '-', 14) }}</span>
                                </td>
                                <td class="px-3 py-3 bg-amber-50/10 whitespace-nowrap">
                                    <span class="text-[9px] font-bold {{ str_contains($rumah->kondisi_dinding ?? '', 'Baik') ? 'text-emerald-600' : (str_contains($rumah->kondisi_dinding ?? '', 'Berat') ? 'text-red-600' : 'text-amber-600') }}">{{ Str::limit($rumah->kondisi_dinding ?? '-', 14) }}</span>
                                </td>
                                <td class="px-3 py-3 bg-amber-50/10 whitespace-nowrap border-r border-amber-100">
                                    <span class="text-[9px] font-bold {{ str_contains($rumah->kondisi_lantai ?? '', 'Baik') ? 'text-emerald-600' : (str_contains($rumah->kondisi_lantai ?? '', 'Berat') ? 'text-red-600' : 'text-amber-600') }}">{{ Str::limit($rumah->kondisi_lantai ?? '-', 14) }}</span>
                                </td>
                                @else
                                <td colspan="15" class="px-4 py-3 text-center text-forest/30 italic text-[10px] border-r border-premium-border/20">— Data rumah belum diinput —</td>
                                @endif

                                @if(Auth::user()->role !== 'operator')
                                <td class="px-3 py-3 text-center text-[10px] font-mono">{{ $skorA ? number_format($skorA->nilai_input, 3) : '—' }}</td>
                                <td class="px-3 py-3 text-center text-[10px] font-mono">{{ $skorB ? number_format($skorB->nilai_input, 3) : '—' }}</td>
                                <td class="px-3 py-3 text-center text-[10px] font-mono">{{ $skorC ? number_format($skorC->nilai_input, 3) : '—' }}</td>
                                <td class="px-3 py-3 text-center text-[10px] font-mono">{{ $skorD ? number_format($skorD->nilai_input, 3) : '—' }}</td>
                                <td class="px-3 py-3 text-center">
                                    @if($hasil)
                                    <div class="flex flex-col items-center space-y-1">
                                        <span class="text-sm font-serif font-extrabold {{ $isLayak ? 'text-forest' : 'text-red-600' }}">{{ number_format($hasil->nilai_defuzzifikasi, 2) }}</span>
                                        <span class="px-2 py-0.5 rounded-full text-[8px] font-black tracking-widest {{ $isLayak ? 'bg-forest text-cream' : 'bg-red-600 text-white' }}">{{ $hasil->kategori_kelayakan }}</span>
                                    </div>
                                    @else
                                    <span class="text-forest/20 text-[9px] italic">—</span>
                                    @endif
                                </td>
                                @endif

                                {{-- Status --}}
                                <td class="px-3 py-3 text-center border-r border-premium-border/10">
                                    @php
                                        $statusConfig = [
                                            'draft'         => ['label' => 'Belum Dikirim',       'color' => 'bg-blue-50 text-blue-500 border-blue-200'],
                                            'dikirim'       => ['label' => 'Menunggu Verifikasi',  'color' => 'bg-blue-600 text-white border-blue-600 shadow-sm shadow-blue-200'],
                                            'dikembalikan'  => ['label' => 'Perlu Revisi',         'color' => 'bg-red-600 text-white border-red-600 shadow-sm shadow-red-200'],
                                            'terverifikasi' => ['label' => 'Terverifikasi',        'color' => 'bg-emerald-100 text-emerald-700 border-emerald-200'],
                                            'valid'         => ['label' => 'VALID',                'color' => 'bg-forest text-cream border-forest shadow-lg shadow-forest/10'],
                                        ];
                                        $cfg = $statusConfig[$p->verifikasi_status] ?? ['label' => strtoupper($p->verifikasi_status), 'color' => 'bg-gray-100 text-gray-500 border-gray-200'];
                                    @endphp
                                    <div class="flex flex-col items-center gap-1">
                                        <span class="px-2 py-1 rounded-lg text-[8px] font-black tracking-widest uppercase border {{ $cfg['color'] }}">{{ $cfg['label'] }}</span>
                                        @if($p->verifikasi_status === 'dikembalikan' && $p->catatan_revisi)
                                            <button type="button" onclick="alert('Catatan Revisi: {{ str_replace("'", "\'", $p->catatan_revisi) }}')" class="text-[8px] text-red-500 hover:underline font-bold">Lihat Catatan</button>
                                        @endif
                                    </div>
                                </td>

                                {{-- Aksi --}}
                                <td class="px-3 py-3 sticky right-0 bg-white/95 border-l border-premium-border/20 z-10">
                                    @include('penilaian._aksi_buttons', ['p' => $p, 'rumah' => $rumah, 'layout' => 'table'])
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="22" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center text-forest/30">
                                        <svg class="w-10 h-10 mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        <p class="font-serif italic text-sm">Belum ada data penilaian.</p>
                                        <p class="text-[10px] mt-1 uppercase tracking-widest">Input data rumah penduduk untuk memulai penilaian.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ========================================================== --}}
            {{-- MODE GRID                                                   --}}
            {{-- ========================================================== --}}
            <div x-show="layout === 'grid'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="p-6">
                @forelse($penilaian as $p)
                @php
                    $rumah = $p->penduduk->rumah;
                    $hasil = $p->hasilSPK;
                    $penghuni = ($p->penduduk->jumlah_tanggungan ?? 0) + 1;
                    $rasio = $rumah ? round($rumah->luas_bangunan / $penghuni, 1) : null;
                    $nilaiMap = $p->nilaiKriteria->keyBy(fn($n) => $n->kriteria->kode ?? $n->kriteria_id);
                    $skorA = $nilaiMap['K1'] ?? $nilaiMap->first(fn($n) => str_contains($n->kriteria->nama ?? '', 'Keselamatan'));
                    $skorB = $nilaiMap['K2'] ?? $nilaiMap->first(fn($n) => str_contains($n->kriteria->nama ?? '', 'Kesehatan'));
                    $skorC = $nilaiMap['K3'] ?? $nilaiMap->first(fn($n) => str_contains($n->kriteria->nama ?? '', 'Kepadatan'));
                    $skorD = $nilaiMap['K4'] ?? $nilaiMap->first(fn($n) => str_contains($n->kriteria->nama ?? '', 'Komponen'));
                    $isLayak = $hasil && $hasil->kategori_kelayakan === 'LAYAK';

                    $statusConfig = [
                        'draft'         => ['label' => 'Belum Dikirim',      'color' => 'bg-blue-50 text-blue-500 border-blue-200'],
                        'dikirim'       => ['label' => 'Menunggu Verifikasi', 'color' => 'bg-blue-600 text-white border-blue-600'],
                        'dikembalikan'  => ['label' => 'Perlu Revisi',        'color' => 'bg-red-600 text-white border-red-600'],
                        'terverifikasi' => ['label' => 'Terverifikasi',       'color' => 'bg-emerald-100 text-emerald-700 border-emerald-200'],
                        'valid'         => ['label' => 'VALID',               'color' => 'bg-forest text-cream border-forest'],
                    ];
                    $sCfg = $statusConfig[$p->verifikasi_status] ?? ['label' => strtoupper($p->verifikasi_status), 'color' => 'bg-gray-100 text-gray-500 border-gray-200'];
                @endphp
                <div class="group bg-white/60 border {{ (Auth::user()->role !== 'operator' && !$isLayak) ? 'border-red-200 bg-red-50/20' : 'border-premium-border/50' }} rounded-2xl p-5 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300 mb-4 last:mb-0">

                    {{-- Card Header --}}
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl {{ $isLayak ? 'bg-forest text-cream' : 'bg-red-100 text-red-600' }} flex items-center justify-center font-serif font-black text-base flex-shrink-0">
                                {{ substr($p->penduduk->nama_lengkap, 0, 1) }}
                            </div>
                            <div>
                                <a href="{{ route('penduduk.show', $p->penduduk) }}" class="font-serif font-bold text-forest text-base hover:text-amber transition-colors leading-tight block">
                                    {{ $p->penduduk->nama_lengkap }}
                                </a>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span class="text-[9px] text-forest/40 font-bold uppercase tracking-widest">{{ $p->penduduk->kelurahan->nama ?? '-' }}</span>
                                    <span class="text-forest/20">·</span>
                                    <span class="text-[9px] text-forest/30 font-mono">{{ $p->periode }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 flex-shrink-0">
                            {{-- Status badge --}}
                            <span class="px-2 py-1 rounded-lg text-[8px] font-black tracking-widest uppercase border {{ $sCfg['color'] }}">{{ $sCfg['label'] }}</span>
                            {{-- Skor Crisp --}}
                            @if($hasil && Auth::user()->role !== 'operator')
                            <div class="text-right">
                                <div class="text-xl font-serif font-extrabold {{ $isLayak ? 'text-forest' : 'text-red-600' }} leading-none">{{ number_format($hasil->nilai_defuzzifikasi, 2) }}</div>
                                <div class="text-[8px] font-black uppercase tracking-widest {{ $isLayak ? 'text-forest/50' : 'text-red-400' }}">Crisp Z*</div>
                            </div>
                            @endif
                        </div>
                    </div>

                    @if($rumah)
                    {{-- Info grid 4 aspek --}}
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-4">

                        {{-- Aspek A --}}
                        <div class="bg-red-50/40 rounded-xl p-3 border border-red-100/60">
                            <div class="text-[8px] font-black text-red-400 uppercase tracking-widest mb-2">A — Keselamatan</div>
                            <div class="space-y-1">
                                <div class="flex justify-between items-center">
                                    <span class="text-[9px] text-forest/50">Pondasi</span>
                                    <span class="text-[9px] font-bold {{ $rumah->pondasi === 'Ada' ? 'text-emerald-600' : 'text-red-600' }}">{{ $rumah->pondasi }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-[9px] text-forest/50">Kolom</span>
                                    <span class="text-[9px] font-bold {{ str_contains($rumah->kolom_balok, 'Baik') ? 'text-emerald-600' : (str_contains($rumah->kolom_balok, 'Berat') ? 'text-red-600' : 'text-amber-600') }}">{{ Str::limit($rumah->kolom_balok, 12) }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-[9px] text-forest/50">Konst. Atap</span>
                                    <span class="text-[9px] font-bold {{ str_contains($rumah->konstruksi_atap, 'Baik') ? 'text-emerald-600' : (str_contains($rumah->konstruksi_atap, 'Berat') ? 'text-red-600' : 'text-amber-600') }}">{{ Str::limit($rumah->konstruksi_atap, 12) }}</span>
                                </div>
                                @if($skorA && Auth::user()->role !== 'operator')
                                <div class="pt-1 border-t border-red-100 mt-1 flex justify-between items-center">
                                    <span class="text-[8px] text-red-400 font-black uppercase">Skor A</span>
                                    <span class="text-[9px] font-mono font-bold text-red-500">{{ number_format($skorA->nilai_input, 3) }}</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        {{-- Aspek B --}}
                        <div class="bg-emerald-50/40 rounded-xl p-3 border border-emerald-100/60">
                            <div class="text-[8px] font-black text-emerald-500 uppercase tracking-widest mb-2">B — Kesehatan</div>
                            <div class="space-y-1">
                                <div class="flex justify-between items-center">
                                    <span class="text-[9px] text-forest/50">Jendela</span>
                                    <span class="text-[9px] font-bold {{ $rumah->jendela === 'Ada' ? 'text-emerald-600' : 'text-red-600' }}">{{ $rumah->jendela }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-[9px] text-forest/50">Ventilasi</span>
                                    <span class="text-[9px] font-bold {{ $rumah->ventilasi === 'Ada' ? 'text-emerald-600' : 'text-red-600' }}">{{ $rumah->ventilasi }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-[9px] text-forest/50">MCK</span>
                                    <span class="text-[9px] font-bold {{ str_contains($rumah->kamar_mandi, 'Sendiri') ? 'text-emerald-600' : (str_contains($rumah->kamar_mandi, 'Tidak') ? 'text-red-600' : 'text-amber-600') }}">{{ Str::limit($rumah->kamar_mandi, 12) }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-[9px] text-forest/50">Air Bersih</span>
                                    <span class="text-[9px] font-bold {{ str_contains($rumah->jarak_sumber_air, 'Lebih') ? 'text-emerald-600' : 'text-red-600' }}">{{ str_contains($rumah->jarak_sumber_air, 'Lebih') ? '✓ Aman' : '✗ Risiko' }}</span>
                                </div>
                                @if($skorB && Auth::user()->role !== 'operator')
                                <div class="pt-1 border-t border-emerald-100 mt-1 flex justify-between items-center">
                                    <span class="text-[8px] text-emerald-500 font-black uppercase">Skor B</span>
                                    <span class="text-[9px] font-mono font-bold text-emerald-600">{{ number_format($skorB->nilai_input, 3) }}</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        {{-- Aspek C --}}
                        <div class="bg-blue-50/40 rounded-xl p-3 border border-blue-100/60">
                            <div class="text-[8px] font-black text-blue-500 uppercase tracking-widest mb-2">C — Kepadatan</div>
                            <div class="space-y-1">
                                <div class="flex justify-between items-center">
                                    <span class="text-[9px] text-forest/50">Luas</span>
                                    <span class="text-[9px] font-bold text-blue-700">{{ $rumah->luas_bangunan }} m²</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-[9px] text-forest/50">Penghuni</span>
                                    <span class="text-[9px] font-bold text-forest/70">{{ $penghuni }} orang</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-[9px] text-forest/50">Rasio</span>
                                    <span class="text-[9px] font-bold {{ is_numeric($rasio) && $rasio < 9 ? 'text-red-600' : 'text-blue-700' }}">{{ $rasio }} m²/org</span>
                                </div>
                                {{-- Visual bar --}}
                                @if(is_numeric($rasio))
                                <div class="pt-1">
                                    <div class="w-full bg-blue-100 rounded-full h-1">
                                        <div class="h-1 rounded-full {{ $rasio < 9 ? 'bg-red-400' : 'bg-blue-500' }}" style="width: {{ min(($rasio / 20) * 100, 100) }}%"></div>
                                    </div>
                                </div>
                                @endif
                                @if($skorC && Auth::user()->role !== 'operator')
                                <div class="pt-1 border-t border-blue-100 mt-1 flex justify-between items-center">
                                    <span class="text-[8px] text-blue-500 font-black uppercase">Skor C</span>
                                    <span class="text-[9px] font-mono font-bold text-blue-600">{{ number_format($skorC->nilai_input, 3) }}</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        {{-- Aspek D --}}
                        <div class="bg-amber-50/40 rounded-xl p-3 border border-amber-100/60">
                            <div class="text-[8px] font-black text-amber-500 uppercase tracking-widest mb-2">D — Material</div>
                            <div class="space-y-1">
                                <div class="flex justify-between items-center">
                                    <span class="text-[9px] text-forest/50">Atap</span>
                                    <span class="text-[9px] font-bold {{ str_contains($rumah->kondisi_atap ?? '', 'Baik') ? 'text-emerald-600' : (str_contains($rumah->kondisi_atap ?? '', 'Berat') ? 'text-red-600' : 'text-amber-600') }}">{{ Str::limit($rumah->kondisi_atap ?? '-', 12) }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-[9px] text-forest/50">Dinding</span>
                                    <span class="text-[9px] font-bold {{ str_contains($rumah->kondisi_dinding ?? '', 'Baik') ? 'text-emerald-600' : (str_contains($rumah->kondisi_dinding ?? '', 'Berat') ? 'text-red-600' : 'text-amber-600') }}">{{ Str::limit($rumah->kondisi_dinding ?? '-', 12) }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-[9px] text-forest/50">Lantai</span>
                                    <span class="text-[9px] font-bold {{ str_contains($rumah->kondisi_lantai ?? '', 'Baik') ? 'text-emerald-600' : (str_contains($rumah->kondisi_lantai ?? '', 'Berat') ? 'text-red-600' : 'text-amber-600') }}">{{ Str::limit($rumah->kondisi_lantai ?? '-', 12) }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-[9px] text-forest/50">Mat. Lantai</span>
                                    <span class="text-[9px] font-bold text-amber-600">{{ $rumah->material_lantai }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-[9px] text-forest/50">Mat. Dinding</span>
                                    <span class="text-[9px] font-bold text-amber-600">{{ $rumah->material_dinding }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-[9px] text-forest/50">Mat. Atap</span>
                                    <span class="text-[9px] font-bold text-amber-600">{{ $rumah->material_atap  }}</span>
                                </div>
                                @if($skorD && Auth::user()->role !== 'operator')
                                <div class="pt-1 border-t border-amber-100 mt-1 flex justify-between items-center">
                                    <span class="text-[8px] text-amber-500 font-black uppercase">Skor D</span>
                                    <span class="text-[9px] font-mono font-bold text-amber-600">{{ number_format($skorD->nilai_input, 3) }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Progress bar skor keseluruhan (non-operator) --}}
                    @if($hasil && Auth::user()->role !== 'operator')
                    <div class="mb-4 bg-paper/40 rounded-xl p-3 border border-premium-border/30">
                        <div class="flex justify-between items-center mb-1.5">
                            <span class="text-[9px] font-black uppercase tracking-widest text-forest/40">Skor Defuzzifikasi (Z*)</span>
                            <span class="text-[9px] font-black {{ $isLayak ? 'text-forest' : 'text-red-600' }}">{{ $isLayak ? 'LAYAK BANTUAN' : 'TIDAK PRIORITAS' }}</span>
                        </div>
                        <div class="w-full bg-forest/10 rounded-full h-2">
                            <div class="h-2 rounded-full transition-all duration-700 {{ $isLayak ? 'bg-forest' : 'bg-red-500' }}" style="width: {{ min($hasil->nilai_defuzzifikasi, 100) }}%"></div>
                        </div>
                        <div class="flex justify-between mt-1 text-[8px] text-forest/30 font-mono">
                            <span>0</span>
                            <span class="font-bold {{ $isLayak ? 'text-forest' : 'text-red-500' }}">{{ number_format($hasil->nilai_defuzzifikasi, 2) }}</span>
                            <span>100</span>
                        </div>
                    </div>
                    @endif

                    @else
                    {{-- No rumah data --}}
                    <div class="mb-4 bg-paper/30 rounded-xl p-4 border border-premium-border/30 text-center">
                        <p class="text-[10px] text-forest/30 italic">Data rumah belum diinput</p>
                    </div>
                    @endif

                    {{-- Catatan revisi --}}
                    @if($p->verifikasi_status === 'dikembalikan' && $p->catatan_revisi)
                    <div class="mb-3 bg-red-50 rounded-xl p-3 border border-red-200">
                        <p class="text-[9px] font-black text-red-500 uppercase tracking-widest mb-1">Catatan Revisi</p>
                        <p class="text-[10px] text-red-700">{{ $p->catatan_revisi }}</p>
                    </div>
                    @endif

                    {{-- Action buttons --}}
                    <div class="flex flex-wrap gap-2 pt-3 border-t border-premium-border/20">
                        @include('penilaian._aksi_buttons', ['p' => $p, 'rumah' => $rumah, 'layout' => 'grid'])
                    </div>
                </div>
                @empty
                <div class="py-16 text-center">
                    <div class="flex flex-col items-center text-forest/30">
                        <svg class="w-10 h-10 mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <p class="font-serif italic text-sm">Belum ada data penilaian.</p>
                    </div>
                </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($penilaian->hasPages())
            <div class="px-6 py-4 border-t border-premium-border/30">
                {{ $penilaian->links() }}
            </div>
            @endif
        </div>

        {{-- ============================================================ --}}
        {{-- LEGEND                                                        --}}
        {{-- ============================================================ --}}
        <div class="flex flex-wrap gap-4 text-[10px] font-bold uppercase tracking-widest text-forest/40">
            <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded bg-emerald-500"></span> Baik / Aman</span>
            <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded bg-amber-400"></span> Sedang / Perlu Perhatian</span>
            <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded bg-red-500"></span> Buruk / Tidak Layak</span>
            @if(Auth::user()->role === 'admin' || Auth::user()->role === 'camat')
            <span class="flex items-center gap-1.5 ml-auto text-forest/60">Skor Crisp Z* = Nilai Defuzzifikasi Centroid (COA) · Threshold LAYAK ≥ 50</span>
            @endif
        </div>
    </div>
</x-app-layout>