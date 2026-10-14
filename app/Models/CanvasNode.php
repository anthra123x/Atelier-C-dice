<?php

namespace App\Models;

use Database\Factories\CanvasNodeFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CanvasNode extends Model
{
    /** @use HasFactory<CanvasNodeFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'board_id',
        'type',
        'title',
        'pos_x',
        'pos_y',
        'width',
        'height',
        'is_pinned',
        'data',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'pos_x' => 'float',
            'pos_y' => 'float',
            'width' => 'integer',
            'height' => 'integer',
            'is_pinned' => 'boolean',
            'data' => 'array',
        ];
    }

    /**
     * Get the board that owns the node.
     */
    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class);
    }

    /**
     * Outgoing connections from this node.
     */
    public function outgoingConnections(): HasMany
    {
        return $this->hasMany(CanvasConnection::class, 'source_node_id');
    }

    /**
     * Incoming connections to this node.
     */
    public function incomingConnections(): HasMany
    {
        return $this->hasMany(CanvasConnection::class, 'target_node_id');
    }
}
