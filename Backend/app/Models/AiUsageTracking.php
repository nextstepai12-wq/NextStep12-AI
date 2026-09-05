<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiUsageTracking extends Model
{
    use HasFactory;

    /**
     * اسم الجدول المرتبط بالـ Model في قاعدة البيانات
     */
    protected $table = 'ai_usage_tracking';

    /**
     * إلغاء Timestamps الافتراضية (created_at / updated_at) نظراً لعدم وجودهما بالجدول
     */
    public $timestamps = false;

    /**
     * الأعمدة المسموح بتعبئتها جماعياً (Mass Assignment)
     */
    protected $fillable = [
        'user_id',                   // رقم الطالب المرتبط بجدول users
        'used_free_llm_question',   // مؤشر استهلاك السؤال المجاني (true/false)
        'last_unmatched_question',  // نص آخر سؤال غير مطابق في بنك الأسئلة
        'used_at',                  // تاريخ ووقت استهلاك السؤال
    ];

    /**
     * تحويل أنواع البيانات للقيم عند الاسترجاع (Attribute Casting)
     */
    protected $casts = [
        'used_free_llm_question' => 'boolean', // تحويل المؤشر إلى boolean
        'used_at'                => 'datetime',// تحويل التاريخ إلى Carbon Instance
    ];

    /**
     * علاقة الموديل بجدول الحسابات (users): كل سجل تتبع ينتمي لطالب واحد (BelongsTo)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}