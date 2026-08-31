<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * ==============================================================================
 * جدول العمادات (deanships)
 * ==============================================================================
 * الوظيفة: تخزين العمادات، ونتوقع 3 حالات:
 * 1. عمادة جامعية عامة (قبول وتسجيل) → faculty_id = null
 * 2. عمادة تابعة لكلية معينة → faculty_id = رقم الكلية
 * 3. عمادات الكلية الجامعية (لأنها ما فيها كليات) → faculty_id = null
 * 
 * ⚠️ مهم: هذا الجدول لازم يتنشأ "بعد" جدول faculties بسبب المفتاح الأجنبي
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deanships', function (Blueprint $table) {
            $table->id(); // المفتاح الأساسي: رقم تعريفي للعمادة

            // ربط العمادة بالجامعة، وإذا انحذفت الجامعة تنحذف عماداتها
            $table->foreignId('university_id')->constrained('universities')->cascadeOnDelete();

            // 🌟 أهم سطر بالجدول:
            // nullable() = العمادة ممكن ما تتبع أي كلية (هذي العمادات العامة)
            // nullOnDelete() = إذا انحذفت الكلية، العمادة ما تنحذف، بس يصير faculty_id = null
            //   وتصير تلقائيًا "عمادة عامة" بدل ما نخسر بياناتها
            $table->foreignId('faculty_id')->nullable()->constrained('faculties')->nullOnDelete();

            $table->string('name'); // اسم العمادة (مثل: عمادة القبول والتسجيل)

            $table->string('cover_image')->nullable(); // صورة العمادة

            $table->text('description')->nullable(); // وصف العمادة

            $table->string('dean_name')->nullable(); // اسم عميد العمادة

            $table->string('email')->nullable(); // إيميل العمادة

            $table->timestamps(); // طوابع زمنية: وقت الإنشاء وآخر تحديث

            // فهرس مركب: يسرّع البحث عن عمادات بجامعة معينة، أو عمادات كلية معينة
            // (الفهرس مثل فهرس الكتاب، يخلي البحث أسرع بدون ما يمسح الجدول كله)
            $table->index(['university_id', 'faculty_id']);

            // نفس قيد الكليات: منع تكرار اسم عمادة بنفس الجامعة
            $table->unique(['university_id', 'name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deanships');
    }
};