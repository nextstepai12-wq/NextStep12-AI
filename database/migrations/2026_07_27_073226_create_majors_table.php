<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * ==============================================================================
 * جدول التخصصات (majors)[cite: 2]
 * ==============================================================================
 * الوظيفة: تخزين بيانات التخصصات الأكاديمية التفصيلية، الخطط، الرسوم، والفرص الوظيفية[cite: 2].
 * الربط التكاملي[cite: 2]:
 * - مرح: توثيق متطلبات قبول ومعدلات التخصصات وسعر الساعة[cite: 1, 2].
 * - مريم: استعراض تفاصيل التخصص، الفيديوهات الشارحة، والخطط الدراسية[cite: 1, 2].
 * - عيد: التخصص هو المخرج الأساسي الذي يُوصى به الطالب في محرك الذكاء الاصطناعي[cite: 1, 2].
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('majors', function (Blueprint $table) {
            $table->id(); // رقم التخصص التعريفي[cite: 2]
            $table->foreignId('deanship_faculty_id')->constrained('deanships_faculties')->onDelete('cascade'); // مربوط بالكلية التابع لها[cite: 2]
            $table->string('title'); // اسم التخصص (مثل: هندسة البرمجيات)[cite: 2]
            $table->string('cover_image')->nullable(); // صورة غلاف التخصص[cite: 2]
            $table->string('video_url')->nullable(); // رابط فيديو تعريفي شارح[cite: 2]
            $table->string('study_plan_image')->nullable(); // صورة الخطة الدراسية[cite: 2]
            $table->string('study_plan_file_url')->nullable(); // ملف الخطة الدراسية (PDF)[cite: 2]
            $table->decimal('min_high_school_score', 5, 2); // أدنى معدل قبول للتخصص (مثلاً 80%)[cite: 2]
            $table->decimal('credit_hour_fee', 8, 2); // سعر الساعة المعتمدة[cite: 2]
            $table->integer('total_credit_hours'); // عدد الساعات الكلي للتخرج[cite: 2]
            $table->text('description')->nullable(); // شرح تفصيلي عن التخصص[cite: 2]
            $table->text('career_opportunities')->nullable(); // مجالات العمل المتوفرة الخريج[cite: 2]
            $table->timestamps(); // طوابع زمنية[cite: 2]
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('majors');
    }
};