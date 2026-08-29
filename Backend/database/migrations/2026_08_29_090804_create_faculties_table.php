<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * ==============================================================================
 * جدول الكليات (faculties)
 * ==============================================================================
 * الوظيفة: تخزين الكليات التابعة للجامعات (كلية الهندسة، كلية طب...)
 * ملاحظة: العمادات ليست هنا، لأنها صارت في جدول منفصل (deanships)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('faculties', function (Blueprint $table) {
            $table->id(); // المفتاح الأساسي: رقم تعريفي تلقائي لكل كلية (1، 2، 3...)

            // مفتاح أجنبي: يربط الكلية بالجامعة اللي تابعة لها
            // constrained('universities') = يضمن أن الرقم موجود فعلًا بجدول الجامعات
            // cascadeOnDelete() = إذا انحذفت الجامعة، تنحذف كل كلياتها معها تلقائيًا
            $table->foreignId('university_id')->constrained('universities')->cascadeOnDelete();

            $table->string('name'); // اسم الكلية (مثل: كلية الهندسة)

            // nullable() = ممكن تكون فاضية، يعني مش شرط الكلية يكون عندها صورة
            $table->string('cover_image')->nullable(); // صورة غلاف الكلية (تظهر بواجهة مريم)

            $table->text('description')->nullable(); // وصف الكلية (نص طويل، وممكن يكون فاضي)

            $table->string('dean_name')->nullable(); // اسم عميد الكلية (ممكن يكون فاضي مؤقتًا)

            $table->string('email')->nullable(); // إيميل التواصل الرسمي للكلية

            $table->timestamps(); // ينشئ عمودين تلقائيًا: created_at و updated_at

            // قيد فريد مركب: يمنع تكرار نفس اسم الكلية بنفس الجامعة
            // يعني ممكن "كلية العلوم" بجامعتين مختلفتين، بس مو بمرتين بنفس الجامعة
            $table->unique(['university_id', 'name']);
        });
    }

    public function down(): void
    {
        // عند التراجع: احذف الجدول كامل إذا موجود
        // dropIfExists = تحذف بس إذا موجود، ما ترمي خطأ إذا مو موجود
        Schema::dropIfExists('faculties');
    }
};