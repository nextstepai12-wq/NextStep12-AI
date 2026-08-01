<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * ==============================================================================
 * جدول أسئلة الاستبيان (survey_questions)[cite: 2]
 * ==============================================================================
 * الوظيفة: تخزين أسئلة استبيان تحديد الميول للشخصية والقدرات[cite: 2].
 * الربط التكاملي[cite: 2]:
 * - عيد ومرح: صياغة الأسئلة وربطها بالشرائح والميول والأعداء المسموحة[cite: 1, 2].
 * - مريم: عرض الأسئلة بشكل متسلسل للطالب في صفحة الاستبيان[cite: 1, 2].
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('survey_questions', function (Blueprint $table) {
            $table->id(); // رقم السؤال التعريفي[cite: 2]
            $table->text('question_text'); // نص السؤال المعروض للطالب[cite: 2]
            $table->enum('type', ['multiple_choice', 'true_false']); // نوع السؤال (خيارات متعددة أم صح/خطأ)[cite: 2]
            $table->integer('order_index'); // ترتيب ظهور السؤال (1، 2، 3...)[cite: 2]
            $table->decimal('min_score_required', 5, 2)->nullable(); // أدنى معدل لظهور السؤال (يمنع ظهور أسئلة غير مناسبة)[cite: 2]
            $table->foreignId('interest_id')->nullable()->constrained('academic_interests')->onDelete('set null'); // ربط بمجال معين[cite: 2]
            $table->boolean('is_active')->default(true); // حالة تفعيل السؤال[cite: 2]
            $table->timestamps(); // طوابع زمنية[cite: 2]
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('survey_questions');
    }
};