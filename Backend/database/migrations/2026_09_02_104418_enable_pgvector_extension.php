<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * تفعيل إضافة pgvector في PostgreSQL
     */
    public function up(): void
    {
        // إمر SQL لتفعيل إضافة pgvector لتخزين الـ Vector Embeddings الخاصة بالـ AI
        DB::statement('CREATE EXTENSION IF NOT EXISTS vector;');
    }

    /**
     * التراجع عن الإضافة
     */
    public function down(): void
    {
        DB::statement('DROP EXTENSION IF EXISTS vector;');
    }
};