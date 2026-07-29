<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * ==============================================================================
 * جدول إجابات الطلاب (student_survey_responses)[cite: 2]
 * ==============================================================================
 * الوظيفة: حفظ الخيارات المحددة من قِبل الطالب أثناء خوض الاستبيان[cite: 2].
 * الربط التكاملي[cite: 2]:
 * - عمر (Backend): تجميع وحفظ إجابات الطالب ثم تجهيزها وبنائها كـ Payload لتمريرها إلى FastAPI الخاص بعيد[cite: 1, 2].
 * - مريم: إرسال ردود الطالب عبر الـ API[cite: 1, 2].
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_survey_responses', function (Blueprint $table) {
            $table->id(); // رقم الإجابة التعريفي[cite: 2]
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // مربوط بالطالب صاحب الإجابة[cite: 2]
            $table->foreignId('question_id')->constrained('survey_questions')->onDelete('cascade'); // مربوط بالسؤال المجاب عنه[cite: 2]
            $table->foreignId('selected_option_id')->constrained('survey_question_options')->onDelete('cascade'); // الخيار المحدد متضمناً وزنه[cite: 2]
            $table->timestamps(); // طوابع زمنية[cite: 2]
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_survey_responses');
    }
};