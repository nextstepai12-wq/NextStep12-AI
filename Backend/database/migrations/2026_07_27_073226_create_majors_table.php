<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * ==============================================================================
 * جدول التخصصات (majors)
 * ==============================================================================
 * الوظيفة: تخزين بيانات التخصصات الأكاديمية التفصيلية، الخطط، الرسوم، والفرص الوظيفية.
 * 
 * الربط التكاملي:
 * - مرح: توثيق متطلبات قبول ومعدلات التخصصات وسعر الساعة.
 * - مريم: استعراض تفاصيل التخصص، الفيديوهات الشارحة، والخطط الدراسية.
 * - عيد: التخصص هو المخرج الأساسي الذي يُوصى به الطالب في محرك الذكاء الاصطناعي.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('majors', function (Blueprint $table) {
            $table->id(); // رقم التخصص التعريفي
            
            // المفاتيح الأجنبية (ملاحظة: جعلناها nullable للارتباط المرن حسب الكلية أو العمادة)
            $table->unsignedBigInteger('faculty_id')->nullable();
            $table->unsignedBigInteger('deanship_id')->nullable();
            
            $table->string('title'); // اسم التخصص (مثل: هندسة البرمجيات)
            $table->string('cover_image')->nullable(); // صورة غلاف التخصص
            $table->string('video_url')->nullable(); // رابط فيديو تعريفي شارح
            $table->string('study_plan_image')->nullable(); // صورة الخطة الدراسية
            $table->string('study_plan_file_url')->nullable(); // ملف الخطة الدراسية (PDF)
            $table->decimal('min_high_school_score', 5, 2); // أدنى معدل قبول للتخصص
            $table->decimal('credit_hour_fee', 8, 2); // سعر الساعة المعتمدة
            $table->integer('total_credit_hours'); // عدد الساعات الكلي للتخرج
            $table->text('description')->nullable(); // شرح تفصيلي عن التخصص
            $table->text('career_opportunities')->nullable(); // مجالات العمل المتوفرة
            
            $table->timestamps();
        });

        // إضافة قيود العلاقات بأمان لتفادي أخطاء الترتيب عند التشغيل
        Schema::table('majors', function (Blueprint $table) {
            if (Schema::hasTable('faculties')) {
                $table->foreign('faculty_id')->references('id')->on('faculties')->cascadeOnDelete();
            }
            if (Schema::hasTable('deanships')) {
                $table->foreign('deanship_id')->references('id')->on('deanships')->cascadeOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('majors');
    }
};