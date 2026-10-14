<?php

namespace App\Http\Resources;

use App\Models\Universe;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Universe
 */
class UniverseResource extends JsonResource
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
            'title' => $this->title,
            'slug' => $this->slug,
            'tagline' => $this->tagline,
            'description' => $this->description,
            'settings' => $this->settings,
            'boards' => BoardResource::collection($this->whenLoaded('boards')),
            'characters' => CharacterResource::collection($this->whenLoaded('characters')),
            'locations' => LocationResource::collection($this->whenLoaded('locations')),
            'audio_tracks' => AudioTrackResource::collection($this->whenLoaded('audioTracks')),
            'collaborators' => CollaboratorResource::collection($this->whenLoaded('collaborators')),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
