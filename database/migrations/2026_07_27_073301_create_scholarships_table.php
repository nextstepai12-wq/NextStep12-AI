<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * ==============================================================================
 * جدول المنح الدراسية (scholarships)[cite: 2]
 * ==============================================================================
 * الوظيفة: تخزين خصومات الشرائح للجامعات والكليات والتخصصات بناءً على معدل الطالب[cite: 2].
 * الربط التكاملي[cite: 2]:
 * - مرح: جمع وتغذية شروط ونسب المنح[cite: 1, 2].
 * - مريم: إظهار المنح المستحقة للطالب في نتائج التوجيه والتوصية[cite: 1, 2].
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scholarships', function (Blueprint $table) {
            $table->id(); // رقم المنحة التعريفي[cite: 2]
            $table->foreignId('university_id')->nullable()->constrained('universities')->onDelete('cascade'); // مربوط بالجامعة (اختياري)[cite: 2]
            $table->foreignId('deanship_faculty_id')->nullable()->constrained('deanships_faculties')->onDelete('cascade'); // مربوط بالكلية (اختياري)[cite: 2]
            $table->foreignId('major_id')->nullable()->constrained('majors')->onDelete('cascade'); // مربوط بالتخصص (اختياري)[cite: 2]
            $table->string('title'); // عنوان المنحة (مثل: منحة التفوق 90% فما فوق)[cite: 2]
            $table->text('description')->nullable(); // تفاصيل وشروط المنحة[cite: 2]
            $table->decimal('min_score', 5, 2); // أدنى معدل مستحق (مثلاً 90.00)[cite: 2]
            $table->decimal('max_score', 5, 2); // أعلى معدل للشريحة (مثلاً 100.00)[cite: 2]
            $table->decimal('discount_percentage', 5, 2); // نسبة الخصم الممنوحة (مثلاً 100%)[cite: 2]
            $table->string('type', 100); // نوع المنحة (تفوق، رياضية...)[cite: 2]
            $table->string('cover_image')->nullable(); // صورة غلاف المنحة[cite: 2]
            $table->boolean('is_active')->default(true); // حالة تفعيل المنحة[cite: 2]
            $table->timestamps(); // طوابع زمنية[cite: 2]
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scholarships');
    }
};