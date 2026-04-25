<x-app-layout>
    <x-slot name="header">
        <div class="py-2">
            <h2 class="font-serif font-bold text-2xl text-forest leading-tight">
                Kriteria & Konfigurasi Fuzzy
            </h2>
            <p class="text-xs text-forest/40 font-bold tracking-widest uppercase mt-1">
                Variabel · Fungsi Keanggotaan · Rule Base — Mamdani Inference System
            </p>
        </div>
    </x-slot>

    <div class="space-y-10 pb-12">

        {{-- =============================================
             SECTION 1: Overview Alur Mamdani
             ============================================= --}}
        <div class="bg-white/70 backdrop-blur-sm rounded-2xl border border-premium-border/50 shadow-sm p-8">
            <h3 class="font-serif font-bold text-forest text-lg mb-6 flex items-center">
                <span class="w-8 h-8 rounded-lg bg-forest/10 flex items-center justify-center text-forest mr-3 text-sm font-black">∿</span>
                Alur Sistem Fuzzy Mamdani
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-5 gap-2 items-center">
                @php
                $steps = [
                    ['icon' => '📥', 'label' => 'Input Crisp', 'desc' => 'Data kondisi rumah dikonversi ke nilai numerik (0–1 atau m²/org)'],
                    ['icon' => '〰️', 'label' => 'Fuzzifikasi', 'desc' => 'Nilai crisp dipetakan ke derajat keanggotaan tiap Fuzzy Set'],
                    ['icon' => '📋', 'label' => 'Evaluasi Rule', 'desc' => '37 aturan dievaluasi dengan operator AND (MIN)'],
                    ['icon' => '⊕', 'label' => 'Komposisi MAX', 'desc' => 'Hasil tiap aturan digabung dengan fungsi MAX'],
                    ['icon' => '📤', 'label' => 'Defuzzifikasi', 'desc' => 'Centroid COA menghasilkan nilai crisp Z* (0–100)'],
                ];
                @endphp
                @foreach($steps as $i => $step)
                <div class="flex flex-col items-center text-center">
                    <div class="w-14 h-14 rounded-2xl bg-forest/5 border border-premium-border/40 flex items-center justify-center text-2xl mb-2">
                        {{ $step['icon'] }}
                    </div>
                    <p class="text-[10px] font-black text-forest uppercase tracking-widest">{{ $step['label'] }}</p>
                    <p class="text-[9px] text-forest/40 mt-1 leading-relaxed">{{ $step['desc'] }}</p>
                </div>
                @if($i < 4)
                <div class="hidden md:flex items-center justify-center text-forest/20 text-xl">→</div>
                @endif
                @endforeach
            </div>
            <div class="mt-6 grid grid-cols-3 gap-4 pt-6 border-t border-premium-border/30">
                <div class="text-center">
                    <p class="text-2xl font-serif font-extrabold text-forest">4</p>
                    <p class="text-[10px] text-forest/40 uppercase tracking-widest font-bold mt-1">Kriteria Input</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-serif font-extrabold text-premium-amber">37</p>
                    <p class="text-[10px] text-forest/40 uppercase tracking-widest font-bold mt-1">Rule Aktif</p>
                </div>
                <div class="text-center">
                    <p class="text-2xl font-serif font-extrabold text-forest">≥50</p>
                    <p class="text-[10px] text-forest/40 uppercase tracking-widest font-bold mt-1">Threshold LAYAK</p>
                </div>
            </div>
        </div>

        {{-- =============================================
             SECTION 2: Variabel Input & Fungsi Keanggotaan
             ============================================= --}}
        <div>
            <h3 class="text-[10px] font-black text-forest/40 uppercase tracking-widest mb-4">
                Variabel Input & Fungsi Keanggotaan (Membership Functions)
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @php
                $aspekColors = [
                    'K1' => ['bg' => 'bg-red-50',    'border' => 'border-red-200',    'text' => 'text-red-600',    'badge' => 'bg-red-100 text-red-700',    'label' => 'Aspek A'],
                    'K2' => ['bg' => 'bg-emerald-50', 'border' => 'border-emerald-200', 'text' => 'text-emerald-600', 'badge' => 'bg-emerald-100 text-emerald-700', 'label' => 'Aspek B'],
                    'K3' => ['bg' => 'bg-blue-50',   'border' => 'border-blue-200',   'text' => 'text-blue-600',   'badge' => 'bg-blue-100 text-blue-700',   'label' => 'Aspek C'],
                    'K4' => ['bg' => 'bg-amber-50',  'border' => 'border-amber-200',  'text' => 'text-amber-600',  'badge' => 'bg-amber-100 text-amber-700',  'label' => 'Aspek D'],
                ];
                $aspekDesc = [
                    'K1' => 'Skor keselamatan bangunan: rata-rata kondisi Pondasi, Kolom/Balok, dan Konstruksi Atap. Skala 0.0–1.0.',
                    'K2' => 'Skor kesehatan penghuni: rata-rata kondisi Jendela, Ventilasi, MCK, dan Jarak Sumber Air. Skala 0.0–1.0.',
                    'K3' => 'Rasio luas bangunan terhadap jumlah penghuni (Luas m² ÷ Jumlah Orang). Satuan: m²/orang.',
                    'K4' => 'Skor kualitas komponen material: sub-inferensi dari Material × Kondisi (Atap, Dinding, Lantai). Skala 0.0–1.0.',
                ];
                $setColors = [
                    'Buruk'      => 'bg-red-100 text-red-700 border-red-200',
                    'Tidak Sehat'=> 'bg-red-100 text-red-700 border-red-200',
                    'Padat'      => 'bg-red-100 text-red-700 border-red-200',
                    'Sedang'     => 'bg-amber-100 text-amber-700 border-amber-200',
                    'Cukup'      => 'bg-amber-100 text-amber-700 border-amber-200',
                    'Baik'       => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                    'Sehat'      => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                    'Layak'      => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                ];
                @endphp

                @foreach($kriterias as $k)
                @php $c = $aspekColors[$k->kode] ?? []; @endphp
                <div class="bg-white/70 backdrop-blur-sm rounded-2xl border border-premium-border/50 shadow-sm overflow-hidden">
                    {{-- Card header --}}
                    <div class="px-6 py-4 {{ $c['bg'] ?? '' }} border-b {{ $c['border'] ?? '' }} flex items-center justify-between">
                        <div>
                            <span class="text-[9px] font-black uppercase tracking-widest {{ $c['text'] ?? '' }}">{{ $c['label'] ?? '' }} · {{ $k->kode }}</span>
                            <h4 class="font-serif font-bold text-forest text-base mt-0.5">{{ $k->nama }}</h4>
                        </div>
                        <span class="text-[10px] font-black px-3 py-1 rounded-full {{ $c['badge'] ?? '' }}">
                            {{ $k->fuzzySets->count() }} Set
                        </span>
                    </div>

                    <div class="p-6 space-y-4">
                        {{-- Description --}}
                        <p class="text-[11px] text-forest/50 leading-relaxed italic">
                            {{ $aspekDesc[$k->kode] ?? '' }}
                        </p>

                        {{-- Fuzzy Sets --}}
                        <div class="space-y-3">
                            @foreach($k->fuzzySets as $fs)
                            @php $sc = $setColors[$fs->nama] ?? 'bg-slate-100 text-slate-700 border-slate-200'; @endphp
                            <div class="flex items-center gap-3">
                                <span class="text-[10px] font-black px-3 py-1 rounded-lg border {{ $sc }} min-w-[90px] text-center whitespace-nowrap">
                                    {{ $fs->nama }}
                                </span>
                                <div class="flex-1 flex items-center gap-2">
                                    <span class="text-[9px] font-bold text-forest/30 uppercase tracking-widest whitespace-nowrap">
                                        {{ $fs->tipe === 'trapesium' ? 'Trapesium' : 'Segitiga' }}
                                    </span>
                                    <div class="flex items-center gap-1">
                                        @foreach($fs->parameter as $i => $p)
                                        <code class="text-[10px] font-mono bg-paper px-1.5 py-0.5 rounded border border-premium-border/30 text-forest/70">{{ $p }}</code>
                                        @if($i < count($fs->parameter)-1)
                                        <span class="text-forest/20 text-[9px]">,</span>
                                        @endif
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        {{-- Visual bar --}}
                        <div class="mt-4 pt-4 border-t border-premium-border/20">
                            <p class="text-[9px] font-black text-forest/30 uppercase tracking-widest mb-2">Rentang Universe</p>
                            <div class="relative h-6 rounded-full overflow-hidden flex">
                                @foreach($k->fuzzySets as $idx => $fs)
                                @php
                                    $colors = ['bg-red-400', 'bg-amber-400', 'bg-emerald-500'];
                                    $pct = 100 / $k->fuzzySets->count();
                                @endphp
                                <div class="{{ $colors[$idx] ?? 'bg-slate-400' }} flex items-center justify-center"
                                     style="width: {{ $pct }}%">
                                    <span class="text-white text-[8px] font-black">{{ $fs->nama }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- =============================================
             SECTION 3: Output Fuzzy Sets
             ============================================= --}}
        <div class="bg-white/70 backdrop-blur-sm rounded-2xl border border-premium-border/50 shadow-sm p-8">
            <h3 class="font-serif font-bold text-forest text-base mb-2 flex items-center">
                <span class="w-6 h-6 rounded bg-forest/10 flex items-center justify-center text-forest mr-2 text-xs font-black">Z</span>
                Output Fuzzy Sets — Variabel Keluaran (Defuzzifikasi)
            </h3>
            <p class="text-[11px] text-forest/40 italic mb-6">Himpunan output yang digunakan dalam proses Defuzzifikasi Centroid (COA) pada rentang Z = 0 sampai 100.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($outputSets as $os)
                @php
                    $isLayak = str_contains(strtoupper($os->nama), 'LAYAK') && !str_contains(strtoupper($os->nama), 'TIDAK');
                    $bgClass = $isLayak ? 'bg-forest' : 'bg-red-600';
                    $params = $os->parameter;
                @endphp
                <div class="rounded-2xl p-6 {{ $isLayak ? 'bg-forest/5 border border-forest/20' : 'bg-red-50 border border-red-200' }}">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <span class="text-[9px] font-black uppercase tracking-widest {{ $isLayak ? 'text-forest/40' : 'text-red-400' }}">Output Set</span>
                            <h4 class="font-serif font-extrabold text-xl {{ $isLayak ? 'text-forest' : 'text-red-700' }}">{{ $os->nama }}</h4>
                        </div>
                        <span class="px-3 py-1 rounded-lg text-[10px] font-black {{ $isLayak ? 'bg-forest text-cream' : 'bg-red-600 text-white' }}">
                            {{ $isLayak ? 'Layak RTLH' : 'Tidak Layak' }}
                        </span>
                    </div>
                    <div class="flex items-center gap-2 mb-4">
                        <span class="text-[9px] font-bold text-forest/30 uppercase tracking-widest">
                            {{ $os->tipe === 'trapesium' ? 'Trapesium' : 'Segitiga' }}
                        </span>
                        @foreach($params as $i => $p)
                        <code class="text-[10px] font-mono bg-white/50 px-1.5 py-0.5 rounded border border-premium-border/30 {{ $isLayak ? 'text-forest/70' : 'text-red-600' }}">{{ $p }}</code>
                        @if($i < count($params)-1)<span class="text-forest/20 text-[9px]">,</span>@endif
                        @endforeach
                    </div>
                    {{-- Rentang visual --}}
                    <div class="relative h-5 bg-paper rounded-full overflow-hidden">
                        @php
                            $start = ($params[0] ?? 0);
                            $end   = ($params[3] ?? $params[2] ?? 100);
                            $pctStart = $start;
                            $pctWidth = $end - $start;
                        @endphp
                        <div class="{{ $isLayak ? 'bg-forest' : 'bg-red-500' }} h-full rounded-full opacity-70"
                             style="margin-left: {{ $pctStart }}%; width: {{ $pctWidth }}%"></div>
                        <div class="absolute inset-0 flex items-center px-3">
                            <span class="text-[8px] font-black {{ $isLayak ? 'text-forest' : 'text-red-600' }} ml-auto">
                                {{ $params[0] }} – {{ end($params) }}
                            </span>
                        </div>
                    </div>
                    <p class="text-[9px] text-forest/30 mt-2 italic">
                        Threshold: Skor Z* {{ $isLayak ? '≥ 50 → LAYAK' : '< 50 → TIDAK LAYAK' }}
                    </p>
                </div>
                @endforeach
            </div>
        </div>

        {{-- =============================================
             SECTION 4: Rule Base
             ============================================= --}}
        <div>
            <h3 class="text-[10px] font-black text-forest/40 uppercase tracking-widest mb-4">
                Rule Base — {{ $rules->count() }} Aturan Inferensi Aktif (Operator: AND · Komposisi: MAX)
            </h3>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{-- LAYAK Rules --}}
                <div class="bg-white/70 backdrop-blur-sm rounded-2xl border border-forest/20 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 bg-forest/5 border-b border-forest/20 flex items-center justify-between">
                        <div>
                            <p class="text-[9px] font-black text-forest/40 uppercase tracking-widest">Output</p>
                            <h4 class="font-serif font-bold text-forest">LAYAK</h4>
                        </div>
                        <span class="bg-forest text-cream text-[10px] font-black px-3 py-1 rounded-full">
                            {{ $rulesLayak->count() }} Rules
                        </span>
                    </div>
                    <div class="p-4 space-y-2 max-h-[500px] overflow-y-auto">
                        @foreach($rulesLayak->values() as $i => $rule)
                        <div class="flex items-start gap-2 p-2.5 rounded-xl hover:bg-forest/5 transition-colors group">
                            <span class="text-[9px] font-black text-forest/30 mt-0.5 w-6 shrink-0">R{{ $i+1 }}</span>
                            <div class="flex flex-wrap gap-1 items-center">
                                <span class="text-[9px] font-bold text-forest/30 uppercase">IF</span>
                                @foreach($rule->details as $j => $d)
                                @php
                                    $sc = $setColors[$d->fuzzy_set_nama] ?? 'bg-slate-100 text-slate-700 border-slate-200';
                                @endphp
                                <span class="text-[9px] font-black text-forest/40">{{ $d->kriteria->kode }}</span>
                                <span class="text-[8px] font-bold text-forest/20 uppercase">is</span>
                                <span class="text-[9px] font-black px-1.5 py-0.5 rounded border {{ $sc }}">
                                    {{ $d->fuzzy_set_nama }}
                                </span>
                                @if($j < $rule->details->count()-1)
                                <span class="text-[8px] font-black text-forest/30 uppercase">AND</span>
                                @endif
                                @endforeach
                                <span class="text-[9px] font-bold text-forest/30 uppercase ml-1">THEN</span>
                                <span class="text-[9px] font-black px-2 py-0.5 rounded-full bg-forest text-cream">LAYAK</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- TIDAK LAYAK Rules --}}
                <div class="bg-white/70 backdrop-blur-sm rounded-2xl border border-red-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 bg-red-50 border-b border-red-200 flex items-center justify-between">
                        <div>
                            <p class="text-[9px] font-black text-red-400 uppercase tracking-widest">Output</p>
                            <h4 class="font-serif font-bold text-red-700">TIDAK LAYAK</h4>
                        </div>
                        <span class="bg-red-600 text-white text-[10px] font-black px-3 py-1 rounded-full">
                            {{ $rulesTidakLayak->count() }} Rules
                        </span>
                    </div>
                    <div class="p-4 space-y-2 max-h-[500px] overflow-y-auto">
                        @foreach($rulesTidakLayak->values() as $i => $rule)
                        <div class="flex items-start gap-2 p-2.5 rounded-xl hover:bg-red-50 transition-colors group">
                            <span class="text-[9px] font-black text-red-300 mt-0.5 w-6 shrink-0">R{{ $i+1 }}</span>
                            <div class="flex flex-wrap gap-1 items-center">
                                <span class="text-[9px] font-bold text-forest/30 uppercase">IF</span>
                                @foreach($rule->details as $j => $d)
                                @php
                                    $sc = $setColors[$d->fuzzy_set_nama] ?? 'bg-slate-100 text-slate-700 border-slate-200';
                                @endphp
                                <span class="text-[9px] font-black text-forest/40">{{ $d->kriteria->kode }}</span>
                                <span class="text-[8px] font-bold text-forest/20 uppercase">is</span>
                                <span class="text-[9px] font-black px-1.5 py-0.5 rounded border {{ $sc }}">
                                    {{ $d->fuzzy_set_nama }}
                                </span>
                                @if($j < $rule->details->count()-1)
                                <span class="text-[8px] font-black text-forest/30 uppercase">AND</span>
                                @endif
                                @endforeach
                                <span class="text-[9px] font-bold text-forest/30 uppercase ml-1">THEN</span>
                                <span class="text-[9px] font-black px-2 py-0.5 rounded-full bg-red-600 text-white">TIDAK LAYAK</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Summary note --}}
            <div class="mt-4 p-4 rounded-xl bg-paper/50 border border-premium-border/30 text-[10px] text-forest/50 leading-relaxed">
                <strong class="text-forest/70">Catatan Metodologi:</strong>
                K1 = Aspek Keselamatan · K2 = Aspek Kesehatan · K3 = Aspek Kepadatan (m²/org) · K4 = Aspek Komponen.
                Setiap rule dievaluasi dengan operator <strong>AND (MIN)</strong>. Hasil seluruh rule per output digabungkan dengan fungsi <strong>MAX (Komposisi Mamdani)</strong>.
                Defuzzifikasi menggunakan metode <strong>Centroid COA</strong> dengan diskritisasi Z = 0 hingga 100.
                Threshold keputusan: <strong>Z* ≥ 50 → LAYAK, Z* &lt; 50 → TIDAK LAYAK</strong>.
                
                <div class="mt-3 p-3 rounded-lg bg-amber-50 border border-amber-200 text-amber-800 flex items-start gap-2 shadow-sm">
                    <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <div>
                        <strong class="font-bold uppercase tracking-widest text-[9px] block mb-0.5">Penjelasan Skor 0.000 (Kasus Unik)</strong>
                        Jika terdapat hasil evaluasi dengan skor Defuzzifikasi tepat <strong>0.000</strong>, hal ini menandakan bahwa kombinasi himpunan fuzzy untuk warga tersebut <strong>tidak terdaftar di dalam 37 aturan di atas</strong>. Tanpa aturan yang cocok (Alpha = 0 untuk semua rule), fungsi centroid bernilai nol dan otomatis dikategorikan sebagai TIDAK LAYAK. Idealnya, sistem dengan 4 kriteria (masing-masing 3 himpunan) membutuhkan 81 rules (3x3x3x3) agar seluruh kemungkinan ter-<em>cover</em>.
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
