<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property int $reviewer
 * @property int $rating
 * @property int $review
 * @method create(array $data)
 */
class GuideReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'reviewer',
        'user_id',
        'rating',
        'review'
    ];

    /**
     * @return BelongsTo
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

}
