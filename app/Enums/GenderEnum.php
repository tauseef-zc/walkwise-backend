<?php

namespace App\Enums;

use App\Traits\EnumOptions;

enum GenderEnum: int
{
    use EnumOptions;

    case MALE = 1;
    case FEMALE = 2;
    case OTHER = 3;

}
