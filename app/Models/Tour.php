<?php

namespace App\Models;

use App\Enums\TourStatusEnum;
use App\Observers\TourObserver;
use App\Traits\HasFilter;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method create(array $data)
 * @method filter(\App\Filters\TourSearchFilter $filter)
 * @method ownTours()
 * @method published()
 * @property mixed $location
 */

#[ObservedBy([TourObserver::class])]
class Tour extends Model
{
    use HasFactory, HasFilter;

    protected $fillable = [
        "title",
        "slug",
        'location',
        "overview",
        "price",
        'duration',
        'start_point',
        'end_point',
        'max_packs',
        'inclusions',
        'exclusions',
        'conditions',
        'is_private',
        'status',
        'featured',
        'tour_category_id',
        'parent_id',
        'rating',
        'user_id'
    ];

    /**
     * @return array
     */
    protected function casts(): array
    {
        return [
            'status' => TourStatusEnum::class,
            'location' => 'json',
            'start_point' => 'json',
            'end_point' => 'json'
        ];
    }

    /**
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(TourCategory::class, 'tour_category_id');
    }

    /**
     * @return HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany(TourImage::class, 'tour_id');
    }

    /**
     * @return HasMany
     */
    public function tour_days(): HasMany
    {
        return $this->hasMany(TourDay::class, 'tour_id');
    }

    /**
     * @return HasMany
     */
    public function tour_availability(): HasMany
    {
        return $this->hasMany(TourAvailability::class, 'tour_id');
    }

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return BelongsToMany
     */
    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'wishlists', 'tour_id', 'user_id');
    }

    /**
     * @return HasMany
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'tour_id')->latest();
    }

    /**
     * @return HasMany
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'tour_id');
    }

    public function getUserBookingAttribute(): ?Booking
    {
        return $this->bookings->where('user_id', auth()->id())->first();
    }

    /**
     * @return bool
     */
    public function getHasBookingAttribute(): bool
    {
        return $this->bookings->where('user_id', auth()->id())->count() > 0;
    }

    /**
     * @return bool
     */
    public function getIsLikedAttribute(): bool
    {
        return auth()->check() && $this->likes->where('id', auth()->id())->count() > 0;
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function scopeFeatured(Builder $builder): Builder
    {
        return $builder->where('featured', true);
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function scopePublished(Builder $builder): Builder
    {
        return $builder->where('status', TourStatusEnum::PUBLISHED);
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function scopeVerified(Builder $builder): Builder
    {
        return $builder->whereIn('status', [TourStatusEnum::VERIFIED, TourStatusEnum::PUBLISHED]);
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function scopeOwnTours(Builder $builder): Builder
    {
        return $builder->where('user_id', auth()->id());
    }

    /**
     * @param Builder $builder
     * @return Builder
     */
    public function scopeLiked(Builder $builder): Builder
    {
        return $builder->whereHas('likes', function ($query) {
            $query->where('user_id', auth()->id());
        });
    }

}
