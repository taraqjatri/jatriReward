<?php

declare(strict_types=1);
namespace App\Enum;

enum AdminStatusEnum : string
{
    case ACTIVE = 'ACTIVE';
    case INACTIVE = 'INACTIVE';
}
