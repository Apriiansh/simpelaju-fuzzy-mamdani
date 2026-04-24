<x-app-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h2 class="font-serif text-3xl font-bold text-forest leading-tight tracking-tight">
                        Edit <span class="text-amber italic">Kelurahan</span>
                    </h2>
                    <p class="mt-2 text-sm text-forest/60 font-medium italic">"{{ $kelurahan->nama }}"</p>
                </div>
                <a href="{{ route('kelurahan.index') }}" class="group inline-flex items-center text-sm font-bold text-forest/60 hover:text-forest transition-colors duration-300">
                    <svg class="mr-2 w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>

            <!-- Form Card -->
            <div class="bg-white/70 backdrop-blur-sm rounded-2xl shadow-sm border border-premium-border/50 overflow-hidden">
                <form action="{{ route('kelurahan.update', $kelurahan) }}" method="POST" class="p-8 space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <x-input-label for="nama" :value="__('Nama Kelurahan')" />
                            <x-text-input id="nama" name="nama" type="text" class="mt-1 block w-full" :value="old('nama', $kelurahan->nama)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('nama')" />
                        </div>

                        <div>
                            <x-input-label for="kode" :value="__('Kode Wilayah')" />
                            <x-text-input id="kode" name="kode" type="text" class="mt-1 block w-full" :value="old('kode', $kelurahan->kode)" />
                            <x-input-error class="mt-2" :messages="$errors->get('kode')" />
                        </div>

                        <div>
                            <x-input-label for="batas_wilayah" :value="__('Batas Wilayah (Deskripsi)')" />
                            <textarea id="batas_wilayah" name="batas_wilayah" rows="4" 
                                class="mt-1 block w-full border-premium-border/40 bg-white/50 focus:border-forest focus:ring-forest rounded-xl shadow-sm transition-all duration-300 placeholder-forest/30">{{ old('batas_wilayah', $kelurahan->batas_wilayah) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('batas_wilayah')" />
                        </div>
                    </div>

                    <div class="pt-6 mt-6 border-t border-premium-border/30 flex items-center justify-end space-x-4">
                        <a href="{{ route('kelurahan.index') }}" class="text-sm font-bold text-forest/50 hover:text-forest transition-colors duration-300">
                            Batal
                        </a>
                        <x-primary-button>
                            {{ __('Update Kelurahan') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

