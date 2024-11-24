<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class TourSearchFilter extends Filter
{
    /**
     * @var array|string[]
     */
    protected array $filters = [
        'search',
        'byCategory',
        'byCategories',
        'byLocation',
        'minPrice',
        'maxPrice'
    ];

    public function search(string $value): Builder
    {
        return $this->builder->where('title', 'like', '%' . $value . '%');
    }

    public function byCategory(string $value): Builder
    {
        return $this->builder->where('tour_category_id', $value);
    }

    public function byCategories(string $value): Builder
    {
        return $this->builder->whereIn('tour_category_id', json_decode($value));
    }

    public function minPrice(float $value): Builder
    {
        return $this->builder->where('price', ">=" , $value);
    }

    public function maxPrice(float $value): Builder
    {
        return $this->builder->where('price', "<=",  $value);
    }

    public function byLocation(string $value): Builder
    {
        $location = json_decode($value, true);
        $lat = $location['lat'] ?? "";
        $lng = $location['lng'] ?? "";

        return $this->builder->when(!empty($lat) && !empty($lng), function ($query) use ($lat, $lng) {
            $earthRadius = 6371; // Earth's radius in kilometers
            $radius = 20;
            return $query->whereRaw(
                "(
                    $earthRadius * acos(
                        cos(radians(?)) * cos(radians(location->'$.geocode.lat')) * cos(radians(location->'$.geocode.lng') - radians(?)) +
                        sin(radians(?)) * sin(radians(location->'$.geocode.lat'))
                    )
                ) <= ?",
                [$lat, $lng, $lat, $radius]
                );
        });
    }

}