<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Board;
use App\Models\Universe;
use App\Services\CanvasService;
use App\Services\UniverseService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudioController extends Controller
{
    public function __construct(
        protected UniverseService $universeService,
        protected CanvasService $canvasService
    ) {}

    /**
     * Resolve the active universe for the authenticated user or fallback.
     */
    protected function resolveCurrentUniverse(): Universe
    {
        if (Auth::check()) {
            $userUniverse = Universe::query()
                ->with(['collaborators', 'boards'])
                ->where('user_id', Auth::id())
                ->first();

            if ($userUniverse) {
                return $userUniverse;
            }
        }

        return Universe::query()
            ->with(['collaborators', 'boards'])
            ->where('slug', 'cronicas-de-neo-kyoto')
            ->first() ?? Universe::query()->with(['collaborators', 'boards'])->firstOrFail();
    }

    /**
     * Show the main interactive Creative Canvas (Lienzo Creativo).
     */
    public function canvas(Request $request): View
    {
        $universe = $this->resolveCurrentUniverse();
        $board = Board::query()
            ->with(['nodes', 'connections.sourceNode', 'connections.targetNode'])
            ->where('universe_id', $universe->id)
            ->where('is_active', true)
            ->first() ?? Board::query()->firstOrFail();

        return view('studio.canvas', [
            'universe' => $universe,
            'board' => $board,
            'collaborators' => $universe->collaborators,
            'currentModule' => 'canvas',
        ]);
    }

    /**
     * Show Characters Dossiers and Moodboards (Fichas de Personajes y Moodboards).
     */
    public function characters(Request $request): View
    {
        $universe = $this->resolveCurrentUniverse();
        $search = $request->query('search');
        $characters = $this->universeService->listCharacters($universe->id, is_string($search) ? $search : null);
        $locations = $this->universeService->listLocations($universe->id);
        $audioTracks = $this->universeService->listAudioTracks($universe->id);

        return view('studio.characters', [
            'universe' => $universe,
            'characters' => $characters,
            'locations' => $locations,
            'audioTracks' => $audioTracks,
            'collaborators' => $universe->collaborators,
            'currentModule' => 'characters',
            'search' => $search,
        ]);
    }

    /**
     * Show Maps, Cartography & Pins (Mapas y Locaciones con Point Marks).
     */
    public function maps(Request $request): View
    {
        $universe = $this->resolveCurrentUniverse();
        $sector = $request->query('sector');
        $locations = $this->universeService->listLocations($universe->id, is_string($sector) ? $sector : null);

        $sectors = [
            'Sector 01 · Perímetro Militar',
            'Sector 02 · Alta Jerarquía',
            'Sector 03 · Bazares y Tráfico',
            'Sector 04 · Hangares y Contrabando',
            'Sector 00 · Terreno Inundado',
        ];

        return view('studio.maps', [
            'universe' => $universe,
            'locations' => $locations,
            'sectors' => $sectors,
            'selectedSector' => $sector,
            'collaborators' => $universe->collaborators,
            'currentModule' => 'maps',
        ]);
    }

    /**
     * Show Library, Compendium & Playlists (Biblioteca de Recursos y Playlists).
     */
    public function library(Request $request): View
    {
        $universe = $this->resolveCurrentUniverse();
        $category = $request->query('category');
        $libraryItems = $this->universeService->listLibraryItems($universe->id, is_string($category) ? $category : null);
        $audioTracks = $this->universeService->listAudioTracks($universe->id);

        $categories = [
            'Todos',
            'Lore & Documentos',
            'Leyes & Manuscritos',
            'Señales & Audio',
        ];

        return view('studio.library', [
            'universe' => $universe,
            'libraryItems' => $libraryItems,
            'audioTracks' => $audioTracks,
            'categories' => $categories,
            'selectedCategory' => $category ?? 'Todos',
            'collaborators' => $universe->collaborators,
            'currentModule' => 'library',
        ]);
    }
}
