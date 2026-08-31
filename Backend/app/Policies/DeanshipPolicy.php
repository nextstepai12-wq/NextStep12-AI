<?php

namespace App\Policies;

use App\Models\Deanship;
use App\Models\User;

/**
 * ==============================================================================
 * سياسة صلاحيات العمادات (Deanship)
 * ==============================================================================
 */
class DeanshipPolicy
{
    public function before(User $user, string $ability): ?bool
    {
        return $user->role === 'admin' ? true : null;
    }

    public function view(User $user, Deanship $deanship): bool
    {
        return $this->belongsToUser($user, $deanship);
    }

    public function update(User $user, Deanship $deanship): bool
    {
        return $this->belongsToUser($user, $deanship);
    }

    public function delete(User $user, Deanship $deanship): bool
    {
        return $this->belongsToUser($user, $deanship);
    }

    private function belongsToUser(User $user, Deanship $deanship): bool
    {
        return $user->role === 'university'
            && $user->university_id !== null
            && $deanship->university_id === $user->university_id;
    }
}
