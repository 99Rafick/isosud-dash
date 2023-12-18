<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class IndicatorFrequency extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'number_of_month_or_year',
        'month_or_year'
    ];
}
