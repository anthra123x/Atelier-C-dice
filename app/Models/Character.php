<?php

namespace App\Models;

use Database\Factories\CharacterFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Character extends Model
{
    /** @use HasFactory<CharacterFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'universe_id',
        'location_id',
        'audio_track_id',
        'code',
        'name',
        'role',
        'status',
        'quote',
        'bio',
        'portrait_url',
        'gallery_urls',
        'traits',
        'palette',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'gallery_urls' => 'array',
            'traits' => 'array',
            'palette' => 'array',
        ];
    }

    /**
     * Get the universe that owns the character.
     */
    public function universe(): BelongsTo
    {
        return $this->belongsTo(Universe::class);
    }

    /**
     * Get associated location.
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Get associated theme audio track.
     */
    public function audioTrack(): BelongsTo
    {
        return $this->belongsTo(AudioTrack::class);
    }
}
