<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;

class Post extends Model
{
    use HasFactory, Searchable;
    
    protected $fillable = [
        'title',
        'slug',
        'body',
        'featured_image_url',
        'is_published',
        'category_id',
        'meta_title',
        'meta_description',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the indexable data array for the model.
     */
    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'body' => $this->body,
            'meta_title' => $this->meta_title,
            'meta_description' => $this->meta_description,
            'is_published' => $this->is_published,
            'category_id' => $this->category_id,
            'created_at' => $this->created_at?->timestamp,
            'updated_at' => $this->updated_at?->timestamp,
        ];
    }

    /**
     * Get the index name for the model.
     */
    public function searchableAs(): string
    {
        return 'posts';
    }

    /**
     * Determine if the model should be searchable.
     */
    public function shouldBeSearchable(): bool
    {
        return $this->is_published ?? true;
    }
}
