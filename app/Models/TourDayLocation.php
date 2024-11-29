<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TourDayLocation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'location',
        'tour_day_id',
        'lat_long'
    ];

    protected function casts(): array
    {
        return [
            'lat_long' => 'json'
        ];
    }

    /**
     * @return BelongsTo
     */
    public function tourDay(): BelongsTo
    {
        return $this->belongsTo(TourDay::class, 'tour_day_id');
    }

}
