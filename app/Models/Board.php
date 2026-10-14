<?php

namespace App\Models;

use Database\Factories\BoardFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Board extends Model
{
    /** @use HasFactory<BoardFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'universe_id',
        'title',
        'slug',
        'act',
        'is_active',
        'grid_snap_size',
        'zoom_level',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'grid_snap_size' => 'integer',
            'zoom_level' => 'integer',
        ];
    }

    /**
     * Get the universe that owns the board.
     */
    public function universe(): BelongsTo
    {
        return $this->belongsTo(Universe::class);
    }

    /**
     * Get the nodes on this board.
     */
    public function nodes(): HasMany
    {
        return $this->hasMany(CanvasNode::class);
    }

    /**
     * Get the connections on this board.
     */
    public function connections(): HasMany
    {
        return $this->hasMany(CanvasConnection::class);
    }
}
