<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Registro — Crear Cuenta Atelier · Estudio Códice</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Newsreader:ital,opsz,wght@0,6..72,400;0,6..72,500;1,6..72,400&family=Plus+Jakarta+Sans:wght@500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-canvas-bg font-body text-text-primary antialiased min-h-full flex flex-col justify-center">

    <div class="min-h-screen w-full grid grid-cols-1 lg:grid-cols-12">
        
        <!-- LEFT COLUMN: Register Form Box -->
        <div class="lg:col-span-6 xl:col-span-5 flex flex-col justify-between p-8 sm:p-12 xl:p-16 bg-surface-card border-r border-border-subtle shadow-sm z-10">
            <div>
                <a href="{{ route('studio.canvas') }}" class="inline-flex items-center gap-2 group mb-6">
                    <div class="w-9 h-9 rounded-xl bg-accent-indigo text-white flex items-center justify-center font-headline font-bold text-xl shadow-md group-hover:scale-105 transition-transform">
                        C
                    </div>
                    <span class="font-label font-bold text-text-primary tracking-tight text-lg">Atelier <span class="text-accent-indigo font-normal">Códice</span></span>
                </a>

                <div class="mb-5">
                    <h1 class="font-headline text-3xl font-bold text-text-primary tracking-tight">Comienza tu Universo</h1>
                    <p class="font-body text-xs text-text-secondary mt-1">Crea tu cuenta de autor y obtén un lienzo espacial infinito con base de datos propia.</p>
                </div>

                @if ($errors->any())
                    <div class="mb-4 p-3 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs font-label">
                        {{ $errors->first() }}
                    </div>
                @endif

                <!-- Form Fields -->
                <form action="{{ route('register') }}" method="POST" class="space-y-3.5">
                    @csrf
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="font-label text-xs font-semibold text-text-primary flex items-center gap-1.5" for="name">
                                <span class="material-symbols-outlined text-[16px] text-text-secondary">badge</span>
                                Nombre o Seudónimo creativo
                            </label>
                            <span class="font-label text-[10px] text-text-muted">Público en tu Atelier</span>
                        </div>
                        <input class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low border border-border-subtle focus:bg-surface-card text-text-primary font-body text-xs focus:outline-none focus:ring-2 focus:ring-accent-indigo" 
                               id="name" name="name" value="{{ old('name') }}" placeholder="p. ej. Aurelio Vance" required type="text"/>
                    </div>

                    <div>
                        <label class="font-label text-xs font-semibold text-text-primary flex items-center gap-1.5 mb-1" for="email">
                            <span class="material-symbols-outlined text-[16px] text-text-secondary">mail</span>
                            Correo electrónico
                        </label>
                        <input class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low border border-border-subtle focus:bg-surface-card text-text-primary font-body text-xs focus:outline-none focus:ring-2 focus:ring-accent-indigo" 
                               id="email" name="email" value="{{ old('email') }}" placeholder="tu@dominio.com" required type="email"/>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="font-label text-xs font-semibold text-text-primary flex items-center gap-1.5" for="password">
                                <span class="material-symbols-outlined text-[16px] text-text-secondary">lock</span>
                                Contraseña maestra
                            </label>
                            <span class="font-label text-[10px] text-text-muted" id="strength-label">Mínimo 8 caracteres</span>
                        </div>
                        <div class="relative">
                            <input class="w-full px-3.5 py-2.5 rounded-xl bg-surface-container-low border border-border-subtle focus:bg-surface-card text-text-primary font-body text-xs focus:outline-none focus:ring-2 focus:ring-accent-indigo pr-10" 
                                   id="password" name="password" placeholder="Crea una clave maestra..." required type="password" oninput="checkPasswordStrength(this.value)"/>
                            <button type="button" onclick="togglePasswordVisibility()" class="absolute right-3 top-2.5 text-text-muted hover:text-text-primary">
                                <span class="material-symbols-outlined text-[18px]" id="eye-icon">visibility</span>
                            </button>
                        </div>

                        <!-- Segmented Strength Meter -->
                        <div class="grid grid-cols-3 gap-1.5 mt-2">
                            <div id="bar-1" class="h-1 rounded-full bg-border-strong transition-colors duration-300"></div>
                            <div id="bar-2" class="h-1 rounded-full bg-border-strong transition-colors duration-300"></div>
                            <div id="bar-3" class="h-1 rounded-full bg-border-strong transition-colors duration-300"></div>
                        </div>

                        <!-- Rules Checklist -->
                        <div class="flex items-center gap-3 mt-1.5 font-label text-[10px] text-text-muted">
                            <span id="rule-len" class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[12px]">radio_button_unchecked</span>
                                8+ carac.
                            </span>
                            <span id="rule-num" class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[12px]">radio_button_unchecked</span>
                                1 número
                            </span>
                            <span id="rule-sym" class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[12px]">radio_button_unchecked</span>
                                1 símbolo
                            </span>
                        </div>
                    </div>

                    <!-- Creative Role Selector -->
                    <div>
                        <span class="block font-label text-xs font-semibold text-text-primary mb-1.5">
                            ¿Cuál es tu enfoque principal? <span class="font-normal text-text-muted font-body">(Opcional)</span>
                        </span>
                        <input type="hidden" name="creative_role" id="selected-role" value="Autor & Novelista">
                        <div class="flex flex-wrap gap-1.5" id="role-selector">
                            <button type="button" onclick="selectRole(this, 'Autor & Novelista')" class="role-chip px-3 py-1 rounded-full bg-accent-indigo text-white font-label text-[11px] font-semibold border border-accent-indigo">
                                Autor &amp; Novelista
                            </button>
                            <button type="button" onclick="selectRole(this, 'Worldbuilder & Guionista')" class="role-chip px-3 py-1 rounded-full bg-surface-container-low text-text-secondary font-label text-[11px] hover:text-text-primary border border-border-subtle">
                                Worldbuilder &amp; Guionista
                            </button>
                            <button type="button" onclick="selectRole(this, 'Director de Arte')" class="role-chip px-3 py-1 rounded-full bg-surface-container-low text-text-secondary font-label text-[11px] hover:text-text-primary border border-border-subtle">
                                Director de Arte
                            </button>
                            <button type="button" onclick="selectRole(this, 'Diseñador de Videojuegos')" class="role-chip px-3 py-1 rounded-full bg-surface-container-low text-text-secondary font-label text-[11px] hover:text-text-primary border border-border-subtle">
                                Diseñador de Videojuegos
                            </button>
                        </div>
                    </div>

                    <button class="w-full flex items-center justify-center gap-2 py-3 px-6 rounded-xl bg-accent-indigo hover:bg-accent-indigo-hover text-white font-label text-xs font-bold tracking-wide shadow-lg shadow-accent-indigo/25 transition-all duration-200 active:scale-[0.99] mt-3" type="submit">
                        <span>Crear mi Atelier Códice</span>
                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                    </button>
                </form>

                <div class="mt-5 text-center font-body text-xs text-text-secondary">
                    ¿Ya tienes una cuenta? 
                    <a class="font-label text-xs font-semibold text-accent-indigo hover:text-accent-indigo-hover ml-1 underline-offset-4 hover:underline" href="{{ route('login') }}">
                        Inicia sesión
                    </a>
                </div>
            </div>

            <!-- Micro status footer -->
            <div class="pt-4 border-t border-border-subtle mt-6 flex items-center justify-between text-text-muted font-label text-[11px]">
                <div class="flex items-center gap-1.5">
                    <span class="inline-block w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>Espacios de trabajo individuales con Neon DB</span>
                </div>
                <span>v4.2.0-pro</span>
            </div>
        </div>

        <!-- RIGHT COLUMN: Spatial Showcase Workspace Live Demo -->
        <div class="lg:col-span-6 xl:col-span-7 relative hidden lg:flex flex-col justify-between p-12 xl:p-16 overflow-hidden bg-gradient-to-br from-surface-container-low via-surface-container to-surface-dim canvas-grid border-l border-border-subtle">
            <div class="absolute -top-32 -right-32 w-96 h-96 rounded-full bg-accent-indigo/15 blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-10 left-10 w-80 h-80 rounded-full bg-accent-terracotta/15 blur-3xl pointer-events-none"></div>

            <div class="relative z-20 flex items-center justify-between">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-surface-card/90 backdrop-blur-md border border-border-subtle shadow-sm font-label text-xs">
                    <span class="material-symbols-outlined text-accent-sage text-[16px]">verified</span>
                    <span class="font-bold text-text-primary tracking-wide">Plataforma Creativa para Worldbuilders</span>
                </div>
                <div class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-surface-card/85 backdrop-blur-md text-text-secondary font-label text-xs border border-border-subtle shadow-sm">
                    <span class="material-symbols-outlined text-[15px]">auto_awesome</span>
                    <span>Códice AI Integrado</span>
                </div>
            </div>

            <div class="relative z-10 my-auto py-8 w-full max-w-lg mx-auto">
                <div class="bg-surface-card rounded-2xl border border-border-subtle shadow-xl p-5 mb-4">
                    <span class="font-label text-[10px] text-accent-sage font-bold tracking-wider uppercase">Aliada Clave</span>
                    <h3 class="font-headline font-bold text-xl text-text-primary mt-1">Dra. Valeria Ruiz</h3>
                    <p class="font-body text-xs text-text-secondary mt-0.5">Neurobióloga &amp; Enlace Rebelde</p>
                    <blockquote class="bg-surface-container-low p-2.5 rounded-lg font-headline italic text-xs text-text-secondary border-l-2 border-accent-sage mt-3">
                        “No modificamos la mente para escapar, sino para recordar quiénes éramos.”
                    </blockquote>
                </div>

                <div class="bg-surface-card rounded-2xl border border-border-subtle shadow-xl p-4 ml-8 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-orange-50 text-accent-terracotta flex items-center justify-center font-bold">
                        <span class="material-symbols-outlined text-[20px]">palette</span>
                    </div>
                    <div>
                        <h4 class="font-label text-xs font-bold text-text-primary">Paletas de Arte &amp; Moodboards</h4>
                        <p class="font-body text-[11px] text-text-muted">Organiza referencias visuales y sonoras en un mismo lienzo.</p>
                    </div>
                </div>
            </div>

            <div class="relative z-20 flex items-center justify-between text-text-muted font-label text-xs">
                <span>Conexiones vectoriales · Cartografía con Point Marks · Playlists de ambient</span>
                <span class="font-bold text-accent-indigo">Atelier Canvas</span>
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

        function selectRole(button, role) {
            document.querySelectorAll('.role-chip').forEach(chip => {
                chip.className = 'role-chip px-3 py-1 rounded-full bg-surface-container-low text-text-secondary font-label text-[11px] hover:text-text-primary border border-border-subtle';
            });
            button.className = 'role-chip px-3 py-1 rounded-full bg-accent-indigo text-white font-label text-[11px] font-semibold border border-accent-indigo';
            document.getElementById('selected-role').value = role;
        }

        function checkPasswordStrength(val) {
            const bar1 = document.getElementById('bar-1');
            const bar2 = document.getElementById('bar-2');
            const bar3 = document.getElementById('bar-3');
            const label = document.getElementById('strength-label');
            const ruleLen = document.getElementById('rule-len');
            const ruleNum = document.getElementById('rule-num');
            const ruleSym = document.getElementById('rule-sym');

            const hasLen = val.length >= 8;
            const hasNum = /\d/.test(val);
            const hasSym = /[^A-Za-z0-9]/.test(val);

            updateRule(ruleLen, hasLen);
            updateRule(ruleNum, hasNum);
            updateRule(ruleSym, hasSym);

            const score = (hasLen ? 1 : 0) + (hasNum ? 1 : 0) + (hasSym ? 1 : 0);

            bar1.className = 'h-1 rounded-full transition-colors duration-300 ' + (score >= 1 ? 'bg-red-500' : 'bg-border-strong');
            bar2.className = 'h-1 rounded-full transition-colors duration-300 ' + (score >= 2 ? 'bg-amber-500' : 'bg-border-strong');
            bar3.className = 'h-1 rounded-full transition-colors duration-300 ' + (score >= 3 ? 'bg-emerald-500' : 'bg-border-strong');

            if (score === 3) label.textContent = 'Fuerte';
            else if (score === 2) label.textContent = 'Media';
            else if (score === 1) label.textContent = 'Básica';
            else label.textContent = 'Débil';
        }

        function updateRule(el, valid) {
            if (valid) {
                el.classList.add('text-emerald-600');
                el.classList.remove('text-text-muted');
                el.querySelector('.material-symbols-outlined').textContent = 'check_circle';
            } else {
                el.classList.remove('text-emerald-600');
                el.classList.add('text-text-muted');
                el.querySelector('.material-symbols-outlined').textContent = 'radio_button_unchecked';
            }
        }
    </script>
</body>
</html>
