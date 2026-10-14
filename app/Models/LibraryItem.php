<?php

namespace App\Models;

use Database\Factories\LibraryItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LibraryItem extends Model
{
    /** @use HasFactory<LibraryItemFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'universe_id',
        'title',
        'category',
        'author',
        'content',
        'tags',
        'file_url',
        'file_type',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tags' => 'array',
        ];
    }

    /**
     * Get the universe that owns the library item.
     */
    public function universe(): BelongsTo
    {
        return $this->belongsTo(Universe::class);
    }
}
