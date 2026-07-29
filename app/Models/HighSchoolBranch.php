<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * نموذج الفرع الأكاديمي للثانوية العامة
 */
class HighSchoolBranch extends Model
{
    protected $fillable = [
        'name',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // علاقة (واحد لمتعدد) مع ملفات الطلاب
    public function studentProfiles(): HasMany
    {
        return $this->hasMany(StudentProfile::class);
    }
}