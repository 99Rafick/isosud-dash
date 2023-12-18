<?php

namespace App\Enums;

enum IndicatorEnum
{
    public const OPERATOR = [
        '<=' => '<=',
        '>=' => '>='
    ];

    public const TARGET_TYPE = [
        'nombre' => 'nombre',
        'date' => 'date',
        'pourcentage' => 'pourcentage'
    ];
}
