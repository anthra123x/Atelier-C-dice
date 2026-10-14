<?php

namespace App\Models;

use Database\Factories\AudioTrackFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AudioTrack extends Model
{
    /** @use HasFactory<AudioTrackFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'universe_id',
        'title',
        'artist',
        'category',
        'duration',
        'audio_url',
        'waveform',
        'is_loop',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'waveform' => 'array',
            'is_loop' => 'boolean',
        ];
    }

    /**
     * Get the universe that owns the audio track.
     */
    public function universe(): BelongsTo
    {
        return $this->belongsTo(Universe::class);
    }

    /**
     * Get characters referencing this theme track.
     */
    public function characters(): HasMany
    {
        return $this->hasMany(Character::class);
    }
}
