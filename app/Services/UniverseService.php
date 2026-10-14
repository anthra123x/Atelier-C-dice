<?php

namespace App\Services;

use App\Models\AudioTrack;
use App\Models\Character;
use App\Models\LibraryItem;
use App\Models\Location;
use App\Models\Universe;
use Illuminate\Database\Eloquent\Collection;

class UniverseService
{
    /**
     * Get full universe overview with relationships.
     */
    public function getUniverseBySlug(string $slug): Universe
    {
        return Universe::query()
            ->with(['boards', 'collaborators', 'characters.location', 'locations', 'audioTracks'])
            ->where('slug', $slug)
            ->firstOrFail();
    }

    /**
     * List characters filtered by query.
     *
     * @return Collection<int, Character>
     */
    public function listCharacters(int $universeId, ?string $search = null): Collection
    {
        return Character::query()
            ->with(['location', 'audioTrack'])
            ->where('universe_id', $universeId)
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'ilike', "%{$search}%")
                        ->orWhere('role', 'ilike', "%{$search}%")
                        ->orWhere('code', 'ilike', "%{$search}%");
                });
            })
            ->orderBy('id')
            ->get();
    }

    /**
     * Create character.
     *
     * @param  array<string, mixed>  $data
     */
    public function createCharacter(int $universeId, array $data): Character
    {
        $data['universe_id'] = $universeId;

        return Character::query()->create($data);
    }

    /**
     * Update character.
     *
     * @param  array<string, mixed>  $data
     */
    public function updateCharacter(Character $character, array $data): Character
    {
        $character->update($data);

        return $character->fresh(['location', 'audioTrack']);
    }

    /**
     * List locations with optional sector filter.
     *
     * @return Collection<int, Location>
     */
    public function listLocations(int $universeId, ?string $sector = null): Collection
    {
        return Location::query()
            ->where('universe_id', $universeId)
            ->when($sector, fn ($q) => $q->where('sector', $sector))
            ->orderBy('id')
            ->get();
    }

    /**
     * Create location.
     *
     * @param  array<string, mixed>  $data
     */
    public function createLocation(int $universeId, array $data): Location
    {
        $data['universe_id'] = $universeId;

        return Location::query()->create($data);
    }

    /**
     * Update location.
     *
     * @param  array<string, mixed>  $data
     */
    public function updateLocation(Location $location, array $data): Location
    {
        $location->update($data);

        return $location->fresh();
    }

    /**
     * List audio tracks.
     *
     * @return Collection<int, AudioTrack>
     */
    public function listAudioTracks(int $universeId): Collection
    {
        return AudioTrack::query()
            ->where('universe_id', $universeId)
            ->orderBy('id')
            ->get();
    }

    /**
     * List library items.
     *
     * @return Collection<int, LibraryItem>
     */
    public function listLibraryItems(int $universeId, ?string $category = null): Collection
    {
        return LibraryItem::query()
            ->where('universe_id', $universeId)
            ->when($category, fn ($q) => $q->where('category', $category))
            ->orderBy('id')
            ->get();
    }
}
