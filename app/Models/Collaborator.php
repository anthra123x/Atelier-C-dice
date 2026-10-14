<?php

namespace App\Models;

use Database\Factories\CollaboratorFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Collaborator extends Model
{
    /** @use HasFactory<CollaboratorFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'universe_id',
        'name',
        'initials',
        'role',
        'color',
        'avatar_url',
        'is_online',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_online' => 'boolean',
        ];
    }

    /**
     * Get the universe that owns the collaborator.
     */
    public function universe(): BelongsTo
    {
        return $this->belongsTo(Universe::class);
    }
}
