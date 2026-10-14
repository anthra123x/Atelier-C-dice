@extends('layouts.studio')

@section('title', 'Lienzo Creativo - Estudio Códice')
@section('view_label', $board->title . ' · ' . ($board->act ?? 'Acto I'))

@section('content')
<div class="relative w-full h-[calc(100vh-64px)] overflow-hidden flex bg-canvas-bg">

    <!-- Floating Tool Dock (Left Toolbar) -->
    <aside class="fixed left-6 top-24 z-30 w-14 frosted-glass border border-border-subtle rounded-2xl shadow-[0_8px_30px_rgba(0,0,0,0.06)] py-3 flex flex-col items-center gap-1.5 select-none">
        <div class="pb-1 cursor-grab active:cursor-grabbing text-text-muted hover:text-text-secondary" title="Barra de herramientas flotante">
            <span class="material-symbols-outlined text-[18px]">drag_indicator</span>
        </div>
        <div class="w-7 h-[1px] bg-border-strong mb-1"></div>

        <button onclick="openCreateModal('note')" class="w-10 h-10 rounded-xl flex flex-col items-center justify-center text-text-secondary hover:bg-surface-container-high hover:text-text-primary group transition-all relative" title="Nota de texto">
            <span class="material-symbols-outlined text-[20px]">description</span>
            <span class="absolute left-full ml-3 px-2 py-1 rounded-md bg-text-primary text-white text-[11px] font-label whitespace-nowrap opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity shadow-md z-40">Nota rápida</span>
        </button>

        <button onclick="openCreateModal('character')" class="w-10 h-10 rounded-xl flex flex-col items-center justify-center text-text-secondary hover:bg-surface-container-high hover:text-text-primary group transition-all relative" title="Ficha de Personaje">
            <span class="material-symbols-outlined text-[20px]">badge</span>
            <span class="absolute left-full ml-3 px-2 py-1 rounded-md bg-text-primary text-white text-[11px] font-label whitespace-nowrap opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity shadow-md z-40">Personaje</span>
        </button>

        <button onclick="openCreateModal('location')" class="w-10 h-10 rounded-xl flex flex-col items-center justify-center text-text-secondary hover:bg-surface-container-high hover:text-text-primary group transition-all relative" title="Pin de Mapa">
            <span class="material-symbols-outlined text-[20px]">location_on</span>
            <span class="absolute left-full ml-3 px-2 py-1 rounded-md bg-text-primary text-white text-[11px] font-label whitespace-nowrap opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity shadow-md z-40">Locación</span>
        </button>

        <button onclick="openCreateModal('audio')" class="w-10 h-10 rounded-xl flex flex-col items-center justify-center text-text-secondary hover:bg-surface-container-high hover:text-text-primary group transition-all relative" title="Reproductor de Audio">
            <span class="material-symbols-outlined text-[20px]">graphic_eq</span>
            <span class="absolute left-full ml-3 px-2 py-1 rounded-md bg-text-primary text-white text-[11px] font-label whitespace-nowrap opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity shadow-md z-40">Pista Sonoro</span>
        </button>

        <div class="w-7 h-[1px] bg-border-strong my-1"></div>

        <button onclick="openCreateModal('note')" class="w-10 h-10 rounded-xl flex items-center justify-center text-accent-indigo hover:bg-surface-container-high hover:scale-105 active:scale-95 transition-all" title="Agregar elemento">
            <span class="material-symbols-outlined text-[22px]">add_circle</span>
        </button>

        <button onclick="toggleCodiceAi()" class="w-10 h-10 rounded-xl flex items-center justify-center bg-gradient-to-tr from-accent-indigo to-purple-600 text-white hover:scale-105 active:scale-95 shadow-sm transition-all group relative" title="Códice AI">
            <span class="material-symbols-outlined text-[20px]">psychology</span>
            <span class="absolute left-full ml-3 px-2 py-1 rounded-md bg-text-primary text-white text-[11px] font-label whitespace-nowrap opacity-0 group-hover:opacity-100 pointer-events-none transition-opacity shadow-md z-40">Códice AI</span>
        </button>
    </aside>


    <!-- Canvas Pan & Zoom Viewport (Infinite Spatial Canvas) -->
    <div id="canvas-viewport" class="relative w-full h-full overflow-hidden canvas-grid select-none cursor-default">
        
        <!-- Top Board Meta HUD -->
        <div class="max-w-[1440px] mx-auto flex items-center justify-between mb-6 relative z-10 pointer-events-none pl-24 pr-12 pt-6">
            <div class="flex items-center gap-3 pointer-events-auto">
                <div class="flex items-center gap-2 bg-surface-card/90 backdrop-blur-md px-4 py-1.5 rounded-full border border-border-subtle shadow-sm font-label text-xs">
                    <span class="w-2 h-2 rounded-full bg-accent-sage animate-pulse"></span>
                    <span class="uppercase tracking-wider text-text-secondary font-semibold">Tablero Dinámico</span>
                    <span class="text-text-muted">·</span>
                    <span class="font-bold text-text-primary">{{ $board->act ?? 'Acto I: Sombras en el Distrito 4' }}</span>
                </div>
                <div class="hidden md:flex items-center gap-1.5 text-text-muted font-label text-[11px] bg-surface-container-low px-3 py-1 rounded-md border border-border-subtle">
                    <span class="material-symbols-outlined text-[14px]">grid_4x4</span>
                    <span>Ajuste a cuadrícula (24px)</span>
                </div>
            </div>

            <div class="flex items-center gap-2 pointer-events-auto">
                <div class="bg-surface-card px-4 py-1.5 rounded-full border border-border-subtle shadow-sm flex items-center gap-3 font-label text-xs">
                    <span class="text-text-muted uppercase text-[11px]">Nodos:</span>
                    <span id="nodes-count-badge" class="font-bold text-text-primary">{{ count($board->nodes) }} activos</span>
                    <span class="w-1 h-3 bg-border-strong rounded-full"></span>
                    <span class="text-accent-indigo font-medium">Sincronizado Neon DB</span>
                </div>
            </div>
        </div>

        <!-- Floating Navigation Shortcuts Pill -->
        <div class="fixed bottom-6 right-6 z-30 pointer-events-auto flex items-center gap-2 bg-surface-card/95 backdrop-blur-md px-3.5 py-1.5 rounded-full border border-border-subtle shadow-lg text-[11px] font-label text-text-secondary select-none">
            <div class="flex items-center gap-1 text-text-primary font-semibold">
                <kbd class="px-1.5 py-0.5 rounded bg-surface-container-high border border-border-subtle text-[10px]">Ctrl</kbd>
                <span>+</span>
                <span class="material-symbols-outlined text-[14px]">mouse</span>
                <span>Scroll: Zoom</span>
            </div>
            <span class="text-border-strong">·</span>
            <div class="flex items-center gap-1 text-text-primary font-semibold">
                <span class="material-symbols-outlined text-[14px]">pan_tool</span>
                <span>Clic derecho: Mover tablero</span>
            </div>
            <span class="text-border-strong">·</span>
            <button type="button" onclick="resetCanvasView()" class="hover:text-accent-indigo text-text-muted transition-colors flex items-center gap-1" title="Restablecer posición inicial">
                <span class="material-symbols-outlined text-[15px]">center_focus_strong</span>
                <span class="text-[10px]">Centrar</span>
            </button>
        </div>

        <!-- Infinite Positioning Surface -->
        <div id="canvas-surface" class="relative w-[3600px] h-[2400px] origin-top-left will-change-transform pl-24 pr-12 pt-6 pb-24" style="transform: translate(0px, 0px) scale(1);">
            
            <!-- SVG Connectors Layer -->
            <svg id="connections-svg" class="absolute inset-0 w-full h-full pointer-events-none z-10" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="lineGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="#4F46E5" stop-opacity="0.95"></stop>
                        <stop offset="100%" stop-color="#EA580C" stop-opacity="0.95"></stop>
                    </linearGradient>
                    <filter id="glow" x="-20%" y="-20%" width="140%" height="140%">
                        <feDropShadow dx="0" dy="2" stdDeviation="3" flood-color="#4F46E5" flood-opacity="0.3"></feDropShadow>
                    </filter>
                </defs>

                <!-- Render dynamically computed connector paths -->
                <path id="primary-connector-path" d="M 380 300 C 460 300, 520 220, 640 180" 
                      fill="none" filter="url(#glow)" stroke="url(#lineGrad)" stroke-dasharray="6,4" stroke-width="2.5"></path>
                <circle id="origin-point" cx="380" cy="300" r="5" fill="#4F46E5"></circle>
                <circle id="origin-ring" cx="380" cy="300" r="9" fill="none" stroke="#4F46E5" stroke-opacity="0.4" stroke-width="1.5"></circle>
                <circle id="dest-point" cx="640" cy="180" r="4.5" fill="#EA580C"></circle>
            </svg>

            <!-- Connector badge -->
            <div id="connector-badge" class="absolute left-[480px] top-[220px] z-20 pointer-events-auto transform -rotate-6 hover:rotate-0 transition-transform cursor-pointer">
                <div class="bg-surface-card px-3 py-1 rounded-full border border-border-subtle shadow-md flex items-center gap-1.5 text-accent-indigo hover:shadow-lg transition-shadow">
                    <span class="material-symbols-outlined text-[14px] text-accent-terracotta">radar</span>
                    <span class="font-label text-xs font-bold tracking-tight text-text-primary">Investiga aquí</span>
                    <span class="material-symbols-outlined text-[13px] text-text-muted">arrow_forward</span>
                </div>
            </div>

            <!-- Nodes loop -->
            @foreach($board->nodes as $node)
                <div id="node-{{ $node->id }}" 
                     class="canvas-node absolute bg-surface-card rounded-2xl border border-border-subtle shadow-[0_4px_16px_rgba(15,23,42,0.06)] hover:shadow-[0_12px_28px_rgba(15,23,42,0.12)] transition-shadow duration-200 z-20 group"
                     style="left: {{ $node->pos_x }}px; top: {{ $node->pos_y }}px; width: {{ $node->width }}px;"
                     data-id="{{ $node->id }}"
                     data-x="{{ $node->pos_x }}"
                     data-y="{{ $node->pos_y }}">

                    <!-- Drag Handle Header -->
                    <div class="node-drag-handle flex items-center justify-between px-4 pt-3.5 pb-2 cursor-grab active:cursor-grabbing border-b border-border-subtle/50">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-text-muted text-[18px]">drag_indicator</span>
                            <span class="font-label text-[11px] uppercase tracking-wider font-semibold text-text-secondary">
                                {{ $node->data['category'] ?? ucfirst($node->type) }}
                            </span>
                        </div>
                        <div class="flex items-center gap-1 opacity-40 group-hover:opacity-100 transition-opacity">
                            <button onclick="togglePin({{ $node->id }})" class="w-6 h-6 rounded hover:bg-surface-container-high flex items-center justify-center text-text-secondary" title="Fijar">
                                <span class="material-symbols-outlined text-[15px]">{{ $node->is_pinned ? 'push_pin' : 'keep' }}</span>
                            </button>
                            <button onclick="deleteNode({{ $node->id }})" class="w-6 h-6 rounded hover:bg-red-50 hover:text-red-600 flex items-center justify-center text-text-secondary" title="Eliminar nodo">
                                <span class="material-symbols-outlined text-[15px]">delete</span>
                            </button>
                        </div>
                    </div>

                    <!-- Card Body based on node type -->
                    <div class="p-4 space-y-3">
                        @if($node->type === 'character')
                            <!-- Character Card Type -->
                            @if(!empty($node->data['image']))
                                <div class="relative rounded-xl overflow-hidden shadow-sm aspect-video bg-surface-container">
                                    <img src="{{ $node->data['image'] }}" class="w-full h-full object-cover object-top hover:scale-105 transition-transform duration-500" alt="Character Portrait">
                                    <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-text-primary/90 via-text-primary/40 to-transparent p-3 pt-6 flex items-end justify-between">
                                        <div>
                                            <span class="font-label text-[10px] text-emerald-300 font-bold tracking-widest uppercase">{{ $node->data['id_badge'] ?? 'ID: CLASSIFIED' }}</span>
                                            <p class="font-headline text-lg text-white font-medium leading-tight">{{ $node->data['name'] ?? $node->title }}</p>
                                        </div>
                                        <span class="material-symbols-outlined text-white text-[18px] bg-accent-indigo/70 backdrop-blur-sm p-1 rounded-full">fingerprint</span>
                                    </div>
                                </div>
                            @endif

                            @if(!empty($node->data['quote']))
                                <blockquote class="bg-surface-container-low p-3 rounded-xl font-headline italic text-xs text-text-secondary border-l-2 border-accent-terracotta">
                                    “{{ $node->data['quote'] }}”
                                </blockquote>
                            @endif

                            @if(!empty($node->data['traits']))
                                <div class="flex flex-wrap gap-1.5 pt-1">
                                    @foreach($node->data['traits'] as $trait)
                                        <span class="px-2 py-0.5 rounded-full bg-surface-container-high text-text-primary font-label text-[10px] font-medium border border-border-subtle">{{ $trait }}</span>
                                    @endforeach
                                </div>
                            @endif

                            @if(!empty($node->data['palette']))
                                <div class="flex items-center justify-between pt-1">
                                    <span class="font-label text-[10px] text-text-muted uppercase">Paleta cromática</span>
                                    <div class="flex items-center -space-x-1">
                                        @foreach($node->data['palette'] as $hex)
                                            <div class="w-4 h-4 rounded-full shadow-sm ring-1 ring-white" style="background-color: {{ $hex }};" title="{{ $hex }}"></div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                        @elseif($node->type === 'location')
                            <!-- Location Card Type -->
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 rounded-xl bg-orange-50 text-accent-terracotta flex items-center justify-center flex-shrink-0 border border-orange-200">
                                    <span class="material-symbols-outlined text-[20px]">warehouse</span>
                                </div>
                                <div>
                                    <span class="px-2 py-0.5 rounded-full bg-orange-100 text-accent-terracotta font-label text-[10px] font-bold">{{ $node->data['threat'] ?? 'Nivel 4' }}</span>
                                    <h3 class="font-headline text-base text-text-primary font-bold mt-1 leading-snug">{{ $node->data['name'] ?? $node->title }}</h3>
                                    <p class="font-label text-xs text-text-muted">{{ $node->data['sector'] ?? 'Sector 04' }}</p>
                                </div>
                            </div>
                            <p class="font-body text-xs text-text-secondary leading-relaxed bg-surface-container-low p-2.5 rounded-lg border border-border-subtle">
                                {{ $node->data['intel'] ?? 'Sin inteligencia disponible.' }}
                            </p>

                        @elseif($node->type === 'audio')
                            <!-- Audio Widget Card -->
                            <div class="flex items-center justify-between p-2 rounded-xl bg-surface-container-low border border-border-subtle">
                                <div class="flex items-center gap-2.5">
                                    <button class="w-8 h-8 rounded-full bg-accent-indigo text-white flex items-center justify-center hover:scale-105 active:scale-95 transition-transform shadow-sm">
                                        <span class="material-symbols-outlined text-[18px]">play_arrow</span>
                                    </button>
                                    <div class="flex flex-col">
                                        <span class="font-label text-xs text-text-primary font-bold leading-tight truncate max-w-[190px]">{{ $node->data['track'] ?? 'Noir Rain' }}</span>
                                        <span class="font-body text-[10px] text-text-secondary leading-none">{{ $node->data['duration'] ?? '03:45' }} • Ambient Loop</span>
                                    </div>
                                </div>
                                <div class="flex items-end gap-0.5 h-4 pr-1">
                                    <div class="w-1 h-2 bg-accent-indigo rounded-full"></div>
                                    <div class="w-1 h-3.5 bg-accent-indigo rounded-full"></div>
                                    <div class="w-1 h-1.5 bg-accent-indigo rounded-full"></div>
                                    <div class="w-1 h-4 bg-accent-indigo rounded-full"></div>
                                    <div class="w-1 h-2.5 bg-accent-indigo rounded-full"></div>
                                </div>
                            </div>

                        @else
                            <!-- Note / General Content Card -->
                            <h3 class="font-headline text-base text-text-primary font-bold">{{ $node->title }}</h3>
                            <p class="font-body text-xs text-text-secondary leading-relaxed">
                                {{ $node->data['body'] ?? $node->data['content'] ?? 'Nota sin contenido adicional.' }}
                            </p>
                            @if(!empty($node->data['tags']))
                                <div class="flex flex-wrap gap-1 pt-1">
                                    @foreach($node->data['tags'] as $tag)
                                        <span class="px-2 py-0.5 rounded-md bg-surface-container-high text-text-muted font-label text-[10px]">#{{ $tag }}</span>
                                    @endforeach
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</div>

<!-- Quick Create Node Modal -->
<div id="create-modal" class="fixed inset-0 z-50 bg-text-primary/40 backdrop-blur-sm hidden items-center justify-center p-4">
    <div class="bg-surface-card rounded-2xl border border-border-subtle shadow-2xl w-full max-w-md p-6 animate-in fade-in zoom-in-95 duration-200">
        <div class="flex items-center justify-between pb-3 border-b border-border-subtle">
            <h3 class="font-headline text-lg font-bold text-text-primary" id="modal-title">Agregar Nodo al Lienzo</h3>
            <button onclick="closeCreateModal()" class="w-7 h-7 rounded-lg hover:bg-surface-container-high flex items-center justify-center text-text-muted hover:text-text-primary">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        <form id="create-node-form" onsubmit="handleCreateNode(event)" class="mt-4 space-y-4">
            <div>
                <label class="block font-label text-xs font-semibold text-text-secondary mb-1">Tipo de Elemento</label>
                <select id="new-node-type" class="w-full bg-surface-container-low border border-border-subtle rounded-xl px-3 py-2 font-label text-xs text-text-primary focus:outline-none focus:ring-2 focus:ring-accent-indigo">
                    <option value="note">Nota de Texto</option>
                    <option value="character">Ficha de Personaje</option>
                    <option value="location">Locación de Mapa</option>
                    <option value="audio">Pista de Audio</option>
                </select>
            </div>

            <div>
                <label class="block font-label text-xs font-semibold text-text-secondary mb-1">Título del Nodo</label>
                <input type="text" id="new-node-title" required placeholder="Ej. Pista Forense: Huella Digital"
                       class="w-full bg-surface-container-low border border-border-subtle rounded-xl px-3 py-2 font-body text-xs text-text-primary focus:outline-none focus:ring-2 focus:ring-accent-indigo">
            </div>

            <div>
                <label class="block font-label text-xs font-semibold text-text-secondary mb-1">Contenido / Descripción</label>
                <textarea id="new-node-content" rows="3" placeholder="Detalles de la anotación o lore..."
                          class="w-full bg-surface-container-low border border-border-subtle rounded-xl px-3 py-2 font-body text-xs text-text-primary focus:outline-none focus:ring-2 focus:ring-accent-indigo"></textarea>
            </div>

            <div class="flex items-center justify-end gap-2 pt-2">
                <button type="button" onclick="closeCreateModal()" class="px-4 py-2 rounded-xl text-text-secondary hover:bg-surface-container font-label text-xs">Cancelar</button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-accent-indigo text-white hover:bg-accent-indigo-hover font-label text-xs font-semibold shadow-md">Crear Nodo</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Canvas Interactive Drag, Zoom & Pan Persistence Engine
    let currentScale = 1.0;
    let panX = 0;
    let panY = 0;
    let isRightClickPanning = false;
    let panStartX = 0;
    let panStartY = 0;
    let didRightClickPan = false;

    const boardId = {{ $board->id }};
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const viewport = document.getElementById('canvas-viewport');
    const surface = document.getElementById('canvas-surface');

    function applyTransform() {
        if (surface) {
            surface.style.transform = `translate(${panX}px, ${panY}px) scale(${currentScale})`;
        }
        const text = document.getElementById('zoom-val-text');
        if (text) {
            text.textContent = `${Math.round(currentScale * 100)}%`;
        }
        updateConnector();
    }

    function resetCanvasView() {
        currentScale = 1.0;
        panX = 0;
        panY = 0;
        applyTransform();
        showToast('Vista del tablero centrada al 100%', 'info');
    }

    // Zoom Controls from Top Bar / HUD
    document.getElementById('zoom-in-btn')?.addEventListener('click', () => {
        currentScale = Math.min(currentScale + 0.15, 2.5);
        applyTransform();
    });

    document.getElementById('zoom-out-btn')?.addEventListener('click', () => {
        currentScale = Math.max(currentScale - 0.15, 0.25);
        applyTransform();
    });

    // 1. CTRL + SCROLL TO ZOOM IN / ZOOM OUT (Focal to cursor)
    if (viewport) {
        viewport.addEventListener('wheel', (e) => {
            if (e.ctrlKey || e.metaKey) {
                e.preventDefault();

                const zoomFactor = e.deltaY < 0 ? 1.08 : 0.92;
                const oldScale = currentScale;
                const newScale = Math.min(Math.max(currentScale * zoomFactor, 0.25), 2.5);

                if (newScale !== oldScale) {
                    const rect = viewport.getBoundingClientRect();
                    const mouseX = e.clientX - rect.left;
                    const mouseY = e.clientY - rect.top;

                    panX = mouseX - (mouseX - panX) * (newScale / oldScale);
                    panY = mouseY - (mouseY - panY) * (newScale / oldScale);
                    currentScale = newScale;

                    applyTransform();
                }
            }
        }, { passive: false });

        // 2. RIGHT-CLICK DRAG TO PAN CANVAS VIEWPORT
        viewport.addEventListener('mousedown', (e) => {
            if (e.button === 2) {
                // Ensure click is outside any interactive element, card, or modal
                if (e.target.closest('.canvas-node, aside, button, input, select, textarea, a, #create-modal, .fixed')) {
                    return;
                }

                isRightClickPanning = true;
                didRightClickPan = false;
                panStartX = e.clientX - panX;
                panStartY = e.clientY - panY;
                viewport.style.cursor = 'grabbing';
                e.preventDefault();
            }
        });
    }

    // Suppress context menu when right clicking on canvas
    window.addEventListener('contextmenu', (e) => {
        if (isRightClickPanning || didRightClickPan || e.target.closest('#canvas-viewport')) {
            e.preventDefault();
            didRightClickPan = false;
        }
    });

    // 3. Left-Click Drag and Drop Engine for Canvas Nodes
    let draggedNode = null;
    let dragStartX = 0, dragStartY = 0;
    let nodeStartX = 0, nodeStartY = 0;
    let saveTimeout = null;

    document.querySelectorAll('.canvas-node').forEach(node => {
        const handle = node.querySelector('.node-drag-handle') || node;
        
        handle.addEventListener('mousedown', (e) => {
            if (e.button !== 0) return; // Only primary left-click for nodes
            if (e.target.closest('button, input, select, textarea, a')) return;
            
            draggedNode = node;
            dragStartX = e.clientX;
            dragStartY = e.clientY;
            nodeStartX = parseFloat(node.style.left) || 0;
            nodeStartY = parseFloat(node.style.top) || 0;
            node.classList.add('scale-[1.02]', 'z-30');
            e.preventDefault();
        });
    });

    window.addEventListener('mousemove', (e) => {
        // Handle canvas panning with right click
        if (isRightClickPanning) {
            const newPanX = e.clientX - panStartX;
            const newPanY = e.clientY - panStartY;
            if (Math.abs(newPanX - panX) > 2 || Math.abs(newPanY - panY) > 2) {
                didRightClickPan = true;
            }
            panX = newPanX;
            panY = newPanY;
            applyTransform();
            return;
        }

        // Handle card movement
        if (!draggedNode) return;
        const dx = (e.clientX - dragStartX) / currentScale;
        const dy = (e.clientY - dragStartY) / currentScale;
        
        // Snap to 24px grid
        const rawX = Math.max(0, nodeStartX + dx);
        const rawY = Math.max(0, nodeStartY + dy);
        const snappedX = Math.round(rawX / 24) * 24;
        const snappedY = Math.round(rawY / 24) * 24;

        draggedNode.style.left = `${snappedX}px`;
        draggedNode.style.top = `${snappedY}px`;
        draggedNode.dataset.x = snappedX;
        draggedNode.dataset.y = snappedY;

        updateConnector();
    });

    window.addEventListener('mouseup', (e) => {
        if (e.button === 2 && isRightClickPanning) {
            isRightClickPanning = false;
            if (viewport) viewport.style.cursor = '';
        }

        if (draggedNode) {
            draggedNode.classList.remove('scale-[1.02]', 'z-30');
            const nodeId = draggedNode.dataset.id;
            const finalX = parseFloat(draggedNode.style.left);
            const finalY = parseFloat(draggedNode.style.top);

            // Debounced persistence to Laravel API
            clearTimeout(saveTimeout);
            saveTimeout = setTimeout(() => {
                persistNodePosition(nodeId, finalX, finalY);
            }, 200);

            draggedNode = null;
        }
    });

    // API Call to persist node position
    async function persistNodePosition(id, x, y) {
        try {
            const res = await fetch(`/api/v1/nodes/${id}/position`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ pos_x: x, pos_y: y })
            });
            if (res.ok) {
                showToast('Posición sincronizada en Neon DB', 'success');
            }
        } catch (err) {
            console.error('Error saving position:', err);
        }
    }

    // Dynamic SVG Connector Updating
    function updateConnector() {
        const node1 = document.getElementById('node-1') || document.querySelector('.canvas-node:nth-of-type(1)');
        const node2 = document.getElementById('node-2') || document.querySelector('.canvas-node:nth-of-type(2)');
        const path = document.getElementById('primary-connector-path');
        const badge = document.getElementById('connector-badge');
        const originPoint = document.getElementById('origin-point');
        const originRing = document.getElementById('origin-ring');
        const destPoint = document.getElementById('dest-point');

        if (!node1 || !node2 || !path) return;

        const x1 = (parseFloat(node1.style.left) || 0) + (node1.offsetWidth || 360);
        const y1 = (parseFloat(node1.style.top) || 0) + 180;
        const x2 = (parseFloat(node2.style.left) || 0);
        const y2 = (parseFloat(node2.style.top) || 0) + 120;

        const mx = (x1 + x2) / 2;
        const my = (y1 + y2) / 2;

        const d = `M ${x1} ${y1} C ${mx} ${y1}, ${mx} ${y2}, ${x2} ${y2}`;
        path.setAttribute('d', d);

        if (originPoint) { originPoint.setAttribute('cx', x1); originPoint.setAttribute('cy', y1); }
        if (originRing) { originRing.setAttribute('cx', x1); originRing.setAttribute('cy', y1); }
        if (destPoint) { destPoint.setAttribute('cx', x2); destPoint.setAttribute('cy', y2); }

        if (badge) {
            badge.style.left = `${mx - 40}px`;
            badge.style.top = `${my - 14}px`;
        }
    }

    // Initialize connector path on load
    setTimeout(updateConnector, 100);

    // Modal Handlers
    function openCreateModal(defaultType = 'note') {
        const modal = document.getElementById('create-modal');
        const select = document.getElementById('new-node-type');
        if (select) select.value = defaultType;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeCreateModal() {
        const modal = document.getElementById('create-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    async function handleCreateNode(e) {
        e.preventDefault();
        const type = document.getElementById('new-node-type').value;
        const title = document.getElementById('new-node-title').value;
        const content = document.getElementById('new-node-content').value;

        try {
            const res = await fetch(`/api/v1/boards/${boardId}/nodes`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    type: type,
                    title: title,
                    pos_x: 520,
                    pos_y: 200,
                    width: 340,
                    data: { content: content, category: type.toUpperCase() }
                })
            });

            if (res.ok) {
                closeCreateModal();
                showToast('Nodo creado exitosamente en el lienzo', 'success');
                setTimeout(() => location.reload(), 600);
            }
        } catch (err) {
            console.error('Error creating node:', err);
        }
    }

    async function deleteNode(id) {
        if (!confirm('¿Deseas eliminar este nodo del lienzo?')) return;
        try {
            const res = await fetch(`/api/v1/nodes/${id}`, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            });
            if (res.ok) {
                document.getElementById(`node-${id}`)?.remove();
                showToast('Nodo eliminado', 'success');
                updateConnector();
            }
        } catch (err) {
            console.error('Error deleting node:', err);
        }
    }
</script>
@endpush
