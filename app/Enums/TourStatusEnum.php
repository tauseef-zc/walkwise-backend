<?php

namespace App\Enums;

use App\Traits\EnumOptions;

enum TourStatusEnum : string
{
    use EnumOptions;

    case DRAFT = 'draft';

    case PENDING = 'pending';

    case VERIFIED = 'verified';

    case PUBLISHED = 'published';

}
