<?php

namespace App\Enums;

enum RoleEnum
{
    const ADMIN = 'ADMIN';
    const STRUCTURE = 'STRUCTURE';

    public static function values(): array
    {
        $class = new \ReflectionClass(self::class);
        return $class->getConstants();
    }
}
