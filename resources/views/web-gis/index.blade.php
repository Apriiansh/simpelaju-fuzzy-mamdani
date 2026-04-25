<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center py-2">
            <div>
                <h2 class="font-serif font-bold text-2xl text-forest leading-tight">
                    Peta Sebaran Bantuan RTLH
                </h2>
                <p class="text-xs text-forest/40 font-bold tracking-widest uppercase mt-1">
                    Sistem Informasi Geografis (Web GIS)
                </p>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 h-[calc(100vh-140px)] min-h-[600px] pb-6">
        
        <!-- Map Container -->
        <div class="lg:col-span-3 bg-white/70 backdrop-blur-sm rounded-2xl border border-premium-border/50 shadow-sm overflow-hidden flex flex-col relative z-0">
            <div id="gis-map" class="w-full h-full flex-1"></div>
            
            <!-- Map Overlay Controls (Optional future expansion) -->
            <div class="absolute top-4 right-4 z-[400] bg-white/90 backdrop-blur-md p-2 rounded-xl shadow-lg border border-premium-border/30">
                <p class="text-[9px] font-black text-forest/50 uppercase tracking-widest px-2 pb-1 border-b border-premium-border/30 mb-1 text-center">Legend</p>
                <div class="flex items-center gap-2 px-2 py-1">
                    <span class="w-3 h-3 rounded-full border-2 border-white shadow-sm" style="background-color: #10b981;"></span>
                    <span class="text-[10px] font-bold text-forest">Layak</span>
                </div>
                <div class="flex items-center gap-2 px-2 py-1">
                    <span class="w-3 h-3 rounded-full border-2 border-white shadow-sm" style="background-color: #ef4444;"></span>
                    <span class="text-[10px] font-bold text-forest">Tidak Layak</span>
                </div>
                <div class="flex items-center gap-2 px-2 py-1">
                    <span class="w-3 h-3 rounded-full border-2 border-white shadow-sm" style="background-color: #94a3b8;"></span>
                    <span class="text-[10px] font-bold text-forest">Belum Dinilai</span>
                </div>
            </div>
        </div>

        <!-- Right Side Panel -->
        <div class="flex flex-col gap-6 overflow-y-auto pr-2 custom-scrollbar">
            
            <!-- Global Stats Card -->
            <div class="bg-white/70 backdrop-blur-sm p-6 rounded-2xl border border-premium-border/50 shadow-sm">
                <h3 class="text-[10px] font-black text-forest/40 uppercase tracking-widest mb-4 flex items-center">
                    <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    Ringkasan Data Spasial
                </h3>
                
                <div class="text-4xl font-serif font-extrabold text-forest mb-1">
                    {{ number_format($stats['total']) }}
                </div>
                <p class="text-[10px] font-bold text-forest/60 uppercase tracking-widest mb-5">Titik Koordinat Terekam</p>

                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 rounded-xl bg-emerald-50 border border-emerald-100">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <span class="text-[10px] font-black text-emerald-700 uppercase tracking-widest">Layak RTLH</span>
                        </div>
                        <span class="font-bold text-emerald-700">{{ $stats['layak'] }}</span>
                    </div>

                    <div class="flex items-center justify-between p-3 rounded-xl bg-red-50 border border-red-100">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-red-500"></span>
                            <span class="text-[10px] font-black text-red-700 uppercase tracking-widest">Tidak Layak</span>
                        </div>
                        <span class="font-bold text-red-700">{{ $stats['tidak_layak'] }}</span>
                    </div>

                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 border border-slate-200">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-slate-400"></span>
                            <span class="text-[10px] font-black text-slate-600 uppercase tracking-widest">Belum Dinilai</span>
                        </div>
                        <span class="font-bold text-slate-600">{{ $stats['belum_dinilai'] }}</span>
                    </div>
                </div>
            </div>

            <!-- List Penduduk -->
            <div class="bg-white/70 backdrop-blur-sm rounded-2xl border border-premium-border/50 shadow-sm flex-1 flex flex-col min-h-[300px]">
                <div class="p-4 border-b border-premium-border/30">
                    <h3 class="text-[10px] font-black text-forest/40 uppercase tracking-widest flex items-center">
                        <svg class="w-3 h-3 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        Direktori Penduduk
                    </h3>
                    <input type="text" id="search-penduduk" placeholder="Cari nama atau NIK..." class="mt-3 w-full border-premium-border/40 rounded-xl text-xs bg-paper focus:ring-forest focus:border-forest py-2">
                </div>
                
                <div class="p-2 overflow-y-auto flex-1 custom-scrollbar" id="penduduk-list">
                    @foreach($geoData as $p)
                    <div class="penduduk-item p-3 mb-1.5 rounded-xl hover:bg-paper/80 transition-colors cursor-pointer border border-transparent hover:border-premium-border/30" 
                         data-lat="{{ $p['lat'] }}" data-lng="{{ $p['lng'] }}" data-nama="{{ strtolower($p['nama']) }}" data-nik="{{ $p['nik'] }}">
                        <div class="flex justify-between items-start mb-1">
                            <h4 class="font-serif font-bold text-forest text-sm truncate pr-2">{{ $p['nama'] }}</h4>
                            <span class="w-2 h-2 mt-1.5 shrink-0 rounded-full {{ $p['status'] === 'LAYAK' ? 'bg-emerald-500' : ($p['status'] === 'TIDAK LAYAK' ? 'bg-red-500' : 'bg-slate-400') }}"></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <p class="text-[9px] font-black text-forest/40 uppercase tracking-widest truncate">{{ $p['kelurahan'] }}</p>
                            <p class="text-[9px] font-mono text-forest/60">Z: {{ $p['score'] > 0 ? $p['score'] : '-' }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

    @push('styles')
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        
        /* Fix z-index for leaflet inside fixed header layout */
        .leaflet-container {
            z-index: 1 !important;
        }
        .leaflet-popup-content-wrapper {
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1), 0 8px 10px -6px rgba(0,0,0,0.1);
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                if (typeof L === 'undefined') {
                    console.error('Leaflet is not loaded.');
                    return;
                }

                const geoData = @json($geoData);
                
                // Initialize Map centered on Plaju, Palembang
                // Using average lat/lng or default to Plaju center
                const defaultCenter = [-3.0000, 104.8200];
                const map = L.map('gis-map', {
                    zoomControl: false // We will move it to a better position
                }).setView(defaultCenter, 14);

                // Add zoom control to bottom right so it doesn't overlap header
                L.control.zoom({ position: 'bottomright' }).addTo(map);

                // Add Base Layer
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors',
                    maxZoom: 19
                }).addTo(map);

                const markers = [];
                const colors = {
                    'LAYAK': '#10b981',      // emerald-500
                    'TIDAK LAYAK': '#ef4444', // red-500
                    'BELUM DINILAI': '#94a3b8' // slate-400
                };

                // Create markers
                geoData.forEach(item => {
                    const color = colors[item.status] || colors['BELUM DINILAI'];
                    
                    // Create Custom HTML Circle Marker
                    const customIcon = L.divIcon({
                        html: `<div style="background-color: ${color}; width: 14px; height: 14px; border-radius: 50%; border: 2.5px solid white; box-shadow: 0 2px 5px rgba(0,0,0,0.4);"></div>`,
                        className: 'custom-leaflet-marker',
                        iconSize: [14, 14],
                        iconAnchor: [7, 7],
                        popupAnchor: [0, -10]
                    });

                    const popupContent = `
                        <div class="p-1 min-w-[180px]">
                            <p class="text-[9px] font-black uppercase tracking-widest text-forest/40 mb-1">${item.kelurahan}</p>
                            <h4 class="font-serif font-bold text-forest text-sm leading-tight mb-2">${item.nama}</h4>
                            <div class="flex items-center justify-between border-t border-b border-premium-border/30 py-2 my-2">
                                <span class="text-[9px] font-bold text-forest/50 uppercase tracking-widest">Skor Crisp Z*</span>
                                <span class="font-mono font-black text-xs ${item.status === 'LAYAK' ? 'text-emerald-600' : (item.status === 'TIDAK LAYAK' ? 'text-red-600' : 'text-slate-400')}">
                                    ${item.score > 0 ? item.score : '-'}
                                </span>
                            </div>
                            <div class="mb-3">
                                <span class="px-2 py-1 rounded text-[9px] font-black uppercase ${item.status === 'LAYAK' ? 'bg-emerald-100 text-emerald-700' : (item.status === 'TIDAK LAYAK' ? 'bg-red-100 text-red-700' : 'bg-slate-100 text-slate-600')}">
                                    ${item.status}
                                </span>
                            </div>
                            <a href="${item.url}" class="block w-full text-center bg-forest text-cream py-1.5 rounded-lg text-[9px] font-bold uppercase tracking-widest hover:bg-forest-dark transition-colors">
                                Lihat Detail
                            </a>
                        </div>
                    `;

                    const marker = L.marker([item.lat, item.lng], {icon: customIcon})
                                   .bindPopup(popupContent)
                                   .addTo(map);
                    
                    // Save reference to marker in the item
                    item._marker = marker;
                    markers.push(marker);
                });

                // Auto-fit bounds if we have markers
                if (markers.length > 0) {
                    const group = new L.featureGroup(markers);
                    map.fitBounds(group.getBounds(), { padding: [50, 50] });
                }

                // Handle List Clicks to open popup and center map
                document.querySelectorAll('.penduduk-item').forEach(el => {
                    el.addEventListener('click', function() {
                        const lat = parseFloat(this.dataset.lat);
                        const lng = parseFloat(this.dataset.lng);
                        
                        map.flyTo([lat, lng], 18, {
                            duration: 1.5
                        });

                        // Find and open the corresponding popup
                        const pItem = geoData.find(d => d.lat == lat && d.lng == lng);
                        if(pItem && pItem._marker) {
                            setTimeout(() => {
                                pItem._marker.openPopup();
                            }, 1500); // Wait for flyTo animation
                        }
                    });
                });

                // Simple Search Filtering
                document.getElementById('search-penduduk').addEventListener('input', function(e) {
                    const term = e.target.value.toLowerCase();
                    document.querySelectorAll('.penduduk-item').forEach(el => {
                        const nama = el.dataset.nama;
                        const nik = el.dataset.nik;
                        if(nama.includes(term) || nik.includes(term)) {
                            el.style.display = 'block';
                        } else {
                            el.style.display = 'none';
                        }
                    });
                });

                // Fix scatter tiles
                setTimeout(() => { map.invalidateSize(); }, 500);
            }, 300);
        });
    </script>
    @endpush
</x-app-layout>
