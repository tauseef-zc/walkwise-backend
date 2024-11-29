<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int id
 * @property int tour_id
 * @property int $user_id
 * @property int $total
 */
class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'tour_id',
        'user_id',
        'booking_date',
        'total',
        'adults',
        'children',
        'infants',
        'first_name',
        'last_name',
        'phone',
        'email',
        'status',
    ];

    protected array $dates = [
        'booking_date'
    ];

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class, 'tour_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class, 'booking_id', 'id');
    }
}
