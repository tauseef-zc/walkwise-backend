<?php

namespace App\Services;

use App\Filters\GuideSearchFilter;
use App\Models\Guide;
use Illuminate\Pagination\LengthAwarePaginator;

class GuideService extends BaseService
{
    private Guide $guide;

    public function __construct(Guide $guide)
    {
        $this->guide = $guide;
    }

    public function search(GuideSearchFilter $filter): LengthAwarePaginator
    {
        return $this->guide->filter($filter)->paginate(12);
    }
}
