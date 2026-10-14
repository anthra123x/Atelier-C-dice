<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Iniciar Sesión — Atelier Canvas · Estudio Códice</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Newsreader:ital,opsz,wght@0,6..72,400;0,6..72,500;1,6..72,400&family=Plus+Jakarta+Sans:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-canvas-bg font-body text-text-primary antialiased min-h-full flex flex-col justify-center">

    <div class="min-h-screen w-full grid grid-cols-1 lg:grid-cols-12">
        
        <!-- LEFT COLUMN: Authentication Form Box -->
        <div class="lg:col-span-6 xl:col-span-5 flex flex-col justify-between p-8 sm:p-12 xl:p-16 bg-surface-card border-r border-border-subtle shadow-sm z-10">
            <!-- Brand Header -->
            <div>
                <a href="{{ route('studio.canvas') }}" class="inline-flex items-center gap-2 group mb-8">
                    <div class="w-9 h-9 rounded-xl bg-accent-indigo text-white flex items-center justify-center font-headline font-bold text-xl shadow-md group-hover:scale-105 transition-transform">
                        C
                    </div>
                    <span class="font-label font-bold text-text-primary tracking-tight text-lg">Atelier <span class="text-accent-indigo font-normal">Códice</span></span>
                </a>

                <div class="mb-6">
                    <h1 class="font-headline text-3xl font-bold text-text-primary tracking-tight">Acceder al Lienzo</h1>
                    <p class="font-body text-xs text-text-secondary mt-1">Conecta con tu espacio de trabajo de narrativa, mundos y cartografía espacial.</p>
                </div>

                <!-- Error alerts -->
                @if ($errors->any())
                    <div class="mb-5 p-3 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs font-label">
                        {{ $errors->first() }}
                    </div>
                @endif

                @if (session('info'))
                    <div class="mb-5 p-3 rounded-xl bg-blue-50 border border-blue-200 text-blue-700 text-xs font-label">
                        {{ session('info') }}
                    </div>
                @endif

                <!-- Fast Social Access Buttons -->
                <div class="grid grid-cols-2 gap-3 mb-5">
                    <button type="button" class="flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl bg-surface-container-low hover:bg-surface-container border border-border-subtle transition-all shadow-sm text-text-primary font-label text-xs font-semibold">
                        <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24">
                            <path d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.66-5.17 3.66-9.17z" fill="#4285F4"></path>
                            <path d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.1-6.72-4.93H1.25v3.15C3.26 21.36 7.34 24 12 24z" fill="#34A853"></path>
                            <path d="M5.28 14.27c-.25-.72-.38-1.49-.38-2.27s.13-1.55.38-2.27V6.58H1.25C.45 8.18 0 9.99 0 12s.45 3.82 1.25 5.42l4.03-3.15z" fill="#FBBC05"></path>
                            <path d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.34 0 3.26 2.64 1.25 6.58l4.03 3.15c.95-2.83 3.6-4.98 6.72-4.98z" fill="#EA4335"></path>
                        </svg>
                        <span>Google</span>
                    </button>
                    <button type="button" class="flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl bg-surface-container-low hover:bg-surface-container border border-border-subtle transition-all shadow-sm text-text-primary font-label text-xs font-semibold">
                        <svg class="w-4 h-4 fill-current shrink-0" viewBox="0 0 24 24">
                            <path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M15.97 6.37c.66-.82 1.11-1.96.99-3.11-1 .04-2.18.67-2.88 1.48-.59.68-1.11 1.79-.97 2.9 1.12.09 2.22-.51 2.86-1.27z"></path>
                        </svg>
                        <span>Apple ID</span>
                    </button>
                </div>

                <!-- Divider -->
                <div class="relative flex items-center justify-center my-6">
                    <div class="w-full h-px bg-border-subtle"></div>
                    <span class="absolute px-3 bg-surface-card font-label text-[10px] uppercase tracking-widest text-text-muted">
                        o con tu correo
                    </span>
                </div>

                <!-- Login Form -->
                <form action="{{ route('login') }}" method="POST" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block font-label text-[11px] uppercase tracking-wider font-semibold text-text-secondary mb-1.5" for="email">
                            Dirección de correo
                        </label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3.5 top-2.5 text-text-muted text-[18px]">alternate_email</span>
                            <input class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-surface-container-low border border-border-subtle focus:bg-surface-card text-text-primary placeholder:text-text-muted font-body text-xs transition-all outline-none focus:ring-2 focus:ring-accent-indigo" 
                                   id="email" name="email" value="{{ old('email', 'admin@codice.local') }}" placeholder="autor@estudio.com" required type="email"/>
                        </div>
                    </div>

                    <div>
                        <label class="block font-label text-[11px] uppercase tracking-wider font-semibold text-text-secondary mb-1.5" for="password">
                            Contraseña maestra
                        </label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3.5 top-2.5 text-text-muted text-[18px]">lock</span>
                            <input class="w-full pl-10 pr-10 py-2.5 rounded-xl bg-surface-container-low border border-border-subtle focus:bg-surface-card text-text-primary placeholder:text-text-muted font-body text-xs transition-all outline-none focus:ring-2 focus:ring-accent-indigo" 
                                   id="password" name="password" value="password123" placeholder="••••••••••••" required type="password"/>
                            <button type="button" onclick="togglePasswordVisibility()" class="absolute right-3.5 top-2.5 text-text-muted hover:text-text-primary">
                                <span class="material-symbols-outlined text-[18px]" id="eye-icon">visibility</span>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-1">
                        <label class="flex items-center gap-2 cursor-pointer select-none">
                            <input type="checkbox" name="remember" checked class="w-4 h-4 rounded text-accent-indigo focus:ring-0 bg-surface-container-high border-border-subtle cursor-pointer accent-accent-indigo"/>
                            <span class="font-body text-xs text-text-secondary hover:text-text-primary transition-colors">Recordar mi sesión</span>
                        </label>
                        <a href="#" class="font-label text-xs text-accent-indigo hover:text-accent-indigo-hover underline-offset-4 hover:underline">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>

                    <button class="w-full group flex items-center justify-center gap-2 py-3 px-6 rounded-xl bg-accent-indigo hover:bg-accent-indigo-hover text-white font-label text-xs font-bold tracking-wide shadow-lg shadow-accent-indigo/25 transition-all duration-200 active:scale-[0.99] mt-2" type="submit">
                        <span>Entrar al Atelier</span>
                        <span class="material-symbols-outlined text-[18px] transition-transform duration-200 group-hover:translate-x-1">arrow_forward</span>
                    </button>
                </form>

                <div class="mt-6 text-center font-body text-xs text-text-secondary">
                    ¿Nuevo en Atelier? 
                    <a class="font-label text-xs font-semibold text-accent-indigo hover:text-accent-indigo-hover ml-1 underline-offset-4 hover:underline" href="{{ route('register') }}">
                        Crea tu cuenta gratis
                    </a>
                </div>
            </div>

            <!-- Micro status footer -->
            <div class="pt-6 border-t border-border-subtle mt-8 flex items-center justify-between text-text-muted font-label text-[11px]">
                <div class="flex items-center gap-2">
                    <span class="inline-block w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span>PostgreSQL Neon Operativo</span>
                </div>
                <span class="tracking-wider uppercase">v4.2.0-pro</span>
            </div>
        </div>

        <!-- RIGHT COLUMN: Spatial Showcase Workspace Live Demo -->
        <div class="lg:col-span-6 xl:col-span-7 relative hidden lg:flex flex-col justify-between p-12 xl:p-16 overflow-hidden bg-gradient-to-br from-surface-container-low via-surface-container to-surface-dim canvas-grid border-l border-border-subtle">
            <!-- Glow background -->
            <div class="absolute -top-32 -right-32 w-96 h-96 rounded-full bg-accent-indigo/15 blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-10 left-10 w-80 h-80 rounded-full bg-accent-terracotta/15 blur-3xl pointer-events-none"></div>

            <!-- Floating Top HUD -->
            <div class="relative z-20 flex items-center justify-between">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-surface-card/90 backdrop-blur-md border border-border-subtle shadow-sm font-label text-xs">
                    <span class="material-symbols-outlined text-accent-indigo text-[16px]">spatial_audio</span>
                    <span class="font-bold text-text-primary tracking-wide">Crónicas de Neo-Kyoto</span>
                    <span class="text-text-muted">· 5 Nodos Activos</span>
                </div>
                <div class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-surface-card/85 backdrop-blur-md text-text-secondary font-label text-xs border border-border-subtle shadow-sm">
                    <span class="material-symbols-outlined text-[15px]">zoom_in</span>
                    <span>100% Escala</span>
                </div>
            </div>

            <!-- Spatial Cards Showcase -->
            <div class="relative z-10 my-auto py-8 w-full max-w-lg mx-auto">
                <svg class="absolute inset-0 w-full h-full pointer-events-none -z-10 overflow-visible" xmlns="http://www.w3.org/2000/svg">
                    <path d="M 120 100 Q 220 180 180 260 T 320 320" fill="none" stroke="#CBD5E1" stroke-dasharray="6 4" stroke-width="2"></path>
                    <circle cx="120" cy="100" fill="#4F46E5" r="4"></circle>
                    <circle cx="320" cy="320" fill="#EA580C" r="4"></circle>
                </svg>

                <!-- Demo Card 1: Character Dossier -->
                <div class="bg-surface-card rounded-2xl border border-border-subtle shadow-xl p-4 max-w-xs transform -rotate-1 hover:rotate-0 transition-transform">
                    <div class="flex items-center justify-between pb-2 mb-2 border-b border-border-subtle">
                        <span class="font-label text-[10px] text-accent-indigo font-bold tracking-wider uppercase">ID: NEO-0924</span>
                        <span class="material-symbols-outlined text-[16px] text-text-muted">push_pin</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-surface-container overflow-hidden flex-shrink-0">
                            <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuDSlE-30PW7KJ3-LolW8xKS0QEqLTVavb-51_hxIwASekg53HiiD_oow5lpeCjn96h4tjOp7RvLXY4LEHzZrruRkJ3PGO70WcEq8k9zOwFORnydL8M637mr-XrddhXaZHkzwSbDIHcO8XCuq-XgzmbsyNjNIHIulx045DIehd2XGbf68T6daL1Tp5gdTLSPefEEIAEJ2Zuz6voaErGvT8IdUtQt7XayRWpdYlfHIOvzcPMhXJs3Inq4Hw" 
                                 class="w-full h-full object-cover" alt="Detective">
                        </div>
                        <div>
                            <h4 class="font-headline font-bold text-sm text-text-primary">Kaelen Vance</h4>
                            <p class="font-body text-[11px] text-text-secondary">Detective Privado / Ex-Operativo</p>
                        </div>
                    </div>
                </div>

                <!-- Demo Card 2: Lore Snippet -->
                <div class="bg-surface-card rounded-2xl border border-border-subtle shadow-xl p-4 max-w-xs ml-auto mt-6 transform rotate-2 hover:rotate-0 transition-transform">
                    <div class="flex items-center gap-2 mb-1.5">
                        <span class="material-symbols-outlined text-accent-terracotta text-[16px]">location_on</span>
                        <h4 class="font-headline font-bold text-sm text-text-primary">Almacén 17 · Muelle Este</h4>
                    </div>
                    <p class="font-body text-[11px] text-text-secondary leading-relaxed">
                        Punto de descarga clandestina de chips de memoria neural para el mercado negro.
                    </p>
                </div>
            </div>

            <!-- Bottom Footnote -->
            <div class="relative z-20 flex items-center justify-between text-text-muted font-label text-xs">
                <span>Lienzo Espacial para Autores y Creadores de Universos</span>
                <span class="flex items-center gap-1 font-bold text-accent-indigo">
                    <span>Estudio Códice</span>
                    <span class="material-symbols-outlined text-[14px]">arrow_outward</span>
                </span>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const input = document.getElementById('password');
            const icon = document.getElementById('eye-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = 'visibility_off';
            } else {
                input.type = 'password';
                icon.textContent = 'visibility';
            }
        }
    </script>
</body>
</html>
