<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'store_id', 'title', 'slug', 'description', 'image_url',
        'current_price', 'old_price', 'installment_info', 'installment_count',
        'installment_is_interest_free', 'coupon', 'purchase_url',
        'expires_at', 'is_featured', 'is_active',
        'clicks_count',
    ];

    protected function casts(): array
    {
        return [
            'current_price' => 'decimal:2',
            'old_price' => 'decimal:2',
            'expires_at' => 'datetime',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'installment_count' => 'integer',
            'installment_is_interest_free' => 'boolean',
            'clicks_count' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function collections(): BelongsToMany
    {
        return $this->belongsToMany(Collection::class, 'collection_offer')
            ->withPivot('position');
    }

    public function isExpired(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }
}
