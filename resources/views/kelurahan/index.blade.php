<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif font-bold text-3xl text-forest leading-tight py-4">
            {{ __('Daftar Kelurahan') }}
        </h2>
    </x-slot>

    <div class="mb-8 flex justify-between items-end">
        <div>
            <p class="text-forest/60 text-sm italic">Entitas wilayah administratif Kecamatan Plaju.</p>
            <div class="h-1 w-12 bg-amber/30 mt-2 rounded-full"></div>
        </div>
        <a href="{{ route('kelurahan.create') }}" class="group inline-flex items-center px-8 py-4 bg-forest text-cream rounded-[1.5rem] font-bold text-xs uppercase tracking-widest hover:bg-forest/90 transition-all duration-500 shadow-xl shadow-forest/20 hover:-translate-y-1 active:translate-y-0">
            <svg class="w-4 h-4 mr-3 group-hover:rotate-90 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Wilayah
        </a>
    </div>

    <div class="bg-white/60 backdrop-blur-md overflow-hidden shadow-sm rounded-[2.5rem] border border-premium-border/50 transition-all duration-500 hover:shadow-2xl hover:shadow-forest/5">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse">
                <thead>
                    <tr class="text-[10px] text-forest/40 uppercase bg-paper/20 border-b border-premium-border/20 font-black tracking-[0.2em]">
                        <th class="px-10 py-6">Nama Wilayah</th>
                        <th class="px-10 py-6 text-center">Kode Arsip</th>
                        <th class="px-10 py-6 text-center">Densitas Penduduk</th>
                        <th class="px-10 py-6 text-right">Opsi Operasi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-premium-border/10">
                    @forelse ($kelurahan as $k)
                    <tr class="hover:bg-cream/30 transition-all duration-300 group">
                        <td class="px-10 py-6">
                            <div class="flex items-center">
                                <div>
                                    <div class="font-serif font-bold text-forest text-lg group-hover:text-forest-dark transition-colors">{{ $k->nama }}</div>
                                    <!-- <div class="text-[10px] font-black text-forest/30 uppercase tracking-[0.1em]">Kelurahan Terdaftar</div> -->
                                </div>
                            </div>
                        </td>
                        <td class="px-10 py-6 text-center">
                            <span class="font-mono text-xs font-bold text-forest/50 bg-paper/50 px-3 py-1 rounded-lg border border-premium-border/30">
                                {{ $k->kode ?? 'N/A' }}
                            </span>
                        </td>
                        <td class="px-10 py-6 text-center">
                            <div class="inline-flex flex-col">
                                <div class="text-base font-serif font-bold text-forest">
                                    {{ $k->penduduk_count ?? $k->penduduk()->count() }}
                                </div>
                                <div class="text-[9px] font-black text-forest/30 uppercase tracking-widest">JIWA TERDATA</div>
                            </div>
                        </td>
                        <td class="px-10 py-6 text-right">
                            <div class="flex justify-end items-center space-x-6">
                                <a href="{{ route('kelurahan.show', $k) }}" class="text-forest hover:text-amber font-black text-[10px] uppercase tracking-[0.15em] transition-all duration-300">View</a>
                                <a href="{{ route('kelurahan.edit', $k) }}" class="text-forest/30 hover:text-forest font-black text-[10px] uppercase tracking-[0.15em] transition-all duration-300">Edit</a>
                                <form action="{{ route('kelurahan.destroy', $k) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-300 hover:text-red-600 transition-all duration-300" onclick="return confirm('Hapus data ini?')">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-10 py-24 text-center">
                            <p class="text-forest/30 font-serif italic text-lg tracking-tight">Database wilayah masih kosong.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>