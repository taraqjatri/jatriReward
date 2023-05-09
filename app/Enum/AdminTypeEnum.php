<?php

declare(strict_types=1);
namespace App\Enum;

enum AdminTypeEnum : string
{
    case REGULAR = 'REGULAR';
    case SYSTEM_ADMIN = 'SYSTEM_ADMIN';
}
