<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudyPlanCoursePrerequisite extends Model
{
    protected $table = 'study_plan_course_prerequisites';

    protected $fillable = [
        'study_plan_course_id',
        'prerequisite_code',
        'prerequisite_study_plan_course_id',
    ];

    public function studyPlanCourse(): BelongsTo
    {
        return $this->belongsTo(StudyPlanCourse::class, 'study_plan_course_id');
    }

    public function resolvedPrerequisite(): BelongsTo
    {
        return $this->belongsTo(StudyPlanCourse::class, 'prerequisite_study_plan_course_id');
    }
}