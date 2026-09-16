<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'store_id', 'title', 'slug', 'description', 'image_url',
        'current_price', 'old_price', 'installment_info', 'coupon', 'purchase_url',
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

    public function isExpired(): bool
    {
        return $this->expires_at !== null && $this->expires_at->isPast();
    }
}
