<x-app-layout>
    <x-slot name="header">
        <h2 class="font-serif font-bold text-3xl text-forest leading-tight py-4">
            {{ __('Manajemen User') }}
        </h2>
    </x-slot>

    <div class="mb-8 flex justify-between items-end">
        <div>
            <p class="text-forest/60 text-sm italic">Kelola akun pengguna: Admin Camat, Operator Lurah, dan Camat.</p>
            <div class="h-1 w-12 bg-amber/30 mt-2 rounded-full"></div>
        </div>
        <a href="{{ route('users.create') }}" class="group inline-flex items-center px-8 py-4 bg-forest text-cream rounded-[1.5rem] font-bold text-xs uppercase tracking-widest hover:bg-forest/90 transition-all duration-500 shadow-xl shadow-forest/20 hover:-translate-y-1 active:translate-y-0">
            <svg class="w-4 h-4 mr-3 group-hover:rotate-90 transition-transform duration-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
            </svg>
            Tambah User
        </a>
    </div>

    <div class="bg-white/60 backdrop-blur-md overflow-hidden shadow-sm rounded-[2.5rem] border border-premium-border/50 transition-all duration-500 hover:shadow-2xl hover:shadow-forest/5">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left border-collapse">
                <thead>
                    <tr class="text-[10px] text-forest/40 uppercase bg-paper/20 border-b border-premium-border/20 font-black tracking-[0.2em]">
                        <th class="px-10 py-6">Nama</th>
                        <th class="px-10 py-6">Email</th>
                        <th class="px-10 py-6 text-center">Role</th>
                        <th class="px-10 py-6">Kelurahan</th>
                        <th class="px-10 py-6 text-right">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-premium-border/10">
                    @forelse ($users as $user)
                    <tr class="hover:bg-cream/30 transition-all duration-300 group">
                        <td class="px-10 py-6">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-forest/10 flex items-center justify-center mr-4">
                                    <span class="font-serif font-bold text-forest text-lg">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <div class="font-serif font-bold text-forest text-lg group-hover:text-forest-dark transition-colors">{{ $user->name }}</div>
                                    <div class="text-[10px] font-black text-forest/30 uppercase tracking-[0.1em]">ID: {{ $user->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-10 py-6">
                            <span class="text-forest/70">{{ $user->email }}</span>
                        </td>
                        <td class="px-10 py-6 text-center">
                            @php
                                $roleColors = [
                                    'admin' => 'bg-purple-100 text-purple-700 border-purple-200',
                                    'operator' => 'bg-blue-100 text-blue-700 border-blue-200',
                                    'camat' => 'bg-amber-100 text-amber-700 border-amber-200',
                                ];
                                $roleLabels = [
                                    'admin' => 'Admin Camat',
                                    'operator' => 'Operator Lurah',
                                    'camat' => 'Camat',
                                ];
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-lg border text-xs font-bold uppercase tracking-wider {{ $roleColors[$user->role] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">
                                {{ $roleLabels[$user->role] ?? $user->role }}
                            </span>
                        </td>
                        <td class="px-10 py-6">
                            @if($user->kelurahan)
                                <span class="font-medium text-forest">{{ $user->kelurahan->nama }}</span>
                            @else
                                <span class="text-forest/30 italic">-</span>
                            @endif
                        </td>
                        <td class="px-10 py-6 text-right">
                            <div class="flex justify-end items-center space-x-6">
                                <a href="{{ route('users.edit', $user) }}" class="text-forest/30 hover:text-forest font-black text-[10px] uppercase tracking-[0.15em] transition-all duration-300">Edit</a>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-300 hover:text-red-600 transition-all duration-300" onclick="return confirm('Hapus user {{ $user->name }}?')">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-10 py-24 text-center">
                            <p class="text-forest/30 font-serif italic text-lg tracking-tight">Belum ada data user.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
