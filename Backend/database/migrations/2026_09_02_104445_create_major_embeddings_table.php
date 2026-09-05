<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * إنشاء جدول major_embeddings
     */
    public function up(): void
    {
        Schema::create('major_embeddings', function (Blueprint $table) {
            // major_id: مفتاح رئيسي وأجنبي في آن واحد يربط المتجه بالتخصص الأكاديمي مباشرة في جدول majors
            $table->foreignId('major_id')
                  ->primary()
                  ->constrained('majors')
                  ->onDelete('cascade');

            // updated_at: الطابع الزمني لآخر تحديث على متجه التخصص عند تعديل بياناته بواسطة مرح عبر الـ Admin Panel
            $table->timestampTz('updated_at')->useCurrent();
        });

        // embedding: المتجه الرقمي المكون من 768 بُعداً لتنفيذ المطابقة مع ميول وأجوبة الطالب
        DB::statement('ALTER TABLE major_embeddings ADD COLUMN embedding vector(768);');
    }

    /**
     * التراجع عن الجدول
     */
    public function down(): void
    {
        Schema::dropIfExists('major_embeddings');
    }
};