<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Community extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'statistical_info',
        'monthly_events',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($community) {
            if (empty($community->slug)) {
                $community->slug = Str::slug($community->name);
            }
        });

        static::updating(function ($community) {
            if ($community->isDirty('name') && empty($community->slug)) {
                $community->slug = Str::slug($community->name);
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
