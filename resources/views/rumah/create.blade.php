<x-app-layout>
    <div class="py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-12 flex items-center justify-between">
                <div>
                    <h2 class="font-serif text-4xl font-bold text-forest leading-tight tracking-tight">
                        Survei <span class="text-amber italic">Kondisi Fisik Rumah</span>
                    </h2>
                    <p class="mt-2 text-sm text-forest/60 font-medium">Berdasarkan Standar PUPR No. 7/2022 & Metodologi Fuzzy Mamdani.</p>
                </div>
                <a href="{{ url()->previous() }}" class="group inline-flex items-center text-sm font-bold text-forest/60 hover:text-forest transition-colors duration-300">
                    <svg class="mr-2 w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>

            <form action="{{ route('rumah.store') }}" method="POST" class="space-y-10">
                @csrf
                
                <!-- Identification Card -->
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-premium-border/50 overflow-hidden">
                    <div class="px-10 py-6 bg-slate-50 border-b border-premium-border/30 flex items-center justify-between">
                        <h3 class="font-serif text-xl font-bold text-slate-800">1. Identitas & Aspek Kepadatan</h3>
                        <span class="px-4 py-1 bg-slate-200 text-slate-600 text-[10px] font-black rounded-full uppercase tracking-widest">Aspek C</span>
                    </div>
                    <div class="p-10">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                            <div class="md:col-span-1">
                                <x-input-label for="penduduk_id" :value="__('Pemilik / Penghuni')" />
                                @if($penduduk instanceof \App\Models\Penduduk)
                                    <input type="hidden" name="penduduk_id" value="{{ $penduduk->id }}">
                                    <div class="mt-2 flex items-center p-4 bg-slate-50 rounded-2xl border border-slate-100">
                                        <div class="w-10 h-10 rounded-full bg-forest text-cream flex items-center justify-center mr-4 shadow-lg shadow-forest/20">
                                            <span class="text-sm font-bold">{{ substr($penduduk->nama_lengkap, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-forest">{{ $penduduk->nama_lengkap }}</p>
                                            <p class="text-[10px] font-mono text-forest/50 tracking-wider">{{ $penduduk->nik }}</p>
                                        </div>
                                    </div>
                                @else
                                    <select id="penduduk_id" name="penduduk_id" 
                                        class="mt-2 block w-full border-premium-border/40 bg-white focus:border-forest focus:ring-forest rounded-2xl shadow-sm transition-all duration-300 text-sm py-3" required>
                                        <option value="">Pilih Penduduk</option>
                                        @foreach($penduduk as $p)
                                            <option value="{{ $p->id }}" {{ old('penduduk_id') == $p->id ? 'selected' : '' }}>{{ $p->nama_lengkap }} ({{ $p->nik }})</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>

                            <div>
                                <x-input-label for="status_kepemilikan" :value="__('Status Kepemilikan')" />
                                <select id="status_kepemilikan" name="status_kepemilikan" 
                                    class="mt-2 block w-full border-premium-border/40 bg-white focus:border-forest focus:ring-forest rounded-2xl shadow-sm transition-all duration-300 text-sm py-3" required>
                                    <option value="Milik Sendiri" {{ old('status_kepemilikan') == 'Milik Sendiri' ? 'selected' : '' }}>Milik Sendiri</option>
                                    <option value="Sewa" {{ old('status_kepemilikan') == 'Sewa' ? 'selected' : '' }}>Sewa</option>
                                    <option value="Numpang" {{ old('status_kepemilikan') == 'Numpang' ? 'selected' : '' }}>Numpang</option>
                                    <option value="Lainnya" {{ old('status_kepemilikan') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                            </div>

                            <div>
                                <x-input-label for="luas_bangunan" :value="__('Luas Bangunan (m²)')" />
                                <x-text-input id="luas_bangunan" name="luas_bangunan" type="number" step="0.01" class="mt-2 block w-full py-3 bg-white" :value="old('luas_bangunan')" required placeholder="Misal: 36.5" />
                                <p class="mt-2 text-[10px] text-forest/40 italic">*Minimal standar PUPR: 9m²/orang.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Aspect A: Safety -->
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-premium-border/50 overflow-hidden">
                    <div class="px-10 py-6 bg-slate-50 border-b border-premium-border/30 flex items-center justify-between">
                        <h3 class="font-serif text-xl font-bold text-slate-800">2. Aspek Keselamatan Bangunan</h3>
                        <span class="px-4 py-1 bg-slate-200 text-slate-600 text-[10px] font-black rounded-full uppercase tracking-widest">Aspek A</span>
                    </div>
                    <div class="p-10">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                            <div class="space-y-3">
                                <x-input-label for="pondasi" :value="__('Pondasi')" />
                                <select name="pondasi" class="w-full border-red-200 rounded-2xl text-sm py-3 focus:ring-red-500 bg-red-50/20">
                                    <option value="Ada">Ada (Kokoh)</option>
                                    <option value="Tidak Ada">Tidak Ada / Rusak Total</option>
                                </select>
                            </div>
                            <div class="space-y-3">
                                <x-input-label for="kolom_balok" :value="__('Kondisi Kolom & Balok')" />
                                <select name="kolom_balok" class="w-full border-red-200 rounded-2xl text-sm py-3 focus:ring-red-500 bg-red-50/20">
                                    <option value="Baik">Baik (Kayu/Beton Kokoh)</option>
                                    <option value="Rusak Sedang / Sebagian">Rusak Sedang (Mulai Lapuk/Retak)</option>
                                    <option value="Rusak Berat / Seluruhnya">Rusak Berat (Hampir Roboh)</option>
                                </select>
                            </div>
                            <div class="space-y-3">
                                <x-input-label for="konstruksi_atap" :value="__('Kondisi Konstruksi Atap')" />
                                <select name="konstruksi_atap" class="w-full border-red-200 rounded-2xl text-sm py-3 focus:ring-red-500 bg-red-50/20">
                                    <option value="Baik">Baik (Rangka Kokoh)</option>
                                    <option value="Rusak Sedang / Sebagian">Rusak Sedang (Patah/Miring)</option>
                                    <option value="Rusak Berat / Seluruhnya">Rusak Berat (Patah Total)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Aspect B: Health -->
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-premium-border/50 overflow-hidden">
                    <div class="px-10 py-6 bg-slate-50 border-b border-premium-border/30 flex items-center justify-between">
                        <h3 class="font-serif text-xl font-bold text-slate-800">3. Aspek Kesehatan Penghuni</h3>
                        <span class="px-4 py-1 bg-slate-200 text-slate-600 text-[10px] font-black rounded-full uppercase tracking-widest">Aspek B</span>
                    </div>
                    <div class="p-10">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                            <div class="space-y-3">
                                <x-input-label for="jendela" :value="__('Jendela / Pencahayaan')" />
                                <select name="jendela" class="w-full border-emerald-200 rounded-2xl text-sm py-3 focus:ring-emerald-500 bg-emerald-50/20">
                                    <option value="Ada">Ada</option>
                                    <option value="Tidak Ada">Tidak Ada</option>
                                </select>
                            </div>
                            <div class="space-y-3">
                                <x-input-label for="ventilasi" :value="__('Ventilasi Udara')" />
                                <select name="ventilasi" class="w-full border-emerald-200 rounded-2xl text-sm py-3 focus:ring-emerald-500 bg-emerald-50/20">
                                    <option value="Ada">Ada</option>
                                    <option value="Tidak Ada">Tidak Ada</option>
                                </select>
                            </div>
                            <div class="space-y-3">
                                <x-input-label for="kamar_mandi" :value="__('Fasilitas MCK')" />
                                <select name="kamar_mandi" class="w-full border-emerald-200 rounded-2xl text-sm py-3 focus:ring-emerald-500 bg-emerald-50/20">
                                    <option value="Sendiri">Milik Sendiri</option>
                                    <option value="Bersama / MCK Komunal">Bersama / Komunal</option>
                                    <option value="Tidak Ada">Tidak Ada / Di Sungai</option>
                                </select>
                            </div>
                            <div class="space-y-3">
                                <x-input-label for="jarak_sumber_air" :value="__('Jarak Air ke TPA Tinja')" />
                                <select name="jarak_sumber_air" class="w-full border-emerald-200 rounded-2xl text-sm py-3 focus:ring-emerald-500 bg-emerald-50/20">
                                    <option value="Lebih dari 10 meter">Aman (> 10m)</option>
                                    <option value="Kurang dari 10 meter">Tidak Aman (< 10m)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Aspect D: Component Quality -->
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-premium-border/50 overflow-hidden">
                    <div class="px-10 py-6 bg-slate-50 border-b border-premium-border/30 flex items-center justify-between">
                        <h3 class="font-serif text-xl font-bold text-slate-800">4. Aspek Komponen Bangunan (Material)</h3>
                        <span class="px-4 py-1 bg-slate-200 text-slate-600 text-[10px] font-black rounded-full uppercase tracking-widest">Aspek D</span>
                    </div>
                    <div class="p-10">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                            <!-- Material Groups -->
                            <div class="space-y-6">
                                <h4 class="text-[10px] font-black text-amber-700 uppercase tracking-widest border-b border-amber-200 pb-2">Material Utama</h4>
                                <div class="space-y-4">
                                    <div>
                                        <x-input-label for="material_atap" :value="__('Material Atap')" />
                                        <select name="material_atap" class="mt-1 w-full border-amber-200 rounded-xl text-sm bg-amber-50/10">
                                            <option value="Genteng Beton / Keramik">Genteng Beton / Keramik</option>
                                            <option value="Genteng Tanah Liat">Genteng Tanah Liat</option>
                                            <option value="Seng">Seng</option>
                                            <option value="Asbes">Asbes</option>
                                            <option value="Daun / Rumbia / Ijuk">Daun / Rumbia / Ijuk</option>
                                        </select>
                                    </div>
                                    <div>
                                        <x-input-label for="material_dinding" :value="__('Material Dinding')" />
                                        <select name="material_dinding" class="mt-1 w-full border-amber-200 rounded-xl text-sm bg-amber-50/10">
                                            <option value="Bata Diplester / Tembok Permanen">Tembok Permanen</option>
                                            <option value="Bata Tanpa Plester">Bata Tanpa Plester</option>
                                            <option value="Semi Permanen (Triplek, dll)">Semi Permanen</option>
                                            <option value="Kayu Papan">Kayu Papan</option>
                                            <option value="Bambu / Anyaman">Bambu / Anyaman</option>
                                        </select>
                                    </div>
                                    <div>
                                        <x-input-label for="material_lantai" :value="__('Material Lantai')" />
                                        <select name="material_lantai" class="mt-1 w-full border-amber-200 rounded-xl text-sm bg-amber-50/10">
                                            <option value="Granit / Ubin Berkualitas">Granit / Ubin</option>
                                            <option value="Keramik">Keramik</option>
                                            <option value="Plester Semen">Plester Semen</option>
                                            <option value="Bambu / Kayu Kasar">Bambu / Kayu Kasar</option>
                                            <option value="Tanah">Tanah</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Condition Groups -->
                            <div class="md:col-span-2 space-y-6">
                                <h4 class="text-[10px] font-black text-amber-700 uppercase tracking-widest border-b border-amber-200 pb-2">Kondisi Kerusakan Komponen</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                    <div class="space-y-4">
                                        <div>
                                            <x-input-label for="kondisi_atap" :value="__('Kondisi Atap')" />
                                            <select name="kondisi_atap" class="mt-1 w-full border-amber-200 rounded-xl text-sm bg-amber-50/10">
                                                <option value="Baik">Baik (Tidak Bocor)</option>
                                                <option value="Rusak Sedang / Sebagian">Rusak Sedang (Bocor Sebagian)</option>
                                                <option value="Rusak Berat / Seluruhnya">Rusak Berat (Bocor Parah)</option>
                                            </select>
                                        </div>
                                        <div>
                                            <x-input-label for="kondisi_dinding" :value="__('Kondisi Dinding')" />
                                            <select name="kondisi_dinding" class="mt-1 w-full border-amber-200 rounded-xl text-sm bg-amber-50/10">
                                                <option value="Baik">Baik (Kokoh)</option>
                                                <option value="Rusak Sedang / Sebagian">Rusak Sedang (Retak/Lapuk)</option>
                                                <option value="Rusak Berat / Seluruhnya">Rusak Berat (Miring/Roboh)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="space-y-4">
                                        <div>
                                            <x-input-label for="kondisi_lantai" :value="__('Kondisi Lantai')" />
                                            <select name="kondisi_lantai" class="mt-1 w-full border-amber-200 rounded-xl text-sm bg-amber-50/10">
                                                <option value="Baik">Baik (Rata/Bersih)</option>
                                                <option value="Rusak Sedang / Sebagian">Rusak Sedang (Pecah/Lembab)</option>
                                                <option value="Rusak Berat / Seluruhnya">Rusak Berat (Hancur/Berlubang)</option>
                                            </select>
                                        </div>
                                        <div class="p-5 bg-amber-50/50 rounded-2xl border border-amber-100 h-[100px] flex items-center">
                                            <p class="text-[10px] text-amber-800/70 leading-relaxed italic">
                                                *Material dan kondisi akan dihitung rata-rata untuk menentukan skor Aspek Komponen.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-10 border-t border-premium-border/30 flex items-center justify-end space-x-8">
                    <a href="{{ url()->previous() }}" class="text-sm font-bold text-forest/40 hover:text-forest transition-colors duration-300 uppercase tracking-widest">
                        Batal
                    </a>
                    <button type="submit" class="px-10 py-4 bg-forest text-cream font-serif font-bold text-lg rounded-2xl shadow-2xl shadow-forest/30 hover:bg-forest-dark transition-all duration-500 hover:-translate-y-1 active:scale-95">
                        Simpan Data Survei
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
