<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Deanship extends Model
{
    /**
     * الحقول المسموح تعبئتها
     * لاحظ faculty_id موجود هنا مع إنه ممكن يكون null
     * (null يعني عمادة عامة ما تتبع كلية)
     */
    protected $fillable = [
        'university_id', // الجامعة
        'faculty_id',    // الكلية (ممكن null = عمادة عامة)
        'name',          // اسم العمادة
        'cover_image',   // الصورة
        'description',   // الوصف
        'dean_name',     // العميد
        'email',         // الإيميل
    ];

    /**
     * العمادة تنتمي لجامعة واحدة
     * $deanship->university
     */
    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class);
    }

    /**
     * العمادة ممكن تنتمي لكلية واحدة (أو لا شيء إذا null)
     * $deanship->faculty → يرجع الكلية، أو null إذا كانت عمادة عامة
     * Laravel يتعامل مع العلاقات nullable تلقائيًا بدون أخطاء
     */
    public function faculty(): BelongsTo
    {
        return $this->belongsTo(Faculty::class);
    }

    /**
     * العمادة لديها أقسام (لمشروع مرح)
     * $deanship->departments
     */
    public function departments(): HasMany
    {
        return $this->hasMany(Department::class);
    }

    /**
     * دالة مساعدة (Helper): هل هذي عمادة عامة؟
     * الفايدة: بدل ما تكتب is_null($deanship->faculty_id) في كل مكان بالـ Views
     * تكتب ببساطة: $deanship->isGeneral()
     * كود أنظف وأسهل للقراءة
     */
    public function isGeneral(): bool
    {
        return is_null($this->faculty_id); // true إذا ما تتبع أي كلية
    }
}