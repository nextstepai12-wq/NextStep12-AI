<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * نموذج المنحة الدراسية[cite: 2]
 */
class Scholarship extends Model
{
    protected $fillable = [
        'university_id',
        'deanship_faculty_id',
        'major_id',
        'title',
        'description',
        'min_score',
        'max_score',
        'discount_percentage',
        'type',
        'cover_image',
        'is_active',
    ];

    protected $casts = [
        'min_score' => 'decimal:2',
        'max_score' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class);
    }

 // Major.php — بعد التصحيح
public function faculty(): BelongsTo
{
    return $this->belongsTo(Faculty::class);
}

public function deanship(): BelongsTo
{
    return $this->belongsTo(Deanship::class);
}

    public function major(): BelongsTo
    {
        return $this->belongsTo(Major::class);
    }
}