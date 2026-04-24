<x-app-layout>
    <x-slot name="header">
        <div class="py-2">
            <h2 class="font-serif font-bold text-3xl text-forest leading-tight">
                {{ __('Dashboard Utama') }}
            </h2>
            <p class="text-forest/60 text-sm mt-1 italic">Selamat datang di Pusat Kendali SIMPELAJU.</p>
        </div>
    </x-slot>

    <div class="pb-12">
        <!-- Stats Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
            <!-- Total Penduduk -->
            <div class="bg-white/70 backdrop-blur-md p-8 rounded-[2rem] shadow-sm border border-premium-border/50 transition-all duration-500 hover:shadow-xl hover:-translate-y-1 group relative overflow-hidden">
                <div class="absolute -right-4 -top-4 text-forest/5 group-hover:text-forest/10 transition-colors duration-500">
                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <div class="relative z-10">
                    <div class="text-[10px] font-black text-forest/40 uppercase tracking-[0.2em] mb-4">Total Penduduk</div>
                    <div class="text-4xl font-serif font-bold text-forest tracking-tighter">{{ number_format($total_penduduk) }}</div>
                    <div class="mt-4 flex items-center text-[10px] font-bold text-forest/60 bg-paper/50 px-2.5 py-1 rounded-lg border border-premium-border/30 w-fit">
                        TERDATA SISTEM
                    </div>
                </div>
            </div>

            <!-- Sudah Dinilai -->
            <div class="bg-white/70 backdrop-blur-md p-8 rounded-[2rem] shadow-sm border border-premium-border/50 transition-all duration-500 hover:shadow-xl hover:-translate-y-1 group relative overflow-hidden">
                <div class="absolute -right-4 -top-4 text-amber/5 group-hover:text-amber/10 transition-colors duration-500">
                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="relative z-10">
                    <div class="text-[10px] font-black text-amber/60 uppercase tracking-[0.2em] mb-4">Terverifikasi</div>
                    <div class="text-4xl font-serif font-bold text-forest tracking-tighter">{{ number_format($total_dinilai) }}</div>
                    <div class="mt-4 flex items-center text-[10px] font-bold text-amber/80 bg-amber/5 px-2.5 py-1 rounded-lg border border-amber/20 w-fit">
                        RIWAYAT SPK
                    </div>
                </div>
            </div>

            <!-- Layak Bantuan -->
            <div class="bg-forest p-8 rounded-[2rem] shadow-2xl shadow-forest/20 transition-all duration-500 hover:shadow-forest/30 hover:-translate-y-1 group relative overflow-hidden">
                <div class="absolute -right-4 -top-4 text-cream/5 group-hover:text-cream/10 transition-colors duration-500">
                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"></path></svg>
                </div>
                <div class="relative z-10">
                    <div class="text-[10px] font-black text-cream/40 uppercase tracking-[0.2em] mb-4">Layak RTLH</div>
                    <div class="text-4xl font-serif font-bold text-cream tracking-tighter">{{ number_format($total_layak) }}</div>
                    <div class="mt-4 flex items-center text-[10px] font-bold text-cream bg-amber/20 px-2.5 py-1 rounded-lg border border-amber/10 w-fit uppercase tracking-widest">
                        PRIORITAS
                    </div>
                </div>
            </div>

            <!-- Tidak Layak -->
            <div class="bg-white/70 backdrop-blur-md p-8 rounded-[2rem] shadow-sm border border-premium-border/50 transition-all duration-500 hover:shadow-xl hover:-translate-y-1 group relative overflow-hidden">
                <div class="absolute -right-4 -top-4 text-red-500/5 group-hover:text-red-500/10 transition-colors duration-500">
                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12"></path></svg>
                </div>
                <div class="relative z-10">
                    <div class="text-[10px] font-black text-red-400 uppercase tracking-[0.2em] mb-4">Belum Prioritas</div>
                    <div class="text-4xl font-serif font-bold text-forest tracking-tighter">{{ number_format($total_tidak_layak) }}</div>
                    <div class="mt-4 flex items-center text-[10px] font-bold text-red-500/50 bg-red-50 px-2.5 py-1 rounded-lg border border-red-100 w-fit">
                        FOLLOW UP
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white/50 backdrop-blur-lg overflow-hidden shadow-sm rounded-[3rem] border border-premium-border/50 p-12 relative">
            <div class="absolute top-0 right-0 p-12 opacity-5 pointer-events-none">
                <svg class="w-64 h-64 text-forest" fill="currentColor" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>

            <div class="flex items-center space-x-8 mb-10 relative z-10">
                <div class="p-6 bg-forest rounded-3xl text-cream shadow-2xl shadow-forest/30">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                </div>
                <div>
                    <h1 class="text-4xl font-serif font-bold text-forest tracking-tight">SIMPELAJU</h1>
                    <p class="text-forest/60 font-serif italic text-lg mt-1">Sistem Pendukung Keputusan Rehab Rumah Tidak Layak Huni</p>
                </div>
            </div>
            
            <div class="prose prose-forest max-w-4xl text-forest/70 leading-relaxed text-lg mb-12 relative z-10">
                Platform ini menggunakan kecerdasan buatan berbasis <strong class="text-forest font-serif italic">Fuzzy Logic Mamdani</strong> untuk menentukan kelayakan hunian secara objektif. Anda dapat mulai dengan mengelola data penduduk, mencatat kondisi fisik rumah, dan melakukan kalkulasi penilaian secara otomatis.
            </div>

            <!-- Ranking Table -->
            <div class="relative z-10 mb-12">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-serif font-bold text-forest uppercase tracking-widest">Daftar Prioritas Tertinggi</h3>
                    <span class="px-4 py-1.5 bg-forest text-cream text-[10px] font-black rounded-full tracking-[0.2em]">RANKING SPK</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-premium-border/30">
                                <th class="pb-4 text-[10px] font-black text-forest/40 uppercase tracking-[0.2em]">Peringkat</th>
                                <th class="pb-4 text-[10px] font-black text-forest/40 uppercase tracking-[0.2em]">Calon Penerima</th>
                                <th class="pb-4 text-[10px] font-black text-forest/40 uppercase tracking-[0.2em]">Skor Kelayakan (Z*)</th>
                                <th class="pb-4 text-[10px] font-black text-forest/40 uppercase tracking-[0.2em]">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-premium-border/20">
                            @forelse($rankings as $index => $rank)
                                <tr class="group hover:bg-forest/5 transition-colors duration-300">
                                    <td class="py-6">
                                        <div class="w-8 h-8 rounded-lg bg-forest/10 flex items-center justify-center text-forest font-serif font-bold">
                                            {{ $index + 1 }}
                                        </div>
                                    </td>
                                    <td class="py-6">
                                        <div class="font-serif font-bold text-forest">{{ $rank->penilaian->penduduk->nama_lengkap }}</div>
                                        <div class="text-[10px] text-forest/50 font-medium uppercase tracking-widest mt-1">{{ $rank->penilaian->penduduk->nik }}</div>
                                    </td>
                                    <td class="py-6">
                                        <div class="flex items-center">
                                            <div class="text-2xl font-serif font-bold text-forest mr-3">{{ number_format($rank->nilai_defuzzifikasi, 2) }}</div>
                                            <div class="w-24 h-1.5 bg-forest/10 rounded-full overflow-hidden">
                                                <div class="h-full bg-forest rounded-full" style="width: {{ $rank->nilai_defuzzifikasi }}%"></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-6">
                                        @if($rank->kategori_kelayakan === 'LAYAK')
                                            <span class="px-3 py-1 bg-forest text-cream text-[9px] font-black rounded-lg tracking-widest">PRIORITAS</span>
                                        @else
                                            <span class="px-3 py-1 bg-paper text-forest/40 text-[9px] font-black rounded-lg tracking-widest border border-premium-border">DIPROSES</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-12 text-center text-forest/30 italic font-serif">Belum ada data penilaian yang terselesaikan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative z-10">
                <a href="{{ route('penduduk.index') }}" class="group bg-paper/30 p-8 rounded-2xl border border-premium-border/50 hover:bg-white hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="text-forest font-serif font-bold text-lg mb-3 flex items-center">
                        Input Data Baru
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </div>
                    <p class="text-xs text-forest/50 font-medium leading-relaxed uppercase tracking-widest">Registrasi Demografi</p>
                </a>
                
                <a href="{{ route('penilaian.index') }}" class="group bg-paper/30 p-8 rounded-2xl border border-premium-border/50 hover:bg-forest hover:text-cream hover:border-forest transition-all duration-300">
                    <div class="text-amber font-serif font-bold text-lg mb-3 flex items-center group-hover:text-cream transition-colors">
                        Riwayat Seleksi
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </div>
                    <p class="text-xs text-forest/50 font-medium leading-relaxed uppercase tracking-widest group-hover:text-cream/60">Arsip Keputusan</p>
                </a>
                
                <div class="bg-paper/10 p-8 rounded-2xl border border-premium-border/20 opacity-40 cursor-not-allowed">
                    <div class="text-forest/40 font-serif font-bold text-lg mb-3">Cetak Laporan</div>
                    <p class="text-xs text-forest/30 font-medium leading-relaxed uppercase tracking-widest">Export Phase 4</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

