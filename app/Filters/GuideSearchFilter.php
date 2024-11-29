<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

class GuideSearchFilter extends Filter
{
    /**
     * @var array|string[]
     */
    protected array $filters = [
        'byLocation'
    ];

    public function byLocation(string $value): Builder
    {
        $guideLocation = json_decode($value, true);
        $lat = $guideLocation['lat'] ?? "";
        $lng = $guideLocation['lng'] ?? "";

        return $this->builder->when(!empty($lat) && !empty($lng), function ($query) use ($lat, $lng) {
            $earthRadius = 6371; // Earth's radius in kilometers
            $radius = 30;
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
