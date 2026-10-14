<?php

namespace App\Http\Resources;

use App\Models\CanvasConnection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin CanvasConnection
 */
class CanvasConnectionResource extends JsonResource
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
            'board_id' => $this->board_id,
            'source_node_id' => $this->source_node_id,
            'target_node_id' => $this->target_node_id,
            'label' => $this->label,
            'badge_icon' => $this->badge_icon,
            'curvature' => $this->curvature,
            'color' => $this->color,
            'source_node' => new CanvasNodeResource($this->whenLoaded('sourceNode')),
            'target_node' => new CanvasNodeResource($this->whenLoaded('targetNode')),
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
