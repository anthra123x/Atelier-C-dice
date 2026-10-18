@extends('layouts.studio')

@section('title', 'Cartografía y Mapas - Estudio Cóice')
@section('view_label', 'Cartografía & Point Marks')

@section('content')
<div class="relative w-full h-[calc(100vh-64px)] overflow-hidden flex bg-canvas-bg">

    <!-- Sector Filter Floating Pill Bar -->
    <div class="absolute top-6 left-8 z-30 flex items-center gap-2 bg-surface-card/90 backdrop-blur-xl px-3 py-1.5 rounded-full border border-border-subtle shadow-md">
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
        <button onclick="openLocationModal()" class="ml-2 w-7 h-7 rounded-full bg-accent-indigo text-white flex items-center justify-center hover:bg-accent-indigo-hover shadow-sm" title="Agregar pin de locación">
            <span class="material-symbols-outlined text-[16px]">add_location_alt</span>
        </button>
    </div>

    <!-- Interactive Cartography Canvas Area -->
    <div id="map-viewport" class="relative flex-1 h-full overflow-auto canvas-grid select-none">
        <div id="map-plane" class="relative w-[1600px] h-[1100px] bg-[#f7f5fa] border-r border-border-subtle">
            
            <!-- Architectural Vector Blueprint Overlay -->
            <svg class="absolute inset-0 w-full h-full pointer-events-none opacity-25" xmlns="http://www.w3.org/2000/svg">
                <circle cx="800" cy="550" r="450" fill="none" stroke="#4F46E5" stroke-dasharray="8 6" stroke-width="1.5"></circle>
                <circle cx="800" cy="550" r="280" fill="none" stroke="#64748B" stroke-dasharray="4 4" stroke-width="1"></circle>
                <line x1="800" y1="50" x2="800" y2="1050" stroke="#CBD5E1" stroke-width="1.5" stroke-dasharray="10 5"></line>
                <line x1="100" y1="550" x2="1500" y2="550" stroke="#CBD5E1" stroke-width="1.5" stroke-dasharray="10 5"></line>
            </svg>

            <!-- Sector Watermark Typography -->
            <div class="absolute top-[80px] left-[180px] pointer-events-none">
                <span class="font-headline text-2xl text-accent-indigo/60 uppercase tracking-widest font-bold block">Sector 01 · Perímetro Militar</span>
                <span class="font-label text-xs text-text-muted uppercase tracking-wider">Antenas de Bloqueo y Drones</span>
            </div>

            <div class="absolute top-[80px] left-[980px] pointer-events-none">
                <span class="font-headline text-2xl text-accent-sage/70 uppercase tracking-widest font-bold block">Sector 02 · Torres de Marfil</span>
                <span class="font-label text-xs text-text-muted uppercase tracking-wider">Cúpula Corporativa y Archivo Central</span>
            </div>

            <div class="absolute top-[360px] left-[260px] pointer-events-none">
                <span class="font-headline text-2xl text-accent-amber/70 uppercase tracking-widest font-bold block">Sector 03 · Mercado Central</span>
                <span class="font-label text-xs text-text-muted uppercase tracking-wider">Bazares, Cantinas y Tráfico Neural</span>
            </div>

            <div class="absolute top-[520px] left-[680px] pointer-events-none">
                <span class="font-headline text-2xl text-accent-terracotta/75 uppercase tracking-widest font-bold block">Sector 04 · Muelle Este</span>
                <span class="font-label text-xs text-text-muted uppercase tracking-wider">Hangares, Dragado y Contrabando</span>
            </div>

            <div class="absolute top-[820px] left-[200px] pointer-events-none">
                <span class="font-headline text-2xl text-text-secondary/50 uppercase tracking-widest font-bold block">Sector 00 · Terreno Inundado</span>
                <span class="font-label text-xs text-text-muted uppercase tracking-wider">Ruinas Antiguas Sumergidas</span>
            </div>

            <!-- Dynamic Location Pins -->
            @foreach($locations as $loc)
                <div class="location-pin absolute -translate-x-1/2 -translate-y-full cursor-pointer group z-20"
                     style="left: {{ $loc->map_x }}px; top: {{ $loc->map_y }}px;"
                     onclick="inspectLocation({{ json_encode($loc) }})"
                     data-id="{{ $loc->id }}">
                    
                    <div class="relative flex flex-col items-center">
                        <!-- Floating Title Tooltip -->
                        <div class="mb-2 px-3 py-1 rounded-md bg-text-primary text-white shadow-xl font-label text-xs flex items-center gap-1.5 whitespace-nowrap opacity-90 group-hover:opacity-100 transition-opacity">
                            <span class="w-2 h-2 rounded-full" style="background-color: {{ $loc->color }};"></span>
                            <span class="font-semibold">{{ $loc->name }}</span>
                            <span class="text-text-muted text-[10px]">{{ $loc->code }}</span>
                        </div>

                        <!-- Outer Pulsing Halo -->
                        <span class="absolute bottom-1 w-10 h-10 rounded-full opacity-40 animate-ping" style="background-color: {{ $loc->color }};"></span>

                        <!-- Pin Marker Head -->
                        <div class="relative w-8 h-8 rounded-full text-white flex items-center justify-center shadow-lg transition-transform group-hover:scale-110"
                             style="background-color: {{ $loc->color }};">
                            <span class="material-symbols-outlined text-[18px]">{{ $loc->icon ?? 'location_on' }}</span>
                        </div>

                        <!-- Pin needle -->
                        <div class="w-1 h-3 -mt-0.5 rounded-b-sm" style="background-color: {{ $loc->color }};"></div>
                        <div class="w-3 h-1 rounded-full blur-[1px] opacity-40" style="background-color: {{ $loc->color }};"></div>
                    </div>
                </div>
            @endforeach

            <!-- Bottom Floating Coordinates & Compass Overlay -->
            <div class="absolute bottom-6 left-8 z-30 flex items-center gap-3 bg-surface-card/90 backdrop-blur-xl px-4 py-2.5 rounded-2xl border border-border-subtle shadow-lg font-label text-xs">
                <div class="flex items-center gap-2 text-text-secondary">
                    <span class="material-symbols-outlined text-[16px] text-accent-indigo">gps_fixed</span>
                    <span class="font-semibold text-text-primary">Neo-Kyoto Datum:</span>
                    <span>35°41'N 139°46'E · Elev: +12m</span>
                </div>
                <span class="w-1 h-3 bg-border-strong rounded-full"></span>
                <div class="flex items-center gap-1.5 text-accent-terracotta font-bold">
                    <span class="material-symbols-outlined text-[16px]">crisis_alert</span>
                    <span>4 Zonas Monitoreadas</span>
                </div>
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
            <!-- Location Image / Satellite Preview -->
            <div id="drawer-image-box" class="rounded-xl overflow-hidden h-44 bg-surface-container shadow-sm border border-border-subtle">
                <img id="drawer-image" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDSlE-30PW7KJ3-LolW8xKS0QEqLTVavb-51_hxIwASekg53HiiD_oow5lpeCjn96h4tjOp7RvLXY4LEHzZrruRkJ3PGO70WcEq8k9zOwFORnydL8M637mr-XrddhXaZHkzwSbDIHcO8XCuq-XgzmbsyNjNIHIulx045DIehd2XGbf68T6daL1Tp5gdTLSPefEEIAEJ2Zuz6voaErGvT8IdUtQt7XayRWpdYlfHIOvzcPMhXJs3Inq4Hw" 
                     class="w-full h-full object-cover" alt="Drone Shot">
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

<!-- Modal Crear Locación -->
<div id="location-modal" class="fixed inset-0 z-50 bg-text-primary/40 backdrop-blur-sm hidden items-center justify-center p-4">
    <div class="bg-surface-card rounded-2xl border border-border-subtle shadow-2xl w-full max-w-md p-6 animate-in fade-in zoom-in-95 duration-200">
        <div class="flex items-center justify-between pb-3 border-b border-border-subtle">
            <h3 class="font-headline text-lg font-bold text-text-primary">Agregar Marcador de Locación</h3>
            <button onclick="closeLocationModal()" class="w-7 h-7 rounded-lg hover:bg-surface-container-high flex items-center justify-center text-text-muted hover:text-text-primary">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        <form onsubmit="handleCreateLocation(event)" class="mt-4 space-y-3.5">
            <div>
                <label class="block font-label text-xs font-semibold text-text-secondary mb-1">Nombre de la Locación</label>
                <input type="text" id="loc-name" required placeholder="Ej. Refugio Subterráneo 09"
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
                    <label class="block font-label text-xs font-semibold text-text-secondary mb-1">Coordenada X</label>
                    <input type="number" id="loc-x" value="500" required
                           class="w-full bg-surface-container-low border border-border-subtle rounded-xl px-3 py-2 font-body text-xs text-text-primary focus:outline-none focus:ring-2 focus:ring-accent-indigo">
                </div>
                <div>
                    <label class="block font-label text-xs font-semibold text-text-secondary mb-1">Coordenada Y</label>
                    <input type="number" id="loc-y" value="400" required
                           class="w-full bg-surface-container-low border border-border-subtle rounded-xl px-3 py-2 font-body text-xs text-text-primary focus:outline-none focus:ring-2 focus:ring-accent-indigo">
                </div>
            </div>

            <div>
                <label class="block font-label text-xs font-semibold text-text-secondary mb-1">Descripción</label>
                <textarea id="loc-desc" rows="2" required placeholder="Propósito de la locación y detalles..."
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
<script>
    const universeId = {{ $universe->id }};
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    function inspectLocation(loc) {
        document.getElementById('drawer-code').textContent = loc.code || '#--';
        document.getElementById('drawer-name').textContent = loc.name;
        document.getElementById('drawer-sector').textContent = loc.sector;
        document.getElementById('drawer-status').textContent = loc.status || 'Activo';
        document.getElementById('drawer-desc').textContent = loc.description || '';
        document.getElementById('drawer-intel').textContent = loc.intel || 'Sin inteligencia clasificada.';
        
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

        showToast(`Locación seleccionada: ${loc.name}`);
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
                    color: '#EA580C'
                })
            });

            if (res.ok) {
                closeLocationModal();
                showToast('Pin de locación registrado con éxito', 'success');
                setTimeout(() => location.reload(), 600);
            }
        } catch (err) {
            console.error('Error creating location:', err);
        }
    }
</script>
@endpush
