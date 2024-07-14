<?php

namespace App\Enums;

use App\Traits\EnumOptions;

enum UserStatusEnum: int
{
    use EnumOptions;

    case PENDING = 0;
    case ACTIVE = 1;
    case INACTIVE = 2;
    case BLOCKED = 3;
}
