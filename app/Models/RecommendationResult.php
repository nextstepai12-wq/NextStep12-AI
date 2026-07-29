<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * نموذج نتيجة التوصية النهائية[cite: 2]
 */
class RecommendationResult extends Model
{
    protected $fillable = [
        'user_id',
        'major_id',
        'match_percentage',
        'ai_feedback',
    ];

    protected $casts = [
        'match_percentage' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function major(): BelongsTo
    {
        return $this->belongsTo(Major::class);
    }
}