<?php

namespace App\Services\Guide;

use App\Models\Tour;
use App\Models\TourImage;
use App\Notifications\Guide\TourCreatedNotification;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Intervention\Image\Laravel\Facades\Image;

class TourService extends BaseService
{
    private Tour $tour;

    public function __construct(Tour $tour)
    {
        $this->tour = $tour;
    }

    /**
     * @param array $data
     * @return array
     */
    public function createTour(array $data): array
    {
        $data['slug'] = Str::slug($data['title']);
        $data['user_id'] = auth()->user()->id;

        $tour = $this->tour->create($data);

        $this->uploadTourImages($tour);

        $this->addTourDays($tour, $data['tour_days']);

        $this->addTourAvailability($tour, $data['tour_dates']);

        auth()->user()->notify(new TourCreatedNotification($tour));

        return $this->payload([
            "tour" => $tour,
            "message" => "Tour created successfully! It will take a while to appear on the website.
             You will have a confirmation mail."
        ]);
    }

    /**
     * @param Tour $tour
     * @return void
     */
    private function uploadTourImages(Tour $tour): void
    {
        $fileNames = [];

        if(request()->hasFile('tour_images')){
            $images = request()->tour_images;
            foreach ($images as $index=>$image) {
                $fileName = 'tour-'. $tour->id. '-' .$index. '.jpg';
                $path = public_path('uploads/tours/images/' . $fileName);
                Image::read($image)->cover(1000, 666)->toJpeg()->save($path);
                $fileNames[]['image'] = 'tours/images/' . $fileName;
            }
        }

        if(!empty($fileNames)){
            $tour->images()->createMany($fileNames);
        }
    }

    /**
     * @param Tour $tour
     * @param array $days
     * @return void
     */
    private function addTourDays(Tour $tour, array $days): void
    {
        if(!empty($days) && count($days) > 0){
            $order = 0;
            foreach ($days as $day) {
                $dayObj = json_decode($day, true);
                $dayObj['order'] = $order++;
                $tour->tour_days()->create($dayObj);
            }
            $tour->update(['duration' => $order]);
        }

    }

    /**
     * @param Tour $tour
     * @param array $available_dates
     * @return void
     */
    private function addTourAvailability(Tour $tour, array $available_dates): void
    {
        if(!empty($available_dates) && count($available_dates) > 0){
            foreach ($available_dates as $date) {
                $dateObj = json_decode($date, true);
                $tour->tour_availability()->create($dateObj);
            }
        }
    }

    public function getTours(): LengthAwarePaginator
    {
        return $this->tour->ownTours()->latest()->paginate(8);
    }
}
