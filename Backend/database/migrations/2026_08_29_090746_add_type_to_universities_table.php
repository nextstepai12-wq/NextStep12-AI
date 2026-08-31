<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * ==============================================================================
 * إضافة حقل "النوع" لجدول الجامعات
 * ==============================================================================
 * ليش؟ لأن عندنا نوعين من المؤسسات:
 * - جامعة (مثل: الجامعة الإسلامية) → فيها كليات + عمادات
 * - كلية مستقلة (مثل: الكلية الجامعية) → ما فيها كليات، بس عمادات
 * فبدل ما نسوي جدول جديد، نميّزهم بهذا الحقل عشان الواجهة تعرف وش تعرض
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('universities', function (Blueprint $table) {
            // enum = حقل اختيارات محددة مسبقًا، إما 'university' أو 'college'
            // default('university') = إذا ما اخترنا شي، يعتبرها جامعة تلقائيًا
            $table->enum('type', ['university', 'college'])->default('university');
        });
    }

    public function down(): void
    {
        // down() = كود التراجع، إذا سوينا rollback يحذف الحقل ويرجع الجدول كما كان
        Schema::table('universities', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};