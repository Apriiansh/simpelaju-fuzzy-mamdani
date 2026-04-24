<x-app-layout>
    <div class="py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-12 flex items-center justify-between">
                <div>
                    <h2 class="font-serif text-4xl font-bold text-forest leading-tight tracking-tight">
                        Edit <span class="text-amber italic">Kondisi Fisik Rumah</span>
                    </h2>
                    <p class="mt-2 text-sm text-forest/60 font-medium">Milik: <span class="font-bold text-forest">{{ $rumah->penduduk->nama_lengkap }}</span></p>
                </div>
                <a href="{{ route('penduduk.show', $rumah->penduduk_id) }}" class="group inline-flex items-center text-sm font-bold text-forest/60 hover:text-forest transition-colors duration-300">
                    <svg class="mr-2 w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>

            <form action="{{ route('rumah.update', $rumah) }}" method="POST" class="space-y-10">
                @csrf
                @method('PUT')
                
                <!-- Identification Card -->
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-premium-border/50 overflow-hidden">
                    <div class="px-10 py-6 bg-slate-50 border-b border-premium-border/30 flex items-center justify-between">
                        <h3 class="font-serif text-xl font-bold text-slate-800">1. Identitas & Aspek Kepadatan</h3>
                        <span class="px-4 py-1 bg-slate-200 text-slate-600 text-[10px] font-black rounded-full uppercase tracking-widest">Aspek C</span>
                    </div>
                    <div class="p-10">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                            <div>
                                <x-input-label for="status_kepemilikan" :value="__('Status Kepemilikan')" />
                                <select id="status_kepemilikan" name="status_kepemilikan" 
                                    class="mt-2 block w-full border-premium-border/40 bg-white focus:border-forest focus:ring-forest rounded-2xl shadow-sm transition-all duration-300 text-sm py-3" required>
                                    <option value="Milik Sendiri" {{ old('status_kepemilikan', $rumah->status_kepemilikan) == 'Milik Sendiri' ? 'selected' : '' }}>Milik Sendiri</option>
                                    <option value="Sewa" {{ old('status_kepemilikan', $rumah->status_kepemilikan) == 'Sewa' ? 'selected' : '' }}>Sewa</option>
                                    <option value="Numpang" {{ old('status_kepemilikan', $rumah->status_kepemilikan) == 'Numpang' ? 'selected' : '' }}>Numpang</option>
                                    <option value="Lainnya" {{ old('status_kepemilikan', $rumah->status_kepemilikan) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                            </div>

                            <div>
                                <x-input-label for="luas_bangunan" :value="__('Luas Bangunan (m²)')" />
                                <x-text-input id="luas_bangunan" name="luas_bangunan" type="number" step="0.01" class="mt-2 block w-full py-3 bg-white" :value="old('luas_bangunan', $rumah->luas_bangunan)" required />
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
                                    <option value="Ada" {{ old('pondasi', $rumah->pondasi) == 'Ada' ? 'selected' : '' }}>Ada (Kokoh)</option>
                                    <option value="Tidak Ada" {{ old('pondasi', $rumah->pondasi) == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada / Rusak Total</option>
                                </select>
                            </div>
                            <div class="space-y-3">
                                <x-input-label for="kolom_balok" :value="__('Kondisi Kolom & Balok')" />
                                <select name="kolom_balok" class="w-full border-red-200 rounded-2xl text-sm py-3 focus:ring-red-500 bg-red-50/20">
                                    <option value="Baik" {{ old('kolom_balok', $rumah->kolom_balok) == 'Baik' ? 'selected' : '' }}>Baik (Kayu/Beton Kokoh)</option>
                                    <option value="Rusak Sedang / Sebagian" {{ old('kolom_balok', $rumah->kolom_balok) == 'Rusak Sedang / Sebagian' ? 'selected' : '' }}>Rusak Sedang</option>
                                    <option value="Rusak Berat / Seluruhnya" {{ old('kolom_balok', $rumah->kolom_balok) == 'Rusak Berat / Seluruhnya' ? 'selected' : '' }}>Rusak Berat</option>
                                </select>
                            </div>
                            <div class="space-y-3">
                                <x-input-label for="konstruksi_atap" :value="__('Kondisi Konstruksi Atap')" />
                                <select name="konstruksi_atap" class="w-full border-red-200 rounded-2xl text-sm py-3 focus:ring-red-500 bg-red-50/20">
                                    <option value="Baik" {{ old('konstruksi_atap', $rumah->konstruksi_atap) == 'Baik' ? 'selected' : '' }}>Baik (Rangka Kokoh)</option>
                                    <option value="Rusak Sedang / Sebagian" {{ old('konstruksi_atap', $rumah->konstruksi_atap) == 'Rusak Sedang / Sebagian' ? 'selected' : '' }}>Rusak Sedang</option>
                                    <option value="Rusak Berat / Seluruhnya" {{ old('konstruksi_atap', $rumah->konstruksi_atap) == 'Rusak Berat / Seluruhnya' ? 'selected' : '' }}>Rusak Berat</option>
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
                                    <option value="Ada" {{ old('jendela', $rumah->jendela) == 'Ada' ? 'selected' : '' }}>Ada</option>
                                    <option value="Tidak Ada" {{ old('jendela', $rumah->jendela) == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                                </select>
                            </div>
                            <div class="space-y-3">
                                <x-input-label for="ventilasi" :value="__('Ventilasi Udara')" />
                                <select name="ventilasi" class="w-full border-emerald-200 rounded-2xl text-sm py-3 focus:ring-emerald-500 bg-emerald-50/20">
                                    <option value="Ada" {{ old('ventilasi', $rumah->ventilasi) == 'Ada' ? 'selected' : '' }}>Ada</option>
                                    <option value="Tidak Ada" {{ old('ventilasi', $rumah->ventilasi) == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                                </select>
                            </div>
                            <div class="space-y-3">
                                <x-input-label for="kamar_mandi" :value="__('Fasilitas MCK')" />
                                <select name="kamar_mandi" class="w-full border-emerald-200 rounded-2xl text-sm py-3 focus:ring-emerald-500 bg-emerald-50/20">
                                    <option value="Sendiri" {{ old('kamar_mandi', $rumah->kamar_mandi) == 'Sendiri' ? 'selected' : '' }}>Milik Sendiri</option>
                                    <option value="Bersama / MCK Komunal" {{ old('kamar_mandi', $rumah->kamar_mandi) == 'Bersama / MCK Komunal' ? 'selected' : '' }}>Bersama / Komunal</option>
                                    <option value="Tidak Ada" {{ old('kamar_mandi', $rumah->kamar_mandi) == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada / Di Sungai</option>
                                </select>
                            </div>
                            <div class="space-y-3">
                                <x-input-label for="jarak_sumber_air" :value="__('Jarak Air ke TPA Tinja')" />
                                <select name="jarak_sumber_air" class="w-full border-emerald-200 rounded-2xl text-sm py-3 focus:ring-emerald-500 bg-emerald-50/20">
                                    <option value="Lebih dari 10 meter" {{ old('jarak_sumber_air', $rumah->jarak_sumber_air) == 'Lebih dari 10 meter' ? 'selected' : '' }}>Aman (> 10m)</option>
                                    <option value="Kurang dari 10 meter" {{ old('jarak_sumber_air', $rumah->jarak_sumber_air) == 'Kurang dari 10 meter' ? 'selected' : '' }}>Tidak Aman (< 10m)</option>
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
                                            <option value="Genteng Beton / Keramik" {{ old('material_atap', $rumah->material_atap) == 'Genteng Beton / Keramik' ? 'selected' : '' }}>Genteng Beton / Keramik</option>
                                            <option value="Genteng Tanah Liat" {{ old('material_atap', $rumah->material_atap) == 'Genteng Tanah Liat' ? 'selected' : '' }}>Genteng Tanah Liat</option>
                                            <option value="Seng" {{ old('material_atap', $rumah->material_atap) == 'Seng' ? 'selected' : '' }}>Seng</option>
                                            <option value="Asbes" {{ old('material_atap', $rumah->material_atap) == 'Asbes' ? 'selected' : '' }}>Asbes</option>
                                            <option value="Daun / Rumbia / Ijuk" {{ old('material_atap', $rumah->material_atap) == 'Daun / Rumbia / Ijuk' ? 'selected' : '' }}>Daun / Rumbia / Ijuk</option>
                                        </select>
                                    </div>
                                    <div>
                                        <x-input-label for="material_dinding" :value="__('Material Dinding')" />
                                        <select name="material_dinding" class="mt-1 w-full border-amber-200 rounded-xl text-sm bg-amber-50/10">
                                            <option value="Bata Diplester / Tembok Permanen" {{ old('material_dinding', $rumah->material_dinding) == 'Bata Diplester / Tembok Permanen' ? 'selected' : '' }}>Tembok Permanen</option>
                                            <option value="Bata Tanpa Plester" {{ old('material_dinding', $rumah->material_dinding) == 'Bata Tanpa Plester' ? 'selected' : '' }}>Bata Tanpa Plester</option>
                                            <option value="Semi Permanen (Triplek, dll)" {{ old('material_dinding', $rumah->material_dinding) == 'Semi Permanen (Triplek, dll)' ? 'selected' : '' }}>Semi Permanen</option>
                                            <option value="Kayu Papan" {{ old('material_dinding', $rumah->material_dinding) == 'Kayu Papan' ? 'selected' : '' }}>Kayu Papan</option>
                                            <option value="Bambu / Anyaman" {{ old('material_dinding', $rumah->material_dinding) == 'Bambu / Anyaman' ? 'selected' : '' }}>Bambu / Anyaman</option>
                                        </select>
                                    </div>
                                    <div>
                                        <x-input-label for="material_lantai" :value="__('Material Lantai')" />
                                        <select name="material_lantai" class="mt-1 w-full border-amber-200 rounded-xl text-sm bg-amber-50/10">
                                            <option value="Granit / Ubin Berkualitas" {{ old('material_lantai', $rumah->material_lantai) == 'Granit / Ubin Berkualitas' ? 'selected' : '' }}>Granit / Ubin</option>
                                            <option value="Keramik" {{ old('material_lantai', $rumah->material_lantai) == 'Keramik' ? 'selected' : '' }}>Keramik</option>
                                            <option value="Plester Semen" {{ old('material_lantai', $rumah->material_lantai) == 'Plester Semen' ? 'selected' : '' }}>Plester Semen</option>
                                            <option value="Bambu / Kayu Kasar" {{ old('material_lantai', $rumah->material_lantai) == 'Bambu / Kayu Kasar' ? 'selected' : '' }}>Bambu / Kayu Kasar</option>
                                            <option value="Tanah" {{ old('material_lantai', $rumah->material_lantai) == 'Tanah' ? 'selected' : '' }}>Tanah</option>
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
                                                <option value="Baik" {{ old('kondisi_atap', $rumah->kondisi_atap) == 'Baik' ? 'selected' : '' }}>Baik (Tidak Bocor)</option>
                                                <option value="Rusak Sedang / Sebagian" {{ old('kondisi_atap', $rumah->kondisi_atap) == 'Rusak Sedang / Sebagian' ? 'selected' : '' }}>Rusak Sedang</option>
                                                <option value="Rusak Berat / Seluruhnya" {{ old('kondisi_atap', $rumah->kondisi_atap) == 'Rusak Berat / Seluruhnya' ? 'selected' : '' }}>Rusak Berat</option>
                                            </select>
                                        </div>
                                        <div>
                                            <x-input-label for="kondisi_dinding" :value="__('Kondisi Dinding')" />
                                            <select name="kondisi_dinding" class="mt-1 w-full border-amber-200 rounded-xl text-sm bg-amber-50/10">
                                                <option value="Baik" {{ old('kondisi_dinding', $rumah->kondisi_dinding) == 'Baik' ? 'selected' : '' }}>Baik (Kokoh)</option>
                                                <option value="Rusak Sedang / Sebagian" {{ old('kondisi_dinding', $rumah->kondisi_dinding) == 'Rusak Sedang / Sebagian' ? 'selected' : '' }}>Rusak Sedang</option>
                                                <option value="Rusak Berat / Seluruhnya" {{ old('kondisi_dinding', $rumah->kondisi_dinding) == 'Rusak Berat / Seluruhnya' ? 'selected' : '' }}>Rusak Berat</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="space-y-4">
                                        <div>
                                            <x-input-label for="kondisi_lantai" :value="__('Kondisi Lantai')" />
                                            <select name="kondisi_lantai" class="mt-1 w-full border-amber-200 rounded-xl text-sm bg-amber-50/10">
                                                <option value="Baik" {{ old('kondisi_lantai', $rumah->kondisi_lantai) == 'Baik' ? 'selected' : '' }}>Baik (Rata/Bersih)</option>
                                                <option value="Rusak Sedang / Sebagian" {{ old('kondisi_lantai', $rumah->kondisi_lantai) == 'Rusak Sedang / Sebagian' ? 'selected' : '' }}>Rusak Sedang</option>
                                                <option value="Rusak Berat / Seluruhnya" {{ old('kondisi_lantai', $rumah->kondisi_lantai) == 'Rusak Berat / Seluruhnya' ? 'selected' : '' }}>Rusak Berat</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-10 border-t border-premium-border/30 flex items-center justify-end space-x-8">
                    <a href="{{ route('penduduk.show', $rumah->penduduk_id) }}" class="text-sm font-bold text-forest/40 hover:text-forest transition-colors duration-300 uppercase tracking-widest">
                        Batal
                    </a>
                    <button type="submit" class="px-10 py-4 bg-forest text-cream font-serif font-bold text-lg rounded-2xl shadow-2xl shadow-forest/30 hover:bg-forest-dark transition-all duration-500 hover:-translate-y-1 active:scale-95">
                        Update Data Survei
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
