<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center py-2">
            <div>
                <h2 class="font-serif font-bold text-2xl text-forest leading-tight">
                    {{ __('Detail Penduduk') }}
                </h2>
                <div class="flex items-center text-forest/50 text-xs mt-1 font-medium tracking-wide uppercase">
                    <a href="{{ route('penduduk.index') }}" class="hover:text-forest transition-colors">Daftar Penduduk</a>
                    <svg class="w-3 h-3 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <span class="text-forest/80">{{ $penduduk->nama_lengkap }}</span>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('penduduk.index') }}" class="text-forest/60 hover:text-forest bg-white/50 border border-premium-border/50 px-5 py-2.5 rounded-xl transition-all duration-300 font-bold text-xs uppercase tracking-widest shadow-sm hover:shadow-md">
                    Kembali
                </a>
                <a href="{{ route('penduduk.edit', $penduduk) }}" class="bg-forest text-cream px-5 py-2.5 rounded-xl shadow-lg shadow-forest/10 text-xs font-bold uppercase tracking-widest hover:bg-forest-dark transition-all duration-300 hover:-translate-y-0.5">
                    Edit Profil
                </a>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 pb-12">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white/70 backdrop-blur-sm p-8 rounded-2xl shadow-sm border border-premium-border/50">
                <div class="flex items-center mb-8 border-b border-premium-border/30 pb-4">
                    <div class="w-10 h-10 rounded-xl bg-forest/10 flex items-center justify-center text-forest mr-4 border border-forest/10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-serif font-bold text-forest leading-tight">Profil Lengkap</h3>
                        <p class="text-xs text-forest/40 font-bold tracking-widest uppercase">General Information</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-12">
                    <div class="group">
                        <span class="text-[10px] font-bold text-forest/40 uppercase tracking-widest block mb-1 group-hover:text-forest transition-colors">NIK</span>
                        <p class="text-forest font-bold text-lg font-mono">{{ $penduduk->nik }}</p>
                    </div>
                    <div class="group">
                        <span class="text-[10px] font-bold text-forest/40 uppercase tracking-widest block mb-1 group-hover:text-forest transition-colors">Nama Lengkap</span>
                        <p class="text-forest font-bold text-lg font-serif">{{ $penduduk->nama_lengkap }}</p>
                    </div>
                    <div class="md:col-span-2 p-4 rounded-xl bg-paper/30 border border-premium-border/30">
                        <span class="text-[10px] font-bold text-forest/40 uppercase tracking-widest block mb-1">Alamat Tinggal</span>
                        <p class="text-forest font-medium italic">"{{ $penduduk->alamat }}"</p>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-forest/40 uppercase tracking-widest block mb-1">Kelurahan</span>
                        <p class="text-forest font-bold">{{ $penduduk->kelurahan->nama }}</p>
                    </div>
                    <div>
                        <span class="text-[10px] font-bold text-forest/40 uppercase tracking-widest block mb-1">No. Telepon</span>
                        <p class="text-forest font-bold">{{ $penduduk->no_telepon ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white/70 backdrop-blur-sm p-8 rounded-2xl shadow-sm border border-premium-border/50">
                 <div class="flex items-center mb-8 border-b border-premium-border/30 pb-4">
                    <div class="w-10 h-10 rounded-xl bg-premium-amber/10 flex items-center justify-center text-premium-amber mr-4 border border-premium-amber/10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-serif font-bold text-forest leading-tight">Data Rumah & Ekonomi</h3>
                        <p class="text-xs text-forest/40 font-bold tracking-widest uppercase">Livelihood Status</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-paper/40 p-5 rounded-2xl border border-premium-border/30">
                        <span class="text-[10px] font-bold text-forest/40 uppercase tracking-widest block mb-1">Status Nikah</span>
                        <p class="text-forest font-bold">{{ $penduduk->status_pernikahan }}</p>
                    </div>
                    <div class="bg-paper/40 p-5 rounded-2xl border border-premium-border/30">
                        <span class="text-[10px] font-bold text-forest/40 uppercase tracking-widest block mb-1">Tanggungan</span>
                        <p class="text-forest font-bold text-xl">{{ $penduduk->jumlah_tanggungan }} <span class="text-xs">Orang</span></p>
                    </div>
                    <div class="bg-forest p-5 rounded-2xl border border-forest shadow-lg shadow-forest/10">
                        <span class="text-[10px] font-bold text-cream/50 uppercase tracking-widest block mb-1">Penghasilan</span>
                        <p class="text-premium-amber font-bold text-lg font-serif">Rp {{ number_format($penduduk->penghasilan, 0, ',', '.') }}</p>
                    </div>
                </div>

                @if($penduduk->rumah)
                    <div class="mt-8 overflow-hidden rounded-2xl border border-premium-border/50 bg-white/40">
                        <div class="bg-paper/50 px-6 py-3 border-b border-premium-border/30 flex justify-between items-center">
                            <h4 class="font-bold text-xs text-forest uppercase tracking-widest">Detail Kondisi Fisik</h4>
                            <div class="flex items-center space-x-4">
                                <a href="{{ route('rumah.edit', $penduduk->rumah) }}" class="text-[10px] font-black text-forest/40 hover:text-forest transition-colors uppercase tracking-widest flex items-center">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                    Edit Data Rumah
                                </a>
                                <span class="px-2 py-0.5 rounded bg-forest text-cream text-[10px] font-bold">{{ $penduduk->rumah->status_kepemilikan }}</span>
                            </div>
                        </div>
                        <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-4 bg-slate-50/50">
                            <!-- Aspek A -->
                            <div class="p-4 rounded-2xl border border-premium-border/50 bg-white">
                                <span class="text-[9px] font-black text-forest/40 block mb-2 uppercase tracking-widest">Aspek A: Keselamatan</span>
                                <div class="space-y-1">
                                    <div class="flex justify-between text-[10px]">
                                        <span class="text-slate-400">Pondasi:</span>
                                        <span class="font-bold text-forest">{{ $penduduk->rumah->pondasi }}</span>
                                    </div>
                                    <div class="flex justify-between text-[10px]">
                                        <span class="text-slate-400">Struktur:</span>
                                        <span class="font-bold text-forest">{{ $penduduk->rumah->kolom_balok }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Aspek B -->
                            <div class="p-4 rounded-2xl border border-premium-border/50 bg-white">
                                <span class="text-[9px] font-black text-forest/40 block mb-2 uppercase tracking-widest">Aspek B: Kesehatan</span>
                                <div class="space-y-1">
                                    <div class="flex justify-between text-[10px]">
                                        <span class="text-slate-400">Sanitasi:</span>
                                        <span class="font-bold text-forest">{{ $penduduk->rumah->kamar_mandi }}</span>
                                    </div>
                                    <div class="flex justify-between text-[10px]">
                                        <span class="text-slate-400">Ventilasi:</span>
                                        <span class="font-bold text-forest">{{ $penduduk->rumah->ventilasi }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Aspek C -->
                            <div class="p-4 rounded-2xl border border-premium-border/50 bg-white">
                                <span class="text-[9px] font-black text-forest/40 block mb-2 uppercase tracking-widest">Aspek C: Kepadatan</span>
                                <div class="space-y-1">
                                    <div class="flex justify-between text-[10px]">
                                        <span class="text-slate-400">Luas:</span>
                                        <span class="font-bold text-forest">{{ $penduduk->rumah->luas_bangunan }} m²</span>
                                    </div>
                                    <div class="flex justify-between text-[10px]">
                                        <span class="text-slate-400">Rasio:</span>
                                        @php 
                                            $penghuni = ($penduduk->jumlah_tanggungan ?? 0) + 1;
                                            $rasio = $penduduk->rumah->luas_bangunan / $penghuni;
                                        @endphp
                                        <span class="font-bold {{ $rasio < 9 ? 'text-red-600' : 'text-forest' }}">{{ number_format($rasio, 1) }} m²/org</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Aspek D -->
                            <div class="p-4 rounded-2xl border border-premium-border/50 bg-white">
                                <span class="text-[9px] font-black text-forest/40 block mb-2 uppercase tracking-widest">Aspek D: Komponen</span>
                                <div class="space-y-1">
                                    <div class="flex justify-between text-[10px]">
                                        <span class="text-slate-400">Atap:</span>
                                        <span class="font-bold text-forest">{{ $penduduk->rumah->material_atap }}</span>
                                    </div>
                                    <div class="flex justify-between text-[10px]">
                                        <span class="text-slate-400">Dinding:</span>
                                        <span class="font-bold text-forest">{{ $penduduk->rumah->material_dinding }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="mt-8 p-8 rounded-2xl border-2 border-dashed border-premium-border/30 text-center group hover:border-forest/30 transition-colors bg-paper/10">
                        <div class="w-12 h-12 rounded-full bg-paper flex items-center justify-center mx-auto mb-3 text-forest/20 group-hover:text-forest/40 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                        </div>
                        <p class="text-forest/40 font-serif italic text-sm">Belum ada rincian data kondisi rumah fisik.</p>
                        <a href="{{ route('rumah.create', ['penduduk_id' => $penduduk->id]) }}" class="inline-flex items-center mt-4 text-forest font-bold text-xs uppercase tracking-widest hover:text-premium-amber transition-colors">
                            Input Data Sekarang
                            <svg class="w-3 h-3 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-8">
            <div class="bg-white/70 backdrop-blur-sm p-8 rounded-2xl shadow-sm border border-premium-border/50">
                <div class="flex justify-between items-center mb-6 border-b border-premium-border/30 pb-4">
                    <h3 class="text-lg font-serif font-bold text-forest flex items-center">
                        <svg class="w-5 h-5 mr-3 text-premium-amber" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        Hasil SPK Mamdani
                    </h3>
                    
                    @if($penduduk->rumah)
                    <form action="{{ route('rumah.recalculate', $penduduk->rumah) }}" method="POST">
                        @csrf
                        <button type="submit" class="p-2 rounded-lg bg-paper hover:bg-forest hover:text-cream transition-all group shadow-sm border border-premium-border/30" title="Hitung Ulang">
                            <svg class="w-4 h-4 group-hover:rotate-180 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        </button>
                    </form>
                    @endif
                </div>
                
                @if($penduduk->penilaian->isNotEmpty())
                    @php $latest = $penduduk->penilaian->last(); @endphp
                    @if($latest->hasilSPK)
                        <div class="text-center p-8 rounded-2xl {{ $latest->hasilSPK->kategori_kelayakan == 'LAYAK' ? 'bg-forest text-cream shadow-xl shadow-forest/20' : 'bg-red-50 text-red-800' }} border {{ $latest->hasilSPK->kategori_kelayakan == 'LAYAK' ? 'border-forest' : 'border-red-100' }}">
                            <div class="text-4xl font-serif font-extrabold mb-1">
                                {{ $latest->hasilSPK->kategori_kelayakan }}
                            </div>
                            <div class="w-12 h-0.5 {{ $latest->hasilSPK->kategori_kelayakan == 'LAYAK' ? 'bg-premium-amber' : 'bg-red-300' }} mx-auto mb-4"></div>
                            <p class="text-xs uppercase font-bold tracking-[0.2em] {{ $latest->hasilSPK->kategori_kelayakan == 'LAYAK' ? 'text-cream/60' : 'text-red-400' }}">
                                Skor: {{ number_format($latest->hasilSPK->nilai_defuzzifikasi, 3) }}
                            </p>
                            <div class="mt-6 pt-6 border-t {{ $latest->hasilSPK->kategori_kelayakan == 'LAYAK' ? 'border-cream/10' : 'border-red-100' }} text-[10px] font-medium opacity-60 uppercase tracking-widest">
                                Periode: {{ $latest->periode }}
                            </div>
                        </div>
                    @else
                        <div class="text-center p-8 bg-paper/50 rounded-2xl border border-premium-border/50">
                            <svg class="animate-spin h-8 w-8 text-premium-amber mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text-forest/70 font-bold text-xs uppercase tracking-widest">Kalkulasi Sedang Berjalan</span>
                        </div>
                    @endif
                @else
                    <div class="text-center p-10 bg-paper/20 rounded-2xl border-2 border-dashed border-premium-border/50">
                        <p class="text-forest/30 font-serif italic text-sm">
                            {{ $penduduk->rumah ? 'Belum ada hasil penilaian untuk tahun ini.' : 'Silakan input data rumah untuk melihat skor kelayakan.' }}
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>









