<?php

namespace App\Services;

use App\Filters\TourSearchFilter;
use App\Models\Tour;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class TourService extends BaseService
{
    private Tour $tour;
    const PAGINATION = 20;

    public function __construct(Tour $tour)
    {
        $this->tour = $tour;
    }

    public function searchTours(TourSearchFilter $filter): Paginator
    {
        return $this->tour
            ->filter($filter)
            ->published()
            ->latest()
            ->paginate(self::PAGINATION);
    }

    /**
     * @param int $limit
     * @return Collection
     */
    public function getFeaturedTours(int $limit = 8): Collection
    {
        return $this->tour->featured()->published()->limit($limit)->get();
    }

    public function addToWishlist(Tour $tour): bool
    {
        $exist = auth()->user()->wishlist()->where('tour_id', $tour->id)->count();
        if(!$exist)
            auth()->user()->wishlist()->attach($tour);
        return true;
    }

    public function removeFromWishlist(Tour $tour): bool
    {
        $exist = auth()->user()->wishlist()->where('tour_id', $tour->id)->count();
        if($exist)
            auth()->user()->wishlist()->detach($tour);
        return true;
    }

    public function getLikedTours(int $limit = 8): Paginator
    {
        return $this->tour->published()->liked()->paginate($limit);
    }

}
