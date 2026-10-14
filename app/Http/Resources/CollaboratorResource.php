<?php

namespace App\Http\Resources;

use App\Models\Collaborator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Collaborator
 */
class CollaboratorResource extends JsonResource
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
            'initials' => $this->initials,
            'role' => $this->role,
            'color' => $this->color,
            'avatar_url' => $this->avatar_url,
            'is_online' => (bool) $this->is_online,
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
