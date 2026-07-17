<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'image',
        'category',
        'time_of_use',
        'purchase_date',
        'expiry_date',
        'notes',
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'expiry_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function routineLogs(): HasMany
    {
        return $this->hasMany(RoutineLog::class);
    }

    /**
     * Get the public URL of the product image, or null if none.
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::url($this->image) : null;
    }

    /**
     * Check whether the product is already expired.
     */
    public function isExpired(): bool
    {
        return $this->expiry_date && $this->expiry_date->isPast();
    }

    /**
     * Check whether the product is expiring soon (within 30 days).
     */
    public function isExpiringSoon(): bool
    {
        if (!$this->expiry_date || $this->isExpired()) {
            return false;
        }

        return Carbon::now()->diffInDays($this->expiry_date, false) <= 30;
    }
}
