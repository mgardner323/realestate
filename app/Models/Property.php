<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Scout\Searchable;

class Property extends Model
{
    use HasFactory, Searchable;
    protected $fillable = [
        'title',
        'description',
        'price',
        'location',
        'type',
        'is_featured',
        'mls_provider_id',
        'mls_listing_id',
        'raw_data',
        'last_synced_at',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_featured' => 'boolean',
        'raw_data' => 'json',
        'last_synced_at' => 'datetime',
    ];

    /**
     * Get the MLS provider that this property belongs to.
     */
    public function mlsProvider(): BelongsTo
    {
        return $this->belongsTo(MlsProvider::class);
    }

    /**
     * Get the indexable data array for the model.
     */
    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'location' => $this->location,
            'type' => $this->type,
            'price' => $this->price,
            'is_featured' => $this->is_featured,
            'mls_listing_id' => $this->mls_listing_id,
            'created_at' => $this->created_at?->timestamp,
            'updated_at' => $this->updated_at?->timestamp,
        ];
    }

    /**
     * Get the index name for the model.
     */
    public function searchableAs(): string
    {
        return 'properties';
    }

    /**
     * Determine if the model should be searchable.
     */
    public function shouldBeSearchable(): bool
    {
        return true;
    }
}
