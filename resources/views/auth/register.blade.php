<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Registro — Empieza a construir tus universos · Estudio Cóice</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Newsreader:ital,opsz,wght@0,6..72,400;0,6..72,500;1,6..72,400&family=Plus+Jakarta+Sans:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @keyframes float-gentle-1 {
            0%, 100% { transform: translateY(0px) rotate(-0.5deg); }
            50% { transform: translateY(-8px) rotate(0.3deg); }
        }
        @keyframes float-gentle-2 {
            0%, 100% { transform: translateY(0px) rotate(0.4deg); }
            50% { transform: translateY(-10px) rotate(-0.3deg); }
        }
        .float-idle-a { animation: float-gentle-1 8s ease-in-out infinite; }
        .float-idle-b { animation: float-gentle-2 9s ease-in-out infinite 1s; }

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

    <!-- UNIFIED SPATIAL CANVAS WORKSPACE (Stitch Design for Register) -->
    <main class="w-full flex-1 relative overflow-hidden select-none">
        <div class="relative w-full min-h-screen canvas-dots-bg flex flex-col items-center justify-center p-4 sm:p-8 py-8 sm:py-12" id="spatial-canvas-viewport">
            
            <!-- Atmospheric Glow Blobs -->
            <div class="absolute -top-24 right-1/4 w-[600px] h-[600px] rounded-full bg-accent-sage/6 blur-[120px] pointer-events-none"></div>
            <div class="absolute bottom-10 left-10 w-[550px] h-[550px] rounded-full bg-accent-terracotta/8 blur-[130px] pointer-events-none"></div>

            <!-- FLOATING BACKGROUND INSPIRATION CARDS (Stitch Layout) -->
            <!-- Card 1: Fichas de personajes (Top Left) -->
            <div class="draggable-card float-idle-a absolute z-10 hidden xl:block w-72 bg-surface-card/90 backdrop-blur-md rounded-xl p-4 shadow-lg border border-border-subtle/80" style="top: 80px; left: 5%;">
                <div class="flex items-center justify-between pb-1.5 mb-2 border-b border-border-subtle/40">
                    <div class="flex items-center gap-1.5 text-text-muted">
                        <span class="material-symbols-outlined text-[14px]">drag_indicator</span>
                        <span class="font-label text-[10px] uppercase tracking-wider">Arrastra en el lienzo</span>
                    </div>
                </div>
                <div class="flex items-center gap-2.5 my-1">
                    <div class="w-8 h-8 rounded-lg bg-orange-50 text-accent-terracotta flex items-center justify-center font-bold text-xs">
                        <span class="material-symbols-outlined text-[18px]">badge</span>
                    </div>
                    <div>
                        <h4 class="font-headline text-[15px] text-text-primary font-medium">Fichas de personajes</h4>
                        <p class="font-body text-[11px] text-text-secondary">Aurelio · 3 rasgos vinculados</p>
                    </div>
                </div>
            </div>

            <!-- Card 2: Mapas interactivos (Top Right) -->
            <div class="draggable-card float-idle-b absolute z-10 hidden xl:block w-72 bg-surface-card/90 backdrop-blur-md rounded-xl p-4 shadow-lg border border-border-subtle/80" style="top: 80px; right: 5%;">
                <div class="flex items-center justify-between pb-1.5 mb-2 border-b border-border-subtle/40">
                    <div class="flex items-center gap-1.5 text-text-muted">
                        <span class="material-symbols-outlined text-[14px]">drag_indicator</span>
                        <span class="font-label text-[10px] uppercase tracking-wider">Coordenadas</span>
                    </div>
                    <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-accent-sage text-[10px] font-label font-bold">Activo</span>
                </div>
                <div class="flex items-center gap-2.5 my-1">
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-accent-sage flex items-center justify-center font-bold text-xs">
                        <span class="material-symbols-outlined text-[18px]">map</span>
                    </div>
                    <div>
                        <h4 class="font-headline text-[15px] text-text-primary font-medium">Mapas interactivos</h4>
                        <p class="font-body text-[11px] text-text-secondary">Sector 04 · N 34° 08' W</p>
                    </div>
                </div>
            </div>

            <!-- Card 3: Testimonial Card (Bottom Right) -->
            <div class="draggable-card float-idle-b absolute z-20 hidden 2xl:block w-80 bg-surface-card/95 backdrop-blur-md rounded-xl p-4 shadow-xl border border-border-subtle/80" style="bottom: 50px; right: 5%;">
                <div class="flex items-center justify-between pb-2 mb-2 border-b border-border-subtle/40">
                    <span class="font-label text-[10px] uppercase tracking-wider text-text-muted">Opinión de creador</span>
                    <div class="flex items-center gap-0.5 text-amber-500">
                        <span class="material-symbols-outlined text-[14px]">star</span>
                        <span class="material-symbols-outlined text-[14px]">star</span>
                        <span class="material-symbols-outlined text-[14px]">star</span>
                        <span class="material-symbols-outlined text-[14px]">star</span>
                        <span class="material-symbols-outlined text-[14px]">star</span>
                    </div>
                </div>
                <blockquote class="font-headline text-[13px] italic text-text-primary leading-snug mb-3">
                    “Por fin una herramienta que une mis notas caóticas, mis playlists de atmósfera y los mapas de mi saga en un solo lugar.”
                </blockquote>
                <div class="flex items-center gap-2.5 pt-2 border-t border-border-subtle/40">
                    <div class="w-8 h-8 rounded-full overflow-hidden bg-surface-container shrink-0 ring-1 ring-accent-indigo/20">
                        <img class="w-full h-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBTknx1K7aYlIHDgwYe6hPwfp9s62PcGj97V_q4amTnCTN5BcaLtZh5yZ4tzhLSJiHvoNnP9ebnvsic452j7uxmuTnAPLrsGUZWs1bRTfj4jM5VUUe8tYCXWJj7LZmcl_KEWrvxrXIAoX71HLKBqKYTbmLsIiUpD4RHPTNYu7hd0y2NT5jcId7jkFlsEb4jvM8-EG7bHiOgUoLnNOUzvahXLZF_XA4nSXYxOT3TgTBia0H0hPVZVQhRGg" alt="Helena K. Aris">
                    </div>
                    <div>
                        <p class="font-label text-xs font-semibold text-text-primary">Helena K. Aris</p>
                        <p class="font-body text-[10px] text-text-secondary">Autora de <span class="italic">El Eco de los Tres Soles</span></p>
                    </div>
                </div>
            </div>

            <!-- CENTRAL FLOATING SIGN-UP PANEL (Stitch Design - Simplified) -->
            <div class="draggable-card relative z-30 w-full max-w-[480px] my-6 transition-transform duration-200" id="register-window-card">
                <div class="bg-surface-card rounded-2xl shadow-[0_20px_50px_rgba(27,27,31,0.08),0_1px_3px_rgba(0,0,0,0.05)] border border-border-subtle p-6 sm:p-8 relative overflow-hidden backdrop-blur-md">
                    
                    <!-- Card Drag Header -->
                    <div class="flex items-center justify-between pb-3 mb-5 border-b border-border-subtle/50">
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
                    <div class="space-y-1 mb-5">
                        <h1 class="font-headline text-2xl sm:text-3xl text-text-primary tracking-tight font-normal">
                            Empieza a construir tus universos
                        </h1>
                        <p class="font-body text-xs text-text-secondary leading-relaxed">
                            Crea tu cuenta para acceder a tu lienzo creativo.
                        </p>
                    </div>

                    <!-- Error alerts -->
                    @if ($errors->any())
                        <div class="mb-4 p-3 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs font-label">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <!-- Fast Social Buttons -->
                    <div class="grid grid-cols-2 gap-2 mb-4">
                        <button type="button" onclick="showSocialNotice('Google')" class="flex items-center justify-center gap-2 py-2.5 px-3 rounded-lg bg-surface-card hover:bg-surface-container-low border border-border-subtle transition-all text-text-primary font-label text-xs font-semibold shadow-sm active:scale-95">
                            <svg class="w-3.5 h-3.5 shrink-0" viewBox="0 0 24 24">
                                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"></path>
                                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"></path>
                                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" fill="#FBBC05"></path>
                                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" fill="#EA4335"></path>
                            </svg>
                            <span>Google</span>
                        </button>
                        <button type="button" onclick="showSocialNotice('Apple')" class="flex items-center justify-center gap-2 py-2.5 px-3 rounded-lg bg-surface-card hover:bg-surface-container-low border border-border-subtle transition-all text-text-primary font-label text-xs font-semibold shadow-sm active:scale-95">
                            <svg class="w-3.5 h-3.5 text-text-primary fill-current shrink-0" viewBox="0 0 24 24">
                                <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M15.97 6.87c.66-.82 1.11-1.96.99-3.11-1 .04-2.18.67-2.88 1.49-.6.69-1.13 1.83-.99 2.95 1.11.09 2.22-.51 2.88-1.33z"></path>
                            </svg>
                            <span>Apple</span>
                        </button>
                    </div>

                    <!-- Divider -->
                    <div class="relative flex items-center justify-center my-4">
                        <div class="w-full h-px bg-border-subtle"></div>
                        <span class="absolute px-2.5 bg-surface-card font-label text-[10px] uppercase tracking-wider text-text-muted">
                            o con tu correo
                        </span>
                    </div>

                    <!-- Real Registration Form -->
                    <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="creative_role" value="Autor / Diseñador">

                        <div>
                            <label class="block font-label text-[11px] uppercase tracking-wider text-text-secondary mb-1" for="name">
                                Nombre completo o seudónimo
                            </label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                   class="w-full px-3.5 py-2.5 rounded-lg bg-surface-card border border-border-subtle text-text-primary font-body text-xs transition-all focus:border-accent-indigo focus:outline-none focus:ring-1 focus:ring-accent-indigo/20 placeholder:text-text-muted shadow-sm"
                                   placeholder="p. ej. Aurelio Vance">
                        </div>

                        <div>
                            <label class="block font-label text-[11px] uppercase tracking-wider text-text-secondary mb-1" for="email">
                                Correo electrónico
                            </label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                   class="w-full px-3.5 py-2.5 rounded-lg bg-surface-card border border-border-subtle text-text-primary font-body text-xs transition-all focus:border-accent-indigo focus:outline-none focus:ring-1 focus:ring-accent-indigo/20 placeholder:text-text-muted shadow-sm"
                                   placeholder="tu@dominio.com">
                        </div>

                        <div>
                            <label class="block font-label text-[11px] uppercase tracking-wider text-text-secondary mb-1" for="password">
                                Contraseña
                            </label>
                            <div class="relative">
                                <input type="password" id="password" name="password" required minlength="8"
                                       class="w-full pl-3.5 pr-10 py-2.5 rounded-lg bg-surface-card border border-border-subtle text-text-primary font-body text-xs transition-all focus:border-accent-indigo focus:outline-none focus:ring-1 focus:ring-accent-indigo/20 placeholder:text-text-muted shadow-sm"
                                       placeholder="Mínimo 8 caracteres">
                                <button type="button" id="toggle-password-btn" aria-label="Alternar visibilidad" 
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-text-muted hover:text-text-primary transition-colors">
                                    <span class="material-symbols-outlined text-[17px]" id="password-icon">visibility</span>
                                </button>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 pt-1">
                            <input type="checkbox" id="terms" required checked class="w-3.5 h-3.5 rounded text-accent-indigo focus:ring-0 bg-surface-container border border-border-subtle cursor-pointer">
                            <label for="terms" class="font-body text-[11px] text-text-secondary leading-tight cursor-pointer select-none">
                                Acepto los <a href="#" class="underline hover:text-text-primary">Términos</a> y la <a href="#" class="underline hover:text-text-primary">Política de Privacidad</a>.
                            </label>
                        </div>

                        <button type="submit" class="w-full flex items-center justify-center gap-2 py-3 px-4 rounded-lg bg-text-primary hover:bg-black text-white font-label text-xs font-semibold tracking-wide shadow-md transition-all duration-150 active:scale-[0.99] mt-2">
                            <span>Crear mi Estudio Cóice</span>
                            <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                        </button>
                    </form>

                    <!-- Link to login -->
                    <div class="mt-4 text-center font-body text-xs text-text-secondary">
                        ¿Ya tienes cuenta? 
                        <a href="{{ route('login') }}" class="text-accent-indigo hover:underline ml-1 font-semibold">Inicia sesión</a>
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

    <script>
        // Password toggle
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

        // Draggable floating cards
        (function initDraggableCards() {
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
                    try { card.releasePointerCapture(e.pointerId); } catch (err) {}
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

        function showSocialNotice(provider) {
            showToast(`El registro con ${provider} se habilitará próximamente. Por favor completa los campos del formulario.`, 'info');
        }
    </script>
</body>
</html>
