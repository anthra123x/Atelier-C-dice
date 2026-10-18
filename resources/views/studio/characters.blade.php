@extends('layouts.studio')

@section('title', 'Fichas de Personajes y Moodboards - Estudio Cóice')
@section('view_label', 'Fichas de Personajes')

@section('content')
<div class="max-w-[1440px] w-full mx-auto px-6 py-8 select-none">
    
    <!-- Top Action Bar -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="font-headline text-3xl font-bold text-text-primary tracking-tight">Fichas de Personajes &amp; Moodboards</h1>
            <p class="font-body text-xs text-text-secondary mt-1">Dossiers narrativos, paletas de arte, citas y estética visual de los habitantes de Neo-Kyoto.</p>
        </div>

        <div class="flex items-center gap-3">
            <!-- Search input -->
            <form action="{{ route('studio.characters') }}" method="GET" class="relative">
                <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Buscar por nombre, rol o ID..."
                       class="pl-9 pr-4 py-2 rounded-xl bg-surface-card border border-border-subtle font-body text-xs text-text-primary placeholder:text-text-muted focus:outline-none focus:ring-2 focus:ring-accent-indigo shadow-sm w-64">
                <span class="material-symbols-outlined absolute left-2.5 top-2 text-text-muted text-[18px]">search</span>
            </form>

            <button onclick="openCharacterModal()" class="flex items-center gap-1.5 px-4 py-2 rounded-xl bg-accent-indigo text-white hover:bg-accent-indigo-hover font-label text-xs font-semibold shadow-md transition-all">
                <span class="material-symbols-outlined text-[18px]">add</span>
                <span>Nuevo Personaje</span>
            </button>
        </div>
    </div>

    <!-- Characters Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($characters as $character)
            <article class="bg-surface-card rounded-2xl border border-border-subtle shadow-[0_4px_16px_rgba(15,23,42,0.04)] hover:shadow-[0_12px_28px_rgba(15,23,42,0.1)] transition-all duration-300 group relative flex flex-col overflow-hidden">
                
                <!-- Floating Hover HUD -->
                <div class="absolute top-3 right-3 z-20 flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity frosted-glass px-2 py-1 rounded-xl shadow-md border border-border-subtle">
                    <button class="p-1 hover:text-accent-indigo text-text-muted transition-colors" title="Fijar"><span class="material-symbols-outlined text-[16px]">push_pin</span></button>
                    <button class="p-1 hover:text-accent-amber text-text-muted transition-colors" title="Destacar"><span class="material-symbols-outlined text-[16px]">star</span></button>
                    <button class="p-1 hover:text-text-primary text-text-muted transition-colors" title="Editar"><span class="material-symbols-outlined text-[16px]">edit</span></button>
                </div>

                <div class="p-5 flex flex-col gap-4">
                    <!-- Identity Header -->
                    <div class="flex items-start justify-between">
                        <div>
                            @if($character->code)
                                <span class="px-2 py-0.5 rounded-full bg-surface-container-high text-accent-indigo font-label text-[10px] font-bold tracking-wider uppercase border border-border-subtle">{{ $character->code }}</span>
                            @endif
                            <h2 class="font-headline text-2xl text-text-primary font-bold mt-1 leading-tight">{{ $character->name }}</h2>
                            <p class="font-body text-xs text-text-secondary mt-0.5">{{ $character->role }}</p>
                        </div>
                        <div class="w-10 h-10 rounded-xl bg-surface-container-low border border-border-subtle flex items-center justify-center text-accent-indigo">
                            <span class="material-symbols-outlined text-[20px]">badge</span>
                        </div>
                    </div>

                    <!-- Moodboard Collage Layout -->
                    @if(!empty($character->gallery_urls) && count($character->gallery_urls) > 1)
                        <div class="grid grid-cols-2 gap-2">
                            <div class="col-span-1 rounded-xl overflow-hidden h-44 bg-surface-container">
                                <img src="{{ $character->portrait_url ?? $character->gallery_urls[0] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="{{ $character->name }}">
                            </div>
                            <div class="col-span-1 flex flex-col gap-2">
                                <div class="rounded-xl overflow-hidden h-[84px] bg-surface-container">
                                    <img src="{{ $character->gallery_urls[1] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Moodboard 1">
                                </div>
                                <div class="rounded-xl overflow-hidden h-[84px] bg-surface-container">
                                    <img src="{{ $character->gallery_urls[2] ?? $character->gallery_urls[0] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Moodboard 2">
                                </div>
                            </div>
                        </div>
                    @elseif($character->portrait_url)
                        <div class="rounded-xl overflow-hidden h-48 bg-surface-container shadow-sm">
                            <img src="{{ $character->portrait_url }}" class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500" alt="{{ $character->name }}">
                        </div>
                    @endif

                    <!-- Quote Block -->
                    @if($character->quote)
                        <blockquote class="bg-surface-container-low p-3 rounded-xl font-headline italic text-xs text-text-secondary border-l-2 border-accent-terracotta leading-relaxed">
                            “{{ $character->quote }}”
                        </blockquote>
                    @endif

                    <!-- Traits Chips -->
                    @if(!empty($character->traits))
                        <div class="flex flex-wrap gap-1.5">
                            @foreach($character->traits as $trait)
                                <span class="px-2.5 py-0.5 rounded-full bg-surface-container-high text-text-primary font-label text-[11px] font-medium border border-border-subtle">{{ $trait }}</span>
                            @endforeach
                        </div>
                    @endif

                    <!-- Palette Swatches -->
                    @if(!empty($character->palette))
                        <div class="flex items-center justify-between pt-2 border-t border-border-subtle/60">
                            <span class="font-label text-[10px] text-text-muted uppercase font-bold tracking-wider">Paleta de Referencia</span>
                            <div class="flex items-center -space-x-1">
                                @foreach($character->palette as $hex)
                                    <div class="w-4 h-4 rounded-full ring-2 ring-surface-card shadow-sm" style="background-color: {{ $hex }};" title="{{ $hex }}"></div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Audio Track Mini-Player -->
                    @if($character->audioTrack)
                        <div class="flex items-center justify-between p-2 rounded-xl bg-surface-container-low border border-border-subtle mt-1">
                            <div class="flex items-center gap-2">
                                <button class="w-7 h-7 rounded-full bg-accent-indigo text-white flex items-center justify-center hover:scale-105 transition-transform shadow-sm">
                                    <span class="material-symbols-outlined text-[16px]">play_arrow</span>
                                </button>
                                <div class="flex flex-col">
                                    <span class="font-label text-xs font-bold text-text-primary leading-tight">{{ $character->audioTrack->title }}</span>
                                    <span class="font-body text-[10px] text-text-secondary leading-none">{{ $character->audioTrack->duration }} • {{ $character->audioTrack->category }}</span>
                                </div>
                            </div>
                            <div class="flex items-end gap-0.5 h-3.5 pr-1">
                                <div class="w-0.5 h-2 bg-accent-indigo rounded-full"></div>
                                <div class="w-0.5 h-3.5 bg-accent-indigo rounded-full"></div>
                                <div class="w-0.5 h-1.5 bg-accent-indigo rounded-full"></div>
                                <div class="w-0.5 h-3 bg-accent-indigo rounded-full"></div>
                            </div>
                        </div>
                    @endif
                </div>
            </article>
        @empty
            <div class="col-span-full py-16 text-center">
                <span class="material-symbols-outlined text-4xl text-text-muted mb-2">person_search</span>
                <p class="font-headline text-lg text-text-primary font-bold">No se encontraron personajes</p>
                <p class="font-body text-xs text-text-secondary mt-1">Prueba con otro término de búsqueda o crea una nueva ficha.</p>
            </div>
        @endforelse
    </div>
</div>

<!-- Modal Crear Personaje -->
<div id="character-modal" class="fixed inset-0 z-50 bg-text-primary/40 backdrop-blur-sm hidden items-center justify-center p-4">
    <div class="bg-surface-card rounded-2xl border border-border-subtle shadow-2xl w-full max-w-lg p-6 animate-in fade-in zoom-in-95 duration-200">
        <div class="flex items-center justify-between pb-3 border-b border-border-subtle">
            <h3 class="font-headline text-lg font-bold text-text-primary">Crear Ficha de Personaje</h3>
            <button onclick="closeCharacterModal()" class="w-7 h-7 rounded-lg hover:bg-surface-container-high flex items-center justify-center text-text-muted hover:text-text-primary">
                <span class="material-symbols-outlined text-[20px]">close</span>
            </button>
        </div>

        <form onsubmit="handleCreateCharacter(event)" class="mt-4 space-y-3.5">
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block font-label text-xs font-semibold text-text-secondary mb-1">Nombre Completo</label>
                    <input type="text" id="char-name" required placeholder="Ej. Soran Kurogane"
                           class="w-full bg-surface-container-low border border-border-subtle rounded-xl px-3 py-2 font-body text-xs text-text-primary focus:outline-none focus:ring-2 focus:ring-accent-indigo">
                </div>
                <div>
                    <label class="block font-label text-xs font-semibold text-text-secondary mb-1">Código / ID</label>
                    <input type="text" id="char-code" placeholder="Ej. NEO-8801"
                           class="w-full bg-surface-container-low border border-border-subtle rounded-xl px-3 py-2 font-body text-xs text-text-primary focus:outline-none focus:ring-2 focus:ring-accent-indigo">
                </div>
            </div>

            <div>
                <label class="block font-label text-xs font-semibold text-text-secondary mb-1">Rol / Arquetipo</label>
                <input type="text" id="char-role" required placeholder="Ej. Corredor de Información & Hacker"
                       class="w-full bg-surface-container-low border border-border-subtle rounded-xl px-3 py-2 font-body text-xs text-text-primary focus:outline-none focus:ring-2 focus:ring-accent-indigo">
            </div>

            <div>
                <label class="block font-label text-xs font-semibold text-text-secondary mb-1">Cita Característica</label>
                <input type="text" id="char-quote" placeholder="Ej. Todo tiene un precio en megabytes."
                       class="w-full bg-surface-container-low border border-border-subtle rounded-xl px-3 py-2 font-body text-xs text-text-primary focus:outline-none focus:ring-2 focus:ring-accent-indigo">
            </div>

            <div>
                <label class="block font-label text-xs font-semibold text-text-secondary mb-1">Rasgos (separados por coma)</label>
                <input type="text" id="char-traits" placeholder="Criptografía, Redes Oscuras, Sigilo"
                       class="w-full bg-surface-container-low border border-border-subtle rounded-xl px-3 py-2 font-body text-xs text-text-primary focus:outline-none focus:ring-2 focus:ring-accent-indigo">
            </div>

            <div class="flex items-center justify-end gap-2 pt-3">
                <button type="button" onclick="closeCharacterModal()" class="px-4 py-2 rounded-xl text-text-secondary hover:bg-surface-container font-label text-xs">Cancelar</button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-accent-indigo text-white hover:bg-accent-indigo-hover font-label text-xs font-semibold shadow-md">Guardar Personaje</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const universeId = {{ $universe->id }};
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    function openCharacterModal() {
        const modal = document.getElementById('character-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeCharacterModal() {
        const modal = document.getElementById('character-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    async function handleCreateCharacter(e) {
        e.preventDefault();
        const name = document.getElementById('char-name').value;
        const code = document.getElementById('char-code').value;
        const role = document.getElementById('char-role').value;
        const quote = document.getElementById('char-quote').value;
        const traitsRaw = document.getElementById('char-traits').value;
        const traits = traitsRaw ? traitsRaw.split(',').map(t => t.trim()) : [];

        try {
            const res = await fetch(`/api/v1/universes/${universeId}/characters`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    name: name,
                    code: code,
                    role: role,
                    quote: quote,
                    traits: traits,
                    palette: ['#000000', '#F59E0B', '#64748B']
                })
            });

            if (res.ok) {
                closeCharacterModal();
                showToast('Personaje creado en PostgreSQL Neon', 'success');
                setTimeout(() => location.reload(), 600);
            }
        } catch (err) {
            console.error('Error creating character:', err);
        }
    }
</script>
@endpush
