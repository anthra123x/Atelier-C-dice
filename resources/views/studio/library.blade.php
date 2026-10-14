@extends('layouts.studio')

@section('title', 'Biblioteca de Recursos y Playlists - Estudio Códice')
@section('view_label', 'Biblioteca & Playlists')

@section('content')
<div class="max-w-[1440px] w-full mx-auto px-6 py-8 select-none space-y-8">

    <!-- Master Ambient Music Player & Waveform Deck -->
    <div class="bg-surface-card rounded-2xl border border-border-subtle shadow-md p-6 relative overflow-hidden">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            
            <!-- Track Info & Artwork -->
            <div class="flex items-center gap-4 min-w-[280px]">
                <div class="w-16 h-16 rounded-xl bg-accent-indigo text-white flex items-center justify-center flex-shrink-0 shadow-md">
                    <span class="material-symbols-outlined text-[32px]">graphic_eq</span>
                </div>
                <div>
                    <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 font-label text-[10px] font-bold uppercase">Reproduciendo</span>
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
                        <!-- SVG Graphic Waveform Bars -->
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
    </div>

    <!-- Hidden HTML5 Audio Element -->
    <audio id="audio-engine" src="https://cdn.pixabay.com/download/audio/2022/05/27/audio_1808fbf07a.mp3?filename=rain-and-nostalgia-ambient-112959.mp3" loop></audio>

    <!-- Compendium & Library Documents -->
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
                        <button onclick="playTrack('{{ $track->title }}', '{{ $track->artist }}', '{{ $track->audio_url }}', '{{ $track->duration }}')"
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
@endsection

@push('scripts')
<script>
    const audio = document.getElementById('audio-engine');
    let isPlaying = false;

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

    function copyExcerpt(text) {
        navigator.clipboard.writeText(text);
        showToast('Extracto copiado al portapapeles');
    }
</script>
@endpush
