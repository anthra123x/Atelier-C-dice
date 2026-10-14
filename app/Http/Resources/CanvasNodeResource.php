<?php

namespace App\Http\Resources;

use App\Models\CanvasNode;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin CanvasNode
 */
class CanvasNodeResource extends JsonResource
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
            'type' => $this->type,
            'title' => $this->title,
            'pos_x' => (float) $this->pos_x,
            'pos_y' => (float) $this->pos_y,
            'width' => (int) $this->width,
            'height' => $this->height ? (int) $this->height : null,
            'is_pinned' => (bool) $this->is_pinned,
            'data' => $this->data ?? [],
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
