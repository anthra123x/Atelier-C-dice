<?php

namespace App\Http\Resources;

use App\Models\AudioTrack;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin AudioTrack
 */
class AudioTrackResource extends JsonResource
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
            'artist' => $this->artist,
            'category' => $this->category,
            'duration' => $this->duration,
            'audio_url' => $this->audio_url,
            'waveform' => $this->waveform ?? [],
            'is_loop' => (bool) $this->is_loop,
            'created_at' => $this->created_at?->toIso8601String(),
            'updated_at' => $this->updated_at?->toIso8601String(),
        ];
    }
}
