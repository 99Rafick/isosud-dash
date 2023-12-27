<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static where(string $string, string $string1, int|string $userId)
 */
class Process extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'category',
        'user_id'
    ];
    public function structure(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
