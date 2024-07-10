<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Traveler extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'avatar',
        'emergency_contact',
        'accessibility',
        'dietary_restrictions',
        'interests',
        'verified_at',
        'user_id'
    ];

    /**
     * @return string[]
     */
    protected function casts(): array
    {
        return [
            'emergency_contact' => 'json',
            'accessibility' => 'json',
            'dietary_restrictions' => 'json',
            'interests' => 'json',
            'verified_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
