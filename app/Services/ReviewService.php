<?php

namespace App\Services;

use App\Models\GuideReview;
use App\Models\Review;
use App\Services\BaseService;

class ReviewService extends BaseService
{
    private GuideReview $guideReview;
    private Review $tourReview;

    public function __construct(GuideReview $guideReview, Review $tourReview)
    {
        $this->guideReview = $guideReview;
        $this->tourReview = $tourReview;
    }

    public function addTourReview(array $data): Review
    {
        return $this->tourReview->create($data);
    }

    public function addGuideReview(array $data): GuideReview
    {
        return $this->guideReview->create($data);
    }

}
