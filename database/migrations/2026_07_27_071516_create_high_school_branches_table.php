<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * ==============================================================================
 * جدول فروع الثانوية العامة (high_school_branches)
 * ==============================================================================
 * الوظيفة: تخزين فروع الثانوية (علمي، أدبي، تكنولوجي...) لتحديد المتاح منها للطالب.
 * الربط التكاملي:
 * - مرح: توثيق أفرع الثانوية المتاحة[cite: 1, 2].
 * - مريم: عرض القائمة للطالب أثناء إنشاء الملف الشخصي[cite: 1, 2].
 * - عيد: فلترة التخصصات والجامعات المتاحة بناءً على الفرع[cite: 1, 2].
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('high_school_branches', function (Blueprint $table) {
            $table->id(); // رقم الفرع التعريفي
            $table->string('name'); // اسم الفرع (علمي، أدبي، تكنولوجي...)
            $table->boolean('is_active')->default(true); // حالة تفعيل الفرع
            $table->timestamps(); // طوابع الإنشاء والتحديث
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('high_school_branches');
    }
};