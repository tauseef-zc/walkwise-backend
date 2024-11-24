<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method withCount(string $string)
 */
class TourCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'slug',
        'info',
        'image'
    ];

    public function tours(): HasMany
    {
        return $this->hasMany(Tour::class, 'tour_category_id');
    }
}
