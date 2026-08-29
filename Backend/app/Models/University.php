<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * نموذج الجامعة الأكاديمية[cite: 2]
 */
class University extends Model
{
    protected $fillable = [
        'name',
        'cover_image',
        'logo',
        'location',
        'description',
        'vision_mission',
        'website_url',
        'contact_info',
        'type', // النوع: 'university' أو 'college'

    ];

    // علاقة (واحد لمتعدد) مع العمادات والكليات التابعة للجامعة[cite: 2]
    public function deanshipsFaculties(): HasMany
    {
        return $this->hasMany(DeanshipFaculty::class);
    }

    // علاقة (واحد لمتعدد) مع المنح المقدمة من الجامعة[cite: 2]
    public function scholarships(): HasMany
    {
        return $this->hasMany(Scholarship::class);
    }
    /**
     * الجامعة لديها عدة كليات
     * $university->faculties → كل كليات الجامعة
     * للكلية الجامعية هذي القائمة بتكون فاضية (طبيعي)
     */
    public function faculties(): HasMany
    {
        return $this->hasMany(Faculty::class);
    }

    /**
     * الجامعة لديها عدة عمادات
     * $university->deanships
     */
    public function deanships(): HasMany
    {
        return $this->hasMany(Deanship::class);
    }

    /**
     * هل هذا الكيان "كلية مستقلة" مو جامعة؟
     * تستخدمها بالواجهة:
     * if ($university->isCollege()) → اعرض العمادات فقط، أخفِ قسم الكليات
     */
    public function isCollege(): bool
    {
        return $this->type === 'college';
    }
}