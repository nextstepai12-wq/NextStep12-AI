<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * نموذج إجابة الطالب على الاستبيان[cite: 2]
 */
class StudentSurveyResponse extends Model
{
    protected $fillable = [
        'user_id',
        'question_id',
        'selected_option_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(SurveyQuestion::class, 'question_id');
    }

    public function selectedOption(): BelongsTo
    {
        return $this->belongsTo(SurveyQuestionOption::class, 'selected_option_id');
    }
}