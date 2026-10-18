@extends('layouts.studio')

@section('title', 'Biblioteca de Recursos y Conexión de Música - Estudio Cóice')
@section('view_label', 'Biblioteca & Playlists')

@section('content')
<div class="max-w-[1440px] w-full mx-auto px-6 py-8 select-none space-y-8">

    <!-- Connected Music & Streaming Service Hub -->
    <div class="bg-surface-card rounded-3xl border border-border-subtle shadow-lg p-6 relative overflow-hidden space-y-6">
        
        <!-- Header: Service Selector Tabs & Status -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-border-subtle/80">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-accent-indigo via-indigo-600 to-purple-600 text-white flex items-center justify-center shadow-md">
                    <span class="material-symbols-outlined text-[22px]">headphones</span>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="font-headline text-lg font-bold text-text-primary">Servicio de Música Activo</h2>
                        <span id="service-status-pill" class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200 font-label text-[10px] font-bold uppercase flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            Conectado
                        </span>
                    </div>
                    <p class="font-body text-xs text-text-muted">Sincroniza el reproductor con el servicio de streaming que estás usando ahora mismo</p>
                </div>
            </div>

            <!-- Provider Selection Tabs -->
            <div class="flex items-center p-1 rounded-2xl bg-surface-container-low border border-border-subtle font-label text-xs">
                <button onclick="switchMusicService('spotify')" id="tab-spotify"
                        class="service-tab-btn flex items-center gap-1.5 px-3 py-1.5 rounded-xl font-semibold transition-all bg-accent-indigo text-white shadow-xs">
                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.66 0 12 0zm5.521 17.34c-.24.359-.66.48-1.021.24-2.82-1.74-6.36-2.101-10.561-1.141-.418.122-.779-.179-.899-.539-.12-.421.18-.78.54-.9 4.56-1.021 8.52-.6 11.64 1.32.42.18.479.659.301 1.02zm1.44-3.3c-.301.42-.841.6-1.262.3-3.239-1.98-8.159-2.58-11.939-1.38-.479.12-1.02-.12-1.14-.6-.12-.48.12-1.021.6-1.141C9.6 9.9 15 10.561 18.72 12.84c.361.181.54.78.241 1.2zm.12-3.36C15.24 8.4 8.82 8.16 5.16 9.301c-.6.179-1.2-.181-1.38-.721-.18-.601.18-1.2.72-1.381 4.26-1.26 11.28-1.02 15.721 1.621.539.3.719 1.02.419 1.56-.299.421-1.02.599-1.559.3z"/></svg>
                    <span>Spotify</span>
                </button>
                <button onclick="switchMusicService('youtube')" id="tab-youtube"
                        class="service-tab-btn flex items-center gap-1.5 px-3 py-1.5 rounded-xl font-medium text-text-secondary hover:text-text-primary transition-all">
                    <svg class="w-3.5 h-3.5 fill-current text-red-500" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    <span>YouTube Music</span>
                </button>
                <button onclick="switchMusicService('apple')" id="tab-apple"
                        class="service-tab-btn flex items-center gap-1.5 px-3 py-1.5 rounded-xl font-medium text-text-secondary hover:text-text-primary transition-all">
                    <svg class="w-3.5 h-3.5 fill-current text-pink-500" viewBox="0 0 24 24"><path d="M18.71 19.5c-.83 1.24-1.71 2.45-3.05 2.47-1.34.03-1.77-.79-3.29-.79-1.53 0-2 .77-3.27.82-1.31.05-2.3-1.32-3.14-2.53C4.25 17 2.94 12.45 4.7 9.39c.87-1.52 2.43-2.48 4.12-2.51 1.28-.02 2.5.87 3.29.87.78 0 2.26-1.07 3.81-.91.65.03 2.47.26 3.64 1.98-.09.06-2.17 1.28-2.15 3.81.03 3.02 2.65 4.03 2.68 4.04-.03.07-.42 1.44-1.38 2.83M15.97 6.84c.66-.82 1.11-1.96.99-3.11-1 .04-2.17.67-2.86 1.48-.6.7-.1.14 1.87 1.02 3.04 1.05-.03 2.12-.66 2.85-1.41z"/></svg>
                    <span>Apple Music</span>
                </button>
                <button onclick="switchMusicService('vault')" id="tab-vault"
                        class="service-tab-btn flex items-center gap-1.5 px-3 py-1.5 rounded-xl font-medium text-text-secondary hover:text-text-primary transition-all">
                    <span class="material-symbols-outlined text-[15px]">graphic_eq</span>
                    <span>Bóveda Local</span>
                </button>
            </div>
        </div>

        <!-- 1. SPOTIFY SERVICE CONTAINER -->
        <div id="service-panel-spotify" class="service-content-panel space-y-4">
            <!-- URL / URI Link Input & Quick Presets -->
            <div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-4 bg-surface-container-low/70 p-4 rounded-2xl border border-border-subtle">
                <div class="flex-1 flex items-center gap-2">
                    <span class="material-symbols-outlined text-emerald-600 text-[20px]">link</span>
                    <input type="text" id="spotify-input-url" 
                           placeholder="Pega enlace de Spotify que estés escuchando (Playlist, Álbum o Canción)..." 
                           class="w-full bg-surface-card border border-border-subtle rounded-xl px-3.5 py-2 font-body text-xs text-text-primary placeholder:text-text-muted focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <button onclick="loadCustomSpotifyUrl()" 
                            class="px-4 py-2 rounded-xl bg-emerald-600 text-white font-label text-xs font-semibold hover:bg-emerald-700 transition-all shadow-sm flex items-center gap-1.5 flex-shrink-0">
                        <span>Conectar</span>
                    </button>
                </div>

                <!-- Open in Native App or Web Client -->
                <div class="flex items-center gap-2 flex-shrink-0">
                    <button onclick="openSpotifyApp()" 
                            class="px-3 py-2 rounded-xl bg-surface-card hover:bg-surface-container text-text-primary border border-border-subtle font-label text-xs font-medium flex items-center gap-1.5 transition-colors" title="Abrir en tu cliente instalado de Spotify">
                        <span class="material-symbols-outlined text-[16px] text-emerald-600">launch</span>
                        <span>Abrir app Spotify</span>
                    </button>
                    <button onclick="openSpotifyAuthModal()" 
                            class="px-3 py-2 rounded-xl bg-surface-card hover:bg-surface-container text-text-secondary hover:text-text-primary border border-border-subtle font-label text-xs font-medium flex items-center gap-1.5 transition-colors" title="Configurar Token o Client ID de Spotify API">
                        <span class="material-symbols-outlined text-[16px]">tune</span>
                        <span>Sincronizar API</span>
                    </button>
                </div>
            </div>

            <!-- Curated Presets Pills for Writing & Creativity -->
            <div class="flex items-center gap-2 overflow-x-auto pb-1 text-xs font-label">
                <span class="text-text-muted font-bold mr-1 flex items-center gap-1">
                    <span class="material-symbols-outlined text-[15px]">auto_awesome</span>
                    Presets:
                </span>
                <button onclick="loadSpotifyPreset('37i9dQZF1DXdLEN7aqioXM', 'Cyberpunk & Synthwave Focus')" 
                        class="px-3 py-1 rounded-full bg-surface-card hover:bg-surface-container border border-border-subtle text-text-primary flex items-center gap-1.5 transition-colors">
                    <span>⚡ Cyberpunk &amp; Synthwave</span>
                </button>
                <button onclick="loadSpotifyPreset('37i9dQZF1DX1s9knjP51Oa', 'Dark Ambient & Deep Space')" 
                        class="px-3 py-1 rounded-full bg-surface-card hover:bg-surface-container border border-border-subtle text-text-primary flex items-center gap-1.5 transition-colors">
                    <span>🌧️ Lluvia &amp; Dark Ambient</span>
                </button>
                <button onclick="loadSpotifyPreset('37i9dQZF1DX8Uebhn9wzrS', 'Lo-Fi Writing & Chill Beats')" 
                        class="px-3 py-1 rounded-full bg-surface-card hover:bg-surface-container border border-border-subtle text-text-primary flex items-center gap-1.5 transition-colors">
                    <span>☕ Lo-Fi Beats para Escritura</span>
                </button>
                <button onclick="loadSpotifyPreset('37i9dQZF1DX3Ogo9pFvBkY', 'Atmósferas de Concentración')" 
                        class="px-3 py-1 rounded-full bg-surface-card hover:bg-surface-container border border-border-subtle text-text-primary flex items-center gap-1.5 transition-colors">
                    <span>📖 Concentración Profunda</span>
                </button>
            </div>

            <!-- Spotify Responsive Live Player Embed -->
            <div class="rounded-2xl overflow-hidden shadow-inner border border-border-subtle bg-black">
                <iframe id="spotify-embed-frame" 
                        style="border-radius:12px" 
                        src="https://open.spotify.com/embed/playlist/37i9dQZF1DXdLEN7aqioXM?utm_source=generator&theme=0" 
                        width="100%" height="220" frameBorder="0" allowfullscreen="" 
                        allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" 
                        loading="lazy"></iframe>
            </div>
        </div>

        <!-- 2. YOUTUBE MUSIC SERVICE CONTAINER -->
        <div id="service-panel-youtube" class="service-content-panel hidden space-y-4">
            <div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-4 bg-surface-container-low/70 p-4 rounded-2xl border border-border-subtle">
                <div class="flex-1 flex items-center gap-2">
                    <span class="material-symbols-outlined text-red-600 text-[20px]">smart_display</span>
                    <input type="text" id="youtube-input-url" 
                           placeholder="Pega enlace de YouTube Music o YouTube (Video o Playlist)..." 
                           class="w-full bg-surface-card border border-border-subtle rounded-xl px-3.5 py-2 font-body text-xs text-text-primary placeholder:text-text-muted focus:outline-none focus:ring-2 focus:ring-red-500">
                    <button onclick="loadCustomYouTubeUrl()" 
                            class="px-4 py-2 rounded-xl bg-red-600 text-white font-label text-xs font-semibold hover:bg-red-700 transition-all shadow-sm flex items-center gap-1.5 flex-shrink-0">
                        <span>Reproducir</span>
                    </button>
                </div>
                <div class="flex items-center gap-2">
                    <button onclick="loadYouTubePreset('jfKfPfyJRdk', 'Lofi Girl 24/7 Focus Stream')" 
                            class="px-3 py-2 rounded-xl bg-surface-card hover:bg-surface-container border border-border-subtle text-text-primary font-label text-xs font-medium">
                        🔴 Lofi Girl Live
                    </button>
                    <button onclick="loadYouTubePreset('4xDzrJKXOOY', 'Synthwave Radio 24/7')" 
                            class="px-3 py-2 rounded-xl bg-surface-card hover:bg-surface-container border border-border-subtle text-text-primary font-label text-xs font-medium">
                        🔴 Synthwave Radio
                    </button>
                </div>
            </div>

            <!-- YouTube Music Embed -->
            <div class="rounded-2xl overflow-hidden shadow-inner border border-border-subtle bg-black aspect-video max-h-[320px] w-full flex items-center justify-center">
                <iframe id="youtube-embed-frame" 
                        class="w-full h-full"
                        src="https://www.youtube-nocookie.com/embed/jfKfPfyJRdk?autoplay=0" 
                        title="YouTube Music Ambient Player" frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                        allowfullscreen></iframe>
            </div>
        </div>

        <!-- 3. APPLE MUSIC SERVICE CONTAINER -->
        <div id="service-panel-apple" class="service-content-panel hidden space-y-4">
            <div class="flex items-center justify-between gap-4 bg-surface-container-low/70 p-4 rounded-2xl border border-border-subtle">
                <div class="flex-1 flex items-center gap-2">
                    <span class="material-symbols-outlined text-pink-600 text-[20px]">music_note</span>
                    <input type="text" id="apple-input-url" 
                           placeholder="Pega enlace de Apple Music (Álbum, Playlist o Canción)..." 
                           class="w-full bg-surface-card border border-border-subtle rounded-xl px-3.5 py-2 font-body text-xs text-text-primary placeholder:text-text-muted focus:outline-none focus:ring-2 focus:ring-pink-500">
                    <button onclick="loadCustomAppleMusicUrl()" 
                            class="px-4 py-2 rounded-xl bg-pink-600 text-white font-label text-xs font-semibold hover:bg-pink-700 transition-all shadow-sm flex items-center gap-1.5 flex-shrink-0">
                        <span>Cargar</span>
                    </button>
                </div>
            </div>

            <!-- Apple Music Embed -->
            <div class="rounded-2xl overflow-hidden shadow-inner border border-border-subtle bg-black">
                <iframe id="apple-embed-frame" allow="autoplay *; encrypted-media *; fullscreen *; clipboard-write" 
                        frameborder="0" height="220" style="width:100%;max-width:100%;overflow:hidden;border-radius:12px;" 
                        sandbox="allow-forms allow-popups allow-same-origin allow-scripts allow-storage-access-by-user-activation allow-top-navigation-by-user-activation" 
                        src="https://embed.music.apple.com/us/playlist/lo-fi-jazz-beats/pl.u-38oWZ45FPk858Y"></iframe>
            </div>
        </div>

        <!-- 4. LOCAL AUDIO VAULT DECK (Procedural Loops & Local Audio Engine) -->
        <div id="service-panel-vault" class="service-content-panel hidden space-y-4">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 bg-surface-container-low/60 p-5 rounded-2xl border border-border-subtle">
                <!-- Track Info & Artwork -->
                <div class="flex items-center gap-4 min-w-[280px]">
                    <div class="w-16 h-16 rounded-2xl bg-accent-indigo text-white flex items-center justify-center flex-shrink-0 shadow-md">
                        <span class="material-symbols-outlined text-[32px]">graphic_eq</span>
                    </div>
                    <div>
                        <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-label text-[10px] font-bold uppercase">Reproduciendo Bóveda</span>
                        <h2 id="player-title" class="font-headline text-xl font-bold text-text-primary mt-1">Atmósfera de Escritura: Lluvia y Neón</h2>
                        <p id="player-artist" class="font-body text-xs text-text-muted">Kowloon Echoes · Dark Ambient &amp; Procedural Rain Loops</p>
                    </div>
                </div>

                <!-- Central Transport Controls & Waveform -->
                <div class="flex-1 max-w-2xl flex flex-col items-center gap-2.5">
                    <div class="flex items-center gap-6">
                        <button class="text-text-muted hover:text-text-primary transition-colors" title="Aleatorio">
                            <span class="material-symbols-outlined text-[20px]">shuffle</span>
                        </button>
                        <button class="text-text-secondary hover:text-text-primary transition-colors" title="Pista anterior">
                            <span class="material-symbols-outlined text-[24px]">skip_previous</span>
                        </button>
                        <button id="master-play-btn" onclick="togglePlayback()" 
                                class="w-12 h-12 rounded-full bg-accent-indigo text-white flex items-center justify-center shadow-lg hover:scale-105 active:scale-95 transition-all">
                            <span id="master-play-icon" class="material-symbols-outlined text-[26px]">play_arrow</span>
                        </button>
                        <button class="text-text-secondary hover:text-text-primary transition-colors" title="Siguiente pista">
                            <span class="material-symbols-outlined text-[24px]">skip_next</span>
                        </button>
                        <button class="text-text-muted hover:text-text-primary transition-colors" title="Repetir bucle">
                            <span class="material-symbols-outlined text-[20px]">repeat</span>
                        </button>
                    </div>

                    <!-- Interactive SVG Waveform Bar -->
                    <div class="w-full flex items-center gap-3">
                        <span id="player-current-time" class="font-label text-xs text-text-secondary">00:00</span>
                        <div class="relative flex-1 h-6 flex items-center cursor-pointer group" onclick="seekWaveform(event)">
                            <svg class="w-full h-5 text-border-strong group-hover:text-accent-indigo/60 transition-colors" viewBox="0 0 200 16" preserveAspectRatio="none">
                                @php
                                    $bars = [6,10,12,8,4,14,10,6,12,8,14,6,10,12,4,8,14,10,6,12,8,2,10,14,6,12,8,4,12,14,10,6,12,8,2,12,6,10,14,8];
                                @endphp
                                @foreach($bars as $idx => $height)
                                    <rect x="{{ $idx * 5 }}" y="{{ (16 - $height) / 2 }}" width="3" height="{{ $height }}" rx="1" fill="currentColor"></rect>
                                @endforeach
                            </svg>
                            <div id="waveform-progress" class="absolute inset-y-0 left-0 bg-accent-indigo/20 pointer-events-none rounded transition-all" style="width: 25%;"></div>
                        </div>
                        <span id="player-total-time" class="font-label text-xs text-text-muted">03:45</span>
                    </div>
                </div>

                <!-- Volume Slider & Loop Badge -->
                <div class="hidden lg:flex items-center gap-3">
                    <span class="material-symbols-outlined text-[20px] text-text-muted">volume_up</span>
                    <input type="range" min="0" max="100" value="75" onchange="adjustVolume(this.value)"
                           class="w-24 accent-accent-indigo cursor-pointer">
                    <span class="px-2.5 py-1 rounded-full bg-surface-container-high text-accent-indigo font-label text-[10px] font-bold border border-border-subtle uppercase">Loop Infinito</span>
                </div>
            </div>

            <!-- Hidden HTML5 Audio Element for Vault -->
            <audio id="audio-engine" src="https://cdn.pixabay.com/download/audio/2022/05/27/audio_1808fbf07a.mp3?filename=rain-and-nostalgia-ambient-112959.mp3" loop></audio>
        </div>
    </div>

    <!-- Compendio de Lore & Documentos -->
    <div class="space-y-6">
        <!-- Filter Pills Bar -->
        <div class="flex items-center justify-between border-b border-border-subtle pb-4">
            <div class="flex items-center gap-2">
                <span class="font-headline text-2xl font-bold text-text-primary mr-2">Compendio de Lore</span>
                @foreach($categories as $cat)
                    <a href="{{ route('studio.library', ['category' => $cat === 'Todos' ? null : $cat]) }}" 
                       class="px-3 py-1 rounded-full font-label text-xs transition-all {{ $selectedCategory === $cat ? 'bg-text-primary text-white font-semibold' : 'bg-surface-card border border-border-subtle text-text-secondary hover:text-text-primary' }}">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>

            <span class="font-label text-xs text-text-muted">{{ count($libraryItems) }} Manuscritos indexados</span>
        </div>

        <!-- Library Items Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($libraryItems as $item)
                <article class="bg-surface-card rounded-2xl border border-border-subtle shadow-sm hover:shadow-md transition-shadow p-5 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <span class="px-2.5 py-0.5 rounded-full bg-surface-container-high text-accent-indigo font-label text-[10px] font-bold uppercase border border-border-subtle">{{ $item->category }}</span>
                            <span class="font-label text-[11px] text-text-muted">{{ $item->author ?? 'Autor Desconocido' }}</span>
                        </div>
                        <h3 class="font-headline text-lg font-bold text-text-primary leading-snug">{{ $item->title }}</h3>
                        <p class="font-body text-xs text-text-secondary leading-relaxed mt-2.5">
                            {{ $item->content }}
                        </p>
                    </div>

                    <div class="mt-4 pt-3 border-t border-border-subtle/70 flex items-center justify-between">
                        <div class="flex flex-wrap gap-1">
                            @foreach($item->tags ?? [] as $tag)
                                <span class="px-2 py-0.5 rounded-md bg-surface-container-low text-text-muted font-label text-[10px]">#{{ $tag }}</span>
                            @endforeach
                        </div>
                        <button onclick="copyExcerpt('{{ addslashes($item->content) }}')" class="p-1.5 hover:bg-surface-container-high rounded-lg text-text-muted hover:text-text-primary transition-colors" title="Copiar extracto">
                            <span class="material-symbols-outlined text-[16px]">content_copy</span>
                        </button>
                    </div>
                </article>
            @empty
                <div class="col-span-full py-12 text-center text-text-muted">
                    <p class="font-headline text-base">No hay documentos en esta categoría.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Audio Track Vault -->
    <div class="space-y-4 pt-4">
        <h3 class="font-headline text-xl font-bold text-text-primary">Bóveda de Frecuencias &amp; Audio Loops</h3>
        <div class="bg-surface-card rounded-2xl border border-border-subtle overflow-hidden divide-y divide-border-subtle">
            @foreach($audioTracks as $track)
                <div class="px-6 py-4 flex items-center justify-between hover:bg-surface-container-low/50 transition-colors">
                    <div class="flex items-center gap-4">
                        <button onclick="switchMusicService('vault'); playTrack('{{ $track->title }}', '{{ $track->artist }}', '{{ $track->audio_url }}', '{{ $track->duration }}')"
                                class="w-9 h-9 rounded-full bg-surface-container-high hover:bg-accent-indigo hover:text-white flex items-center justify-center text-text-primary transition-colors shadow-sm">
                            <span class="material-symbols-outlined text-[18px]">play_arrow</span>
                        </button>
                        <div>
                            <h4 class="font-label text-xs font-bold text-text-primary">{{ $track->title }}</h4>
                            <p class="font-body text-[11px] text-text-muted">{{ $track->artist }} • {{ $track->category }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="font-label text-xs text-text-secondary">{{ $track->duration }}</span>
                        <span class="material-symbols-outlined text-text-muted text-[18px] cursor-pointer hover:text-text-primary">favorite_border</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<!-- Modal Configuración Sincronización Spotify Web API -->
<div id="spotify-sync-modal" class="fixed inset-0 z-50 bg-text-primary/40 backdrop-blur-sm hidden items-center justify-center p-4">
    <div class="bg-surface-card rounded-2xl border border-border-subtle shadow-2xl w-full max-w-md p-6 animate-in fade-in zoom-in-95 duration-200">
        <div class="flex items-center justify-between pb-3 border-b border-border-subtle">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white flex items-center justify-center">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.66 0 12 0zm5.521 17.34c-.24.359-.66.48-1.021.24-2.82-1.74-6.36-2.101-10.561-1.141-.418.122-.779-.179-.899-.539-.12-.421.18-.78.54-.9 4.56-1.021 8.52-.6 11.64 1.32.42.18.479.659.301 1.02zm1.44-3.3c-.301.42-.841.6-1.262.3-3.239-1.98-8.159-2.58-11.939-1.38-.479.12-1.02-.12-1.14-.6-.12-.48.12-1.021.6-1.141C9.6 9.9 15 10.561 18.72 12.84c.361.181.54.78.241 1.2zm.12-3.36C15.24 8.4 8.82 8.16 5.16 9.301c-.6.179-1.2-.181-1.38-.721-.18-.601.18-1.2.72-1.381 4.26-1.26 11.28-1.02 15.721 1.621.539.3.719 1.02.419 1.56-.299.421-1.02.599-1.559.3z"/></svg>
                </div>
                <div>
                    <h3 class="font-headline text-lg font-bold text-text-primary">Sincronización Spotify</h3>
                    <p class="font-body text-xs text-text-muted">Conexión con tu reproductor en segundo plano</p>
                </div>
            </div>
            <button onclick="closeSpotifyAuthModal()" class="w-7 h-7 rounded-lg hover:bg-surface-container flex items-center justify-center text-text-muted hover:text-text-primary">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        <div class="mt-4 space-y-3.5 text-xs font-body text-text-secondary">
            <p>
                El reproductor embebido de Spotify ya se conecta a tu sesión abierta en el navegador. Si estás usando la aplicación de Spotify Desktop en tu ordenador, puedes abrirla directamente:
            </p>
            <div class="p-3 rounded-xl bg-surface-container-low border border-border-subtle flex items-center justify-between">
                <div>
                    <div class="font-label font-bold text-text-primary">Spotify Desktop Connect</div>
                    <div class="text-[11px] text-text-muted">Abre tu app instalada con control multimedia</div>
                </div>
                <button onclick="openSpotifyApp()" class="px-3 py-1.5 rounded-lg bg-emerald-600 text-white font-label font-semibold text-xs hover:bg-emerald-700">
                    Abrir App
                </button>
            </div>

            <div>
                <label class="block font-label text-xs font-semibold text-text-primary mb-1">Spotify User Access Token (Opcional):</label>
                <input type="text" id="spotify-api-token" placeholder="Bearer Token para consulta en vivo de canciones..."
                       class="w-full bg-surface-container-low border border-border-subtle rounded-xl px-3 py-2 font-mono text-xs text-text-primary focus:outline-none focus:ring-2 focus:ring-emerald-500">
            </div>

            <div class="flex items-center justify-end gap-2 pt-2">
                <button type="button" onclick="closeSpotifyAuthModal()" class="px-4 py-2 rounded-xl text-text-secondary hover:bg-surface-container font-label text-xs">Cerrar</button>
                <button type="button" onclick="saveSpotifyToken()" class="px-4 py-2 rounded-xl bg-emerald-600 text-white hover:bg-emerald-700 font-label text-xs font-semibold">Guardar Sincronización</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Audio engine for local procedural vault
    const audio = document.getElementById('audio-engine');
    let isPlaying = false;
    let activeService = 'spotify';

    // Switch between music providers
    function switchMusicService(service) {
        activeService = service;
        
        // Hide all panels
        document.querySelectorAll('.service-content-panel').forEach(p => p.classList.add('hidden'));
        document.querySelectorAll('.service-tab-btn').forEach(btn => {
            btn.classList.remove('bg-accent-indigo', 'text-white', 'shadow-xs', 'font-semibold');
            btn.classList.add('text-text-secondary', 'font-medium');
        });

        // Show active panel & update tab
        const panel = document.getElementById(`service-panel-${service}`);
        const tab = document.getElementById(`tab-tab-${service}`) || document.getElementById(`tab-${service}`);
        if (panel) panel.classList.remove('hidden');
        if (tab) {
            tab.classList.add('bg-accent-indigo', 'text-white', 'shadow-xs', 'font-semibold');
            tab.classList.remove('text-text-secondary', 'font-medium');
        }

        // Pause local audio if switching away from vault
        if (service !== 'vault' && audio && isPlaying) {
            togglePlayback();
        }

        localStorage.setItem('codice_preferred_music_service', service);
        showToast(`Servicio activo: ${service.toUpperCase()}`);
    }

    // Convert Spotify Links to Embeddable URLs
    function formatSpotifyEmbed(url) {
        if (!url) return null;
        const clean = url.trim();
        // Check if already an embed
        if (clean.includes('/embed/')) return clean;

        // Matches playlist, track, album, episode, artist
        const match = clean.match(/open\.spotify\.com\/(playlist|track|album|episode|show|artist)\/([a-zA-Z0-9]+)/);
        if (match) {
            return `https://open.spotify.com/embed/${match[1]}/${match[2]}?utm_source=generator&theme=0`;
        }

        // Matches URI format spotify:track:id or spotify:playlist:id
        const uriMatch = clean.match(/spotify:(playlist|track|album|episode):([a-zA-Z0-9]+)/);
        if (uriMatch) {
            return `https://open.spotify.com/embed/${uriMatch[1]}/${uriMatch[2]}?utm_source=generator&theme=0`;
        }

        return clean;
    }

    function loadCustomSpotifyUrl() {
        const input = document.getElementById('spotify-input-url');
        const url = input.value;
        if (!url) {
            showToast('Por favor pega un enlace de Spotify válido', 'error');
            return;
        }

        const embedUrl = formatSpotifyEmbed(url);
        const iframe = document.getElementById('spotify-embed-frame');
        if (iframe && embedUrl) {
            iframe.src = embedUrl;
            localStorage.setItem('codice_spotify_custom_url', embedUrl);
            showToast('Reproductor de Spotify conectado con éxito', 'success');
        }
    }

    function loadSpotifyPreset(id, title) {
        const embedUrl = `https://open.spotify.com/embed/playlist/${id}?utm_source=generator&theme=0`;
        const iframe = document.getElementById('spotify-embed-frame');
        if (iframe) {
            iframe.src = embedUrl;
            showToast(`Cargada playlist: ${title}`);
        }
    }

    function openSpotifyApp() {
        window.location.href = 'spotify:';
        setTimeout(() => {
            showToast('Intentando abrir tu app de Spotify instalada...');
        }, 300);
    }

    function openSpotifyAuthModal() {
        const modal = document.getElementById('spotify-sync-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeSpotifyAuthModal() {
        const modal = document.getElementById('spotify-sync-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function saveSpotifyToken() {
        const token = document.getElementById('spotify-api-token').value;
        if (token) {
            localStorage.setItem('codice_spotify_api_token', token);
            showToast('Token de Spotify sincronizado', 'success');
        }
        closeSpotifyAuthModal();
    }

    // YouTube Music Functions
    function formatYouTubeEmbed(url) {
        if (!url) return null;
        let videoId = '';
        if (url.includes('youtu.be/')) {
            videoId = url.split('youtu.be/')[1].split('?')[0];
        } else if (url.includes('watch?v=')) {
            videoId = url.split('watch?v=')[1].split('&')[0];
        } else if (url.includes('embed/')) {
            return url;
        }
        return videoId ? `https://www.youtube-nocookie.com/embed/${videoId}?autoplay=1` : null;
    }

    function loadCustomYouTubeUrl() {
        const input = document.getElementById('youtube-input-url');
        const url = input.value;
        const embed = formatYouTubeEmbed(url);
        if (embed) {
            document.getElementById('youtube-embed-frame').src = embed;
            showToast('Video de YouTube conectado', 'success');
        } else {
            showToast('Enlace de YouTube no reconocido', 'error');
        }
    }

    function loadYouTubePreset(id, title) {
        document.getElementById('youtube-embed-frame').src = `https://www.youtube-nocookie.com/embed/${id}?autoplay=1`;
        showToast(`Reproduciendo: ${title}`);
    }

    // Apple Music Functions
    function loadCustomAppleMusicUrl() {
        const input = document.getElementById('apple-input-url');
        let url = input.value.trim();
        if (url && !url.includes('embed.music.apple.com')) {
            url = url.replace('music.apple.com', 'embed.music.apple.com');
        }
        if (url) {
            document.getElementById('apple-embed-frame').src = url;
            showToast('Apple Music conectado', 'success');
        }
    }

    // Local Vault Audio Engine Controls
    function togglePlayback() {
        if (!audio) return;
        if (isPlaying) {
            audio.pause();
            isPlaying = false;
            document.getElementById('master-play-icon').textContent = 'play_arrow';
            showToast('Audio pausado');
        } else {
            audio.play().then(() => {
                isPlaying = true;
                document.getElementById('master-play-icon').textContent = 'pause';
                showToast('Reproduciendo pista ambiental');
            }).catch(e => {
                showToast('Haz click para permitir reproducción de audio', 'error');
            });
        }
    }

    function playTrack(title, artist, url, duration) {
        document.getElementById('player-title').textContent = title;
        document.getElementById('player-artist').textContent = `${artist} · Bóveda de Sonido`;
        document.getElementById('player-total-time').textContent = duration;
        if (url) {
            audio.src = url;
            audio.play().then(() => {
                isPlaying = true;
                document.getElementById('master-play-icon').textContent = 'pause';
                showToast(`Reproduciendo: ${title}`);
            });
        }
    }

    function adjustVolume(val) {
        if (audio) audio.volume = val / 100;
    }

    function seekWaveform(e) {
        const rect = e.currentTarget.getBoundingClientRect();
        const pos = (e.clientX - rect.left) / rect.width;
        document.getElementById('waveform-progress').style.width = `${pos * 100}%`;
        if (audio && audio.duration) {
            audio.currentTime = audio.duration * pos;
        }
    }

    audio?.addEventListener('timeupdate', () => {
        if (!audio.duration) return;
        const pct = (audio.currentTime / audio.duration) * 100;
        document.getElementById('waveform-progress').style.width = `${pct}%`;
        const mins = Math.floor(audio.currentTime / 60);
        const secs = Math.floor(audio.currentTime % 60).toString().padStart(2, '0');
        document.getElementById('player-current-time').textContent = `${mins}:${secs}`;
    });

    // Native Browser Media Session API Integration
    if ('mediaSession' in navigator) {
        navigator.mediaSession.metadata = new MediaMetadata({
            title: 'Atmósfera de Escritura: Estudio Cóice',
            artist: 'Kowloon Echoes',
            album: 'Crónicas de Neo-Kyoto',
            artwork: [
                { src: 'https://images.unsplash.com/photo-1518709268805-4e9042af9f23?w=512', sizes: '512x512', type: 'image/jpeg' }
            ]
        });

        navigator.mediaSession.setActionHandler('play', () => {
            if (activeService === 'vault') togglePlayback();
        });
        navigator.mediaSession.setActionHandler('pause', () => {
            if (activeService === 'vault') togglePlayback();
        });
    }

    // Restore saved user preferences
    document.addEventListener('DOMContentLoaded', () => {
        const savedService = localStorage.getItem('codice_preferred_music_service');
        if (savedService && ['spotify', 'youtube', 'apple', 'vault'].includes(savedService)) {
            switchMusicService(savedService);
        }

        const savedSpotifyUrl = localStorage.getItem('codice_spotify_custom_url');
        if (savedSpotifyUrl) {
            const frame = document.getElementById('spotify-embed-frame');
            if (frame) frame.src = savedSpotifyUrl;
        }
    });

    function copyExcerpt(text) {
        navigator.clipboard.writeText(text);
        showToast('Extracto copiado al portapapeles');
    }
</script>
@endpush
