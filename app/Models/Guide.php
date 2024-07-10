<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guide extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'bio',
        'skills',
        'avatar',
        'has_vehicle',
        'rating',
        'verified_at',
        'user_id'
    ];

    /**
     * @return string[]
     */
    protected function casts(): array
    {
        return [
            'skills' => 'json',
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
