<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoutineLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'date',
        'time_of_day',
        'is_done',
    ];

    protected $casts = [
        'date' => 'date',
        'is_done' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
