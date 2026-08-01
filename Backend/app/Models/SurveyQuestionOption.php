<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * نموذج خيار السؤال ووزنه الأكاديمي[cite: 2]
 */
class SurveyQuestionOption extends Model
{
    protected $fillable = [
        'question_id',
        'option_text',
        'weight_score',
        'option_value',
    ];

    protected $casts = [
        'weight_score' => 'decimal:2',
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(SurveyQuestion::class, 'question_id');
    }
}