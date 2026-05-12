<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif font-bold text-3xl text-forest leading-tight py-4">
            {{ __('Tambah User Baru') }}
        </h2>
    </x-slot>

    <div class="mb-8">
        <p class="text-forest/60 text-sm italic">Buat akun pengguna baru dengan role dan akses yang sesuai.</p>
        <div class="h-1 w-12 bg-amber/30 mt-2 rounded-full"></div>
    </div>

    <div class="bg-white/60 backdrop-blur-md overflow-hidden shadow-sm rounded-[2.5rem] border border-premium-border/50 p-10">
        <form action="{{ route('users.store') }}" method="POST" class="space-y-8">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Nama --}}
                <div>
                    <label for="name" class="block text-[10px] font-black text-forest/50 uppercase tracking-[0.2em] mb-3">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                        class="w-full bg-paper/30 border border-premium-border/30 rounded-xl px-6 py-4 text-forest placeholder-forest/30 focus:outline-none focus:border-forest/50 focus:bg-white transition-all duration-300">
                    @error('name')
                        <p class="mt-2 text-red-500 text-xs">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-[10px] font-black text-forest/50 uppercase tracking-[0.2em] mb-3">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        class="w-full bg-paper/30 border border-premium-border/30 rounded-xl px-6 py-4 text-forest placeholder-forest/30 focus:outline-none focus:border-forest/50 focus:bg-white transition-all duration-300">
                    @error('email')
                        <p class="mt-2 text-red-500 text-xs">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-[10px] font-black text-forest/50 uppercase tracking-[0.2em] mb-3">Password</label>
                    <input type="password" name="password" id="password" required minlength="8"
                        class="w-full bg-paper/30 border border-premium-border/30 rounded-xl px-6 py-4 text-forest placeholder-forest/30 focus:outline-none focus:border-forest/50 focus:bg-white transition-all duration-300">
                    <p class="mt-2 text-forest/40 text-xs">Minimal 8 karakter</p>
                    @error('password')
                        <p class="mt-2 text-red-500 text-xs">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Role --}}
                <div>
                    <label for="role" class="block text-[10px] font-black text-forest/50 uppercase tracking-[0.2em] mb-3">Role</label>
                    <select name="role" id="role" required onchange="toggleKelurahan()"
                        class="w-full bg-paper/30 border border-premium-border/30 rounded-xl px-6 py-4 text-forest focus:outline-none focus:border-forest/50 focus:bg-white transition-all duration-300">
                        <option value="">Pilih Role</option>
                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin Camat</option>
                        <option value="operator" {{ old('role') === 'operator' ? 'selected' : '' }}>Operator Lurah</option>
                        <option value="camat" {{ old('role') === 'camat' ? 'selected' : '' }}>Camat</option>
                    </select>
                    @error('role')
                        <p class="mt-2 text-red-500 text-xs">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Kelurahan (hanya untuk operator) --}}
            <div id="kelurahan-container" class="{{ old('role') === 'operator' ? '' : 'hidden' }}">
                <label for="kelurahan_id" class="block text-[10px] font-black text-forest/50 uppercase tracking-[0.2em] mb-3">Kelurahan</label>
                <select name="kelurahan_id" id="kelurahan_id"
                    class="w-full bg-paper/30 border border-premium-border/30 rounded-xl px-6 py-4 text-forest focus:outline-none focus:border-forest/50 focus:bg-white transition-all duration-300">
                    <option value="">Pilih Kelurahan</option>
                    @foreach($kelurahan as $k)
                        <option value="{{ $k->id }}" {{ old('kelurahan_id') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                    @endforeach
                </select>
                @error('kelurahan_id')
                    <p class="mt-2 text-red-500 text-xs">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol --}}
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-premium-border/20">
                <a href="{{ route('users.index') }}" class="px-8 py-4 text-forest/50 font-bold text-xs uppercase tracking-widest hover:text-forest transition-all duration-300">
                    Batal
                </a>
                <button type="submit" class="group inline-flex items-center px-8 py-4 bg-forest text-cream rounded-[1.5rem] font-bold text-xs uppercase tracking-widest hover:bg-forest/90 transition-all duration-500 shadow-xl shadow-forest/20 hover:-translate-y-1 active:translate-y-0">
                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Simpan
                </button>
            </div>
        </form>
    </div>

    <script>
        function toggleKelurahan() {
            const role = document.getElementById('role').value;
            const container = document.getElementById('kelurahan-container');
            const kelurahanSelect = document.getElementById('kelurahan_id');

            if (role === 'operator') {
                container.classList.remove('hidden');
                kelurahanSelect.setAttribute('required', 'required');
            } else {
                container.classList.add('hidden');
                kelurahanSelect.removeAttribute('required');
                kelurahanSelect.value = '';
            }
        }
    </script>
</x-app-layout>
