<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Iniciar Sesión — Estudio Cóice</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Newsreader:ital,opsz,wght@0,6..72,400;0,6..72,500;1,6..72,400&family=Plus+Jakarta+Sans:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Ambient floating animations */
        @keyframes subtle-float-1 {
            0%, 100% { transform: translateY(0px) rotate(-0.5deg); }
            50% { transform: translateY(-7px) rotate(0.2deg); }
        }
        @keyframes subtle-float-2 {
            0%, 100% { transform: translateY(0px) rotate(0.6deg); }
            50% { transform: translateY(-9px) rotate(-0.4deg); }
        }
        @keyframes subtle-float-3 {
            0%, 100% { transform: translateY(0px) rotate(-0.2deg); }
            50% { transform: translateY(-6px) rotate(0.5deg); }
        }

        .animate-float-1 { animation: subtle-float-1 7s ease-in-out infinite; }
        .animate-float-2 { animation: subtle-float-2 8.5s ease-in-out infinite 1s; }
        .animate-float-3 { animation: subtle-float-3 6.8s ease-in-out infinite 0.5s; }

        .is-dragging {
            animation: none !important;
            cursor: grabbing !important;
            opacity: 0.96;
            box-shadow: 0 25px 50px -12px rgba(79, 70, 229, 0.25), 0 0 0 2px #4F46E5 !important;
            transition: none !important;
        }

        .draggable-card {
            touch-action: none;
            cursor: grab;
            will-change: transform, left, top;
        }
        .draggable-card:active { cursor: grabbing; }

        .canvas-dots-bg {
            background-image: radial-gradient(#CBD5E1 1.25px, transparent 1.25px);
            background-size: 26px 26px;
        }
    </style>
</head>
<body class="min-h-full bg-canvas-bg font-body text-text-primary antialiased flex flex-col justify-between selection:bg-accent-indigo selection:text-white overflow-x-hidden">

    <!-- UNIFIED SPATIAL CANVAS WORKSPACE (Stitch Design) -->
    <main class="w-full flex-1 relative overflow-hidden select-none">
        <div class="relative w-full min-h-[calc(100vh-4rem)] canvas-dots-bg" id="spatial-canvas-viewport">
            
            <!-- Atmospheric Ambient Glow Blobs across the canvas -->
            <div class="absolute -top-24 left-1/4 w-[600px] h-[600px] rounded-full bg-accent-indigo/5 blur-[120px] pointer-events-none"></div>
            <div class="absolute bottom-10 right-10 w-[550px] h-[550px] rounded-full bg-accent-terracotta/8 blur-[130px] pointer-events-none"></div>
            <div class="absolute top-1/2 left-10 w-[400px] h-[400px] rounded-full bg-accent-sage/6 blur-[100px] pointer-events-none"></div>

            <!-- Decorative Canvas Connecting Line -->
            <svg class="absolute inset-0 w-full h-full pointer-events-none z-0" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="canvasLineGrad" x1="0%" x2="100%" y1="0%" y2="100%">
                        <stop offset="0%" stop-color="#4F46E5" stop-opacity="0.35"></stop>
                        <stop offset="100%" stop-color="#EA580C" stop-opacity="0.35"></stop>
                    </linearGradient>
                </defs>
                <path d="M 500 240 C 640 220, 720 280, 840 210" fill="none" stroke="url(#canvasLineGrad)" stroke-dasharray="5 5" stroke-width="1.75"></path>
                <path d="M 860 380 Q 950 490, 840 580" fill="none" stroke="#CBD5E1" stroke-dasharray="4 4" stroke-width="1.5"></path>
                <circle cx="500" cy="240" fill="#4F46E5" r="4.5"></circle>
                <circle cx="840" cy="210" fill="#EA580C" r="4.5"></circle>
                <circle cx="840" cy="580" fill="#10B981" r="4"></circle>
            </svg>

            <!-- CANVAS WORKSPACE CONTENT (Primary Floating Login Card + Draggable Canvas Cards) -->
            <div class="relative z-10 w-full min-h-screen p-4 sm:p-8 lg:p-12 py-8 sm:py-12 flex flex-col xl:flex-row items-center xl:items-start justify-center xl:justify-between gap-8 max-w-7xl mx-auto">
                
                <!-- PRIMARY FLOATING WORKSPACE LOGIN PANEL (Stitch Design) -->
                <div class="draggable-card w-full max-w-[480px] bg-surface-card/95 backdrop-blur-xl rounded-2xl p-6 sm:p-8 shadow-[0_20px_50px_rgba(27,27,31,0.08),0_1px_3px_rgba(0,0,0,0.05)] border border-border-subtle/80 transition-shadow duration-200" id="login-window-card" style="position: relative; z-index: 25;">
                    
                    <!-- Card Drag Header -->
                    <div class="flex items-center justify-between pb-3 mb-6 border-b border-border-subtle/50">
                        <div class="flex items-center gap-2">
                            <span class="font-headline text-[17px] text-text-primary font-medium tracking-tight">Estudio</span>
                            <span class="text-accent-indigo font-normal tracking-wide">Cóice</span>
                        </div>
                        <div class="flex items-center gap-2 text-text-muted text-[11px] font-label">
                            <span class="material-symbols-outlined text-[14px]">drag_indicator</span>
                            <span>Mover</span>
                            <span class="w-1.5 h-1.5 rounded-full bg-accent-sage"></span>
                        </div>
                    </div>

                    <!-- Welcome Title -->
                    <div class="space-y-1 mb-6">
                        <h1 class="font-headline text-3xl text-text-primary tracking-tight font-normal">Bienvenido de vuelta</h1>
                        <p class="font-body text-xs text-text-secondary leading-relaxed">Tu lienzo infinito de historias, locaciones y personajes.</p>
                    </div>

                    <!-- Error feedback -->
                    @if ($errors->any())
                        <div class="mb-4 p-3 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs font-label">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    @if (session('info'))
                        <div class="mb-4 p-3 rounded-xl bg-blue-50 border border-blue-200 text-blue-700 text-xs font-label">
                            {{ session('info') }}
                        </div>
                    @endif

                    <!-- Quick Demo Credentials Box -->
                    <div class="mb-5 p-3 rounded-xl bg-accent-indigo/5 border border-accent-indigo/20 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-2.5">
                            <span class="material-symbols-outlined text-[18px] text-accent-indigo">key</span>
                            <div class="text-[11px] font-body text-text-secondary leading-tight">
                                <span class="font-semibold text-text-primary block">Credenciales de prueba:</span>
                                <span class="font-mono text-text-muted">autor@estudio.com · password123</span>
                            </div>
                        </div>
                        <button type="button" onclick="fillDemoCredentials()" 
                                class="flex-shrink-0 px-2.5 py-1 rounded-lg bg-accent-indigo hover:bg-accent-indigo-hover text-white text-[11px] font-label font-semibold shadow-xs transition-all active:scale-95 cursor-pointer">
                            Autocompletar
                        </button>
                    </div>

                    <!-- Fast Social Buttons -->
                    <div class="grid grid-cols-2 gap-2 mb-5">
                        <button type="button" onclick="showSocialNotice('Google')" class="flex items-center justify-center gap-2 py-2.5 px-3 rounded-lg bg-surface-card hover:bg-surface-container-low border border-border-subtle/70 transition-colors text-text-primary font-label text-xs font-semibold shadow-sm active:scale-95">
                            <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24">
                                <path d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.66-5.17 3.66-9.17z" fill="#4285F4"></path>
                                <path d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.1-6.72-4.93H1.25v3.15C3.26 21.36 7.34 24 12 24z" fill="#34A853"></path>
                                <path d="M5.28 14.27c-.25-.72-.38-1.49-.38-2.27s.13-1.55.38-2.27V6.58H1.25C.45 8.18 0 9.99 0 12s.45 3.82 1.25 5.42l4.03-3.15z" fill="#FBBC05"></path>
                                <path d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.34 0 3.26 2.64 1.25 6.58l4.03 3.15c.95-2.83 3.6-4.98 6.72-4.98z" fill="#EA4335"></path>
                            </svg>
                            <span>Google</span>
                        </button>
                        <button type="button" onclick="showSocialNotice('Apple')" class="flex items-center justify-center gap-2 py-2.5 px-3 rounded-lg bg-surface-card hover:bg-surface-container-low border border-border-subtle/70 transition-colors text-text-primary font-label text-xs font-semibold shadow-sm active:scale-95">
                            <svg class="w-3.5 h-3.5 fill-current shrink-0" viewBox="0 0 24 24">
                                <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M15.97 6.37c.66-.82 1.11-1.96.99-3.11-1 .04-2.18.67-2.88 1.48-.59.68-1.11 1.79-.97 2.9 1.12.09 2.22-.51 2.86-1.27z"></path>
                            </svg>
                            <span>Apple</span>
                        </button>
                    </div>

                    <!-- Divider -->
                    <div class="relative flex items-center justify-center my-5">
                        <div class="w-full h-px bg-border-subtle/60"></div>
                        <span class="absolute px-2.5 bg-surface-card font-label text-[10px] uppercase tracking-wider text-text-muted">o con tu correo</span>
                    </div>

                    <!-- Real Authentication Form -->
                    <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block font-label text-[11px] uppercase tracking-wider text-text-secondary mb-1" for="email">
                                Correo electrónico
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email', 'autor@estudio.com') }}" required 
                                   class="w-full px-3.5 py-2.5 rounded-lg bg-surface-card text-text-primary placeholder:text-text-muted font-body text-xs transition-all outline-none border border-border-subtle focus:border-accent-indigo focus:ring-1 focus:ring-accent-indigo/20 shadow-sm"
                                   placeholder="autor@estudio.com">
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label class="block font-label text-[11px] uppercase tracking-wider text-text-secondary" for="password">
                                    Contraseña
                                </label>
                                <button type="button" onclick="showForgotNotice()" class="font-label text-[11px] text-text-secondary hover:text-accent-indigo transition-colors">¿Olvidaste?</button>
                            </div>
                            <div class="relative">
                                <input type="password" id="password" name="password" required
                                       class="w-full pl-3.5 pr-10 py-2.5 rounded-lg bg-surface-card text-text-primary placeholder:text-text-muted font-body text-xs transition-all outline-none border border-border-subtle focus:border-accent-indigo focus:ring-1 focus:ring-accent-indigo/20 shadow-sm"
                                       placeholder="••••••••••••">
                                <button type="button" id="toggle-password-btn" aria-label="Alternar visibilidad" 
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-text-muted hover:text-text-primary transition-colors">
                                    <span class="material-symbols-outlined text-[17px]" id="password-icon">visibility</span>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center pt-0.5">
                            <label class="flex items-center gap-2 cursor-pointer select-none">
                                <input type="checkbox" name="remember" checked class="w-3.5 h-3.5 rounded text-accent-indigo focus:ring-0 bg-surface-container border border-border-subtle cursor-pointer">
                                <span class="font-body text-xs text-text-secondary">Mantener sesión iniciada</span>
                            </label>
                        </div>

                        <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-lg bg-accent-indigo hover:bg-accent-indigo-hover text-white font-label text-xs font-semibold tracking-wide shadow-md shadow-accent-indigo/20 transition-all duration-150 active:scale-[0.99]">
                            <span>Entrar a Estudio Cóice</span>
                            <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                        </button>
                    </form>

                    <!-- Link to Register -->
                    <div class="mt-5 text-center font-body text-xs text-text-secondary">
                        ¿Nuevo en Estudio Cóice? 
                        <a href="{{ route('register') }}" class="text-accent-indigo hover:underline ml-1 font-semibold">Crea tu cuenta</a>
                    </div>

                    <!-- Bottom Status Bar -->
                    <div class="pt-4 mt-5 border-t border-border-subtle/50 flex items-center justify-between text-text-muted text-[11px] font-label">
                        <span class="flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-accent-sage"></span>
                            Todos los sistemas normales
                        </span>
                        <span class="font-mono">v4.2</span>
                    </div>
                </div>

                <!-- RIGHT CANVAS CLUSTER: Draggable Milanote Cards (Stitch Canvas Elements) -->
                <div class="relative w-full xl:w-[600px] min-h-[580px] flex flex-col justify-start gap-5 pointer-events-auto">
                    
                    <!-- NODE CARD 1: Character Dossier Card -->
                    <div class="draggable-card animate-float-1 w-full sm:w-[350px] bg-surface-card rounded-xl p-4 shadow-xl hover:shadow-2xl border border-border-subtle/80 transition-shadow duration-200" id="card-kaelen" style="position: relative; z-index: 15;">
                        <div class="flex items-center justify-between pb-2 mb-3 border-b border-border-subtle/40">
                            <span class="font-mono text-[10px] tracking-wider text-text-muted uppercase">Personaje · Nodo 01</span>
                            <div class="flex items-center gap-1 text-text-muted">
                                <span class="material-symbols-outlined text-[14px]">drag_indicator</span>
                            </div>
                        </div>
                        <div class="flex gap-3 items-center mb-3">
                            <img class="w-12 h-12 rounded-lg object-cover shrink-0 pointer-events-none border border-border-subtle/50" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC6PvFlsSOjCcrnZSSn06F_6n4j_AhkHGqblSxwfb9tzrgwGltYWPu6fNeAIDVa_Vh86-zOGwJLS8F6I35-ZH6rPCO2iTA5DcLZzIsnT3LkBXA-WFDviLQM3yT3294SDbjGpRiFr0WLmO29_FDb8S8pGT88YZ0GRydc2HJF5DyRtGOsq_JejBliAbGa5QZYA3aSP8ODUUZwUJ0cd5vd12YpAq-EPjE8mex1as4EMDud11C_QJeR9gNtZQ" alt="Kaelen Vance">
                            <div class="min-w-0">
                                <h2 class="font-headline text-[16px] text-text-primary truncate font-medium">Kaelen Vance</h2>
                                <p class="font-body text-[12px] text-text-secondary truncate">División Costera</p>
                            </div>
                        </div>
                        <p class="font-body text-[12px] text-text-secondary italic bg-surface-container-low/60 p-2.5 rounded-lg border border-border-subtle/40 leading-relaxed">
                            “No busca al culpable por justicia, sino para cerrar una promesa.”
                        </p>
                    </div>

                    <!-- NODE CARD 2: Interactive Location Pin Node -->
                    <div class="draggable-card animate-float-2 w-full sm:w-[320px] self-end -mt-4 bg-surface-card rounded-xl p-4 shadow-xl hover:shadow-2xl border border-border-subtle/80 transition-shadow duration-200" id="card-location" style="position: relative; z-index: 18;">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-mono text-[10px] tracking-wider text-text-muted uppercase">Locación · Nodo 04</span>
                            <span class="material-symbols-outlined text-text-muted text-[14px]">drag_indicator</span>
                        </div>
                        <div class="flex items-center gap-2.5 my-1">
                            <div class="w-8 h-8 rounded-lg bg-surface-container flex items-center justify-center shrink-0 text-text-secondary">
                                <span class="material-symbols-outlined text-[17px]">near_me</span>
                            </div>
                            <div>
                                <h3 class="font-headline text-[15px] text-text-primary leading-tight font-medium">Almacén 17</h3>
                                <p class="font-body text-[12px] text-text-secondary">Sector Sumergido</p>
                            </div>
                        </div>
                        <div class="mt-2 pt-2 border-t border-border-subtle/40 flex items-center justify-between text-text-muted text-[11px] font-label">
                            <span>4 conexiones</span>
                            <span class="text-accent-indigo hover:underline cursor-pointer flex items-center gap-0.5">Abrir mapa</span>
                        </div>
                    </div>

                    <!-- NODE CARD 3: Floating Micro Audio Atmosphere Card -->
                    <div class="draggable-card animate-float-3 w-full sm:w-[340px] -mt-2 bg-surface-card/95 backdrop-blur-md rounded-xl p-4 shadow-xl hover:shadow-2xl border border-border-subtle/80 transition-shadow duration-200" id="card-audio" style="position: relative; z-index: 20;">
                        <div class="flex items-center justify-between mb-2">
                            <span class="font-mono text-[10px] tracking-wider text-text-muted uppercase">Audio · Paisaje Sonoro</span>
                            <span class="font-mono text-[11px] text-text-muted">02:44</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <button type="button" id="audio-play-btn" class="w-8 h-8 rounded-full bg-text-primary flex items-center justify-center text-white shrink-0 transition-transform active:scale-95 shadow-sm">
                                <span class="material-symbols-outlined text-[16px]" id="audio-play-icon">play_arrow</span>
                            </button>
                            <div class="flex-1 min-w-0">
                                <p class="font-body text-[13px] text-text-primary truncate font-medium">Lluvia de Medianoche</p>
                                <div class="flex items-end gap-1 h-3.5 mt-1" id="waveform-bars">
                                    <div class="w-1 bg-text-muted/40 rounded-full h-1.5"></div>
                                    <div class="w-1 bg-text-muted/60 rounded-full h-2.5"></div>
                                    <div class="w-1 bg-accent-indigo rounded-full h-3.5"></div>
                                    <div class="w-1 bg-accent-indigo/70 rounded-full h-2"></div>
                                    <div class="w-1 bg-text-muted/50 rounded-full h-2"></div>
                                    <div class="w-1 bg-accent-indigo rounded-full h-3.5"></div>
                                    <div class="w-1 bg-text-muted/60 rounded-full h-2"></div>
                                    <div class="w-1 bg-text-muted/40 rounded-full h-1.5"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- NODE CARD 4: Editorial Quote Worldbuilding Note Card -->
                    <div class="draggable-card animate-float-1 w-full sm:w-[440px] bg-surface-card/90 backdrop-blur-md rounded-xl p-4 shadow-lg hover:shadow-2xl border border-border-subtle/80 transition-shadow duration-200 -mt-2" id="card-quote" style="position: relative; z-index: 16;">
                        <div class="flex items-center justify-between pb-1 text-text-muted mb-1">
                            <span class="font-mono text-[10px] tracking-wider uppercase text-text-muted">Nota de Manifiesto</span>
                            <span class="material-symbols-outlined text-[14px]">drag_indicator</span>
                        </div>
                        <blockquote class="font-headline text-[17px] italic text-text-primary tracking-tight leading-snug my-2">
                            “El desorden creativo necesita un lienzo con alma.”
                        </blockquote>
                        <div class="flex items-center justify-between text-text-muted text-[11px] pt-2 border-t border-border-subtle/40 font-label">
                            <span>Estudio Cóice</span>
                            <span>Borrador</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <!-- Global Footer -->
    <footer class="w-full bg-surface-card/80 backdrop-blur-sm py-4 border-t border-border-subtle/50 relative z-30">
        <div class="w-full px-6 sm:px-8 flex flex-col sm:flex-row items-center justify-between gap-2 text-text-muted font-body text-xs">
            <span>© Estudio Cóice. The Spatial Canvas for Worldbuilders.</span>
            <div class="flex items-center gap-6">
                <a href="#" class="hover:text-text-primary transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-text-primary transition-colors">Terms of Service</a>
                <a href="#" class="hover:text-text-primary transition-colors">System Status</a>
            </div>
        </div>
    </footer>

    <!-- Interactive Drag and Drop Scripts -->
    <script>
        // Password reveal toggle
        (function initPasswordToggle() {
            const toggleBtn = document.getElementById('toggle-password-btn');
            const pwdInput = document.getElementById('password');
            const icon = document.getElementById('password-icon');

            if (toggleBtn && pwdInput && icon) {
                toggleBtn.addEventListener('click', () => {
                    const isPassword = pwdInput.type === 'password';
                    pwdInput.type = isPassword ? 'text' : 'password';
                    icon.textContent = isPassword ? 'visibility_off' : 'visibility';
                });
            }
        })();

        // Audio preview button
        (function initAudioToggle() {
            const playBtn = document.getElementById('audio-play-btn');
            const playIcon = document.getElementById('audio-play-icon');
            let isPlaying = false;

            if (playBtn && playIcon) {
                playBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    isPlaying = !isPlaying;
                    playIcon.textContent = isPlaying ? 'pause' : 'play_arrow';
                    playBtn.classList.toggle('bg-accent-terracotta', isPlaying);
                    playBtn.classList.toggle('bg-text-primary', !isPlaying);
                });
            }
        })();

        // Spatial Canvas Drag & Drop for all cards
        (function initSpatialCanvasDrag() {
            const draggableCards = document.querySelectorAll('.draggable-card');
            let topZIndex = 50;

            draggableCards.forEach((card) => {
                let isDragging = false;
                let startX = 0, startY = 0;
                let initialLeft = 0, initialTop = 0;

                card.addEventListener('pointerdown', (e) => {
                    const target = e.target;
                    if (
                        target.tagName === 'INPUT' ||
                        target.tagName === 'BUTTON' ||
                        target.tagName === 'A' ||
                        target.tagName === 'LABEL' ||
                        target.closest('button') ||
                        target.closest('input') ||
                        target.closest('a') ||
                        target.closest('label') ||
                        target.closest('form')
                    ) {
                        return;
                    }

                    isDragging = true;
                    topZIndex++;
                    card.style.zIndex = topZIndex;
                    card.classList.add('is-dragging');

                    startX = e.clientX;
                    startY = e.clientY;

                    initialLeft = parseFloat(card.style.left) || 0;
                    initialTop = parseFloat(card.style.top) || 0;

                    card.setPointerCapture(e.pointerId);
                    e.preventDefault();
                });

                card.addEventListener('pointermove', (e) => {
                    if (!isDragging) return;
                    const deltaX = e.clientX - startX;
                    const deltaY = e.clientY - startY;

                    card.style.left = (initialLeft + deltaX) + 'px';
                    card.style.top = (initialTop + deltaY) + 'px';
                });

                const stopDragging = (e) => {
                    if (!isDragging) return;
                    isDragging = false;
                    card.classList.remove('is-dragging');
                    try {
                        card.releasePointerCapture(e.pointerId);
                    } catch (err) {}
                };

                card.addEventListener('pointerup', stopDragging);
                card.addEventListener('pointercancel', stopDragging);
            });
        })();
    </script>

    <!-- Toast Notification Container -->
    <div id="toast-container" class="fixed top-6 right-6 z-50 flex flex-col gap-2 pointer-events-none"></div>

    <script>
        // Interactive Toast Notifications
        function showToast(message, type = 'info') {
            const container = document.getElementById('toast-container');
            if (!container) return;
            const toast = document.createElement('div');
            const bgClass = type === 'error' ? 'bg-red-600 text-white' : (type === 'success' ? 'bg-emerald-600 text-white' : 'bg-surface-card/95 text-text-primary border border-border-subtle shadow-xl');
            toast.className = `${bgClass} px-4 py-3 rounded-xl font-label text-xs flex items-center gap-2.5 transform translate-y-2 opacity-0 transition-all duration-300 pointer-events-auto max-w-sm`;
            const icon = type === 'error' ? 'error' : (type === 'success' ? 'check_circle' : 'info');
            toast.innerHTML = `<span class="material-symbols-outlined text-[18px] text-accent-indigo shrink-0">${icon}</span><span>${message}</span>`;
            container.appendChild(toast);
            requestAnimationFrame(() => {
                toast.classList.remove('translate-y-2', 'opacity-0');
            });
            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => toast.remove(), 300);
            }, 3500);
        }

        function fillDemoCredentials() {
            const emailInput = document.getElementById('email');
            const passInput = document.getElementById('password');
            if (emailInput && passInput) {
                emailInput.value = 'autor@estudio.com';
                passInput.value = 'password123';
                showToast('Credenciales autocompletadas: autor@estudio.com', 'info');
            }
        }

        function showSocialNotice(provider) {
            showToast(`El acceso con ${provider} se habilitará próximamente. Puedes ingresar directamente con tu correo electrónico registrado.`, 'info');
        }

        function showForgotNotice() {
            showToast('Para restablecer tu contraseña, introduce tu correo de autor o contacta a soporte técnico en Estudio Cóice.', 'info');
        }
    </script>
</body>
</html>
