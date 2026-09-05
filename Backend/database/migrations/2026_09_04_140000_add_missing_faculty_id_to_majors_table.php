<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('majors', 'faculty_id')) {
            Schema::table('majors', function (Blueprint $table) {
                $table->unsignedBigInteger('faculty_id')->nullable()->after('id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('majors', 'faculty_id')) {
            Schema::table('majors', function (Blueprint $table) {
                $table->dropColumn('faculty_id');
            });
        }
    }
};
