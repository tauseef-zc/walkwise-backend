<?php

namespace App\Services;

use App\Services\Interfaces\ServiceInterface;
use App\Traits\ImageHelper;
use App\Traits\ServicePayloadTrait;

class BaseService implements ServiceInterface
{
    use ServicePayloadTrait, ImageHelper;

}
