<?php
// database/migrations/2026_08_31_120000_add_university_id_to_users_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * ==============================================================================
 * إضافة university_id لجدول users
 * ==============================================================================
 * الوظيفة: ربط حساب مستخدم بـrole='university' بجامعة واحدة محددة، لتفعيل
 * صلاحيات فعلية (مو فقط role check) في UniversityMiddleware/Policies لاحقًا (Step 6).
 * nullable لأن admin/student ما يحتاجون هذا العمود إطلاقًا.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('university_id')
                  ->nullable()
                  ->after('role')
                  ->constrained('universities')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['university_id']);
            $table->dropColumn('university_id');
        });
    }
};