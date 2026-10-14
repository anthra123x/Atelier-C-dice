<?php

namespace App\Http\Resources;

use App\Models\LibraryItem;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin LibraryItem
 */
class LibraryItemResource extends JsonResource
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
            'category' => $this->category,
            'author' => $this->author,
            'content' => $this->content,
            'tags' => $this->tags ?? [],
            'file_url' => $this->file_url,
            'file_type' => $this->file_type,
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
