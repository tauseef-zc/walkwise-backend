<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $tour_id
 * @property int $booking_id
 * @property int $reviewer
 * @property int $rating
 * @property int $review
 * @method create(array $data)
 */
class Review extends Model
{
    use HasFactory;


    protected $fillable = [
        'tour_id',
        'booking_id',
        'reviewer',
        'rating',
        'review'
    ];

    /**
     * @return BelongsTo
     */
    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class, 'tour_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer', 'id');
    }
}
