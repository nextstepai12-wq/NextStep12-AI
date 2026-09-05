<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * إنشاء جدول ai_usage_tracking
     */
    public function up(): void
    {
        Schema::create('ai_usage_tracking', function (Blueprint $table) {
            // id: الرقم التعريفي الفريد لكل سجل تتبع (BIGINT / Auto Increment)
            $table->id();

            // user_id: رقم الطالب المربوط بجدول الحسابات users(id) مع شرط الفردية (UNIQUE) لضمان سجل واحد لكل طالب
            $table->foreignId('user_id')
                  ->unique()
                  ->constrained('users')
                  ->onDelete('cascade');

            // used_free_llm_question: مؤشر منطقي (true/false) يوضح هل استهلك الطالب السؤال المجاني المتاح عبر النموذج المباشر؟
            $table->boolean('used_free_llm_question')->default(false);

            // last_unmatched_question: نص آخر سؤال طرحه الطالب ولم يجد له إجابة مطابقة في بنك الأسئلة الشائعة
            $table->text('last_unmatched_question')->nullable();

            // used_at: الطابع الزمني الموثق للحظة استخدام/استهلاك السؤال المجاني
            $table->timestampTz('used_at')->nullable();
        });
    }

    /**
     * التراجع عن الجدول
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_usage_tracking');
    }
};