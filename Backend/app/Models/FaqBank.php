<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaqBank extends Model
{
    use HasFactory;

    /**
     * اسم الجدول في قاعدة البيانات
     */
    protected $table = 'faq_bank';

    /**
     * تفعيل created_at فقط وإلغاء updated_at
     */
    const UPDATED_AT = null;

    /**
     * الأعمدة المسموح بتعبئتها جماعياً (Mass Assignment)
     */
    protected $fillable = [
        'question',            // نص السؤال الشائع الأصلي
        'question_normalized', // نص السؤال المعالج والمُعد للبحث النصي
        'answer',              // نص الإجابة النموذجية المعتمدة
        'category',            // تصنيف السؤال (مثل: قبول، تسجيل، منح)
        'embedding',           // المتجه الرقمي (vector 768)
    ];

    /**
     * تحويل أنواع البيانات للقيم عند الاسترجاع
     */
    protected $casts = [
        'created_at' => 'datetime',
    ];
}