<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * نموذج الكلية / العمادة[cite: 2]
 */
class DeanshipFaculty extends Model
{
    protected $table = 'deanships_faculties';

    protected $fillable = [
        'university_id',
        'name',
        'type',
        'cover_image',
        'description',
        'dean_name',
        'email',
    ];

    // علاقة التبعية للجامعة[cite: 2]
    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class);
    }

    // علاقة (واحد لمتعدد) مع التخصصات التابعة للكلية[cite: 2]
    public function majors(): HasMany
    {
        return $this->hasMany(Major::class);
    }

    // علاقة (واحد لمتعدد) مع المنح التابعة للكلية[cite: 2]
    public function scholarships(): HasMany
    {
        return $this->hasMany(Scholarship::class);
    }
}