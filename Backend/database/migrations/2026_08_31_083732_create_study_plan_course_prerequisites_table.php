<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * ==============================================================================
 * جدول المتطلبات السابقة (study_plan_course_prerequisites)
 * ==============================================================================
 * self-reference داخل نفس الخطة. نخزّن أيضًا رمز المقرر النصي (prerequisite_code)
 * لأن AI Service (src/validator.py) قد يستخرج متطلبًا سابقًا لم يُشاهَد بعد
 * (warning: "prereq not seen yet") — فنحتفظ بالنص حتى لو تعذّر الربط الفعلي وقت
 * الاستخراج، ويمكن ربطه لاحقًا أثناء المراجعة اليدوية.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('study_plan_course_prerequisites', function (Blueprint $table) {
            $table->id();

            // المقرر الذي يملك هذا المتطلب السابق
            $table->foreignId('study_plan_course_id')->constrained('study_plan_courses')->cascadeOnDelete();

            $table->string('prerequisite_code', 20); // الرمز كما استُخرج (مثل CS101)

            // الربط الفعلي بالمقرر داخل نفس الخطة إن وُجد (nullable إذا لم يُطابَق بعد)
            $table->foreignId('prerequisite_study_plan_course_id')
                  ->nullable()
                  ->constrained('study_plan_courses')
                  ->nullOnDelete();

            $table->timestamps();

            $table->unique(['study_plan_course_id', 'prerequisite_code'], 'spcp_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('study_plan_course_prerequisites');
    }
};