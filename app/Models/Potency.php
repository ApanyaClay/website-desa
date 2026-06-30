<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Potency extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'category',
        'description',
        'cover_image',
        'contact_person',
        'price_range',
        'location',
    ];

    /**
     * Scope a query to only include potencies of a specific category.
     */
    public function scopeCategory(Builder $query, string $category): Builder
    {
        return $query->where('category', $category);
    }
}
