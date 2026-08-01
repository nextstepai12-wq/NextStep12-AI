<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * ==============================================================================
 * جدول نتائج التوصيات (recommendation_results)[cite: 2]
 * ==============================================================================
 * الوظيفة: تخزين مخرجات نموذج الذكاء الاصطناعي (التخصص المقترح، نسبة التوافق، التفسير)[cite: 2].
 * الربط التكاملي[cite: 2]:
 * - عيد: إرجاع النتائج ونسب التوافق والتحليلات عبر API للباكند[cite: 1, 2].
 * - مريم: استلام هذه النتائج عبر الـ API لعرض التوصيات النهائية والرسوم التوضيحية للطالب[cite: 1, 2].
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recommendation_results', function (Blueprint $table) {
            $table->id(); // رقم النتيجة التعريفي[cite: 2]
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); // مربوط بالطالب الموصى له[cite: 2]
            $table->foreignId('major_id')->constrained('majors')->onDelete('cascade'); // مربوط بالتخصص المقترح[cite: 2]
            $table->decimal('match_percentage', 5, 2); // نسبة التوافق المئوية (مثل 95.50%)[cite: 2]
            $table->text('ai_feedback')->nullable(); // الشرح والتحليل المولد من الذكاء الاصطناعي لسبب التوصية[cite: 2]
            $table->timestamps(); // طوابع زمنية[cite: 2]
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recommendation_results');
    }
};