<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price_kobo',
        'currency',
        'billing_cycle',
        'max_qr_codes',
        'max_file_uploads',
        'storage_limit_mb',
        'max_scans_per_month',
        'is_featured',
        'is_active',
        'features',
        'sort_order',
    ];

    protected $casts = [
        'features'    => 'array',
        'is_featured' => 'boolean',
        'is_active'   => 'boolean',
    ];

    // converts kobo to naira automatically
    public function getPriceNairaAttribute(): float
    {
        return $this->price_kobo / 100;
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}