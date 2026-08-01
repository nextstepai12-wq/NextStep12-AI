<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * ==============================================================================
 * جدول ملف الطالب الشخصي (student_profiles) - NextStep AI
 * ==============================================================================
 * إعداد: عمر حمدية (Backend Engineer)
 * الوظيفة: حفظ البيانات الأكاديمية والشخصية للطلاب (جدد / جامعيين).
 * 
 * الربط التكاملي:
 * - مريم (Frontend): استعراض وتحديث بيانات الملف الشخصي بناءً على نوع الطالب.
 * - عيد (AI Engine): اعتماد المعدل والفرع/التخصص وتاريخ الميلاد كمُدخلات أساسية للذكاء الاصطناعي.
 */
return new class extends Migration
{
    public function up(): void
    {
        // 1. إنشاء الجدول والأعمدة الأساسية أولاً
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->id(); // رقم ملف الطالب[cite: 2]
            
            // العمود المرجعي لجدول الحسابات الرئيسي (users)
            $table->unsignedBigInteger('user_id');
            
            // نوع الطالب: جديد (ثانوية) أم طالب جامعي حالي
            $table->enum('student_type', ['new_student', 'university_student'])->default('new_student');

            // تاريخ الميلاد (يُحسب منه العمر تلقائياً لمريم)[cite: 2]
            $table->date('birth_date')->nullable();
            
            // ==================================================================
            // 1. البيانات الخاصة بالطالب الجديد (New Student - التوجيهي)[cite: 2]
            // ==================================================================
            $table->decimal('high_school_score', 5, 2)->nullable(); // معدل الثانوية العامة[cite: 2]
            $table->unsignedBigInteger('high_school_branch_id')->nullable(); // الفرع الدراسي[cite: 2]
            $table->integer('graduation_year')->nullable(); // سنة التخرج من الثانوية[cite: 2]
            
            // ==================================================================
            // 2. البيانات الخاصة بالطالب الجامعي (University Student)
            // ==================================================================
            $table->unsignedBigInteger('current_university_id')->nullable(); // الجامعة الحالية
            $table->unsignedBigInteger('current_major_id')->nullable(); // التخصص الحالي
                  
            $table->string('academic_level', 50)->nullable(); // السنة الدراسية / المستوى
            $table->decimal('gpa', 4, 2)->nullable(); // المعدل التراكمي الجامعي (GPA)

            // ==================================================================
            // 3. بيانات مشتركة وإضافية[cite: 2]
            // ==================================================================
            $table->string('phone', 50)->nullable(); // رقم جوال الطالب[cite: 2]
            $table->string('city', 100)->nullable(); // مكان سكن الطالب[cite: 2]
            
            $table->timestamps(); // created_at & updated_at[cite: 2]
        });

        // 2. ربط قيود المفاتيح الأجنبية (Foreign Keys) بأمان صريح
        Schema::table('student_profiles', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            if (Schema::hasTable('high_school_branches')) {
                $table->foreign('high_school_branch_id')->references('id')->on('high_school_branches')->nullOnDelete();
            }
            if (Schema::hasTable('universities')) {
                $table->foreign('current_university_id')->references('id')->on('universities')->nullOnDelete();
            }
            if (Schema::hasTable('majors')) {
                $table->foreign('current_major_id')->references('id')->on('majors')->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_profiles');
    }
};