<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif font-bold text-3xl text-forest leading-tight py-4">
            {{ __('Data Penduduk') }}
        </h2>
    </x-slot>

    <div class="mb-8 flex justify-between items-end">
        <div>
            <p class="text-forest/60 text-sm italic">Kelola profil demografi dan basis data subjek bantuan.</p>
            <div class="h-1 w-12 bg-amber/30 mt-2 rounded-full"></div>
        </div>

        @if(auth()->user()->role === 'operator')
        <a href="{{ route('penduduk.create') }}" class="group inline-flex items-center px-8 py-4 bg-forest text-cream rounded-[1.5rem] font-bold text-xs uppercase tracking-widest hover:bg-forest/90 transition-all duration-500 shadow-xl shadow-forest/20 hover:-translate-y-1 active:translate-y-0">
            <svg class="w-4 h-4 mr-3 group-hover:rotate-90 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Penduduk
        </a>
        @endif
    </div>

    @if(auth()->user()->role === 'admin')
    <div class="mb-8">
        <div class="bg-amber-50 border border-amber-200 rounded-[2rem] p-6 flex items-center shadow-sm">
            <div class="w-12 h-12 bg-amber-100 rounded-2xl flex items-center justify-center text-amber-600 mr-5 shrink-0 shadow-inner">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div>
                <p class="text-xs font-black text-amber-800 uppercase tracking-[0.2em] mb-1">Antrian Verifikasi</p>
                <p class="text-sm text-amber-700/80 font-medium leading-relaxed">Silahkan verifikasi data usulan yang telah dikirim melalui halaman <a href="{{ route('penilaian.index') }}" class="font-bold text-amber-900 underline decoration-amber-300 underline-offset-4 hover:decoration-amber-900 transition-all">Verifikasi Usulan / Penilaian</a>.</p>
            </div>
        </div>
    </div>
    @elseif(auth()->user()->role === 'camat')
    <div class="mb-8">
        <div class="bg-forest/5 border border-forest/10 rounded-[2rem] p-6 flex items-center shadow-sm">
            <div class="w-12 h-12 bg-forest/10 rounded-2xl flex items-center justify-center text-forest mr-5 shrink-0 shadow-inner">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div>
                <p class="text-xs font-black text-forest uppercase tracking-[0.2em] mb-1">Antrian Validasi</p>
                <p class="text-sm text-forest/70 font-medium leading-relaxed">Terdapat usulan yang telah diverifikasi. Silahkan lakukan pengesahan pada menu <a href="{{ route('penilaian.index') }}" class="font-bold text-forest underline decoration-forest/30 underline-offset-4 hover:decoration-forest transition-all">Validasi & Perankingan</a>.</p>
            </div>
        </div>
    </div>
    @endif

    @if(auth()->user()->role !== 'operator')
    <div class="mb-8">
        <h3 class="text-[10px] font-black text-forest/40 uppercase tracking-[0.2em] mb-4">Filter Status Usulan</h3>
        <div class="flex flex-wrap gap-2">
            @php
                $currentStatus = request('status');
                $availableStatuses = [];
                if(auth()->user()->role === 'admin') {
                    $availableStatuses = [
                        'dikirim' => 'Menunggu Verifikasi',
                        'dikembalikan' => 'Perlu Revisi',
                        'terverifikasi' => 'Terverifikasi',
                        'valid' => 'Selesai/Valid',
                    ];
                } elseif(auth()->user()->role === 'camat') {
                    $availableStatuses = [
                        'terverifikasi' => 'Menunggu Validasi',
                        'valid' => 'Selesai/Valid',
                    ];
                }
            @endphp

            <a href="{{ route('penduduk.index') }}" 
               class="px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all duration-300 border {{ !$currentStatus ? 'bg-forest text-cream border-forest shadow-lg shadow-forest/20' : 'bg-white text-forest/40 border-premium-border hover:border-forest/30 hover:text-forest' }}">
               Semua Data
            </a>

            @foreach($availableStatuses as $statusKey => $label)
                <a href="{{ route('penduduk.index', ['status' => $statusKey]) }}" 
                   class="px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all duration-300 border {{ $currentStatus === $statusKey ? 'bg-forest text-cream border-forest shadow-lg shadow-forest/20' : 'bg-white text-forest/40 border-premium-border hover:border-forest/30 hover:text-forest' }}">
                   {{ $label }}
                </a>
            @endforeach
        </div>
    </div>
    @endif

    <div class="bg-white/60 backdrop-blur-md overflow-hidden shadow-sm rounded-[2.5rem] border border-premium-border/50 transition-all duration-500 hover:shadow-2xl hover:shadow-forest/5">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse">
                <thead>
                    <tr class="text-[10px] text-forest/40 uppercase bg-paper/20 border-b border-premium-border/20 font-black tracking-[0.2em]">
                        <th class="px-10 py-6">Profil Penduduk</th>
                        <th class="px-10 py-6">Lokasi / Alamat</th>
                        <th class="px-10 py-6 text-center">Kelurahan</th>
                        <th class="px-10 py-6">Kompensasi / Gaji</th>
                        <th class="px-10 py-6 text-center">Status Usulan</th>
                        <th class="px-10 py-6 text-right">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-premium-border/10">
                    @forelse ($penduduk as $p)
                    <tr class="hover:bg-cream/30 transition-all duration-300 group">
                        <td class="px-10 py-6">
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-2xl bg-forest/5 flex items-center justify-center text-forest font-serif font-bold text-lg mr-4 border border-forest/10 group-hover:bg-forest group-hover:text-cream transition-all duration-500">
                                    {{ substr($p->nama_lengkap, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-serif font-bold text-forest text-base group-hover:text-forest-dark transition-colors">{{ $p->nama_lengkap }}</div>
                                    <div class="text-[10px] font-mono font-bold text-forest/40 tracking-tighter">{{ $p->nik }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-10 py-6">
                            <div class="text-xs text-forest/60 font-medium leading-relaxed italic max-w-xs">
                                "{{ Str::limit($p->alamat, 45) }}"
                            </div>
                        </td>
                        <td class="px-10 py-6 text-center">
                            <span class="inline-flex items-center px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-wider bg-paper text-forest border border-premium-border/50 group-hover:bg-amber/10 group-hover:text-amber group-hover:border-amber/20 transition-all duration-500">
                                {{ $p->kelurahan->nama }}
                            </span>
                        </td>
                        <td class="px-10 py-6">
                            <div class="flex flex-col">
                                <div class="text-sm font-serif font-bold text-forest tracking-tight">
                                    {{ number_format($p->penghasilan, 0, ',', '.') }}
                                </div>
                                <div class="text-[9px] font-black text-forest/30 uppercase tracking-widest">IDR / BULAN</div>
                            </div>
                        </td>
                        <td class="px-10 py-6 text-center">
                            @php
                                $latestPenilaian = $p->penilaian->last();
                                $status = 'perlu_input';
                                if ($p->rumah) {
                                    $status = $latestPenilaian ? $latestPenilaian->verifikasi_status : 'draft_penilaian';
                                }

                                $statusConfig = [
                                    'perlu_input' => ['label' => 'Perlu Input Rumah', 'color' => 'bg-red-50 text-red-600 border-red-100'],
                                    'draft_penilaian' => ['label' => 'Draft Penilaian', 'color' => 'bg-slate-50 text-slate-500 border-slate-200'],
                                    'draft' => ['label' => 'Belum Dikirim', 'color' => 'bg-blue-50 text-blue-500 border-blue-200'],
                                    'dikirim' => ['label' => 'Menunggu Verifikasi', 'color' => 'bg-blue-600 text-white border-blue-600 shadow-sm shadow-blue-200'],
                                    'dikembalikan' => ['label' => 'Perlu Revisi', 'color' => 'bg-red-600 text-white border-red-600 shadow-sm shadow-red-200'],
                                    'terverifikasi' => ['label' => 'Terverifikasi', 'color' => 'bg-emerald-100 text-emerald-700 border-emerald-200'],
                                    'valid' => ['label' => 'Disahkan (Valid)', 'color' => 'bg-forest text-cream border-forest shadow-lg shadow-forest/10'],
                                ];

                                $cfg = $statusConfig[$status] ?? ['label' => strtoupper($status), 'color' => 'bg-gray-100 text-gray-500 border-gray-200'];
                            @endphp
                            <div class="flex flex-col items-center gap-2">
                                <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-[8px] font-black uppercase tracking-widest border {{ $cfg['color'] }}">
                                    {{ $cfg['label'] }}
                                </span>

                                @if(auth()->user()->role === 'operator')
                                    @if(!$p->rumah)
                                        <a href="{{ route('rumah.create', ['penduduk_id' => $p->id]) }}" class="text-[9px] font-bold text-red-500 hover:text-red-700 transition-colors flex items-center group/link">
                                            <svg class="w-3 h-3 mr-1 group-hover/link:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                                            Lengkapi Data
                                        </a>
                                    @elseif($status !== 'valid' && $status !== 'terverifikasi')
                                        <a href="{{ route('rumah.edit', $p->rumah) }}" class="text-[9px] font-bold text-forest/40 hover:text-forest transition-colors flex items-center">
                                            <svg class="w-2.5 h-2.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                            Update Rumah
                                        </a>
                                    @endif
                                @endif
                            </div>
                        </td>
                        <td class="px-10 py-6 text-right">
                            <div class="flex justify-end items-center space-x-6">
                                <a href="{{ route('penduduk.show', $p) }}" class="text-forest hover:text-amber font-black text-[10px] uppercase tracking-[0.15em] transition-all duration-300 transform hover:scale-110">Detail</a>
                                
                                @if(auth()->user()->role === 'operator')
                                <a href="{{ route('penduduk.edit', $p) }}" class="text-forest/30 hover:text-forest font-black text-[10px] uppercase tracking-[0.15em] transition-all duration-300">Edit</a>
                                <form action="{{ route('penduduk.destroy', $p) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-300 hover:text-red-600 transition-all duration-300 transform hover:rotate-12" onclick="return confirm('Hapus data ini?')">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-10 py-24 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 bg-paper/30 rounded-[2rem] flex items-center justify-center mb-6 text-forest/10 border border-premium-border/20">
                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                </div>
                                <p class="text-forest/40 font-serif italic text-lg tracking-tight">
                                    @if(auth()->user()->role === 'operator')
                                        Belum ada profil penduduk dalam sistem.
                                    @else
                                        Semua tugas usulan telah selesai diproses.
                                    @endif
                                </p>
                                @if(auth()->user()->role === 'operator')
                                <a href="{{ route('penduduk.create') }}" class="mt-6 text-xs font-black text-amber uppercase tracking-widest hover:text-forest transition-colors">Daftarkan Penduduk →</a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($penduduk->hasPages())
        <div class="px-10 py-8 bg-paper/5 border-t border-premium-border/10">
            {{ $penduduk->links() }}
        </div>
        @endif
    </div>
</x-app-layout>