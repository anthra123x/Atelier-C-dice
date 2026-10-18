@extends('layouts.studio')

@section('title', 'Cartografía y Mapas - Estudio Cóice')
@section('view_label', 'Cartografía & Point Marks')

@push('styles')
<!-- Leaflet CSS for Google Maps Tiles -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<style>
    /* Custom Leaflet Map styling to match Estudio Cóice aesthetic */
    .leaflet-container {
        font-family: inherit;
        background: #0f172a;
    }
    .leaflet-popup-content-wrapper {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(226, 232, 240, 0.8);
        border-radius: 14px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.15), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        padding: 4px;
    }
    .leaflet-popup-tip {
        background: rgba(255, 255, 255, 0.95);
    }
    .leaflet-popup-content {
        margin: 10px 14px;
        font-size: 12px;
        line-height: 1.4;
    }
    /* Pulsing beacon marker animation */
    .gmap-marker-pin {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .gmap-marker-halo {
        position: absolute;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        animation: gmap-pulse 2s cubic-bezier(0, 0, 0.2, 1) infinite;
        opacity: 0.6;
    }
    @keyframes gmap-pulse {
        0% { transform: scale(0.6); opacity: 0.8; }
        70% { transform: scale(1.6); opacity: 0; }
        100% { transform: scale(1.6); opacity: 0; }
    }
</style>
@endpush

@section('content')
<div class="relative w-full h-[calc(100vh-64px)] overflow-hidden flex bg-canvas-bg">

    <!-- Top Floating Filter & Controls Bar -->
    <div class="absolute top-5 left-6 z-30 flex flex-wrap items-center gap-2 max-w-[calc(100%-410px)] pointer-events-auto">
        <!-- Sector Filter Pills Bar -->
        <div class="flex items-center gap-1.5 bg-surface-card/95 backdrop-blur-xl px-3 py-1.5 rounded-2xl border border-border-subtle shadow-lg">
            <span class="material-symbols-outlined text-accent-indigo text-[18px]">explore</span>
            <span class="font-label text-xs font-bold text-text-primary mr-1">Cartografía:</span>
            
            <a href="{{ route('studio.maps') }}" 
               class="px-2.5 py-1 rounded-full font-label text-[11px] transition-all {{ empty($selectedSector) ? 'bg-text-primary text-white font-semibold' : 'text-text-secondary hover:text-text-primary' }}">
                Todos
            </a>
            @foreach($sectors as $sec)
                <a href="{{ route('studio.maps', ['sector' => $sec]) }}" 
                   class="px-2.5 py-1 rounded-full font-label text-[11px] transition-all {{ $selectedSector === $sec ? 'bg-text-primary text-white font-semibold' : 'text-text-secondary hover:text-text-primary' }}">
                    {{ explode('·', $sec)[0] }}
                </a>
            @endforeach
            <button onclick="openLocationModal()" class="ml-1 w-7 h-7 rounded-full bg-accent-indigo text-white flex items-center justify-center hover:bg-accent-indigo-hover shadow-sm transition-transform hover:scale-105" title="Agregar pin de locación en el mapa">
                <span class="material-symbols-outlined text-[16px]">add_location_alt</span>
            </button>
        </div>

        <!-- Google Maps Layer Mode Selector -->
        <div class="flex items-center gap-1 bg-surface-card/95 backdrop-blur-xl p-1 rounded-2xl border border-border-subtle shadow-lg font-label text-xs">
            <button onclick="setMapLayer('hybrid')" id="btn-layer-hybrid" 
                    class="layer-toggle-btn px-2.5 py-1 rounded-xl bg-accent-indigo text-white font-semibold flex items-center gap-1 text-[11px] transition-colors" title="Google Satélite con Nombres de Calles">
                <span class="material-symbols-outlined text-[14px]">satellite_alt</span>
                <span>Híbrido</span>
            </button>
            <button onclick="setMapLayer('roadmap')" id="btn-layer-roadmap" 
                    class="layer-toggle-btn px-2.5 py-1 rounded-xl text-text-secondary hover:text-text-primary hover:bg-surface-container font-medium flex items-center gap-1 text-[11px] transition-colors" title="Google Maps Calles Vectorial">
                <span class="material-symbols-outlined text-[14px]">map</span>
                <span>Calles</span>
            </button>
            <button onclick="setMapLayer('satellite')" id="btn-layer-satellite" 
                    class="layer-toggle-btn px-2.5 py-1 rounded-xl text-text-secondary hover:text-text-primary hover:bg-surface-container font-medium flex items-center gap-1 text-[11px] transition-colors" title="Google Satélite Puro">
                <span class="material-symbols-outlined text-[14px]">public</span>
                <span>Satélite</span>
            </button>
            <button onclick="setMapLayer('terrain')" id="btn-layer-terrain" 
                    class="layer-toggle-btn px-2.5 py-1 rounded-xl text-text-secondary hover:text-text-primary hover:bg-surface-container font-medium flex items-center gap-1 text-[11px] transition-colors" title="Google Terreno & Relieve">
                <span class="material-symbols-outlined text-[14px]">landscape</span>
                <span>Relieve</span>
            </button>
        </div>
    </div>

    <!-- Real Google Maps Viewport Area -->
    <div class="relative flex-1 h-full select-none">
        <!-- Interactive Leaflet + Google Maps Tiles Container -->
        <div id="google-maps-container" class="w-full h-full z-10"></div>

        <!-- Coordinates HUD Overlay at Bottom Left -->
        <div class="absolute bottom-6 left-6 z-20 flex items-center gap-3 bg-surface-card/90 backdrop-blur-xl px-4 py-2.5 rounded-2xl border border-border-subtle shadow-xl font-label text-xs">
            <div class="flex items-center gap-2 text-text-secondary">
                <span class="material-symbols-outlined text-[16px] text-accent-indigo">gps_fixed</span>
                <span class="font-semibold text-text-primary">Google Maps Datum:</span>
                <span id="hud-coordinates">35°40'48"N 139°45'43"E</span>
            </div>
            <span class="w-1 h-3 bg-border-strong rounded-full"></span>
            <div class="flex items-center gap-1.5 text-accent-sage font-bold">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span id="hud-locations-count">{{ count($locations) }} Locaciones Activas</span>
            </div>
            <span class="w-1 h-3 bg-border-strong rounded-full"></span>
            <div class="text-[11px] text-text-muted">
                Tip: Haz clic en el mapa para fijar coordenadas
            </div>
        </div>
    </div>

    <!-- Right Side Location Inspector Drawer -->
    <aside id="inspector-drawer" class="w-96 bg-surface-card border-l border-border-subtle shadow-2xl flex flex-col z-30 transition-all duration-300 overflow-y-auto">
        <div class="p-6 border-b border-border-subtle flex items-start justify-between">
            <div>
                <span id="drawer-code" class="px-2.5 py-0.5 rounded-full bg-surface-container-high text-accent-indigo font-label text-[10px] font-bold tracking-wider uppercase border border-border-subtle">#01</span>
                <h2 id="drawer-name" class="font-headline text-2xl font-bold text-text-primary mt-1 leading-tight">Almacén 17 · Muelle Este</h2>
                <p id="drawer-sector" class="font-body text-xs text-text-secondary mt-0.5">Sector 04 · Hangares y Contrabando</p>
            </div>
            <span id="drawer-status" class="px-2.5 py-1 rounded-full bg-orange-50 text-accent-terracotta border border-orange-200 font-label text-[10px] font-bold">Bajo Sospecha</span>
        </div>

        <div class="p-6 space-y-5 flex-1">
            <!-- Location Image / Drone Satellite Preview -->
            <div id="drawer-image-box" class="rounded-xl overflow-hidden h-44 bg-surface-container shadow-sm border border-border-subtle">
                <img id="drawer-image" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDSlE-30PW7KJ3-LolW8xKS0QEqLTVavb-51_hxIwASekg53HiiD_oow5lpeCjn96h4tjOp7RvLXY4LEHzZrruRkJ3PGO70WcEq8k9zOwFORnydL8M637mr-XrddhXaZHkzwSbDIHcO8XCuq-XgzmbsyNjNIHIulx045DIehd2XGbf68T6daL1Tp5gdTLSPefEEIAEJ2Zuz6voaErGvT8IdUtQt7XayRWpdYlfHIOvzcPMhXJs3Inq4Hw" 
                     class="w-full h-full object-cover" alt="Drone Shot">
            </div>

            <!-- Quick Navigation Actions -->
            <div class="flex items-center gap-2">
                <button onclick="centerSelectedOnMap()" class="flex-1 py-2 px-3 rounded-xl bg-surface-container-high hover:bg-surface-container text-text-primary font-label text-xs font-semibold flex items-center justify-center gap-1.5 border border-border-subtle transition-colors">
                    <span class="material-symbols-outlined text-[16px] text-accent-indigo">center_focus_strong</span>
                    <span>Centrar en Mapa</span>
                </button>
                <a id="drawer-gmaps-link" href="https://maps.google.com/?q=Tokyo+Port+Warehouses" target="_blank" rel="noopener noreferrer" 
                   class="flex-1 py-2 px-3 rounded-xl bg-accent-indigo text-white hover:bg-accent-indigo-hover font-label text-xs font-semibold flex items-center justify-center gap-1.5 shadow-sm transition-all">
                    <span class="material-symbols-outlined text-[16px]">open_in_new</span>
                    <span>Ver en Google Maps</span>
                </a>
            </div>

            <!-- Intel Card -->
            <div class="bg-surface-container-low p-4 rounded-xl border border-border-subtle space-y-1.5">
                <div class="flex items-center gap-1.5 font-label text-[11px] font-bold text-accent-terracotta uppercase">
                    <span class="material-symbols-outlined text-[16px]">verified_user</span>
                    <span>Informe de Inteligencia</span>
                </div>
                <p id="drawer-intel" class="font-body text-xs text-text-secondary leading-relaxed">
                    Se reportan contenedores criogénicos con el sello de Industrias Kurogane. Descarga clandestina de chips de memoria neural.
                </p>
            </div>

            <!-- Description -->
            <div>
                <h4 class="font-label text-xs font-bold text-text-primary uppercase tracking-wider mb-1">Descripción</h4>
                <p id="drawer-desc" class="font-body text-xs text-text-secondary leading-relaxed">
                    Antiguo hangar portuario reconvertido en punto de transferencia para cargamentos biotecnológicos no declarados.
                </p>
            </div>

            <!-- Threat Level Meter -->
            <div class="pt-2 border-t border-border-subtle">
                <div class="flex items-center justify-between font-label text-xs mb-1.5">
                    <span class="font-bold text-text-primary">Nivel de Amenaza</span>
                    <span id="drawer-threat-text" class="text-accent-terracotta font-bold">Nivel 4 / 5</span>
                </div>
                <div class="w-full bg-surface-container-high h-2 rounded-full overflow-hidden flex">
                    <div id="drawer-threat-bar" class="bg-accent-terracotta h-full rounded-full transition-all duration-500" style="width: 80%;"></div>
                </div>
            </div>

            <!-- Coordinates Details -->
            <div class="p-3 rounded-xl bg-surface-container-low border border-border-subtle flex items-center justify-between font-label text-xs">
                <span class="text-text-muted">Coordenadas Exactas:</span>
                <span id="drawer-coords-display" class="font-mono font-semibold text-text-primary">35.64200, 139.78200</span>
            </div>

            <!-- Key Contacts Chips -->
            <div>
                <h4 class="font-label text-xs font-bold text-text-primary uppercase tracking-wider mb-2">Contactos Clave</h4>
                <div id="drawer-contacts" class="flex flex-wrap gap-1.5">
                    <span class="px-2.5 py-1 rounded-full bg-surface-container-high text-text-primary font-label text-[11px] font-medium border border-border-subtle">Capataz Miller</span>
                    <span class="px-2.5 py-1 rounded-full bg-surface-container-high text-text-primary font-label text-[11px] font-medium border border-border-subtle">El Sueco</span>
                </div>
            </div>
        </div>
    </aside>
</div>

<!-- Modal Crear Locación (con coordenadas en Google Maps) -->
<div id="location-modal" class="fixed inset-0 z-50 bg-text-primary/40 backdrop-blur-sm hidden items-center justify-center p-4">
    <div class="bg-surface-card rounded-2xl border border-border-subtle shadow-2xl w-full max-w-md p-6 animate-in fade-in zoom-in-95 duration-200">
        <div class="flex items-center justify-between pb-3 border-b border-border-subtle">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-accent-indigo text-white flex items-center justify-center">
                    <span class="material-symbols-outlined text-[18px]">add_location</span>
                </div>
                <div>
                    <h3 class="font-headline text-lg font-bold text-text-primary">Nuevo Pin en Google Maps</h3>
                    <p class="font-body text-xs text-text-muted">Ubica una nueva locación o punto narrativo</p>
                </div>
            </div>
            <button onclick="closeLocationModal()" class="w-7 h-7 rounded-lg hover:bg-surface-container-high flex items-center justify-center text-text-muted hover:text-text-primary">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        <form onsubmit="handleCreateLocation(event)" class="mt-4 space-y-3.5">
            <div>
                <label class="block font-label text-xs font-semibold text-text-secondary mb-1">Nombre de la Locación</label>
                <input type="text" id="loc-name" required placeholder="Ej. Laboratorio Subterráneo 09"
                       class="w-full bg-surface-container-low border border-border-subtle rounded-xl px-3 py-2 font-body text-xs text-text-primary focus:outline-none focus:ring-2 focus:ring-accent-indigo">
            </div>

            <div>
                <label class="block font-label text-xs font-semibold text-text-secondary mb-1">Sector</label>
                <select id="loc-sector" class="w-full bg-surface-container-low border border-border-subtle rounded-xl px-3 py-2 font-label text-xs text-text-primary focus:outline-none focus:ring-2 focus:ring-accent-indigo">
                    @foreach($sectors as $sec)
                        <option value="{{ $sec }}">{{ $sec }}</option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-label text-xs font-semibold text-text-secondary mb-1">Longitud (X / Lng)</label>
                    <input type="number" step="any" id="loc-x" value="139.7500" required
                           class="w-full bg-surface-container-low border border-border-subtle rounded-xl px-3 py-2 font-mono text-xs text-text-primary focus:outline-none focus:ring-2 focus:ring-accent-indigo">
                </div>
                <div>
                    <label class="block font-label text-xs font-semibold text-text-secondary mb-1">Latitud (Y / Lat)</label>
                    <input type="number" step="any" id="loc-y" value="35.6895" required
                           class="w-full bg-surface-container-low border border-border-subtle rounded-xl px-3 py-2 font-mono text-xs text-text-primary focus:outline-none focus:ring-2 focus:ring-accent-indigo">
                </div>
            </div>

            <div>
                <label class="block font-label text-xs font-semibold text-text-secondary mb-1">Descripción</label>
                <textarea id="loc-desc" rows="2" required placeholder="Propósito de la locación y detalles narrativos..."
                          class="w-full bg-surface-container-low border border-border-subtle rounded-xl px-3 py-2 font-body text-xs text-text-primary focus:outline-none focus:ring-2 focus:ring-accent-indigo"></textarea>
            </div>

            <div class="flex items-center justify-end gap-2 pt-2">
                <button type="button" onclick="closeLocationModal()" class="px-4 py-2 rounded-xl text-text-secondary hover:bg-surface-container font-label text-xs">Cancelar</button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-accent-indigo text-white hover:bg-accent-indigo-hover font-label text-xs font-semibold shadow-md">Guardar Pin</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<!-- Leaflet JS for Google Maps live rendering -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    const universeId = {{ $universe->id }};
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const rawLocations = @json($locations);

    let map;
    let currentTileLayer;
    let markersLayer;
    let selectedLocationCoords = [35.6420, 139.7820];

    // Google Maps Tile Endpoints
    const googleLayers = {
        hybrid: L.tileLayer('https://mt{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['0', '1', '2', '3'],
            attribution: '&copy; Google Maps'
        }),
        roadmap: L.tileLayer('https://mt{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['0', '1', '2', '3'],
            attribution: '&copy; Google Maps'
        }),
        satellite: L.tileLayer('https://mt{s}.google.com/vt/lyrs=s&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['0', '1', '2', '3'],
            attribution: '&copy; Google Maps'
        }),
        terrain: L.tileLayer('https://mt{s}.google.com/vt/lyrs=p&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['0', '1', '2', '3'],
            attribution: '&copy; Google Maps'
        })
    };

    // Calculate real geo-coordinates for each location
    function resolveGeoLocation(loc) {
        if (loc.map_y && Math.abs(loc.map_y) <= 90 && loc.map_x && Math.abs(loc.map_x) <= 180 && loc.map_x !== 0) {
            return [parseFloat(loc.map_y), parseFloat(loc.map_x)];
        }
        // Known lore locations
        if (loc.name.includes('Almacén 17') || loc.name.includes('Muelle')) {
            return [35.6420, 139.7820];
        }
        if (loc.name.includes('Cuervo') || loc.name.includes('Bar')) {
            return [35.6938, 139.7034];
        }
        if (loc.name.includes('Archivo') || loc.name.includes('General')) {
            return [35.6852, 139.7528];
        }
        if (loc.name.includes('Vigilancia') || loc.name.includes('Norte')) {
            return [35.7148, 139.7744];
        }
        if (loc.name.includes('Refugio') || loc.name.includes('Subterráneo')) {
            return [35.6605, 139.7292];
        }
        // Coordinate projection around central datum
        const baseLat = 35.6895;
        const baseLng = 139.6917;
        const lat = baseLat - (((loc.map_y || 400) - 400) * 0.0002);
        const lng = baseLng + (((loc.map_x || 600) - 600) * 0.00035);
        return [lat, lng];
    }

    // Initialize Map on DOM Ready
    document.addEventListener('DOMContentLoaded', () => {
        const defaultCenter = [35.6620, 139.7550]; // Tokyo / Neo-Kyoto Bay
        map = L.map('google-maps-container', {
            center: defaultCenter,
            zoom: 13,
            zoomControl: false
        });

        // Add Zoom Control at bottom right
        L.control.zoom({ position: 'bottomright' }).addTo(map);

        // Set default layer to Google Hybrid
        currentTileLayer = googleLayers.hybrid;
        currentTileLayer.addTo(map);

        markersLayer = L.layerGroup().addTo(map);

        // Render Location Pins
        renderMarkers();

        // Map Click: pick coordinates and prompt new location pin
        map.on('click', (e) => {
            const lat = e.latlng.lat.toFixed(5);
            const lng = e.latlng.lng.toFixed(5);
            document.getElementById('loc-x').value = lng;
            document.getElementById('loc-y').value = lat;
            document.getElementById('hud-coordinates').textContent = `${lat}°N ${lng}°E`;
            openLocationModal();
            showToast(`Punto en Google Maps seleccionado: ${lat}, ${lng}`);
        });

        // Update HUD on mouse move
        map.on('mousemove', (e) => {
            document.getElementById('hud-coordinates').textContent = `${e.latlng.lat.toFixed(4)}°N ${e.latlng.lng.toFixed(4)}°E`;
        });

        // Initial inspector sync with first location if available
        if (rawLocations.length > 0) {
            const first = rawLocations[0];
            const coords = resolveGeoLocation(first);
            selectedLocationCoords = coords;
            inspectLocation(first, false);
        }
    });

    function setMapLayer(layerKey) {
        if (!googleLayers[layerKey] || !map) return;
        if (currentTileLayer) {
            map.removeLayer(currentTileLayer);
        }
        currentTileLayer = googleLayers[layerKey];
        currentTileLayer.addTo(map);

        // Update button visual styles
        document.querySelectorAll('.layer-toggle-btn').forEach(btn => {
            btn.classList.remove('bg-accent-indigo', 'text-white', 'font-semibold');
            btn.classList.add('text-text-secondary', 'font-medium');
        });
        const activeBtn = document.getElementById(`btn-layer-${layerKey}`);
        if (activeBtn) {
            activeBtn.classList.add('bg-accent-indigo', 'text-white', 'font-semibold');
            activeBtn.classList.remove('text-text-secondary', 'font-medium');
        }
        showToast(`Capa cambiada a Google Maps: ${layerKey.toUpperCase()}`);
    }

    function renderMarkers() {
        markersLayer.clearLayers();

        rawLocations.forEach(loc => {
            const coords = resolveGeoLocation(loc);
            const color = loc.color || '#4F46E5';
            const iconName = loc.icon || 'location_on';

            const customIcon = L.divIcon({
                className: 'custom-gmap-pin',
                html: `
                    <div class="gmap-marker-pin" style="cursor: pointer;">
                        <span class="gmap-marker-halo" style="background-color: ${color};"></span>
                        <div style="background-color: ${color}; width: 32px; height: 32px; border-radius: 50%; color: white; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.35); border: 2px solid #ffffff; position: relative; z-index: 2;">
                            <span class="material-symbols-outlined" style="font-size: 18px;">${iconName}</span>
                        </div>
                    </div>
                `,
                iconSize: [36, 36],
                iconAnchor: [18, 18],
                popupAnchor: [0, -20]
            });

            const marker = L.marker(coords, { icon: customIcon });

            const popupContent = `
                <div style="min-width: 170px;">
                    <div style="font-size: 10px; font-weight: bold; text-transform: uppercase; color: ${color};">${loc.code || '#LOC'}</div>
                    <div style="font-size: 13px; font-weight: bold; color: #1e293b; margin-top: 2px;">${loc.name}</div>
                    <div style="font-size: 11px; color: #64748b; margin-top: 1px;">${loc.sector}</div>
                    <div style="margin-top: 6px; padding-top: 6px; border-top: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: space-between;">
                        <span style="font-size: 10px; color: #94a3b8;">${coords[0].toFixed(3)}, ${coords[1].toFixed(3)}</span>
                        <button onclick="inspectLocation(${JSON.stringify(loc).replace(/"/g, '&quot;')})" style="background: ${color}; color: white; border: none; padding: 2px 8px; border-radius: 6px; font-size: 10px; font-weight: bold; cursor: pointer;">
                            Detalles
                        </button>
                    </div>
                </div>
            `;

            marker.bindPopup(popupContent);

            marker.on('click', () => {
                inspectLocation(loc);
            });

            markersLayer.addLayer(marker);
        });
    }

    function inspectLocation(loc, shouldFly = true) {
        document.getElementById('drawer-code').textContent = loc.code || '#--';
        document.getElementById('drawer-name').textContent = loc.name;
        document.getElementById('drawer-sector').textContent = loc.sector;
        document.getElementById('drawer-status').textContent = loc.status || 'Activo';
        document.getElementById('drawer-desc').textContent = loc.description || '';
        document.getElementById('drawer-intel').textContent = loc.intel || 'Sin inteligencia clasificada.';
        
        const coords = resolveGeoLocation(loc);
        selectedLocationCoords = coords;
        document.getElementById('drawer-coords-display').textContent = `${coords[0].toFixed(5)}, ${coords[1].toFixed(5)}`;
        
        // Update direct Google Maps Search Link
        const gmapsLink = document.getElementById('drawer-gmaps-link');
        if (gmapsLink) {
            gmapsLink.href = `https://www.google.com/maps/search/?api=1&query=${coords[0]},${coords[1]}`;
        }

        const threat = loc.threat_level || 1;
        document.getElementById('drawer-threat-text').textContent = `Nivel ${threat} / 5`;
        document.getElementById('drawer-threat-bar').style.width = `${(threat / 5) * 100}%`;

        const image = document.getElementById('drawer-image');
        if (loc.image_url) {
            image.src = loc.image_url;
            document.getElementById('drawer-image-box').classList.remove('hidden');
        }

        const contactsContainer = document.getElementById('drawer-contacts');
        contactsContainer.innerHTML = '';
        const contacts = Array.isArray(loc.key_contacts) ? loc.key_contacts : [];
        if (contacts.length > 0) {
            contacts.forEach(c => {
                const badge = document.createElement('span');
                badge.className = 'px-2.5 py-1 rounded-full bg-surface-container-high text-text-primary font-label text-[11px] font-medium border border-border-subtle';
                badge.textContent = c;
                contactsContainer.appendChild(badge);
            });
        } else {
            contactsContainer.innerHTML = '<span class="text-text-muted font-body text-xs italic">Ningún contacto registrado</span>';
        }

        if (shouldFly && map) {
            map.flyTo(coords, 15, {
                animate: true,
                duration: 1.2
            });
        }

        showToast(`Locación seleccionada: ${loc.name}`);
    }

    function centerSelectedOnMap() {
        if (map && selectedLocationCoords) {
            map.flyTo(selectedLocationCoords, 16, { animate: true, duration: 1.0 });
        }
    }

    function openLocationModal() {
        const modal = document.getElementById('location-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeLocationModal() {
        const modal = document.getElementById('location-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    async function handleCreateLocation(e) {
        e.preventDefault();
        const name = document.getElementById('loc-name').value;
        const sector = document.getElementById('loc-sector').value;
        const x = parseFloat(document.getElementById('loc-x').value);
        const y = parseFloat(document.getElementById('loc-y').value);
        const desc = document.getElementById('loc-desc').value;

        try {
            const res = await fetch(`/api/v1/universes/${universeId}/locations`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    name: name,
                    sector: sector,
                    map_x: x,
                    map_y: y,
                    description: desc,
                    status: 'Activo',
                    threat_level: 3,
                    color: '#4F46E5'
                })
            });

            if (res.ok) {
                closeLocationModal();
                showToast('Pin de locación registrado con éxito en Google Maps', 'success');
                setTimeout(() => location.reload(), 600);
            }
        } catch (err) {
            console.error('Error creating location:', err);
        }
    }
</script>
@endpush
