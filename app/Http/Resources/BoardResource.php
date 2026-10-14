<?php

namespace App\Http\Resources;

use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Board
 */
class BoardResource extends JsonResource
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
            'title' => $this->title,
            'slug' => $this->slug,
            'act' => $this->act,
            'is_active' => $this->is_active,
            'grid_snap_size' => $this->grid_snap_size,
            'zoom_level' => $this->zoom_level,
            'nodes' => CanvasNodeResource::collection($this->whenLoaded('nodes')),
            'connections' => CanvasConnectionResource::collection($this->whenLoaded('connections')),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
