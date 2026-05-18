<x-app-layout>
    <x-slot name="header">
        <div class="py-2">
            <h2 class="font-serif font-bold text-2xl text-forest leading-tight">
                Laporan Hasil Penilaian RTLH
            </h2>
            <p class="text-xs text-forest/40 font-bold tracking-widest uppercase mt-1">
                Export Hasil Penilaian dan Rekomendasi Bantuan RTLH (Format Resmi)
            </p>
        </div>
    </x-slot>

    <div class="space-y-6 pb-12">

        {{-- Info Banner --}}
        <!-- <div class="bg-forest/5 border border-forest/10 rounded-2xl p-4 flex items-center shadow-sm">
            <div class="w-10 h-10 bg-forest/10 rounded-xl flex items-center justify-center text-forest mr-4 shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm text-forest/70 font-medium">Laporan ini hanya menampilkan data usulan yang telah **Disahkan (Status: VALID)** oleh Camat. Data yang masih dalam proses verifikasi tidak akan muncul di sini.</p>
            </div>
        </div> -->
        
        {{-- =============================================
             FILTER PANEL
             ============================================= --}}
        <div class="bg-white/70 backdrop-blur-sm rounded-2xl border border-premium-border/50 shadow-sm p-6">
            <form action="{{ route('laporan.index') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                    
                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-forest/40 uppercase tracking-widest">Wilayah Kelurahan</label>
                        <select name="kelurahan_id" class="w-full border-premium-border/30 rounded-xl bg-paper text-forest focus:ring-forest focus:border-forest text-sm">
                            <option value="">Semua Kelurahan</option>
                            @foreach($kelurahans as $kel)
                                <option value="{{ $kel->id }}" {{ request('kelurahan_id') == $kel->id ? 'selected' : '' }}>
                                    {{ $kel->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-forest/40 uppercase tracking-widest">Status Kelayakan</label>
                        <select name="status" class="w-full border-premium-border/30 rounded-xl bg-paper text-forest focus:ring-forest focus:border-forest text-sm">
                            <option value="">Semua Status</option>
                            <option value="LAYAK" {{ request('status') === 'LAYAK' ? 'selected' : '' }}>Hanya Layak Bantuan</option>
                            <option value="TIDAK_LAYAK" {{ request('status') === 'TIDAK_LAYAK' ? 'selected' : '' }}>Hanya Tidak Layak</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-forest/40 uppercase tracking-widest">Tanggal Mulai</label>
                        <input type="date" name="tgl_mulai" value="{{ request('tgl_mulai') }}" class="w-full border-premium-border/30 rounded-xl bg-paper text-forest focus:ring-forest focus:border-forest text-sm">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-[10px] font-black text-forest/40 uppercase tracking-widest">Tanggal Akhir</label>
                        <input type="date" name="tgl_selesai" value="{{ request('tgl_selesai') }}" class="w-full border-premium-border/30 rounded-xl bg-paper text-forest focus:ring-forest focus:border-forest text-sm">
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-premium-border/20 flex flex-wrap gap-3 items-center justify-between">
                    <div class="flex gap-2">
                        <button type="submit" class="bg-forest text-cream px-6 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-forest/20 hover:bg-forest-dark transition-all hover:-translate-y-0.5">
                            Terapkan Filter
                        </button>
                        @if(request()->anyFilled(['kelurahan_id', 'status', 'tgl_mulai', 'tgl_selesai']))
                        <a href="{{ route('laporan.index') }}" class="px-4 py-2.5 rounded-xl border border-premium-border/40 text-forest/60 hover:bg-paper transition-colors flex items-center justify-center gap-2 text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Reset
                        </a>
                        @endif
                    </div>

                    @if($laporan->total() > 0)
                    <button type="button"
                            onclick="window.open('{{ route('laporan.cetak', request()->all()) }}', '_blank')"
                            class="flex items-center gap-2 px-6 py-2.5 bg-emerald-600 text-white rounded-xl text-sm font-black uppercase tracking-widest shadow-lg shadow-emerald-600/20 hover:bg-emerald-700 transition-all hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Export Excel
                    </button>
                    @endif
                </div>
            </form>
        </div>

        {{-- =============================================
             PREVIEW TABLE
             ============================================= --}}
        <div class="bg-white/70 backdrop-blur-sm rounded-2xl border border-premium-border/50 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-premium-border/30 flex items-center justify-between bg-paper/30">
                <div>
                    <h3 class="font-serif font-bold text-forest text-sm">Pratinjau Data Laporan</h3>
                    <p class="text-[10px] text-forest/40 uppercase tracking-widest font-bold mt-0.5">Menampilkan data sesuai urutan prioritas (Skor Tertinggi)</p>
                </div>
                <div class="text-[10px] font-black text-forest bg-forest/5 px-3 py-1 rounded-full">
                    Total: {{ $laporan->total() }} Data
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-forest">
                    <thead class="bg-forest/5 text-[10px] uppercase font-black tracking-widest text-forest/40">
                        <tr>
                            <th class="px-6 py-4 rounded-tl-2xl">Rank</th>
                            <th class="px-6 py-4">Nama / NIK</th>
                            <th class="px-6 py-4">Kelurahan</th>
                            <th class="px-6 py-4">Status & Rekomendasi</th>
                            <th class="px-6 py-4 text-right rounded-tr-2xl">Skor Z*</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-premium-border/20">
                        @forelse($laporan as $index => $item)
                        @php
                            $isLayak = $item->kategori_kelayakan === 'LAYAK';
                            $actualRank = $laporan->firstItem() + $index;
                        @endphp
                        <tr class="hover:bg-paper/50 transition-colors">
                            <td class="px-6 py-4">
                                <span class="w-8 h-8 rounded-full flex items-center justify-center text-[10px] font-black {{ $actualRank <= 3 ? 'bg-premium-amber/20 text-premium-amber' : 'bg-forest/10 text-forest/60' }}">
                                    #{{ $actualRank }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-bold text-forest">{{ $item->penilaian->penduduk->nama_lengkap }}</div>
                                <div class="text-[10px] text-forest/40 font-mono mt-0.5">{{ $item->penilaian->penduduk->nik }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-bold text-forest/70">{{ $item->penilaian->penduduk->kelurahan->nama ?? '-' }}</span>
                            </td>
                             <td class="px-6 py-4">
                                <div class="flex items-center gap-2 mb-1 flex-wrap">
                                    <span class="w-2 h-2 rounded-full {{ $isLayak ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                                    <span class="text-[10px] font-black uppercase tracking-widest {{ $isLayak ? 'text-emerald-700' : 'text-red-700' }}">
                                        {{ str_replace('_', ' ', $item->kategori_kelayakan) }}
                                    </span>
                                    <span class="px-2 py-0.5 rounded text-[8px] font-black uppercase tracking-wider {{ $item->penilaian->verifikasi_status === 'valid' ? 'bg-forest/10 text-forest' : 'bg-blue-100 text-blue-800' }}">
                                        {{ $item->penilaian->verifikasi_status }}
                                    </span>
                                </div>
                                <p class="text-[10px] text-forest/50 italic">{{ Str::limit($item->rekomendasi, 40) }}</p>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="font-mono font-bold text-lg {{ $isLayak ? 'text-emerald-600' : 'text-red-600' }}">
                                    {{ number_format($item->nilai_defuzzifikasi, 2) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-forest/40">
                                <svg class="w-12 h-12 mx-auto mb-3 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                @if(auth()->user()->role === 'admin')
                                    <p class="text-sm font-bold uppercase tracking-widest mb-1">Belum ada data penilaian yang terverifikasi</p>
                                    <p class="text-[10px] uppercase tracking-[0.2em] opacity-60">Pastikan data usulan telah diverifikasi pada menu penilaian</p>
                                @else
                                    <p class="text-sm font-bold uppercase tracking-widest mb-1">Belum ada data penilaian yang valid</p>
                                    <p class="text-[10px] uppercase tracking-[0.2em] opacity-60">Pastikan Camat telah melakukan validasi pada menu penilaian</p>
                                @endif
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($laporan->hasPages())
            <div class="px-6 py-4 border-t border-premium-border/30 bg-paper/30">
                {{ $laporan->links() }}
            </div>
            @endif
        </div>


    </div>
</x-app-layout>
