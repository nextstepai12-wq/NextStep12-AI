<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * نموذج التخصص الأكاديمي[cite: 2]
 */
class Major extends Model
{
    protected $fillable = [
        'deanship_faculty_id',
        'title',
        'cover_image',
        'video_url',
        'study_plan_image',
        'study_plan_file_url',
        'min_high_school_score',
        'credit_hour_fee',
        'total_credit_hours',
        'description',
        'career_opportunities',
    ];

    protected $casts = [
        'min_high_school_score' => 'decimal:2',
        'credit_hour_fee' => 'decimal:2',
        'total_credit_hours' => 'integer',
    ];

    // علاقة التبعية للكلية / العمادة[cite: 2]
    public function deanshipFaculty(): BelongsTo
    {
        return $this->belongsTo(DeanshipFaculty::class);
    }

    // علاقة (واحد لمتعدد) مع المنح المتاحة لهذا التخصص[cite: 2]
    public function scholarships(): HasMany
    {
        return $this->hasMany(Scholarship::class);
    }

    // علاقة (واحد لمتعدد) مع نتائج التوصيات التابعة للتخصص[cite: 2]
    public function recommendationResults(): HasMany
    {
        return $this->hasMany(RecommendationResult::class);
    }
}