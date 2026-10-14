<?php

namespace App\Http\Resources;

use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Character
 */
class CharacterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'universe_id' => $this->universe_id,
            'location_id' => $this->location_id,
            'audio_track_id' => $this->audio_track_id,
            'code' => $this->code,
            'name' => $this->name,
            'role' => $this->role,
            'status' => $this->status,
            'quote' => $this->quote,
            'bio' => $this->bio,
            'portrait_url' => $this->portrait_url,
            'gallery_urls' => $this->gallery_urls ?? [],
            'traits' => $this->traits ?? [],
            'palette' => $this->palette ?? [],
            'location' => new LocationResource($this->whenLoaded('location')),
            'audio_track' => new AudioTrackResource($this->whenLoaded('audioTrack')),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
