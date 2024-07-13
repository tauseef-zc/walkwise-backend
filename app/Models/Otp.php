<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Otp extends Model
{
    use HasFactory;

    protected $fillable = ['otp', 'expires_at', 'verified', 'taggable_id', 'taggable_type'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'expire_at' => 'datetime',
            'verified' => 'boolean',
        ];
    }

    /**
     * taggable
     *
     * @return MorphTo
     */
    public function taggable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function scopeVerified(Builder $builder): Builder
    {
        return $builder->where('verified', true);
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function scopeUnverified(Builder $builder): Builder
    {
        return $builder->where('verified', false);
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function scopeExpired(Builder $builder): Builder
    {
        return $builder->where('expires_at', '<', now());
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function scopeActive(Builder $builder): Builder
    {
        return $builder->where('expires_at', '>', now());
    }
}
