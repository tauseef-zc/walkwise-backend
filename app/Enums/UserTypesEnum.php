<?php

namespace App\Enums;

use App\Traits\EnumOptions;

enum UserTypesEnum: string
{
    use EnumOptions;

    case ADMIN = 'admin';

    case USER = 'user';

    case TRAVELER = 'traveler';

    case GUIDE = 'guide';
}
