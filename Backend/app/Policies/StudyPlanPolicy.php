<?php

namespace App\Policies;

use App\Models\StudyPlan;
use App\Models\User;

/**
 * ==============================================================================
 * سياسة صلاحيات الخطط الدراسية (StudyPlan)
 * ==============================================================================
 * study_plans.university_id مخزّن مباشرة بالجدول (denormalized)، لذا الفحص
 * مباشر بدون الحاجة لعبور علاقات Faculty/Deanship.
 */
class StudyPlanPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        return $user->role === 'admin' ? true : null;
    }

    public function view(User $user, StudyPlan $studyPlan): bool
    {
        return $this->belongsToUser($user, $studyPlan);
    }

    public function update(User $user, StudyPlan $studyPlan): bool
    {
        return $this->belongsToUser($user, $studyPlan);
    }

    public function delete(User $user, StudyPlan $studyPlan): bool
    {
        return $this->belongsToUser($user, $studyPlan);
    }

    /**
     * فحص خاص لعملية confirm() — تُبنى عليه لاحقًا بـStudyPlanController (Step 7).
     */
    public function confirm(User $user, StudyPlan $studyPlan): bool
    {
        return $this->belongsToUser($user, $studyPlan);
    }

    private function belongsToUser(User $user, StudyPlan $studyPlan): bool
    {
        return $user->role === 'university'
            && $user->university_id !== null
            && $studyPlan->university_id === $user->university_id;
    }
}
