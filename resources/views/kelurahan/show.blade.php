<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <nav class="flex mb-4" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-3">
                            <li class="inline-flex items-center">
                                <a href="{{ route('kelurahan.index') }}" class="text-sm font-bold text-forest/50 hover:text-forest transition-colors duration-300">Kelurahan</a>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <svg class="w-3 h-3 text-forest/30 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                    </svg>
                                    <span class="ml-1 text-sm font-bold text-forest/80 md:ml-2">Detail Wilayah</span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                    <h2 class="font-serif text-4xl font-bold text-forest leading-tight tracking-tight">
                        Detail <span class="text-amber italic">Kelurahan</span>
                    </h2>
                    <p class="mt-2 text-lg text-forest/60 font-medium italic">"{{ $kelurahan->nama }}"</p>
                </div>
                
                <div class="flex items-center space-x-3">
                    <a href="{{ route('kelurahan.edit', $kelurahan) }}" class="inline-flex items-center px-4 py-2 bg-amber border border-amber/20 rounded-xl font-bold text-xs text-forest uppercase tracking-widest hover:bg-amber/90 transition-all duration-300 shadow-sm">
                        <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Wilayah
                    </a>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Info Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white/70 backdrop-blur-sm p-8 rounded-3xl shadow-sm border border-premium-border/50 relative overflow-hidden">
                        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-forest/5 rounded-full blur-2xl"></div>
                        
                        <h3 class="font-serif text-xl font-bold text-forest mb-6 flex items-center">
                            <span class="w-8 h-8 rounded-lg bg-forest/10 flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-forest" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m17.657 16.657-3.414-3.414m0-4.243 4.243-4.243m-8.485 8.485L7.757 14.83a4.472 4.472 0 0 0 3.172-1.314l3.172-3.172a4.472 4.472 0 0 0-1.314-3.172l-3.172-3.172" />
                                </svg>
                            </span>
                            Informasi Umum
                        </h3>

                        <div class="space-y-6">
                            <div>
                                <span class="text-[10px] font-bold text-forest/40 uppercase tracking-[0.2em] block mb-1">Kode Wilayah</span>
                                <p class="text-xl font-mono font-bold text-forest tracking-tight">{{ $kelurahan->kode ?? '-' }}</p>
                            </div>
                            
                            <div>
                                <span class="text-[10px] font-bold text-forest/40 uppercase tracking-[0.2em] block mb-1">Jumlah Penduduk</span>
                                <div class="flex items-baseline space-x-2">
                                    <p class="text-3xl font-serif font-bold text-forest">{{ $kelurahan->penduduk->count() }}</p>
                                    <span class="text-sm font-medium text-forest/60 italic">jiwa terdaftar</span>
                                </div>
                            </div>

                            <div class="pt-6 border-t border-premium-border/30">
                                <span class="text-[10px] font-bold text-forest/40 uppercase tracking-[0.2em] block mb-2">Deskripsi / Batas</span>
                                <p class="text-sm text-forest/70 leading-relaxed italic">
                                    "{{ $kelurahan->batas_wilayah ?? 'Tidak ada deskripsi wilayah yang tercatat.' }}"
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Resident Table -->
                <div class="lg:col-span-2">
                    <div class="bg-forest/[0.02] backdrop-blur-sm rounded-3xl shadow-sm border border-premium-border/30 overflow-hidden">
                        <div class="px-8 py-6 border-b border-premium-border/30 flex items-center justify-between bg-white/40">
                            <h3 class="font-serif text-xl font-bold text-forest">Daftar Penduduk</h3>
                            <a href="{{ route('penduduk.create', ['kelurahan_id' => $kelurahan->id]) }}" class="text-sm font-bold text-forest hover:text-amber transition-colors duration-300 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Tambah Penduduk
                            </a>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-forest/5">
                                        <th class="px-8 py-4 text-[10px] font-bold text-forest/40 uppercase tracking-widest">Penduduk</th>
                                        <th class="px-8 py-4 text-[10px] font-bold text-forest/40 uppercase tracking-widest">Status Kelayakan</th>
                                        <th class="px-8 py-4 text-right"></th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-premium-border/20 text-sm">
                                    @forelse($kelurahan->penduduk as $p)
                                        <tr class="group hover:bg-white/60 transition-all duration-300">
                                            <td class="px-8 py-5">
                                                <div class="flex items-center">
                                                    <div class="w-10 h-10 rounded-full bg-forest/10 flex items-center justify-center mr-4 group-hover:bg-forest group-hover:text-cream transition-all duration-300">
                                                        <span class="font-serif font-bold">{{ substr($p->nama_lengkap, 0, 1) }}</span>
                                                    </div>
                                                    <div>
                                                        <p class="font-bold text-forest group-hover:text-forest/80">{{ $p->nama_lengkap }}</p>
                                                        <p class="text-xs font-mono text-forest/40">{{ $p->nik }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-8 py-5">
                                                @php $latest = $p->penilaian->last(); @endphp
                                                @if($latest && $latest->hasilSPK)
                                                    <div class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold {{ $latest->hasilSPK->kategori_kelayakan == 'LAYAK' ? 'bg-forest/10 text-forest' : 'bg-amber/10 text-amber' }}">
                                                        <span class="w-1.5 h-1.5 rounded-full mr-2 {{ $latest->hasilSPK->kategori_kelayakan == 'LAYAK' ? 'bg-forest' : 'bg-amber' }}"></span>
                                                        {{ $latest->hasilSPK->kategori_kelayakan }}
                                                    </div>
                                                @else
                                                    <span class="text-forest/30 italic text-xs">Belum Dinilai</span>
                                                @endif
                                            </td>
                                            <td class="px-8 py-5 text-right">
                                                <a href="{{ route('penduduk.show', $p) }}" class="inline-flex items-center px-3 py-1.5 bg-forest border border-forest/10 rounded-lg font-bold text-[10px] text-cream uppercase tracking-widest hover:bg-forest/90 transition-all duration-300">
                                                    Profil
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="px-8 py-12 text-center">
                                                <div class="flex flex-col items-center">
                                                    <svg class="w-12 h-12 text-forest/10 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                                    </svg>
                                                    <p class="text-forest/40 font-medium italic">Belum ada data penduduk di kelurahan ini.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

