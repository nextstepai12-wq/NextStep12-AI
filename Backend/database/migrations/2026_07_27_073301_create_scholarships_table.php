<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * ==============================================================================
 * جدول المنح الدراسية (scholarships) - NextStep AI
 * ==============================================================================
 * إعداد: عمر حمدية (Backend Engineer)
 * الوظيفة: تخزين خصومات الشرائح للجامعات والكليات والتخصصات بناءً على معدل الطالب.
 * 
 * الربط التكاملي:
 * - مرح: جمع وتغذية شروط ونسب المنح.
 * - مريم: إظهار المنح المستحقة للطالب في نتائج التوجيه والتوصية.
 */
return new class extends Migration
{
    public function up(): void
    {
        // 1. إنشاء الجدول والأعمدة الأساسية
        Schema::create('scholarships', function (Blueprint $table) {
            $table->id(); // رقم المنحة التعريفي
            
            // المفاتيح الأجنبية المرجعية
            $table->unsignedBigInteger('university_id')->nullable();
            $table->unsignedBigInteger('faculty_id')->nullable();
            $table->unsignedBigInteger('deanship_id')->nullable();
            $table->unsignedBigInteger('major_id')->nullable();
            
            $table->string('title'); // عنوان المنحة (مثل: منحة التفوق 90% فما فوق)
            $table->text('description')->nullable(); // تفاصيل وشروط المنحة
            $table->decimal('min_score', 5, 2); // أدنى معدل مستحق (مثلاً 90.00)
            $table->decimal('max_score', 5, 2); // أعلى معدل للشريحة (مثلاً 100.00)
            $table->decimal('discount_percentage', 5, 2); // نسبة الخصم الممنوحة (مثلاً 100%)
            $table->string('type', 100); // نوع المنحة (تفوق، رياضية...)
            $table->string('cover_image')->nullable(); // صورة غلاف المنحة
            $table->boolean('is_active')->default(true); // حالة تفعيل المنحة
            
            $table->timestamps(); // طوابع زمنية
        });

        // 2. ربط قيود المفاتيح الأجنبية بأمان (Foreign Keys Constraint Protection)
        Schema::table('scholarships', function (Blueprint $table) {
            if (Schema::hasTable('universities')) {
                $table->foreign('university_id')->references('id')->on('universities')->onDelete('cascade');
            }
            if (Schema::hasTable('faculties')) {
                $table->foreign('faculty_id')->references('id')->on('faculties')->onDelete('cascade');
            }
            if (Schema::hasTable('deanships')) {
                $table->foreign('deanship_id')->references('id')->on('deanships')->onDelete('cascade');
            }
            if (Schema::hasTable('majors')) {
                $table->foreign('major_id')->references('id')->on('majors')->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('scholarships');
    }
};