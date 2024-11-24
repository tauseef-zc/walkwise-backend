<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method updateOrCreate(array $array, array $data)
 * @property string name
 * @property string phone
 * @property string bio
 * @property string expertise
 * @property int experience
 * @property string document
 * @property string languages
 * @property string avatar
 * @property boolean has_vehicle
 * @property int rating
 * @property string verified_at
 * @property int user_id
 */
class Guide extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'phone',
        'bio',
        'expertise',
        'experience',
        'documents',
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
            'expertise' => 'array',
            'verified_at' => 'datetime',
            'documents' => 'array',
            'location' => 'json',
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
