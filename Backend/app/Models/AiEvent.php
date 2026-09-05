<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AiEvent extends Model
{
    use HasFactory;

    /**
     * اسم الجدول في قاعدة البيانات
     */
    protected $table = 'ai_events';

    /**
     * تفعيل created_at فقط وإلغاء updated_at
     */
    const UPDATED_AT = null;

    /**
     * الأعمدة المسموح بتعبئتها جماعياً (Mass Assignment)
     */
    protected $fillable = [
        'user_id',            // رقم الطالب صاحب الطلب (إن وجد)
        'source',             // مصدر الحدث (مثل: survey أو faq)
        'provider',           // المزود المعالج (مثل: fastapi أو gemini)
        'latency_ms',         // زمن الاستجابة بالملي ثانية
        'fallback_triggered', // مؤشر تفعيل النظام البديل (true/false)
    ];

    /**
     * تحويل أنواع البيانات عند الاسترجاع
     */
    protected $casts = [
        'latency_ms'         => 'integer',
        'fallback_triggered' => 'boolean',
        'created_at'         => 'datetime',
    ];

    /**
     * علاقة الموديل بجدول الحسابات (users): سجل الحدث ينتمي لطالب واحد أو قد يكون عاماً (BelongsTo)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}