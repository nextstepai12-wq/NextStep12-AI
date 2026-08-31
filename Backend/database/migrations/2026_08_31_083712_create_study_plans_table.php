<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * ==============================================================================
 * جدول الخطط الدراسية (study_plans)
 * ==============================================================================
 * الوظيفة: كل تخصص (Major) يمكن أن يملك عدة خطط دراسية بسنوات مختلفة
 * (مثال: Computer Science -> خطة 2024 / 2025 / 2026). فقط خطة واحدة "نشطة"
 * لكل تخصص في وقت واحد (is_current).
 *
 * يدير هذا الجدول أيضًا دورة حياة الاستيراد من AI Service:
 *   pending -> processing -> extracted (بانتظار المراجعة) -> confirmed
 *                                    \-> failed
 *
 * raw_extracted_data: تخزين خام لنتيجة AI Service (ParserResponse كاملة كـJSON)
 * لدعم شاشة المراجعة (Review) قبل التأكيد النهائي في study_plan_courses.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('study_plans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('major_id')->constrained('majors')->cascadeOnDelete();

            // تخزين مباشر لسهولة فلترة الصلاحيات (نفس نمط جدول deanships)
            $table->foreignId('university_id')->constrained('universities')->cascadeOnDelete();

            $table->string('title')->nullable(); // مثال: "خطة 2025" (اختياري، يُشتق من academic_year إن لم يُحدَّد)
            $table->unsignedSmallInteger('academic_year'); // سنة اعتماد الخطة (2024، 2025...)
            $table->string('version_label', 50)->nullable(); // نص الإصدار كما استُخرج من AI (approval.version)
            $table->string('ucas_code', 50)->nullable(); // approval.ucas_code من AI Service

            $table->unsignedSmallInteger('total_credit_hours')->nullable(); // من program.total_credit_hours بعد المراجعة

            $table->boolean('is_current')->default(false); // الخطة النشطة حاليًا للتخصص

            // ── ملفات المصدر ──
            $table->string('source_pdf_path'); // مسار التخزين الآمن (storage/app/private/...)
            $table->string('source_pdf_original_name');

            // ── حالة المعالجة (AI pipeline) ──
            $table->enum('status', [
                'pending',    // تم الرفع، بانتظار الإرسال لـAI Service
                'processing', // جاري الاستخراج
                'extracted',  // انتهى الاستخراج، بانتظار مراجعة مستخدم الجامعة
                'failed',     // فشلت المعالجة
                'confirmed',  // تمت المراجعة والتأكيد وحفظ المقررات فعليًا
            ])->default('pending');

            $table->text('processing_error')->nullable(); // رسالة الخطأ عند status=failed (بدون بيانات حساسة)
            $table->json('raw_extracted_data')->nullable(); // نسخة كاملة من ParserResponse (metadata+courses+warnings+errors)

            $table->foreignId('uploaded_by')->constrained('users')->cascadeOnDelete(); // مستخدم الجامعة الذي رفع الملف
            $table->foreignId('confirmed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('confirmed_at')->nullable();

            $table->timestamps();

            $table->unique(['major_id', 'academic_year']); // خطة واحدة فقط لكل تخصص/سنة
            $table->index(['major_id', 'is_current']);
            $table->index(['status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('study_plans');
    }
};