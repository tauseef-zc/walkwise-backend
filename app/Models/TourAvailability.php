<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourAvailability extends Model
{
    use HasFactory;

    protected $fillable = [
        'from',
        'to',
        'tour_id'
    ];

    protected function casts(): array
    {
        return [
            'from' => 'date',
            'to' => 'date'
        ];
    }
}
