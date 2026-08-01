<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * ==============================================================================
 * جدول الجامعات (universities)[cite: 2]
 * ==============================================================================
 * الوظيفة: تخزين بيانات الجامعات الكاملة والشعارات ووسائل التواصل[cite: 2].
 * الربط التكاملي[cite: 2]:
 * - مرح: إدخال ومراجعة البيانات الموثقة للجامعات[cite: 1, 2].
 * - مريم: عرض بطاقات وصفحات الجامعات بالتفصيل للطلاب[cite: 1, 2].
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('universities', function (Blueprint $table) {
            $table->id(); // رقم الجامعة التعريفي[cite: 2]
            $table->string('name'); // اسم الجامعة الرسمي[cite: 2]
            $table->string('cover_image')->nullable(); // صورة غلاف الجامعة (لواجهات مريم)[cite: 2]
            $table->string('logo')->nullable(); // شعار الجامعة[cite: 2]
            $table->string('location')->nullable(); // عنوان وموقع الجامعة الجغرافي[cite: 2]
            $table->text('description')->nullable(); // نبذة تعريفية عن الجامعة[cite: 2]
            $table->text('vision_mission')->nullable(); // رؤية ورسالة الجامعة[cite: 2]
            $table->string('website_url')->nullable(); // الموقع الإلكتروني للجامعة[cite: 2]
            $table->text('contact_info')->nullable(); // أرقام وهواتف التواصل[cite: 2]
            $table->timestamps(); // طوابع زمنية[cite: 2]
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('universities');
    }
};