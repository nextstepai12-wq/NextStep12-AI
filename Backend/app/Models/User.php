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
 * يمثل الحساب الأساسي ونظام التوثيق (Sanctum Tokens).
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
        'university_id',
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

    // علاقة (واحد لمتعدد) مع إجابات الاستبيان الخاص بالمستجيب
    public function surveyResponses(): HasMany
    {
        return $this->hasMany(StudentSurveyResponse::class);
    }

    // علاقة (واحد لمتعدد) مع نتائج التوصية المستلمة من AI
    public function recommendationResults(): HasMany
    {
        return $this->hasMany(RecommendationResult::class);
    }

    public function university(): HasOne
    {
        return $this->hasOne(University::class, 'id', 'university_id');
    }
    public function aiUsageTracking(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(AiUsageTracking::class, 'user_id');
    }

    /**
     * علاقة الطالب بسجلات أحداث الذكاء الاصطناعي (HasMany)
     */
    public function aiEvents(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AiEvent::class, 'user_id');
    }
}