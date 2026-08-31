<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $fillable = [
        'university_id',
        'code',
        'name_ar',
        'name_en',
        'default_total_hours',
        'default_theory_hours',
        'default_practical_hours',
        'default_type',
    ];

    protected $casts = [
        'default_total_hours' => 'integer',
        'default_theory_hours' => 'integer',
        'default_practical_hours' => 'integer',
    ];

    // تطبيع رمز المقرر تلقائيًا (نفس منطق course_parser.py: strip + upper + إزالة المسافات)
    public function setCodeAttribute(string $value): void
    {
        $this->attributes['code'] = strtoupper(str_replace(' ', '', trim($value)));
    }

    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class);
    }

    public function studyPlanCourses(): HasMany
    {
        return $this->hasMany(StudyPlanCourse::class);
    }
}