<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * نموذج سؤال الاستبيان[cite: 2]
 */
class SurveyQuestion extends Model
{
    protected $fillable = [
        'question_text',
        'type',
        'order_index',
        'min_score_required',
        'interest_id',
        'is_active',
    ];

    protected $casts = [
        'order_index' => 'integer',
        'min_score_required' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function academicInterest(): BelongsTo
    {
        return $this->belongsTo(AcademicInterest::class, 'interest_id');
    }

    // علاقة (واحد لمتعدد) مع خيارات الإجابة للسؤال[cite: 2]
    public function options(): HasMany
    {
        return $this->hasMany(SurveyQuestionOption::class, 'question_id');
    }

    // علاقة الإجابات المقدمة لهذا السؤال[cite: 2]
    public function responses(): HasMany
    {
        return $this->hasMany(StudentSurveyResponse::class, 'question_id');
    }
}