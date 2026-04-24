<x-guest-layout>
    <div class="min-h-screen bg-[#F6F3EE] flex items-center justify-center px-4 relative overflow-hidden font-sans antialiased text-[#1A3A2A]">
        {{-- Background Decorations --}}
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-[#1A3A2A]/5 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-[#B5850A]/5 rounded-full blur-3xl"></div>

        <div class="w-full max-w-md relative z-10">
            {{-- Brand & Logo Section --}}
            <div class="text-center mb-10 group">
                <div class="inline-block p-4 rounded-[2rem] bg-white/40 backdrop-blur-md border border-white/60 shadow-xl shadow-forest/5 mb-6 transition-transform duration-500 group-hover:scale-110">
                    <img src="{{ asset('logo_dinas.svg') }}" alt="Logo Dinas" class="w-20 h-20 object-contain drop-shadow-md">
                </div>
                <h1 class="font-serif text-4xl font-bold tracking-tight text-[#1A3A2A] mb-2">
                    SIMPEL<span class="text-[#B5850A]">AJU</span>
                </h1>
                <p class="text-[#6B6659] font-medium tracking-wide uppercase text-[10px] md:text-xs">Sistem Informasi Mamdani Pemetaan Layak Huni Plaju</p>
                <div class="h-1 w-12 bg-[#B5850A] mx-auto mt-4 rounded-full opacity-50"></div>
            </div>

            {{-- Login Card --}}
            <div class="bg-white/70 backdrop-blur-xl border border-white/60 rounded-[2.5rem] p-10 shadow-2xl shadow-forest/10 relative overflow-hidden">
                {{-- Gloss Shimmer Effect --}}
                <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/10 to-transparent pointer-events-none"></div>

                <div class="relative z-10">
                    <div class="mb-8">
                        <h2 class="text-2xl font-serif font-bold text-[#1A3A2A]">Selamat Datang</h2>
                        <p class="text-sm text-[#6B6659] mt-1">Silakan masuk untuk melanjutkan ke dashboard.</p>
                    </div>

                    {{-- Session Status --}}
                    @if (session('status'))
                        <div class="mb-6 p-4 rounded-2xl bg-green-50/50 border border-green-100 flex items-center gap-3 backdrop-blur-sm">
                            <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                            <p class="text-sm font-medium text-green-700">{{ session('status') }}</p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        {{-- Email Address --}}
                        <div class="space-y-2">
                            <label for="email" class="block text-[10px] font-bold uppercase tracking-[0.2em] text-[#A0988A] ml-1">
                                Alamat Email
                            </label>
                            <div class="relative group">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#1A3A2A]/40 transition-colors group-focus-within:text-[#1A3A2A]">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                                </span>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                                    placeholder="youremail@plaju.go.id"
                                    class="w-full pl-12 pr-4 py-4 bg-[#F6F3EE]/50 border border-[#D8D4CB]/50 rounded-2xl text-sm text-[#1A3A2A] placeholder-[#B5B0A5] focus:bg-white focus:border-[#1A3A2A] focus:ring-4 focus:ring-[#1A3A2A]/5 outline-none transition-all duration-300 shadow-inner">
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        {{-- Password --}}
                        <div class="space-y-2" x-data="{ show: false }">
                            <label for="password" class="block text-[10px] font-bold uppercase tracking-[0.2em] text-[#A0988A] ml-1">
                                Kata Sandi
                            </label>
                            <div class="relative group">
                                {{-- Lock icon --}}
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#1A3A2A]/40 transition-colors group-focus-within:text-[#1A3A2A]">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                </span>

                                <input
                                    id="password"
                                    :type="show ? 'text' : 'password'"
                                    name="password"
                                    required
                                    autocomplete="current-password"
                                    placeholder="••••••••"
                                    class="w-full pl-12 pr-12 py-4 bg-[#F6F3EE]/50 border border-[#D8D4CB]/50 rounded-2xl text-sm text-[#1A3A2A] placeholder-[#B5B0A5] focus:bg-white focus:border-[#1A3A2A] focus:ring-4 focus:ring-[#1A3A2A]/5 outline-none transition-all duration-300 shadow-inner">

                                {{-- Toggle button --}}
                                <button
                                    type="button"
                                    @click="show = !show"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-[#1A3A2A]/40 hover:text-[#1A3A2A] transition-colors focus:outline-none"
                                    :aria-label="show ? 'Sembunyikan password' : 'Tampilkan password'"
                                >
                                    {{-- Eye icon (saat password tersembunyi) --}}
                                    <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    {{-- Eye-off icon (saat password terlihat) --}}
                                    <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                    </svg>
                                </button>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center justify-between">
                            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                                <input id="remember_me" type="checkbox" class="rounded-lg border-[#D8D4CB] text-[#1A3A2A] shadow-sm focus:ring-[#1A3A2A]/20 transition-all cursor-pointer" name="remember">
                                <span class="ms-2 text-sm text-[#6B6659] group-hover:text-[#1A3A2A] transition-colors">Ingat Saya</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a class="text-sm font-semibold text-[#B5850A] hover:text-[#1A3A2A] transition-colors" href="{{ route('password.request') }}">
                                    Lupa Sandi?
                                </a>
                            @endif
                        </div>

                        {{-- Submit Button --}}
                        <button type="submit" class="w-full py-4 bg-[#1A3A2A] hover:bg-[#274D39] text-white font-bold rounded-2xl shadow-xl shadow-forest/20 hover:shadow-forest/30 transition-all duration-300 transform hover:-translate-y-1 active:scale-[0.98] flex items-center justify-center gap-2 group">
                            <span>Masuk ke Sistem</span>
                            <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                        </button>
                    </form>
                </div>
            </div>

            {{-- Footer Links --}}
            <div class="mt-10 text-center flex flex-col gap-4">
                <a href="{{ url('/') }}" class="text-[#6B6659] hover:text-[#1A3A2A] font-medium transition-all inline-flex items-center justify-center gap-2 group">
                    <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    <span>Kembali ke Beranda</span>
                </a>
                <p class="text-[10px] uppercase tracking-widest text-[#B5B0A5]">&copy; 2026 — Seluruh Hak Cipta Dilindungi</p>
            </div>
        </div>
    </div>
</x-guest-layout>