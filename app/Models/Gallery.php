<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'event_date',
    ];

    protected $casts = [
        'event_date' => 'date',
    ];

    /**
     * Get the items (photos/videos) for this gallery.
     */
    public function items(): HasMany
    {
        return $this->hasMany(GalleryItem::class);
    }
}
