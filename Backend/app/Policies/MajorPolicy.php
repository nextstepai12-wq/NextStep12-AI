<?php

namespace App\Policies;

use App\Models\Major;
use App\Models\User;

/**
 * ==============================================================================
 * سياسة صلاحيات التخصصات (Major)
 * ==============================================================================
 * Major مربوط بالجامعة بشكل غير مباشر: إما عبر faculty_id أو عبر deanship_id
 * (حسب القرار المعماري المثبت: كلاهما nullable، واحد منهم فقط موجود لكل تخصص).
 */
class MajorPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        return $user->role === 'admin' ? true : null;
    }

    public function view(User $user, Major $major): bool
    {
        return $this->belongsToUser($user, $major);
    }

    public function update(User $user, Major $major): bool
    {
        return $this->belongsToUser($user, $major);
    }

    public function delete(User $user, Major $major): bool
    {
        return $this->belongsToUser($user, $major);
    }

    private function belongsToUser(User $user, Major $major): bool
    {
        if ($user->role !== 'university' || $user->university_id === null) {
            return false;
        }

        $universityId = $major->faculty_id
            ? $major->faculty?->university_id
            : ($major->deanship_id ? $major->deanship?->university_id : null);

        return $universityId !== null && $universityId === $user->university_id;
    }
}
