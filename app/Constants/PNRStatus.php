<?php

namespace App\Constants;
use ReflectionClass;

class PNRStatus
{

    const VALID = 'VALID';
    const INVALID = 'INVALID';

    public static function all(): array
    {
        $class = new ReflectionClass(__CLASS__);
        return $class->getConstants();
    }
}
