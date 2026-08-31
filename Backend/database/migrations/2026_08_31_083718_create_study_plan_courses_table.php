<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * ==============================================================================
 * جدول ربط المقررات بالخطة (study_plan_courses)
 * ==============================================================================
 * pivot غني بالبيانات (لذلك Model مستقل وليس belongsToMany بسيطة).
 * يحمل بيانات خاصة بموضع المقرر داخل هذه الخطة تحديدًا: السنة، الفصل، الترتيب،
 * وإن كان إجباري/اختياري، مع إمكانية تجاوز الساعات المعتمدة الافتراضية للمقرر.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('study_plan_courses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('study_plan_id')->constrained('study_plans')->cascadeOnDelete();
            $table->foreignId('course_id')->constrained('courses')->cascadeOnDelete();

            $table->unsignedTinyInteger('year_number'); // 1..5
            $table->unsignedTinyInteger('semester_number'); // 1..2

            // إجباري/اختياري — محور مستقل عن default_type (تخصص/كلية/جامعة) لأن AI Service
            // الحالي لا يستخرجه تلقائيًا؛ يُملأ يدويًا أثناء المراجعة، لذلك nullable.
            $table->boolean('is_elective')->nullable();

            // تجاوز الساعات المعتمدة الافتراضية للمقرر إذا اختلفت داخل هذه الخطة تحديدًا
            $table->unsignedTinyInteger('credit_hours_override')->nullable();
            $table->unsignedTinyInteger('theory_hours_override')->nullable();
            $table->unsignedTinyInteger('practical_hours_override')->nullable();

            $table->unsignedSmallInteger('order_index')->default(0); // ترتيب العرض داخل الفصل

            $table->timestamps();

            // نفس المقرر لا يتكرر داخل نفس الخطة
            $table->unique(['study_plan_id', 'course_id']);
            $table->index(['study_plan_id', 'year_number', 'semester_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('study_plan_courses');
    }
};