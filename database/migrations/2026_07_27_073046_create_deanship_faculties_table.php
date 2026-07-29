<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * ==============================================================================
 * جدول العمادات والكليات (deanships_faculties)[cite: 2]
 * ==============================================================================
 * الوظيفة: تخزين الكليات والعمادات التابعة لكل جامعة[cite: 2].
 * الربط التكاملي[cite: 2]:
 * - مرح: توثيق الهيكلية التنظيمية للكليات والأقسام[cite: 1, 2].
 * - مريم: تصفح الكليات التابعة لجامعة معينة في واجهة الطالب[cite: 1, 2].
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deanships_faculties', function (Blueprint $table) {
            $table->id(); // رقم الكلية/العمادة التعريفي[cite: 2]
            $table->foreignId('university_id')->constrained('universities')->onDelete('cascade'); // مربوط بالجامعة[cite: 2]
            $table->string('name'); // اسم الكلية أو العمادة (مثل: كلية الهندسة)[cite: 2]
            $table->enum('type', ['deanship', 'faculty']); // نوع الكيان (عمادة أم كلية)[cite: 2]
            $table->string('cover_image')->nullable(); // صورة غلاف الكلية[cite: 2]
            $table->text('description')->nullable(); // وصف الكلية[cite: 2]
            $table->string('dean_name')->nullable(); // اسم عميد الكلية[cite: 2]
            $table->string('email')->nullable(); // إيميل التواصل المباشر للكلية[cite: 2]
            $table->timestamps(); // طوابع زمنية[cite: 2]
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deanships_faculties');
    }
};