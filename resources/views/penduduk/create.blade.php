<x-app-layout>
    <x-slot name="header">
        <div class="py-2">
            <h2 class="font-serif font-bold text-2xl text-forest leading-tight">
                {{ __('Tambah Data Penduduk') }}
            </h2>
            <p class="text-forest/60 text-sm mt-1">Lengkapi informasi penduduk untuk proses pendataan dan penilaian.</p>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto pb-12">
        <form action="{{ route('penduduk.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="bg-white/70 backdrop-blur-sm p-8 rounded-2xl shadow-sm border border-premium-border/50">
                <div class="flex items-center mb-6 border-b border-premium-border/30 pb-4">
                    <div class="w-8 h-8 rounded-lg bg-forest/10 flex items-center justify-center text-forest mr-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-serif font-bold text-forest">Informasi Pribadi</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <x-input-label for="nik" :value="__('NIK (Nomor Induk Kependudukan)')" />
                        <x-text-input id="nik" name="nik" type="text" class="mt-1 block w-full" :value="old('nik')" required autofocus placeholder="167xxxxxxxxxxxxx" maxlength="16" minlength="16" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 16)" />
                        <x-input-error class="mt-2" :messages="$errors->get('nik')" />
                    </div>

                    <div>
                        <x-input-label for="nama_lengkap" :value="__('Nama Lengkap')" />
                        <x-text-input id="nama_lengkap" name="nama_lengkap" type="text" class="mt-1 block w-full" :value="old('nama_lengkap')" required placeholder="Masukkan nama sesuai KTP" />
                        <x-input-error class="mt-2" :messages="$errors->get('nama_lengkap')" />
                    </div>

                    <div class="md:col-span-2">
                        <x-input-label for="alamat" :value="__('Alamat Lengkap')" />
                        <textarea id="alamat" name="alamat" rows="3" class="mt-1 block w-full border-premium-border/40 bg-white/50 focus:border-forest focus:ring-forest rounded-xl shadow-sm transition-all duration-300" required placeholder="Jl. Contoh No. 123, RT 01 RW 02">{{ old('alamat') }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('alamat')" />
                    </div>

                    <div>
                        <x-input-label for="kelurahan_id" :value="__('Kelurahan')" />
                        <select id="kelurahan_id" name="kelurahan_id" class="mt-1 block w-full border-premium-border/40 bg-white/50 focus:border-forest focus:ring-forest rounded-xl shadow-sm transition-all duration-300 text-sm font-medium text-forest" required>
                            <option value="">Pilih Kelurahan</option>
                            @foreach($kelurahan as $k)
                                <option value="{{ $k->id }}" {{ old('kelurahan_id') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                            @endforeach
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('kelurahan_id')" />
                    </div>

                    <div>
                        <x-input-label for="no_telepon" :value="__('No. Telepon')" />
                        <x-text-input id="no_telepon" name="no_telepon" type="text" class="mt-1 block w-full" :value="old('no_telepon')" placeholder="08xxxxxxxxxx" />
                        <x-input-error class="mt-2" :messages="$errors->get('no_telepon')" />
                    </div>
                </div>
            </div>

            <div class="bg-white/70 backdrop-blur-sm p-8 rounded-2xl shadow-sm border border-premium-border/50">
                <div class="flex items-center mb-6 border-b border-premium-border/30 pb-4">
                    <div class="w-8 h-8 rounded-lg bg-premium-amber/10 flex items-center justify-center text-premium-amber mr-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-serif font-bold text-forest">Kapasitas & Ekonomi</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <x-input-label for="status_pernikahan" :value="__('Status Pernikahan')" />
                        <select id="status_pernikahan" name="status_pernikahan" class="mt-1 block w-full border-premium-border/40 bg-white/50 focus:border-forest focus:ring-forest rounded-xl shadow-sm transition-all duration-300 text-sm font-medium text-forest" required>
                            <option value="Belum Kawin" {{ old('status_pernikahan') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                            <option value="Kawin" {{ old('status_pernikahan') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                            <option value="Cerai Hidup" {{ old('status_pernikahan') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                            <option value="Cerai Mati" {{ old('status_pernikahan') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('status_pernikahan')" />
                    </div>

                    <div>
                        <x-input-label for="jumlah_tanggungan" :value="__('Jumlah Tanggungan (Orang)')" />
                        <x-text-input id="jumlah_tanggungan" name="jumlah_tanggungan" type="number" class="mt-1 block w-full" :value="old('jumlah_tanggungan', 0)" required />
                        <x-input-error class="mt-2" :messages="$errors->get('jumlah_tanggungan')" />
                    </div>

                    <div>
                        <x-input-label for="penghasilan" :value="__('Penghasilan (Rp/Bulan)')" />
                        <x-text-input id="penghasilan" name="penghasilan" type="number" class="mt-1 block w-full font-bold text-forest" :value="old('penghasilan', 0)" required />
                        <p class="mt-1 text-[10px] text-forest/40 uppercase font-bold tracking-widest">Gunakan angka saja tanpa titik/koma</p>
                        <x-input-error class="mt-2" :messages="$errors->get('penghasilan')" />
                    </div>
                </div>
            </div>

            <div class="bg-white/70 backdrop-blur-sm p-8 rounded-2xl shadow-sm border border-premium-border/50">
                <div class="flex items-center mb-6 border-b border-premium-border/30 pb-4">
                    <div class="w-8 h-8 rounded-lg bg-red-100 flex items-center justify-center text-red-600 mr-3">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-serif font-bold text-forest">Lokasi (Geospasial)</h3>
                </div>
                <p class="text-xs text-forest/50 mb-6 bg-paper/50 p-3 rounded-lg border border-premium-border/20 italic">Koordinat digunakan untuk memetakan lokasi penduduk. Fitur map picker akan tersedia di Phase 6.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <x-input-label for="latitude" :value="__('Latitude')" />
                        <x-text-input id="latitude" name="latitude" type="text" class="mt-1 block w-full" :value="old('latitude')" placeholder="-2.99xxx" />
                        <x-input-error class="mt-2" :messages="$errors->get('latitude')" />
                    </div>

                    <div>
                        <x-input-label for="longitude" :value="__('Longitude')" />
                        <x-text-input id="longitude" name="longitude" type="text" class="mt-1 block w-full" :value="old('longitude')" placeholder="104.77xxx" />
                        <x-input-error class="mt-2" :messages="$errors->get('longitude')" />
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-6">
                <a href="{{ route('penduduk.index') }}" class="text-xs font-bold uppercase tracking-widest text-forest/40 hover:text-forest transition-colors">Batal</a>
                <x-primary-button>
                    {{ __('Simpan Data Penduduk') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
