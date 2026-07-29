<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * نموذج المستخدم (User Model)
 * يمثل الحساب الأساسي ونظام التوثيق (Sanctum Tokens)[cite: 1, 2].
 */
class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // علاقة (واحد لواحد) مع الملف الشخصي للطالب
    public function profile(): HasOne
    {
        return $this->hasOne(StudentProfile::class);
    }

    // علاقة (متعدد لمتعدد) مع الميول الأكاديمية المختارة
    public function academicInterests(): BelongsToMany
    {
        return $this->belongsToMany(AcademicInterest::class, 'student_academic_interests', 'user_id', 'interest_id');
    }

    // علاقة (واحد لمتعدد) مع إجابات الاستبيان الخاصة بالنعطي
    public function surveyResponses(): HasMany
    {
        return $this->hasMany(StudentSurveyResponse::class);
    }

    // علاقة (واحد لمتعدد) مع نتائج التوصية المستلمة من AI
    public function recommendationResults(): HasMany
    {
        return $this->hasMany(RecommendationResult::class);
    }
}