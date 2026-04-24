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
        <a href="{{ route('penduduk.create') }}" class="group inline-flex items-center px-8 py-4 bg-forest text-cream rounded-[1.5rem] font-bold text-xs uppercase tracking-widest hover:bg-forest/90 transition-all duration-500 shadow-xl shadow-forest/20 hover:-translate-y-1 active:translate-y-0">
            <svg class="w-4 h-4 mr-3 group-hover:rotate-90 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Penduduk
        </a>
    </div>

    <div class="bg-white/60 backdrop-blur-md overflow-hidden shadow-sm rounded-[2.5rem] border border-premium-border/50 transition-all duration-500 hover:shadow-2xl hover:shadow-forest/5">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse">
                <thead>
                    <tr class="text-[10px] text-forest/40 uppercase bg-paper/20 border-b border-premium-border/20 font-black tracking-[0.2em]">
                        <th class="px-10 py-6">Profil Penduduk</th>
                        <th class="px-10 py-6">Lokasi / Alamat</th>
                        <th class="px-10 py-6 text-center">Kelurahan</th>
                        <th class="px-10 py-6">Kompensasi / Gaji</th>
                        <th class="px-10 py-6">Data Fisik</th>
                        <th class="px-10 py-6 text-right">Manajemen</th>
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
                        <td class="px-10 py-6">
                            @if($p->rumah)
                            <span class="inline-flex items-center text-[9px] font-black text-forest uppercase tracking-widest bg-forest/5 px-3 py-1.5 rounded-lg border border-forest/10">
                                <span class="w-1.5 h-1.5 rounded-full bg-forest mr-2 shadow-[0_0_8px_rgba(26,58,42,0.5)]"></span>
                                Terverifikasi
                            </span>
                            @else
                            <span class="inline-flex items-center text-[9px] font-black text-amber uppercase tracking-widest bg-amber/5 px-3 py-1.5 rounded-lg border border-amber/10">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber mr-2"></span>
                                Perlu Input
                            </span>
                            @endif
                        </td>
                        <td class="px-10 py-6 text-right">
                            <div class="flex justify-end items-center space-x-6">
                                <a href="{{ route('penduduk.show', $p) }}" class="text-forest hover:text-amber font-black text-[10px] uppercase tracking-[0.15em] transition-all duration-300 transform hover:scale-110">Detail</a>
                                <a href="{{ route('penduduk.edit', $p) }}" class="text-forest/30 hover:text-forest font-black text-[10px] uppercase tracking-[0.15em] transition-all duration-300">Edit</a>
                                <form action="{{ route('penduduk.destroy', $p) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-300 hover:text-red-600 transition-all duration-300 transform hover:rotate-12" onclick="return confirm('Hapus data ini?')">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </form>
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
                                <p class="text-forest/40 font-serif italic text-lg tracking-tight">Belum ada profil penduduk dalam sistem.</p>
                                <a href="{{ route('penduduk.create') }}" class="mt-6 text-xs font-black text-amber uppercase tracking-widest hover:text-forest transition-colors">Daftarkan Penduduk →</a>
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