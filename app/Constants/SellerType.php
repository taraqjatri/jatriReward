<?php

declare(strict_types=1);
namespace App\Constants;

use ReflectionClass;

class SellerType
{
    const COUNTER = 'COUNTER';
    const CHECKER = 'CHECKER';

    public static function all(): array
    {
        $class = new ReflectionClass(__CLASS__);
        return $class->getConstants();
    }
}
