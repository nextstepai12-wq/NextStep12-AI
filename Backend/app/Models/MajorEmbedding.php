<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MajorEmbedding extends Model
{
    use HasFactory;

    /**
     * اسم الجدول في قاعدة البيانات
     */
    protected $table = 'major_embeddings';

    /**
     * تحديد المفتاح الرئيسي المخصص (major_id) بدلاً من id الافتراضي
     */
    protected $primaryKey = 'major_id';

    /**
     * إلغاء الترقيم التلقائي لكون المفتاح الرئيسي هو نفسه المفتاح الأجنبي (foreign key)
     */
    public $incrementing = false;

    /**
     * تفعيل updated_at فقط وإلغاء created_at
     */
    const CREATED_AT = null;

    /**
     * الأعمدة المسموح بتعبئتها جماعياً (Mass Assignment)
     */
    protected $fillable = [
        'major_id',  // رقم التخصص الأكاديمي المرتبط من جدول majors
        'embedding', // المتجه الرقمي المكون من 768 بُعداً
    ];

    /**
     * تحويل أنواع البيانات عند الاسترجاع
     */
    protected $casts = [
        'updated_at' => 'datetime',
    ];

    /**
     * علاقة الموديل بجدول التخصصات (majors): متجه التخصص ينتمي لتخصص أكاديمي واحد (BelongsTo)
     */
    public function major(): BelongsTo
    {
        return $this->belongsTo(Major::class, 'major_id');
    }
}