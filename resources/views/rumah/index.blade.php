<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif font-bold text-3xl text-forest leading-tight py-4">
            {{ __('Inventaris Kondisi Rumah') }}
        </h2>
    </x-slot>

    <div class="mb-8 flex justify-between items-end">
        <div>
            <p class="text-forest/60 text-sm italic">Basis data teknis kelayakan fisik bangunan Kecamatan Plaju.</p>
            <div class="h-1 w-12 bg-amber/30 mt-2 rounded-full"></div>
        </div>
        <a href="{{ route('rumah.create') }}" class="group inline-flex items-center px-8 py-4 bg-forest text-cream rounded-[1.5rem] font-bold text-xs uppercase tracking-widest hover:bg-forest/90 transition-all duration-500 shadow-xl shadow-forest/20 hover:-translate-y-1 active:translate-y-0">
            <svg class="w-4 h-4 mr-3 group-hover:rotate-90 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
            </svg>
            Audit Rumah Baru
        </a>
    </div>

    <div class="bg-white/60 backdrop-blur-md overflow-hidden shadow-sm rounded-[2.5rem] border border-premium-border/50 transition-all duration-500 hover:shadow-2xl hover:shadow-forest/5">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse">
                <thead>
                    <tr class="text-[10px] text-forest/40 uppercase bg-paper/20 border-b border-premium-border/20 font-black tracking-[0.2em]">
                        <th class="px-10 py-6">Entitas Pemilik</th>
                        <th class="px-10 py-6 text-center">Spasial (m²)</th>
                        <th class="px-10 py-6 text-center">Indikator Teknis (A/D/L)</th>
                        <th class="px-10 py-6">Sertifikasi Hak</th>
                        <th class="px-10 py-6 text-right">Audit</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-premium-border/10">
                    @forelse ($rumah as $r)
                    <tr class="hover:bg-cream/30 transition-all duration-300 group">
                        <td class="px-10 py-6">
                            <div class="flex items-center">
                                <div class="w-12 h-12 rounded-[1.25rem] bg-forest/5 flex items-center justify-center text-forest font-serif font-bold text-lg mr-4 border border-forest/10 group-hover:bg-forest group-hover:text-cream transition-all duration-500">
                                    {{ substr($r->penduduk->nama_lengkap, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-serif font-bold text-forest text-base group-hover:text-forest-dark transition-colors">{{ $r->penduduk->nama_lengkap }}</div>
                                    <div class="text-[10px] font-black text-forest/30 uppercase tracking-[0.05em]">{{ $r->penduduk->kelurahan->nama }} • {{ $r->penduduk->nik }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-10 py-6 text-center">
                            <div class="flex flex-col">
                                <div class="text-lg font-serif font-bold text-forest leading-none">{{ $r->luas_bangunan }}</div>
                                <div class="text-[8px] font-black text-forest/30 uppercase mt-1">SQM AREA</div>
                            </div>
                        </td>
                        <td class="px-10 py-6 text-center">
                            <div class="flex justify-center space-x-2">
                                @foreach(['atap' => $r->kondisi_atap, 'dinding' => $r->kondisi_dinding, 'lantai' => $r->kondisi_lantai] as $key => $val)
                                <div class="flex flex-col items-center group/indicator">
                                    <div class="w-8 h-8 rounded-lg flex items-center justify-center text-[10px] font-black {{ $val < 50 ? 'bg-red-50 text-red-600 border border-red-100 shadow-[inset_0_0_10px_rgba(239,68,68,0.05)]' : 'bg-green-50 text-green-600 border border-green-100 shadow-[inset_0_0_10px_rgba(34,197,94,0.05)]' }} transition-transform duration-300 group-hover/indicator:-translate-y-1">
                                        {{ $val }}
                                    </div>
                                    <span class="text-[7px] font-black text-forest/30 uppercase mt-1 tracking-tighter">{{ substr($key, 0, 1) }}</span>
                                </div>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-10 py-6">
                            <span class="inline-flex px-3 py-1.5 rounded-[0.5rem] text-[9px] font-black text-forest uppercase tracking-widest bg-paper border border-premium-border/50 group-hover:bg-amber/5 group-hover:text-amber group-hover:border-amber/10 transition-all duration-500">
                                {{ strtoupper($r->status_kepemilikan) }}
                            </span>
                        </td>
                        <td class="px-10 py-6 text-right">
                            <div class="flex justify-end items-center space-x-4">
                                <a href="{{ route('rumah.edit', $r) }}" class="p-3 text-forest/30 hover:text-forest bg-paper/30 rounded-2xl transition-all duration-300 border border-transparent hover:border-premium-border hover:shadow-lg">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                </a>
                                <form action="{{ route('rumah.destroy', $r) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-3 text-red-300 hover:text-red-600 bg-red-50/30 rounded-2xl transition-all duration-300 border border-transparent hover:border-red-100" onclick="return confirm('Hapus audit ini?')">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-10 py-24 text-center">
                            <p class="text-forest/30 font-serif italic text-lg tracking-tight">Belum ada audit teknis yang dicatatkan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($rumah->hasPages())
        <div class="px-10 py-8 bg-paper/5 border-t border-premium-border/10">
            {{ $rumah->links() }}
        </div>
        @endif
    </div>
</x-app-layout>