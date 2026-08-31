<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * ==============================================================================
 * جدول بنك المقررات (courses)
 * ==============================================================================
 * الوظيفة: تخزين المقررات كـ"كيان مستقل" على مستوى الجامعة، بحيث يمكن إعادة
 * استخدام نفس المقرر (مثل CS101) عبر أكثر من خطة دراسية أو تخصص بنفس الجامعة،
 * ويسهّل ربط المتطلبات السابقة (Prerequisites) بين الخطط المختلفة.
 *
 * ملاحظة: الحقول هنا تطابق مخرجات AI Service (src/models.py -> Course, CourseType)
 * لتفادي أي تعارض Schema عند الاستيراد.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();

            // مربوط بالجامعة (بنك المقررات مستقل لكل جامعة، منعًا لتعارض نفس الرمز بين جامعتين)
            $table->foreignId('university_id')->constrained('universities')->cascadeOnDelete();

            $table->string('code', 20); // رمز المقرر (مثل CS101) — مُطبّع (uppercase, no spaces)
            $table->string('name_ar'); // الاسم بالعربي
            $table->string('name_en')->nullable(); // الاسم بالإنجليزي (اختياري، الـPDFs عادة عربي فقط)

            // القيم الافتراضية للمقرر (تُستخدم إذا لم تُحدَّد قيمة مختلفة على مستوى الخطة)
            $table->unsignedTinyInteger('default_total_hours')->default(0);
            $table->unsignedTinyInteger('default_theory_hours')->default(0);
            $table->unsignedTinyInteger('default_practical_hours')->default(0);

            // مطابق تمامًا لـ CourseType في src/models.py (specialization/college/university)
            $table->enum('default_type', ['specialization', 'college', 'university'])
                  ->default('specialization');

            $table->timestamps();

            // منع تكرار نفس رمز المقرر داخل نفس الجامعة
            $table->unique(['university_id', 'code']);
            $table->index(['university_id', 'code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};