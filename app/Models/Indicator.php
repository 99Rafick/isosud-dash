<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Indicator extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'operator',
        'target_type',
        'number_target',
        'date_target',
        'process_id',
        'indicator_frequency_id',
    ];

    public function frequency(): BelongsTo
    {
        return $this->belongsTo(IndicatorFrequency::class, 'indicator_frequency_id');
    }

    public function process(): BelongsTo
    {
        return $this->belongsTo(Process::class, 'process_id');
    }
}
