<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCharacterRequest;
use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateCharacterRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Http\Resources\AudioTrackResource;
use App\Http\Resources\CharacterResource;
use App\Http\Resources\LibraryItemResource;
use App\Http\Resources\LocationResource;
use App\Http\Resources\UniverseResource;
use App\Models\Character;
use App\Models\Location;
use App\Models\Universe;
use App\Services\UniverseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UniverseController extends Controller
{
    public function __construct(
        protected UniverseService $universeService
    ) {}

    /**
     * Show full universe metadata and overview.
     */
    public function show(string $slug): JsonResponse
    {
        $universe = $this->universeService->getUniverseBySlug($slug);

        return response()->json([
            'status' => 'success',
            'data' => new UniverseResource($universe),
        ]);
    }

    /**
     * List characters in this universe with optional search filter.
     */
    public function characters(Request $request, Universe $universe): JsonResponse
    {
        $search = $request->query('search');
        $characters = $this->universeService->listCharacters($universe->id, is_string($search) ? $search : null);

        return response()->json([
            'status' => 'success',
            'data' => CharacterResource::collection($characters),
        ]);
    }

    /**
     * Create a new character in this universe.
     */
    public function storeCharacter(StoreCharacterRequest $request, Universe $universe): JsonResponse
    {
        $character = $this->universeService->createCharacter($universe->id, $request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Ficha de personaje creada exitosamente.',
            'data' => new CharacterResource($character),
        ], 201);
    }

    /**
     * Update an existing character.
     */
    public function updateCharacter(UpdateCharacterRequest $request, Character $character): JsonResponse
    {
        $updated = $this->universeService->updateCharacter($character, $request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Ficha de personaje actualizada.',
            'data' => new CharacterResource($updated),
        ]);
    }

    /**
     * List map locations and pins.
     */
    public function locations(Request $request, Universe $universe): JsonResponse
    {
        $sector = $request->query('sector');
        $locations = $this->universeService->listLocations($universe->id, is_string($sector) ? $sector : null);

        return response()->json([
            'status' => 'success',
            'data' => LocationResource::collection($locations),
        ]);
    }

    /**
     * Store a new location pin.
     */
    public function storeLocation(StoreLocationRequest $request, Universe $universe): JsonResponse
    {
        $location = $this->universeService->createLocation($universe->id, $request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Locación registrada en la cartografía.',
            'data' => new LocationResource($location),
        ], 201);
    }

    /**
     * Update location details or coordinates.
     */
    public function updateLocation(UpdateLocationRequest $request, Location $location): JsonResponse
    {
        $updated = $this->universeService->updateLocation($location, $request->validated());

        return response()->json([
            'status' => 'success',
            'message' => 'Locación actualizada.',
            'data' => new LocationResource($updated),
        ]);
    }

    /**
     * List audio tracks.
     */
    public function audioTracks(Universe $universe): JsonResponse
    {
        $tracks = $this->universeService->listAudioTracks($universe->id);

        return response()->json([
            'status' => 'success',
            'data' => AudioTrackResource::collection($tracks),
        ]);
    }

    /**
     * List library documents and compendium items.
     */
    public function library(Request $request, Universe $universe): JsonResponse
    {
        $category = $request->query('category');
        $items = $this->universeService->listLibraryItems($universe->id, is_string($category) ? $category : null);

        return response()->json([
            'status' => 'success',
            'data' => LibraryItemResource::collection($items),
        ]);
    }
}
