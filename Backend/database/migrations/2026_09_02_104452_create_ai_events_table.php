<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * إنشاء جدول ai_events
     */
    public function up(): void
    {
        Schema::create('ai_events', function (Blueprint $table) {
            // id: الرقم التعريفي الفريد لكل حدث/طلب ذكاء اصطناعي
            $table->id();

            // user_id: رقم الطالب صاحب الطلب (REFERENCES users) وهو قابل لكونه خالياً (NULL) للطلبات العامة
            $table->foreignId('user_id')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();

            // source: مصدر الحدث المنشئ للطلب (مثل: 'survey' للتحليل من الاستبيان، أو 'faq' للأسئلة)
            $table->string('source', 20);

            // provider: مزود الخدمة المعتمد للطلب (مثل: 'fastapi' لموديل عيد، أو 'gemini')
            $table->string('provider', 20)->nullable();

            // latency_ms: الزمن الذي استغرقته المعالجة مقاساً بالملي ثانية (ms) لقياس أداء السيرفر
            $table->integer('latency_ms')->nullable();

            // fallback_triggered: مؤشر منطقي يوضح ما إذا تم اللجوء للخيار البديل (Fallback) عند فشل المحرك الرئيسي
            $table->boolean('fallback_triggered')->default(false);

            // created_at: الطابع الزمني الدقيق لوقت وقوع الحدث لتتبع السجلات والتحليلات
            $table->timestampTz('created_at')->useCurrent();
        });
    }

    /**
     * التراجع عن الجدول
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_events');
    }
};