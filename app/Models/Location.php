<?php

namespace App\Models;

use Database\Factories\LocationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Location extends Model
{
    /** @use HasFactory<LocationFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'universe_id',
        'name',
        'code',
        'sector',
        'icon',
        'color',
        'map_x',
        'map_y',
        'status',
        'description',
        'intel',
        'threat_level',
        'key_contacts',
        'image_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'map_x' => 'float',
            'map_y' => 'float',
            'threat_level' => 'integer',
            'key_contacts' => 'array',
        ];
    }

    /**
     * Get the universe that owns the location.
     */
    public function universe(): BelongsTo
    {
        return $this->belongsTo(Universe::class);
    }

    /**
     * Get characters tied to this location.
     */
    public function characters(): HasMany
    {
        return $this->hasMany(Character::class);
    }
}
