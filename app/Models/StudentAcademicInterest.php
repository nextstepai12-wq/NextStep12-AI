<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * نموذج الربط بين الطالب والميول[cite: 2]
 */
class StudentAcademicInterest extends Model
{
    protected $table = 'student_academic_interests';

    protected $fillable = [
        'user_id',
        'interest_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function academicInterest(): BelongsTo
    {
        return $this->belongsTo(AcademicInterest::class, 'interest_id');
    }
}