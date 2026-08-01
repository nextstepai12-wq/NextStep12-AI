<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * ==============================================================================
 * جدول خيارات الأسئلة والأوزان (survey_question_options)[cite: 2]
 * ==============================================================================
 * الوظيفة: تخزين الخيارات لكل سؤال مع وزن كل إجابة لتمريرها لمحرك الذكاء الاصطناعي[cite: 2].
 * الربط التكاملي[cite: 2]:
 * - عيد: تحديد أوزان وتأثير الخيارات على خوارزمية التوصية (Weight Score)[cite: 1, 2].
 * - مريم: عرض الخيارات المتاحة تحت كل سؤال للطالب[cite: 1, 2].
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('survey_question_options', function (Blueprint $table) {
            $table->id(); // رقم الخيار التعريفي[cite: 2]
            $table->foreignId('question_id')->constrained('survey_questions')->onDelete('cascade'); // مربوط بالسؤال التابع له[cite: 2]
            $table->string('option_text'); // نص الخيار (مثل: "أفضل العمل الميداني")[cite: 2]
            $table->decimal('weight_score', 5, 2); // وزن الإجابة لتمريره لنموذج الذكاء الاصطناعي الخاص بعيد[cite: 2]
            $table->string('option_value', 100); // القيمة الرمزية للرمز الممرر للـ API[cite: 2]
            $table->timestamps(); // طوابع زمنية[cite: 2]
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('survey_question_options');
    }
};