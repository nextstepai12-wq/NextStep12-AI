<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * ==============================================================================
 * جدول الميول الأكاديمية (academic_interests)
 * ==============================================================================
 * الوظيفة: تخزين المجالات الأكاديمية الكبرى (تكنولوجيا، طب، هندسة، إدارة).
 * الربط التكاملي:
 * - عيد: تحديد نطاق أسئلة الاستبيان ونطاق نموذج الذكاء الاصطناعي[cite: 1, 2].
 * - مريم: عرض مجالات الاهتمام المتاحة للطالب لاختيار ميوله منها[cite: 1, 2].
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('academic_interests', function (Blueprint $table) {
            $table->id(); // رقم المجال التعريفي
            $table->string('name'); // اسم المجال (تكنولوجيا المعلومات IT، مجالات طبية...)
            $table->boolean('is_active')->default(true); // حالة تفعيل المجال
            $table->timestamps(); // طوابع الإنشاء والتحديث[cite: 2]
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_interests');
    }
};