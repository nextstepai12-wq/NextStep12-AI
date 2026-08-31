<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudyPlanCourse extends Model
{
    protected $table = 'study_plan_courses';

    protected $fillable = [
        'study_plan_id',
        'course_id',
        'year_number',
        'semester_number',
        'is_elective',
        'credit_hours_override',
        'theory_hours_override',
        'practical_hours_override',
        'order_index',
    ];

    protected $casts = [
        'year_number' => 'integer',
        'semester_number' => 'integer',
        'is_elective' => 'boolean',
        'credit_hours_override' => 'integer',
        'theory_hours_override' => 'integer',
        'practical_hours_override' => 'integer',
        'order_index' => 'integer',
    ];

    public function studyPlan(): BelongsTo
    {
        return $this->belongsTo(StudyPlan::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function prerequisites(): HasMany
    {
        return $this->hasMany(StudyPlanCoursePrerequisite::class);
    }

    // الساعات الفعلية: override إن وُجد، وإلا القيمة الافتراضية من المقرر
    public function getEffectiveCreditHoursAttribute(): int
    {
        return $this->credit_hours_override ?? $this->course->default_total_hours;
    }
}