<?php

use App\Http\Controllers\Api\AiController;
use App\Http\Controllers\Api\CanvasController;
use App\Http\Controllers\Api\UniverseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    // Universes & Compendium Endpoints
    Route::get('/universes/{slug}', [UniverseController::class, 'show'])->name('api.v1.universes.show');
    Route::get('/universes/{universe}/characters', [UniverseController::class, 'characters'])->name('api.v1.universes.characters');
    Route::post('/universes/{universe}/characters', [UniverseController::class, 'storeCharacter'])->name('api.v1.universes.characters.store');
    Route::put('/characters/{character}', [UniverseController::class, 'updateCharacter'])->name('api.v1.characters.update');

    Route::get('/universes/{universe}/locations', [UniverseController::class, 'locations'])->name('api.v1.universes.locations');
    Route::post('/universes/{universe}/locations', [UniverseController::class, 'storeLocation'])->name('api.v1.universes.locations.store');
    Route::put('/locations/{location}', [UniverseController::class, 'updateLocation'])->name('api.v1.locations.update');

    Route::get('/universes/{universe}/audio-tracks', [UniverseController::class, 'audioTracks'])->name('api.v1.universes.audio-tracks');
    Route::get('/universes/{universe}/library', [UniverseController::class, 'library'])->name('api.v1.universes.library');

    // Canvas & Spatial Board Endpoints
    Route::get('/boards/{board}', [CanvasController::class, 'show'])->name('api.v1.boards.show');
    Route::post('/boards/{board}/nodes', [CanvasController::class, 'storeNode'])->name('api.v1.boards.nodes.store');
    Route::put('/nodes/{node}', [CanvasController::class, 'updateNode'])->name('api.v1.nodes.update');
    Route::patch('/nodes/{node}/position', [CanvasController::class, 'updatePosition'])->name('api.v1.nodes.position.update');
    Route::delete('/nodes/{node}', [CanvasController::class, 'destroyNode'])->name('api.v1.nodes.destroy');

    Route::post('/boards/{board}/connections', [CanvasController::class, 'storeConnection'])->name('api.v1.boards.connections.store');
    Route::delete('/connections/{connection}', [CanvasController::class, 'destroyConnection'])->name('api.v1.connections.destroy');

    // AI Narrative Architect Endpoints
    Route::post('/ai/chat', [AiController::class, 'chat'])->name('api.v1.ai.chat');
    Route::post('/boards/{board}/ai/generate', [AiController::class, 'generateNode'])->name('api.v1.ai.generate');
});
