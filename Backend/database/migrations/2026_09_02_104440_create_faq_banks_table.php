<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * إنشاء جدول faq_bank
     */
    public function up(): void
    {
        Schema::create('faq_bank', function (Blueprint $table) {
            // id: الرقم التعريفي الفريد لكل سؤال شائع في البنك
            $table->id();

            // question: نص السؤال الشائع الأصلي بالشكل المعروض للطلاب في الواجهات الخاصة بمريم
            $table->text('question');

            // question_normalized: نص السؤال بعد تنظيفه ومعالجته (إزالة التشكيل والرموز) لسهولة البحث والمقارنة النصية
            $table->text('question_normalized');

            // answer: النص المعتمد للإجابة النموذجية المجهزة لتقديمها للطالب فوراً
            $table->text('answer');

            // category: تصنيف السؤال (مثل: التسجيل، المنح، الشؤون الأكاديمية) المعتمد في بيانات الكلية
            $table->string('category', 100)->nullable();

            // created_at: الطابع الزمني لتاريخ إضافة السؤال للبنك بواسطة الأدمن في لوحة الإدارة
            $table->timestampTz('created_at')->useCurrent();
        });

        // embedding: العمود المخصص لتخزين المتجه الرقمي (768 بُعداً) الخاص بنص السؤال لعمليات البحث بالتشابه (Cosine Similarity)
        DB::statement('ALTER TABLE faq_bank ADD COLUMN embedding vector(768);');
    }

    /**
     * التراجع عن الجدول
     */
    public function down(): void
    {
        Schema::dropIfExists('faq_bank');
    }
};