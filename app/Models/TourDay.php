<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TourDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'itinerary',
        'location',
        'accommodation',
        'meal_plan',
        'tour_id',
        'order'
    ];

    protected function casts(): array
    {
        return [
            'location' => 'json',
        ];
    }

    /**
     * @return BelongsTo
     */
    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class, 'tour_id');
    }
}
