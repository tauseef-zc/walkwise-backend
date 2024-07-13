<?php

namespace App\Services;

use App\Services\interfaces\ServiceInterface;
use App\Traits\ServicePayloadTrait;

class BaseService implements ServiceInterface
{
    use ServicePayloadTrait;

}
