<?php

namespace App\Constants;
use ReflectionClass;

class QueryVariation
{
    const DAILY = 'DAILY';
    const WEEKLY = 'WEEKLY';
    const MONTHLY = 'MONTHLY';

    public static function all(): array
    {
        $class = new ReflectionClass(__CLASS__);
        return $class->getConstants();
    }
}
