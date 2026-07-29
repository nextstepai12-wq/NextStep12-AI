<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class StudentProfile extends Model
{
    use HasFactory;

    protected $table = 'student_profiles';

    protected $fillable = [
        'user_id',
        'student_type',
        'birth_date',
        'high_school_score',
        'high_school_branch_id',
        'graduation_year',
        'current_university_id',
        'current_major_id',
        'academic_level',
        'gpa',
        'phone',
        'city',
    ];

    /**
     * تحويل الحقول إلى أنماط بيانات مخصصة تلقائياً
     */
    protected $casts = [
        'birth_date' => 'date',
        'high_school_score' => 'float',
        'gpa' => 'float',
        'graduation_year' => 'integer',
    ];

    /**
     * حقل وهمي إضافي يحسب العمر تلقائياً ويرسله مع بيانات الـ API لمريم
     */
    protected $appends = ['age'];

    public function getAgeAttribute(): ?int
    {
        return $this->birth_date ? Carbon::parse($this->birth_date)->age : null;
    }

    // =========================================================================
    // العلاقات (Relationships)
    // =========================================================================

    /**
     * علاقة البروفايل بالحساب الأساسي (User)[cite: 2]
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * علاقة الفرع الدراسي بالثانوية[cite: 2]
     */
    public function highSchoolBranch()
    {
        return $this->belongsTo(HighSchoolBranch::class, 'high_school_branch_id');
    }

    /**
     * علاقة الجامعة الحالية (للطالب الجامعي)
     */
    public function currentUniversity()
    {
        return $this->belongsTo(University::class, 'current_university_id');
    }

    /**
     * علاقة التخصص الحالي (للطالب الجامعي)
     */
    public function currentMajor()
    {
        return $this->belongsTo(Major::class, 'current_major_id');
    }
}