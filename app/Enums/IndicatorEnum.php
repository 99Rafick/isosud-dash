<?php

namespace App\Enums;

enum IndicatorEnum
{
    public const OPERATOR = [
        'inferior_or_equal' => '<= à la cîble',
        'superior_or_equal' => '>= à la cîble'
    ];

    public const TARGET_TYPE = [
        'number' => 'Nombre',
        'date' => 'Date',
        'percentage' => 'Pourcentage'
    ];
}
