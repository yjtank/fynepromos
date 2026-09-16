<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'website',
        'active'
    ];

    protected function casts(): array {
        return [
            'active' => 'boolean'
        ];
    }

    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class);
    }
}
