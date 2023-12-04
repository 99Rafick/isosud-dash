<?php

namespace App\Enums;

enum RoleEnum
{
    const ADMIN = 'admin';
    const USER = 'user';

    public static function values(): array
    {
        $class = new \ReflectionClass(self::class);
        return $class->getConstants();
    }
}
