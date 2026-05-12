<div class="flex flex-wrap gap-2 items-center {{ $layout === 'table' ? 'justify-center' : '' }}">
    {{-- Lihat Detail (Semua Role) --}}
    <a href="{{ route('penduduk.show', $p->penduduk) }}" 
       title="Lihat Detail Penduduk"
       class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-forest/10 hover:bg-forest text-forest hover:text-cream text-[9px] font-black uppercase tracking-widest transition-all duration-200 group">
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
        <span>Detail</span>
    </a>

    {{-- Aksi Berdasarkan Role --}}
    @if(Auth::user()->role === 'operator')
        @if(in_array($p->verifikasi_status, ['draft', 'dikembalikan']))
            <form action="{{ route('penilaian.kirim', $p) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-[9px] font-black uppercase tracking-widest transition-all duration-200">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    {{ $p->verifikasi_status === 'dikembalikan' ? 'Kirim Ulang' : 'Kirim' }}
                </button>
            </form>
        @endif
    @endif

    @if(Auth::user()->role === 'admin')
        @if($p->verifikasi_status === 'dikirim')
            <form action="{{ route('penilaian.verifikasi', $p) }}" method="POST" class="inline">
                @csrf
                <input type="hidden" name="status" value="terverifikasi">
                <button type="submit" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-[9px] font-black uppercase tracking-widest transition-all duration-200">
                    ✓ Verifikasi
                </button>
            </form>
            
            <button type="button" 
                    onclick="const c = prompt('Masukkan alasan pengembalian:'); if(c) { document.getElementById('form-kembalikan-{{ $layout }}-{{ $p->id }}').catatan.value = c; document.getElementById('form-kembalikan-{{ $layout }}-{{ $p->id }}').submit(); }"
                    class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-red-100 hover:bg-red-200 text-red-700 text-[9px] font-black uppercase tracking-widest transition-all duration-200">
                ✕ Kembalikan
            </button>
            <form id="form-kembalikan-{{ $layout }}-{{ $p->id }}" action="{{ route('penilaian.verifikasi', $p) }}" method="POST" class="hidden">
                @csrf
                <input type="hidden" name="status" value="dikembalikan">
                <input type="hidden" name="catatan" value="">
            </form>
        @endif
    @endif

    @if(Auth::user()->role === 'camat')
        @if($p->verifikasi_status === 'terverifikasi')
            <form action="{{ route('penilaian.validasi', $p) }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-forest text-cream text-[9px] font-black uppercase tracking-widest transition-all duration-200 shadow-md">
                    ✓ Validasi
                </button>
            </form>
        @endif
    @endif

    {{-- Edit Data Rumah (Operator/Admin jika status masih draft/revisi) --}}
    @if(in_array($p->verifikasi_status, ['draft', 'dikembalikan']) && $rumah)
        <a href="{{ route('rumah.edit', $rumah) }}" 
           title="Edit Data Rumah"
           class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-amber-50 hover:bg-amber-500 text-amber-600 hover:text-white text-[9px] font-black uppercase tracking-widest transition-all duration-200">
            Edit Data
        </a>
    @endif
</div>
