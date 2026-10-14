<?php

namespace App\Http\Resources;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Location
 */
class LocationResource extends JsonResource
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
            'name' => $this->name,
            'code' => $this->code,
            'sector' => $this->sector,
            'icon' => $this->icon,
            'color' => $this->color,
            'map_x' => (float) $this->map_x,
            'map_y' => (float) $this->map_y,
            'status' => $this->status,
            'description' => $this->description,
            'intel' => $this->intel,
            'threat_level' => (int) $this->threat_level,
            'key_contacts' => $this->key_contacts ?? [],
            'image_url' => $this->image_url,
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
