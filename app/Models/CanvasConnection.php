<?php

namespace App\Models;

use Database\Factories\CanvasConnectionFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CanvasConnection extends Model
{
    /** @use HasFactory<CanvasConnectionFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'board_id',
        'source_node_id',
        'target_node_id',
        'label',
        'badge_icon',
        'curvature',
        'color',
    ];

    /**
     * Get the board that owns the connection.
     */
    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class);
    }

    /**
     * Get the source node.
     */
    public function sourceNode(): BelongsTo
    {
        return $this->belongsTo(CanvasNode::class, 'source_node_id');
    }

    /**
     * Get the target node.
     */
    public function targetNode(): BelongsTo
    {
        return $this->belongsTo(CanvasNode::class, 'target_node_id');
    }
}
