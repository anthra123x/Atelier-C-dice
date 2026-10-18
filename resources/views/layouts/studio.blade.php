<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Estudio Cóice - Creative Canvas')</title>

    <!-- Google Fonts: Newsreader (headlines), Inter (body), Plus Jakarta Sans (labels) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Newsreader:ital,opsz,wght@0,6..72,400;0,6..72,500;1,6..72,400&family=Plus+Jakarta+Sans:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-canvas-bg font-body text-text-primary antialiased min-h-full flex flex-col selection:bg-accent-indigo selection:text-white">

    <!-- Top Navigation Header -->
    <header class="fixed top-0 left-0 right-0 z-40 bg-surface-card/90 backdrop-blur-xl border-b border-border-subtle shadow-[0_1px_8px_rgba(0,0,0,0.03)]">
        <div class="h-16 w-full px-6 flex items-center justify-between gap-4">
            <!-- Brand & Breadcrumbs -->
            <div class="flex items-center gap-3 flex-shrink-0">
                <a href="{{ route('studio.canvas') }}" class="flex items-center gap-2 group">
                    <div class="w-8 h-8 rounded-lg bg-accent-indigo text-white flex items-center justify-center font-headline font-bold text-lg shadow-sm group-hover:scale-105 transition-transform">
                        C
                    </div>
                    <span class="font-label font-bold text-text-primary tracking-tight text-base">Estudio <span class="text-accent-indigo font-normal">Cóice</span></span>
                </a>
                <span class="text-border-strong select-none">/</span>
                <div class="flex items-center gap-1.5 text-text-secondary font-label text-xs bg-surface-container-low px-2.5 py-1 rounded-lg border border-border-subtle">
                    <span class="hover:text-text-primary font-medium cursor-pointer transition-colors">{{ $universe->title ?? 'Crónicas de Neo-Kyoto' }}</span>
                    <span class="text-border-strong select-none">/</span>
                    <span class="font-semibold text-text-primary">@yield('view_label', 'Tablero Principal')</span>
                </div>
            </div>

            <!-- Central Nav Tabs -->
            <nav class="hidden md:flex items-center gap-1 bg-surface-container-low p-1 rounded-xl border border-border-subtle font-label text-xs">
                <a href="{{ route('studio.canvas') }}" 
                   class="px-4 py-1.5 rounded-lg transition-all {{ ($currentModule ?? '') === 'canvas' ? 'bg-accent-indigo text-white shadow-sm font-semibold' : 'text-text-secondary hover:text-text-primary hover:bg-surface-card' }}">
                    Lienzo Creativo
                </a>
                <a href="{{ route('studio.maps') }}" 
                   class="px-4 py-1.5 rounded-lg transition-all {{ ($currentModule ?? '') === 'maps' ? 'bg-accent-indigo text-white shadow-sm font-semibold' : 'text-text-secondary hover:text-text-primary hover:bg-surface-card' }}">
                    Mapas y Locaciones
                </a>
                <a href="{{ route('studio.characters') }}" 
                   class="px-4 py-1.5 rounded-lg transition-all {{ ($currentModule ?? '') === 'characters' ? 'bg-accent-indigo text-white shadow-sm font-semibold' : 'text-text-secondary hover:text-text-primary hover:bg-surface-card' }}">
                    Fichas de Personajes
                </a>
                <a href="{{ route('studio.library') }}" 
                   class="px-4 py-1.5 rounded-lg transition-all {{ ($currentModule ?? '') === 'library' ? 'bg-accent-indigo text-white shadow-sm font-semibold' : 'text-text-secondary hover:text-text-primary hover:bg-surface-card' }}">
                    Biblioteca &amp; Playlists
                </a>
            </nav>

            <!-- Zoom, Collaborators & Profile -->
            <div class="flex items-center gap-3 flex-shrink-0">
                <!-- Zoom Controls -->
                <div class="hidden sm:flex items-center bg-surface-container-low rounded-lg p-0.5 border border-border-subtle text-text-secondary">
                    <button id="zoom-out-btn" class="w-7 h-7 flex items-center justify-center hover:bg-surface-card hover:text-text-primary rounded transition-colors" title="Reducir zoom">
                        <span class="material-symbols-outlined text-[16px]">remove</span>
                    </button>
                    <span id="zoom-val-text" class="px-2 font-label text-xs text-text-primary select-none font-semibold">100%</span>
                    <button id="zoom-in-btn" class="w-7 h-7 flex items-center justify-center hover:bg-surface-card hover:text-text-primary rounded transition-colors" title="Aumentar zoom">
                        <span class="material-symbols-outlined text-[16px]">add</span>
                    </button>
                </div>

                <!-- Database status badge -->
                <div class="hidden lg:flex items-center gap-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 px-2.5 py-1 rounded-full font-label text-[11px]">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>Postgres Neon Online</span>
                </div>

                <!-- Active Collaborators -->
                <div class="flex items-center -space-x-1.5 pl-1">
                    @forelse($collaborators ?? [] as $collab)
                        <div class="w-7 h-7 rounded-full flex items-center justify-center font-label text-[10px] font-bold text-white ring-2 ring-surface-card shadow-sm cursor-help"
                             style="background-color: {{ $collab->color }};"
                             title="{{ $collab->name }} ({{ $collab->role }})">
                            {{ $collab->initials }}
                        </div>
                    @empty
                        <div class="w-7 h-7 rounded-full bg-accent-terracotta text-white flex items-center justify-center font-label text-[10px] ring-2 ring-surface-card">AU</div>
                        <div class="w-7 h-7 rounded-full bg-accent-sage text-white flex items-center justify-center font-label text-[10px] ring-2 ring-surface-card">RN</div>
                    @endforelse
                </div>

                <!-- User Profile & Auth Actions -->
                @auth
                    <div class="flex items-center gap-2 pl-2 border-l border-border-subtle">
                        <div class="flex items-center gap-2" title="{{ Auth::user()->name }} ({{ Auth::user()->email }})">
                            <div class="w-8 h-8 rounded-full bg-accent-indigo text-white flex items-center justify-center font-label font-bold text-xs shadow-sm">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                            <div class="hidden xl:flex flex-col text-left">
                                <span class="font-label text-xs font-semibold text-text-primary leading-tight truncate max-w-[110px]">{{ Auth::user()->name }}</span>
                                <span class="font-label text-[10px] text-text-muted leading-tight">Creador</span>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="inline m-0">
                            @csrf
                            <button type="submit" class="p-1.5 rounded-lg text-text-secondary hover:text-red-600 hover:bg-red-50 transition-colors flex items-center justify-center" title="Cerrar Sesión">
                                <span class="material-symbols-outlined text-[18px]">logout</span>
                            </button>
                        </form>
                    </div>
                @else
                    <div class="flex items-center gap-2 pl-2 border-l border-border-subtle">
                        <a href="{{ route('login') }}" class="font-label text-xs font-semibold px-3 py-1.5 rounded-lg text-text-secondary hover:text-text-primary hover:bg-surface-container-low transition-colors">
                            Ingresar
                        </a>
                        <a href="{{ route('register') }}" class="font-label text-xs font-semibold px-3 py-1.5 rounded-lg bg-accent-indigo text-white hover:bg-accent-indigo/90 transition-all shadow-sm">
                            Registrarse
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1 pt-16 flex flex-col relative overflow-hidden">
        @yield('content')
    </main>

    <!-- Cóice AI Floating Trigger Button -->
    <div class="fixed bottom-6 right-6 z-40">
        <button id="codice-ai-toggle-btn" onclick="toggleCodiceAi()" 
                class="flex items-center gap-2.5 px-4 py-2.5 rounded-full bg-gradient-to-r from-accent-indigo via-indigo-600 to-purple-600 text-white font-label text-xs font-semibold shadow-[0_8px_25px_rgba(79,70,229,0.35)] hover:shadow-[0_12px_32px_rgba(79,70,229,0.5)] hover:scale-105 active:scale-95 transition-all group">
            <span class="material-symbols-outlined text-[19px] group-hover:rotate-12 transition-transform">psychology</span>
            <span>Cóice AI</span>
            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
        </button>
    </div>

    <!-- Cóice AI Interactive Assistant Drawer -->
    <div id="codice-ai-drawer" class="hidden fixed bottom-6 right-6 z-50 w-[420px] max-w-[calc(100vw-32px)] h-[580px] max-h-[calc(100vh-100px)] bg-surface-card/95 backdrop-blur-2xl border border-border-subtle rounded-3xl shadow-[0_25px_70px_rgba(0,0,0,0.22)] flex-col overflow-hidden transition-all duration-300">
        
        <!-- Drawer Header -->
        <div class="px-5 py-4 bg-gradient-to-r from-surface-card via-surface-container-low to-surface-card border-b border-border-subtle flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-accent-indigo to-purple-600 text-white flex items-center justify-center shadow-md">
                    <span class="material-symbols-outlined text-[20px]">psychology</span>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h4 class="font-label font-bold text-sm text-text-primary">Cóice AI</h4>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-50 text-emerald-600 border border-emerald-200">Online</span>
                    </div>
                    <p class="font-body text-xs text-text-muted">Arquitecto Narrativo &amp; Generador de Nodos</p>
                </div>
            </div>
            <button onclick="toggleCodiceAi()" class="w-8 h-8 rounded-full flex items-center justify-center text-text-muted hover:text-text-primary hover:bg-surface-container-high transition-colors" title="Cerrar Cóice AI">
                <span class="material-symbols-outlined text-[18px]">close</span>
            </button>
        </div>

        <!-- Mode Selector / Quick Tabs -->
        <div class="px-4 py-2 bg-surface-container-low/60 border-b border-border-subtle flex items-center justify-between text-[11px] font-label">
            <div class="flex items-center gap-1">
                <button type="button" id="ai-mode-chat-btn" onclick="setAiMode('chat')" class="px-2.5 py-1 rounded-md bg-surface-card font-semibold text-accent-indigo border border-border-subtle shadow-xs">
                    Conversación
                </button>
                <button type="button" id="ai-mode-node-btn" onclick="setAiMode('node')" class="px-2.5 py-1 rounded-md text-text-muted hover:text-text-primary transition-colors">
                    Generar al Lienzo
                </button>
            </div>
            <span class="text-text-muted text-[10px]">OpenRouter LFM</span>
        </div>

        <!-- Chat / Ideas Messages Feed -->
        <div id="ai-chat-messages" class="flex-1 p-4 overflow-y-auto space-y-3 font-body text-xs">
            <!-- Initial Welcome Message from Cóice AI -->
            <div class="flex gap-2.5 items-start">
                <div class="w-6 h-6 rounded-lg bg-accent-indigo/10 text-accent-indigo flex-shrink-0 flex items-center justify-center font-bold text-[11px] mt-0.5">
                    AI
                </div>
                <div class="bg-surface-container-low border border-border-subtle rounded-2xl rounded-tl-sm px-3.5 py-2.5 text-text-secondary leading-relaxed max-w-[85%] shadow-xs">
                    <p class="font-semibold text-text-primary mb-1">¡Saludos, Creador!</p>
                    <p>Soy el Arquitecto Narrativo de Cóice. Puedo forjar personajes rivales, describir sectores clandestinos de Neo-Kyoto o redactar notas de campo e insertarlas directamente en tu lienzo interactivo.</p>
                </div>
            </div>

            <!-- Quick Inspiration Chips -->
            <div id="ai-prompt-chips" class="pt-2 flex flex-wrap gap-1.5">
                <button onclick="useAiChip('Crea un rival clandestino para Kaelen Cross con implantes neurales de grado militar', 'character')" 
                        class="text-[11px] font-label px-2.5 py-1 rounded-full bg-surface-card hover:bg-accent-indigo hover:text-white border border-border-subtle text-text-secondary transition-all">
                    ⚡ Rival para Kaelen
                </button>
                <button onclick="useAiChip('Diseña un mercado subterráneo de datos en el Sector 04', 'location')" 
                        class="text-[11px] font-label px-2.5 py-1 rounded-full bg-surface-card hover:bg-accent-indigo hover:text-white border border-border-subtle text-text-secondary transition-all">
                    🏛️ Mercado clandestino
                </button>
                <button onclick="useAiChip('Redacta un registro de bitácora sobre una señal misteriosa detectada en el río', 'note')" 
                        class="text-[11px] font-label px-2.5 py-1 rounded-full bg-surface-card hover:bg-accent-indigo hover:text-white border border-border-subtle text-text-secondary transition-all">
                    📜 Señal anómala
                </button>
            </div>
        </div>

        <!-- Interactive Input Bar -->
        <div class="p-3 bg-surface-card border-t border-border-subtle">
            <form id="ai-chat-form" onsubmit="handleAiSubmit(event)" class="flex flex-col gap-2">
                <!-- Node Type Options (Visible in 'node' mode) -->
                <div id="ai-node-type-selector" class="hidden flex items-center gap-2 text-[11px] font-label text-text-muted">
                    <span>Crear tipo:</span>
                    <label class="flex items-center gap-1 cursor-pointer">
                        <input type="radio" name="node_type" value="character" class="text-accent-indigo" checked>
                        <span>Personaje</span>
                    </label>
                    <label class="flex items-center gap-1 cursor-pointer">
                        <input type="radio" name="node_type" value="location" class="text-accent-indigo">
                        <span>Locación</span>
                    </label>
                    <label class="flex items-center gap-1 cursor-pointer">
                        <input type="radio" name="node_type" value="note" class="text-accent-indigo">
                        <span>Nota</span>
                    </label>
                </div>

                <div class="flex items-center gap-2">
                    <input type="text" id="ai-prompt-input" 
                           placeholder="Pregunta o describe qué elemento crear..." 
                           class="flex-1 bg-surface-container-low border border-border-subtle rounded-xl px-3.5 py-2 text-xs font-body text-text-primary placeholder:text-text-muted focus:outline-none focus:ring-1 focus:ring-accent-indigo focus:border-accent-indigo transition-all">
                    <button type="submit" id="ai-send-btn" 
                            class="w-9 h-9 rounded-xl bg-accent-indigo text-white flex items-center justify-center hover:bg-accent-indigo/90 active:scale-95 transition-all shadow-sm flex-shrink-0" title="Enviar prompt">
                        <span class="material-symbols-outlined text-[18px]">send</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Global Notification Toast Container -->
    <div id="toast-container" class="fixed bottom-6 right-6 z-50 flex flex-col gap-2 pointer-events-none"></div>

    <script>
        // Global variables
        window.csrfToken = '{{ csrf_token() }}';
        window.currentBoardId = '{{ isset($board) ? $board->id : ($universe->boards->first()->id ?? '') }}';
        let currentAiMode = 'chat';

        // Global Toast Notification Helper
        window.showToast = function(message, type = 'success') {
            const container = document.getElementById('toast-container');
            if (!container) return;
            const toast = document.createElement('div');
            const bgClass = type === 'success' ? 'bg-text-primary text-white' : 'bg-red-600 text-white';
            toast.className = `${bgClass} px-4 py-2.5 rounded-xl shadow-xl font-label text-xs flex items-center gap-2 transform translate-y-2 opacity-0 transition-all duration-300 pointer-events-auto`;
            toast.innerHTML = `<span class="material-symbols-outlined text-[16px]">${type === 'success' ? 'check_circle' : 'error'}</span><span>${message}</span>`;
            container.appendChild(toast);
            requestAnimationFrame(() => {
                toast.classList.remove('translate-y-2', 'opacity-0');
            });
            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        };

        // Cóice AI Toggle Drawer
        function toggleCodiceAi() {
            const drawer = document.getElementById('codice-ai-drawer');
            const toggleBtn = document.getElementById('codice-ai-toggle-btn');
            if (drawer.classList.contains('hidden')) {
                drawer.classList.remove('hidden');
                drawer.classList.add('flex');
                toggleBtn.classList.add('hidden');
                document.getElementById('ai-prompt-input')?.focus();
            } else {
                drawer.classList.add('hidden');
                drawer.classList.remove('flex');
                toggleBtn.classList.remove('hidden');
            }
        }

        // Set AI Mode (chat vs node)
        function setAiMode(mode) {
            currentAiMode = mode;
            const chatBtn = document.getElementById('ai-mode-chat-btn');
            const nodeBtn = document.getElementById('ai-mode-node-btn');
            const selector = document.getElementById('ai-node-type-selector');
            const input = document.getElementById('ai-prompt-input');

            if (mode === 'chat') {
                chatBtn.className = 'px-2.5 py-1 rounded-md bg-surface-card font-semibold text-accent-indigo border border-border-subtle shadow-xs';
                nodeBtn.className = 'px-2.5 py-1 rounded-md text-text-muted hover:text-text-primary transition-colors';
                selector.classList.add('hidden');
                input.placeholder = 'Pregunta sobre la trama, personajes o universo...';
            } else {
                nodeBtn.className = 'px-2.5 py-1 rounded-md bg-surface-card font-semibold text-accent-indigo border border-border-subtle shadow-xs';
                chatBtn.className = 'px-2.5 py-1 rounded-md text-text-muted hover:text-text-primary transition-colors';
                selector.classList.remove('hidden');
                input.placeholder = 'Describe el elemento a generar en el lienzo...';
            }
        }

        // Use inspiration chip
        function useAiChip(prompt, type) {
            setAiMode('node');
            const input = document.getElementById('ai-prompt-input');
            input.value = prompt;
            const radio = document.querySelector(`input[name="node_type"][value="${type}"]`);
            if (radio) radio.checked = true;
            document.getElementById('ai-chat-form').dispatchEvent(new Event('submit'));
        }

        // Append message to chat
        function appendAiMessage(role, text, extraHtml = '') {
            const feed = document.getElementById('ai-chat-messages');
            const chips = document.getElementById('ai-prompt-chips');
            const msgDiv = document.createElement('div');
            
            if (role === 'user') {
                msgDiv.className = 'flex justify-end';
                msgDiv.innerHTML = `
                    <div class="bg-accent-indigo text-white rounded-2xl rounded-tr-sm px-3.5 py-2 max-w-[85%] leading-relaxed shadow-xs">
                        <p>${text.replace(/</g, "&lt;").replace(/>/g, "&gt;")}</p>
                    </div>
                `;
            } else {
                msgDiv.className = 'flex gap-2.5 items-start';
                msgDiv.innerHTML = `
                    <div class="w-6 h-6 rounded-lg bg-accent-indigo/10 text-accent-indigo flex-shrink-0 flex items-center justify-center font-bold text-[11px] mt-0.5">
                        AI
                    </div>
                    <div class="bg-surface-container-low border border-border-subtle rounded-2xl rounded-tl-sm px-3.5 py-2.5 text-text-secondary leading-relaxed max-w-[85%] shadow-xs">
                        <p class="whitespace-pre-line">${text}</p>
                        ${extraHtml}
                    </div>
                `;
            }

            if (chips) {
                feed.insertBefore(msgDiv, chips);
            } else {
                feed.appendChild(msgDiv);
            }
            feed.scrollTop = feed.scrollHeight;
        }

        // Handle AI form submit
        async function handleAiSubmit(e) {
            e.preventDefault();
            const input = document.getElementById('ai-prompt-input');
            const sendBtn = document.getElementById('ai-send-btn');
            const prompt = input.value.trim();
            if (!prompt) return;

            input.value = '';
            input.disabled = true;
            sendBtn.disabled = true;
            sendBtn.innerHTML = '<span class="material-symbols-outlined text-[18px] animate-spin">refresh</span>';

            appendAiMessage('user', prompt);

            try {
                if (currentAiMode === 'node' && window.currentBoardId) {
                    const selectedType = document.querySelector('input[name="node_type"]:checked')?.value || 'note';
                    const res = await fetch(`/api/v1/boards/${window.currentBoardId}/ai/generate`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': window.csrfToken
                        },
                        body: JSON.stringify({
                            prompt: prompt,
                            type: selectedType
                        })
                    });

                    const data = await res.json();
                    if (res.ok && data.status === 'success') {
                        const node = data.data;
                        appendAiMessage('assistant', `✨ He forjado el elemento "${node.title}" y lo he posicionado en tu tablero de lienzo.`, `
                            <div class="mt-2.5 pt-2 border-t border-border-subtle flex items-center gap-2">
                                <a href="{{ route('studio.canvas') }}" class="font-label text-[11px] font-bold text-accent-indigo hover:underline flex items-center gap-1">
                                    <span>Ir al Lienzo</span>
                                    <span class="material-symbols-outlined text-[13px]">arrow_forward</span>
                                </a>
                            </div>
                        `);
                        window.showToast('Nodo generado exitosamente en el lienzo', 'success');
                        // If we are currently on the canvas page, reload after 1s so the node renders
                        if (window.location.pathname.includes('/canvas') || window.location.pathname === '/') {
                            setTimeout(() => location.reload(), 1200);
                        }
                    } else {
                        appendAiMessage('assistant', 'Hubo un inconveniente al generar el nodo en el tablero. Por favor intenta de nuevo.');
                    }
                } else {
                    // Chat mode
                    const res = await fetch('/api/v1/ai/chat', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': window.csrfToken
                        },
                        body: JSON.stringify({
                            prompt: prompt,
                            context: 'Universo: Crónicas de Neo-Kyoto. Personajes principales: Kaelen Cross (Ex-Covenant), Vex Thorne (Netrunner). Locaciones: Sector 04, Búnker Omega.'
                        })
                    });

                    const data = await res.json();
                    if (res.ok && data.reply) {
                        appendAiMessage('assistant', data.reply);
                    } else {
                        appendAiMessage('assistant', 'No fue posible obtener respuesta del núcleo narrativo.');
                    }
                }
            } catch (err) {
                console.error('Error Cóice AI:', err);
                appendAiMessage('assistant', 'Error de conexión con el agente neuronal. Verifica tu red.');
            } finally {
                input.disabled = false;
                sendBtn.disabled = false;
                sendBtn.innerHTML = '<span class="material-symbols-outlined text-[18px]">send</span>';
                input.focus();
            }
        }
    </script>
    @stack('scripts')
</body>
</html>

