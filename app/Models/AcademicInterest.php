<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * نموذج المجال / الميل الأكاديمي[cite: 2]
 */
class AcademicInterest extends Model
{
    protected $fillable = [
        'name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // علاقة (متعدد لمتعدد) مع الطلاب الذين اختاروا هذا المجال[cite: 2]
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'student_academic_interests', 'interest_id', 'user_id');
    }

    // علاقة (واحد لمتعدد) مع الأسئلة المخصصة لهذا المجال[cite: 2]
    public function surveyQuestions(): HasMany
    {
        return $this->hasMany(SurveyQuestion::class, 'interest_id');
    }
}