<?php

namespace App\Enums;

use Illuminate\Support\Facades\Auth;

enum RoleEnum
{
    const ADMIN = 'ADMIN';
    const STRUCTURE = 'STRUCTURE';

    public static function values(): array
    {
        $class = new \ReflectionClass(self::class);
        return $class->getConstants();
    }

    public static function isAdmin(): bool
    {
        return Auth::user()->role === RoleEnum::ADMIN;
    }
}
