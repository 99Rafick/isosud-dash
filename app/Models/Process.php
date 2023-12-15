<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
