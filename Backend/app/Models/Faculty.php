<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;   // علاقة "ينتمي إلى"
use Illuminate\Database\Eloquent\Relations\HasMany;     // علاقة "لديهmany"

class Faculty extends Model
{
    // الموديل = الوسيط بين كودك وجدول faculties بقاعدة البيانات
    // Laravel تلقائيًا يربط هذا الموديل بجدول باسم "faculties" (جمع اسم الكلاس)

    /**
     * الحقول المسموح تعبئتها دفعة واحدة
     * الحماية من Mass Assignment: بدون هذا السطر، Laravel يرفض إنشاء سجل بـ create()
     * يعني حددنا هنا إيش الحقول اللي يقدر المستخدم يعبّيها من الفورمات
     * (لاحظ ما حطينا id ولا timestamps لأن Laravel يديرها بنفسه)
     */
    protected $fillable = [
        'university_id', // رقم الجامعة اللي تتبع لها الكلية
        'name',          // اسم الكلية
        'cover_image',   // صورة الغلاف
        'description',   // الوصف
        'dean_name',     // اسم العميد
        'email',         // الإيميل
    ];

    /**
     * علاقة: الكلية "تنتمي إلى" جامعة واحدة
     * الاستخدام: $faculty->university → يرجع الجامعة اللي تابعة لها
     */
    public function university(): BelongsTo
    {
        return $this->belongsTo(University::class);
    }

    /**
     * علاقة: الكلية "لديها" عدة أقسام
     * هذي جداول مرح (الأقسام تتبع الكليات)
     * الاستخدام: $faculty->departments → يرجع كل أقسام هذي الكلية
     */
    public function departments(): HasMany
    {
        return $this->hasMany(Department::class);
    }

    /**
     * علاقة: الكلية "لديها" عدة عمادات (لو في عمادات داخلية للكلية)
     * الاستخدام: $faculty->deanships
     */
    public function deanships(): HasMany
    {
        return $this->hasMany(Deanship::class);
    }
}