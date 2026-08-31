<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudyPlan extends Model
{
    protected $fillable = [
        'major_id',
        'university_id',
        'title',
        'academic_year',
        'version_label',
        'ucas_code',
        'total_credit_hours',
        'is_current',
        'source_pdf_path',
        'source_pdf_original_name',
        'status',
        'processing_error',
        'raw_extracted_data',
        'uploaded_by',
        'confirmed_by',
        'confirmed_at',
    ];

    protected $casts = [
        'academic_year' => 'integer',
        'total_credit_hours' => 'integer',
        'is_current' => 'boolean',
        'raw_extracted_data' => 'array',
        'confirmed_at' => 'datetime',
    ];

    public function major(): BelongsTo
    {
        return $this->belongsTo(Major::class);
    }

    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class);
    }

    public function uploadedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function confirmedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    public function studyPlanCourses(): HasMany
    {
        return $this->hasMany(StudyPlanCourse::class)->orderBy('year_number')->orderBy('semester_number')->orderBy('order_index');
    }

    // ── Helpers لحالة المعالجة ──
    public function isEditable(): bool
    {
        return in_array($this->status, ['extracted', 'failed']);
    }

    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }
}