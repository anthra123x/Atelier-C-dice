<?php

namespace App\Models;

use Database\Factories\UniverseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Universe extends Model
{
    /** @use HasFactory<UniverseFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'slug',
        'tagline',
        'description',
        'settings',
    ];

    /**
     * Get the user that owns the universe.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'settings' => 'array',
        ];
    }

    /**
     * Get all boards for the universe.
     */
    public function boards(): HasMany
    {
        return $this->hasMany(Board::class);
    }

    /**
     * Get all characters for the universe.
     */
    public function characters(): HasMany
    {
        return $this->hasMany(Character::class);
    }

    /**
     * Get all locations for the universe.
     */
    public function locations(): HasMany
    {
        return $this->hasMany(Location::class);
    }

    /**
     * Get all audio tracks for the universe.
     */
    public function audioTracks(): HasMany
    {
        return $this->hasMany(AudioTrack::class);
    }

    /**
     * Get all library items for the universe.
     */
    public function libraryItems(): HasMany
    {
        return $this->hasMany(LibraryItem::class);
    }

    /**
     * Get all active collaborators for the universe.
     */
    public function collaborators(): HasMany
    {
        return $this->hasMany(Collaborator::class);
    }
}
