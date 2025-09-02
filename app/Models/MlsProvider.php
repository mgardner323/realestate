<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MlsProvider extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'credentials',
        'is_active',
        'last_sync_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * We use the 'encrypted:json' cast for security. This requires that
     * your APP_KEY is properly set in your .env file.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'credentials' => 'encrypted:json', // Automatically encrypts/decrypts
        'is_active' => 'boolean',
        'last_sync_at' => 'datetime',
    ];

    /**
     * Get the properties associated with this MLS provider.
     */
    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }
}
