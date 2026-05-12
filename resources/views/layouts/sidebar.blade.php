<!-- Mobile Backdrop -->
<div x-show="sidebarOpen"
     @click="sidebarOpen = false"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-40 bg-forest/40 backdrop-blur-sm lg:hidden">
</div>

<!-- Sidebar -->
<div class="fixed inset-y-0 left-0 z-50 w-64 bg-forest text-cream shadow-2xl transition-all transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0"
     :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">
    <div class="flex items-center px-6 h-16 bg-forest-dark border-b border-premium-border/10 gap-3">
        <div class="p-1.5 bg-white/10 rounded-xl shadow-sm border border-white/5 shrink-0">
            <img src="{{ asset('logo_dinas.svg') }}" alt="Logo Dinas" class="h-auto w-7">
        </div>
        <span class="text-xl font-bold font-serif tracking-tight text-white leading-none">SIMPEL<span class="text-premium-amber-light">AJU</span></span>
    </div>

    <nav class="mt-5 px-4 space-y-2 overflow-y-auto max-h-[calc(100vh-4rem)]">
        <x-nav-link-custom href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" icon="home">
            Dashboard
        </x-nav-link-custom>

        <div class="pt-4 pb-2 border-b border-premium-border/10">
            <span class="text-[10px] font-bold text-premium-amber-light/60 uppercase tracking-[0.2em]">Manajemen Data</span>
        </div>

        @if(Auth::user()->role === 'admin')
        <x-nav-link-custom href="{{ route('kelurahan.index') }}" :active="request()->routeIs('kelurahan.*')" icon="map">
            Data Kelurahan
        </x-nav-link-custom>

        @if(Auth::user()->role === 'operator' || Auth::user()->role === 'admin' || Auth::user()->role === 'camat')
        <x-nav-link-custom href="{{ route('penduduk.index') }}" :active="request()->routeIs('penduduk.*')" icon="users">
            Data Penduduk
        </x-nav-link-custom>
        @endif

        <x-nav-link-custom href="{{ route('users.index') }}" :active="request()->routeIs('users.*')" icon="user-cog">
            Manajemen User
        </x-nav-link-custom>
        @endif



        <div class="pt-4 pb-2 border-b border-premium-border/10">
            <span class="text-[10px] font-bold text-premium-amber-light/60 uppercase tracking-[0.2em]">Proses SPK</span>
        </div>

        @if(Auth::user()->role === 'admin')
        <x-nav-link-custom href="{{ route('kriteria-fuzzy.index') }}" :active="request()->routeIs('kriteria-fuzzy.*')" icon="clipboard-list">
            Kriteria & Fuzzy
        </x-nav-link-custom>
        @endif

        @if(Auth::user()->role === 'operator')
        <x-nav-link-custom href="{{ route('penilaian.index') }}" :active="request()->routeIs('penilaian.*')" icon="clipboard-list">
            Input Penilaian
        </x-nav-link-custom>
        @endif

        @if(Auth::user()->role === 'admin')
        <x-nav-link-custom href="{{ route('penilaian.index') }}" :active="request()->routeIs('penilaian.*')" icon="check-square">
            Verifikasi Usulan
        </x-nav-link-custom>
        @endif

        @if(Auth::user()->role === 'camat')
        <x-nav-link-custom href="{{ route('penilaian.index') }}" :active="request()->routeIs('penilaian.*')" icon="award">
            Validasi & Perankingan
        </x-nav-link-custom>
        @endif

        @if(Auth::user()->role === 'admin' || Auth::user()->role === 'camat')
        <div class="pt-4 pb-2 border-b border-premium-border/10">
            <span class="text-[10px] font-bold text-premium-amber-light/60 uppercase tracking-[0.2em]">GIS & Laporan</span>
        </div>
        <x-nav-link-custom href="{{ route('web-gis.index') }}" :active="request()->routeIs('web-gis.*')" icon="map-pin">
            Web GIS
        </x-nav-link-custom>

        <x-nav-link-custom href="{{ route('laporan.index') }}" :active="request()->routeIs('laporan.*')" icon="file-text">
            Laporan
        </x-nav-link-custom>
        @endif
    </nav>
</div>
