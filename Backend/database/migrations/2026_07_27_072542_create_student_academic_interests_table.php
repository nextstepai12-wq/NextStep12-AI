<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * ==============================================================================
 * جدول ميول الطالب المحددة (student_academic_interests)[cite: 2]
 * ==============================================================================
 * الوظيفة: جدول وسيط يربط بين الطالب والمجالات الأكاديمية التي يميل إليها[cite: 2].
 * الربط التكاملي[cite: 2]:
 * - مريم: حفظ وتعديل الطالب لميوله[cite: 1, 2].
 * - عيد: تفضيل وتوجيه أسئلة الاستبيان والتوصية بناءً على الميول المختارة[cite: 1, 2].
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_academic_interests', function (Blueprint $table) {
            $table->id(); // رقم السجل[cite: 2]
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // مربوط بالطالب صاحب الاختيار[cite: 2]
            $table->foreignId('interest_id')->constrained('academic_interests')->onDelete('cascade'); // مربوط بالمجال المختار[cite: 2]
            $table->timestamps(); // طوابع التحديث والإنشاء[cite: 2]
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_academic_interests');
    }
};