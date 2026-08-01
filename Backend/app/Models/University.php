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
}