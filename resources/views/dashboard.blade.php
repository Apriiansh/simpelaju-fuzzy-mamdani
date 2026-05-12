<x-app-layout>
    <x-slot name="header">
        <div class="py-2">
            <h2 class="font-serif font-bold text-3xl text-forest leading-tight">
                {{ __('Dashboard Utama') }}
            </h2>
            <p class="text-forest/60 text-sm mt-1 italic">
                @if(Auth::user()->role === 'admin')
                    Pusat Kendali Penuh — SIMPELAJU.
                @elseif(Auth::user()->role === 'camat')
                    Pantau seluruh hasil penilaian kelayakan hunian.
                @else
                    Kelola data penduduk dan penilaian rumah di wilayah Anda.
                @endif
            </p>
        </div>
    </x-slot>

    <div class="pb-12">

        {{-- ============================================================ --}}
        {{-- STAT CARDS                                                    --}}
        {{-- ============================================================ --}}

        @if(Auth::user()->role === 'operator')
        {{-- OPERATOR: 3 stat, 3 kolom full --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">

            <div class="bg-white/70 backdrop-blur-md p-8 rounded-[2rem] shadow-sm border border-premium-border/50 transition-all duration-500 hover:shadow-xl hover:-translate-y-1 group relative overflow-hidden">
                <div class="absolute -right-4 -top-4 text-forest/5 group-hover:text-forest/10 transition-colors duration-500">
                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <div class="relative z-10">
                    <div class="text-[10px] font-black text-forest/40 uppercase tracking-[0.2em] mb-4">Total Penduduk</div>
                    <div class="text-4xl font-serif font-bold text-forest tracking-tighter">{{ number_format($total_penduduk) }}</div>
                    <div class="mt-4 flex items-center text-[10px] font-bold text-forest/60 bg-paper/50 px-2.5 py-1 rounded-lg border border-premium-border/30 w-fit">
                        TERDAFTAR DI SISTEM
                    </div>
                </div>
            </div>

            <div class="bg-white/70 backdrop-blur-md p-8 rounded-[2rem] shadow-sm border border-premium-border/50 transition-all duration-500 hover:shadow-xl hover:-translate-y-1 group relative overflow-hidden">
                <div class="absolute -right-4 -top-4 text-amber/5 group-hover:text-amber/10 transition-colors duration-500">
                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="relative z-10">
                    <div class="text-[10px] font-black text-amber/60 uppercase tracking-[0.2em] mb-4">Data Terproses</div>
                    <div class="text-4xl font-serif font-bold text-forest tracking-tighter">{{ number_format($total_dinilai) }}</div>
                    <div class="mt-4 flex items-center text-[10px] font-bold text-amber/80 bg-amber/5 px-2.5 py-1 rounded-lg border border-amber/20 w-fit">
                        SUDAH DINILAI
                    </div>
                </div>
            </div>

            <div class="bg-forest p-8 rounded-[2rem] shadow-2xl shadow-forest/20 transition-all duration-500 hover:shadow-forest/30 hover:-translate-y-1 group relative overflow-hidden">
                <div class="absolute -right-4 -top-4 text-cream/5 group-hover:text-cream/10 transition-colors duration-500">
                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                </div>
                <div class="relative z-10">
                    <div class="text-[10px] font-black text-cream/40 uppercase tracking-[0.2em] mb-4">Menunggu Verifikasi</div>
                    <div class="text-4xl font-serif font-bold text-cream tracking-tighter">{{ number_format($total_belum_verifikasi) }}</div>
                    <div class="mt-4 flex items-center text-[10px] font-bold text-cream bg-amber/20 px-2.5 py-1 rounded-lg border border-amber/10 w-fit uppercase tracking-widest">
                        DIPROSES KECAMATAN
                    </div>
                </div>
            </div>

        </div>

        @else
        {{-- ADMIN & CAMAT: 4 stat --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">

            <div class="bg-white/70 backdrop-blur-md p-8 rounded-[2rem] shadow-sm border border-premium-border/50 transition-all duration-500 hover:shadow-xl hover:-translate-y-1 group relative overflow-hidden">
                <div class="absolute -right-4 -top-4 text-forest/5 group-hover:text-forest/10 transition-colors duration-500">
                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <div class="relative z-10">
                    <div class="text-[10px] font-black text-forest/40 uppercase tracking-[0.2em] mb-4">Total Penduduk</div>
                    <div class="text-4xl font-serif font-bold text-forest tracking-tighter">{{ number_format($total_penduduk) }}</div>
                    <div class="mt-4 flex items-center text-[10px] font-bold text-forest/60 bg-paper/50 px-2.5 py-1 rounded-lg border border-premium-border/30 w-fit">
                        TERDAFTAR DI SISTEM
                    </div>
                </div>
            </div>

            <div class="bg-white/70 backdrop-blur-md p-8 rounded-[2rem] shadow-sm border border-premium-border/50 transition-all duration-500 hover:shadow-xl hover:-translate-y-1 group relative overflow-hidden">
                <div class="absolute -right-4 -top-4 text-amber/5 group-hover:text-amber/10 transition-colors duration-500">
                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="relative z-10">
                    <div class="text-[10px] font-black text-amber/60 uppercase tracking-[0.2em] mb-4">Sudah Dinilai</div>
                    <div class="text-4xl font-serif font-bold text-forest tracking-tighter">{{ number_format($total_dinilai) }}</div>
                    <div class="mt-4 flex items-center text-[10px] font-bold text-amber/80 bg-amber/5 px-2.5 py-1 rounded-lg border border-amber/20 w-fit">
                        RIWAYAT PENILAIAN
                    </div>
                </div>
            </div>

            <div class="bg-forest p-8 rounded-[2rem] shadow-2xl shadow-forest/20 transition-all duration-500 hover:shadow-forest/30 hover:-translate-y-1 group relative overflow-hidden">
                <div class="absolute -right-4 -top-4 text-cream/5 group-hover:text-cream/10 transition-colors duration-500">
                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                </div>
                <div class="relative z-10">
                    <div class="text-[10px] font-black text-cream/40 uppercase tracking-[0.2em] mb-4">Layak Bantuan RTLH</div>
                    <div class="text-4xl font-serif font-bold text-cream tracking-tighter">{{ number_format($total_layak) }}</div>
                    <div class="mt-4 flex items-center text-[10px] font-bold text-cream bg-amber/20 px-2.5 py-1 rounded-lg border border-amber/10 w-fit uppercase tracking-widest">
                        PRIORITAS UTAMA
                    </div>
                </div>
            </div>

            <div class="bg-white/70 backdrop-blur-md p-8 rounded-[2rem] shadow-sm border border-premium-border/50 transition-all duration-500 hover:shadow-xl hover:-translate-y-1 group relative overflow-hidden">
                <div class="absolute -right-4 -top-4 text-red-500/5 group-hover:text-red-500/10 transition-colors duration-500">
                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"/></svg>
                </div>
                <div class="relative z-10">
                    <div class="text-[10px] font-black text-red-400 uppercase tracking-[0.2em] mb-4">Tidak Layak / Belum Prioritas</div>
                    <div class="text-4xl font-serif font-bold text-forest tracking-tighter">{{ number_format($total_tidak_layak) }}</div>
                    <div class="mt-4 flex items-center text-[10px] font-bold text-red-500/50 bg-red-50 px-2.5 py-1 rounded-lg border border-red-100 w-fit">
                        PERLU TINDAK LANJUT
                    </div>
                </div>
            </div>

        </div>
        @endif

        {{-- ============================================================ --}}
        {{-- MAIN PANEL                                                    --}}
        {{-- ============================================================ --}}
        <div class="bg-white/50 backdrop-blur-lg overflow-hidden shadow-sm rounded-[3rem] border border-premium-border/50 p-12 relative">

            <div class="absolute top-0 right-0 p-12 opacity-5 pointer-events-none">
                <svg class="w-64 h-64 text-forest" fill="currentColor" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>

            {{-- Branding --}}
            <div class="flex items-center space-x-8 mb-10 relative z-10">
                <div class="p-6 bg-forest rounded-3xl text-cream shadow-2xl shadow-forest/30">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                </div>
                <div>
                    <h1 class="text-4xl font-serif font-bold text-forest tracking-tight">SIMPELAJU</h1>
                    <p class="text-forest/60 font-serif italic text-lg mt-1">Sistem Pendukung Keputusan Rumah Tidak Layak Huni — Kecamatan Plaju</p>
                </div>
            </div>

            <div class="prose prose-forest max-w-4xl text-forest/70 leading-relaxed text-lg mb-12 relative z-10">
                Platform ini menggunakan kecerdasan buatan berbasis <strong class="text-forest font-serif italic">Fuzzy Logic Mamdani</strong> untuk menentukan kelayakan hunian secara objektif.
                @if(Auth::user()->role === 'operator')
                    Silakan mulai dengan menambahkan data penduduk dan mengisi formulir penilaian kondisi fisik rumah.
                @else
                    Pantau hasil penilaian, lihat peringkat prioritas penerima, dan kelola seluruh data dari sini.
                @endif
            </div>

            {{-- ======================================================== --}}
            {{-- KONTEN TENGAH                                             --}}
            {{-- ======================================================== --}}

            @if(Auth::user()->role === 'operator')
            {{-- OPERATOR: Info status verifikasi --}}
            <div class="relative z-10 mb-12">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-serif font-bold text-forest uppercase tracking-widest">Status Penilaian Anda</h3>
                    <span class="px-4 py-1.5 bg-amber/10 text-amber border border-amber/30 text-[10px] font-black rounded-full tracking-[0.2em]">DALAM PROSES</span>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-paper/30 rounded-2xl border border-premium-border/50 p-8">
                        <div class="flex items-start space-x-5">
                            <div class="w-12 h-12 rounded-full bg-amber/10 flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="w-6 h-6 text-amber" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-forest font-bold text-base mb-1">Proses Verifikasi Berjalan</p>
                                <p class="text-forest/50 text-sm leading-relaxed">Data penilaian yang sudah Anda masukkan sedang diverifikasi oleh pihak Kecamatan. Hasil akhir dan peringkat prioritas akan tersedia setelah verifikasi selesai.</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-paper/30 rounded-2xl border border-premium-border/50 p-8">
                        <div class="flex items-start space-x-5">
                            <div class="w-12 h-12 rounded-full bg-forest/10 flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="w-6 h-6 text-forest" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-forest font-bold text-base mb-1">Apa yang Bisa Anda Lakukan?</p>
                                <p class="text-forest/50 text-sm leading-relaxed">Anda masih bisa menambah data penduduk baru dan mengisi penilaian kondisi fisik rumah. Data baru akan ikut masuk dalam antrean verifikasi.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @else
            {{-- ADMIN & CAMAT: Ranking table --}}
            <div class="relative z-10 mb-12">
                <div class="flex items-center justify-between mb-6">
                    @if(Auth::user()->role === 'camat')
                        <h3 class="text-xl font-serif font-bold text-forest uppercase tracking-widest">Daftar Prioritas Penerima Bantuan</h3>
                        <span class="px-4 py-1.5 bg-forest text-cream text-[10px] font-black rounded-full tracking-[0.2em]">HASIL SPK</span>
                    @else
                        <h3 class="text-xl font-serif font-bold text-forest uppercase tracking-widest">Ranking Prioritas Kelayakan RTLH</h3>
                        <span class="px-4 py-1.5 bg-forest text-cream text-[10px] font-black rounded-full tracking-[0.2em]">RANKING SPK</span>
                    @endif
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-premium-border/30">
                                <th class="pb-4 text-[10px] font-black text-forest/40 uppercase tracking-[0.2em]">Peringkat</th>
                                <th class="pb-4 text-[10px] font-black text-forest/40 uppercase tracking-[0.2em]">Calon Penerima Bantuan</th>
                                <th class="pb-4 text-[10px] font-black text-forest/40 uppercase tracking-[0.2em]">Skor Kelayakan (Z*)</th>
                                <th class="pb-4 text-[10px] font-black text-forest/40 uppercase tracking-[0.2em]">Hasil Penilaian</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-premium-border/20">
                            @forelse($rankings as $index => $rank)
                                <tr class="group hover:bg-forest/5 transition-colors duration-300">
                                    <td class="py-6">
                                        <div class="w-8 h-8 rounded-lg {{ $index < 3 ? 'bg-forest text-cream' : 'bg-forest/10 text-forest' }} flex items-center justify-center font-serif font-bold text-sm">
                                            {{ $index + 1 }}
                                        </div>
                                    </td>
                                    <td class="py-6">
                                        <div class="font-serif font-bold text-forest">{{ $rank->penilaian->penduduk->nama_lengkap }}</div>
                                        <div class="text-[10px] text-forest/50 font-medium uppercase tracking-widest mt-1">NIK: {{ $rank->penilaian->penduduk->nik }}</div>
                                    </td>
                                    <td class="py-6">
                                        <div class="flex items-center gap-3">
                                            <div class="text-2xl font-serif font-bold text-forest">{{ number_format($rank->nilai_defuzzifikasi, 2) }}</div>
                                            <div class="w-24 h-1.5 bg-forest/10 rounded-full overflow-hidden">
                                                <div class="h-full bg-forest rounded-full" style="width: {{ min($rank->nilai_defuzzifikasi, 100) }}%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-6">
                                        @if($rank->kategori_kelayakan === 'LAYAK')
                                            <span class="px-3 py-1 bg-forest text-cream text-[9px] font-black rounded-lg tracking-widest">LAYAK BANTUAN</span>
                                        @else
                                            <span class="px-3 py-1 bg-paper text-forest/40 text-[9px] font-black rounded-lg tracking-widest border border-premium-border">TIDAK PRIORITAS</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-12 text-center text-forest/30 italic font-serif">
                                        Belum ada data penilaian yang terselesaikan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            {{-- ======================================================== --}}
            {{-- QUICK ACTIONS                                             --}}
            {{-- ======================================================== --}}
            <div class="relative z-10">
                <h3 class="text-[10px] font-black text-forest/30 uppercase tracking-[0.2em] mb-6">Akses Cepat</h3>

                @if(Auth::user()->role === 'operator')
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <a href="{{ route('penduduk.index') }}" class="group bg-paper/30 p-8 rounded-2xl border border-premium-border/50 hover:bg-white hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div class="text-forest font-serif font-bold text-lg mb-2 flex items-center">
                            Tambah Data Penduduk
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </div>
                        <p class="text-xs text-forest/50 font-medium uppercase tracking-widest">Registrasi & Demografi</p>
                    </a>
                    <a href="{{ route('penilaian.index') }}" class="group bg-paper/30 p-8 rounded-2xl border border-premium-border/50 hover:bg-forest hover:border-forest transition-all duration-300">
                        <div class="text-amber font-serif font-bold text-lg mb-2 flex items-center group-hover:text-cream transition-colors">
                            Isi Formulir Penilaian
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </div>
                        <p class="text-xs text-forest/50 font-medium uppercase tracking-widest group-hover:text-cream/60">Kondisi Fisik Rumah</p>
                    </a>
                </div>

                @else
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <a href="{{ route('penduduk.index') }}" class="group bg-paper/30 p-8 rounded-2xl border border-premium-border/50 hover:bg-white hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                        <div class="text-forest font-serif font-bold text-lg mb-2 flex items-center">
                            {{ Auth::user()->role === 'admin' ? 'Kelola Data Penduduk' : 'Data Penduduk' }}
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </div>
                        <p class="text-xs text-forest/50 font-medium uppercase tracking-widest">Registrasi & Demografi</p>
                    </a>
                    <a href="{{ route('penilaian.index') }}" class="group bg-paper/30 p-8 rounded-2xl border border-premium-border/50 hover:bg-forest hover:border-forest transition-all duration-300">
                        <div class="text-amber font-serif font-bold text-lg mb-2 flex items-center group-hover:text-cream transition-colors">
                            {{ Auth::user()->role === 'admin' ? 'Riwayat Penilaian' : 'Hasil Penilaian' }}
                            <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </div>
                        <p class="text-xs text-forest/50 font-medium uppercase tracking-widest group-hover:text-cream/60">{{ Auth::user()->role === 'admin' ? 'Arsip Keputusan SPK' : 'Riwayat & Arsip SPK' }}</p>
                    </a>
                    <div class="bg-paper/10 p-8 rounded-2xl border border-premium-border/20 opacity-40 cursor-not-allowed">
                        <div class="text-forest/40 font-serif font-bold text-lg mb-2">Cetak Laporan</div>
                        <p class="text-xs text-forest/30 font-medium uppercase tracking-widest">Segera Hadir</p>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>