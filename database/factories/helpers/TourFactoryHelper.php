<?php

namespace Database\Factories\helpers;

trait TourFactoryHelper
{
    static array $touristDistricts = [
        [
            "name" => "Colombo",
            "description" => "Commercial capital and largest city with modern amenities and historical sites",
            "latitude" => 6.927079,
            "longitude" => 79.861244
        ],
        [
            "name" => "Kandy",
            "description" => "Cultural capital featuring Temple of the Tooth and scenic lake",
            "latitude" => 7.291418,
            "longitude" => 80.636696
        ],
        [
            "name" => "Galle",
            "description" => "Historic coastal city with Dutch colonial fort",
            "latitude" => 6.032344,
            "longitude" => 80.216801
        ],
        [
            "name" => "Sigiriya",
            "description" => "Ancient rock fortress and UNESCO World Heritage site",
            "latitude" => 7.957064,
            "longitude" => 80.760043
        ],
        [
            "name" => "Nuwara Eliya",
            "description" => "Hill country with tea plantations and cool climate",
            "latitude" => 6.970767,
            "longitude" => 80.787499
        ],
        [
            "name" => "Trincomalee",
            "description" => "Natural harbor city with beautiful beaches",
            "latitude" => 8.576766,
            "longitude" => 81.233050
        ],
        [
            "name" => "Anuradhapura",
            "description" => "Ancient city with Buddhist temples and ruins",
            "latitude" => 8.311350,
            "longitude" => 80.403656
        ],
        [
            "name" => "Ella",
            "description" => "Mountain village famous for hiking and scenic views",
            "latitude" => 6.874417,
            "longitude" => 81.046539
        ],
        [
            "name" => "Mirissa",
            "description" => "Coastal town known for whale watching and beaches",
            "latitude" => 5.947567,
            "longitude" => 80.452769
        ],
        [
            "name" => "Polonnaruwa",
            "description" => "Medieval capital city with archaeological ruins",
            "latitude" => 7.940576,
            "longitude" => 81.018336
        ]
    ];

    private function getRandomLocation(): array
    {
        $city = self::$touristDistricts[array_rand(self::$touristDistricts)];
        return [
            'placeId' => $this->faker->numberBetween(1, 10),
            'name' => $city['name'],
            'address' => $city['name'],
            'geocode' => [
                'lat' => $city['latitude'],
                'lng' => $city['longitude']
            ]
        ];
    }
}
